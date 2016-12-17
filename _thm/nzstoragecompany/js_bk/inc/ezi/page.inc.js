$(document).ready(function() {
    $('[name="paymentMethodType"]').change(function (event) {

        $(':input', 'form')
            .not(':button, :submit, :reset, :hidden, :disabled, [name="paymentMethodType"], :checkbox')
            .val('')
            .removeAttr('selected');


        $('select option:first-child').attr("selected", "selected");

        $('[name="paymentMethodType"]').prop('disabled', 'disabled');

        if($(event.currentTarget).val() === 'Bank Account') {
            $('#paymentMethodCreditCard').fadeOut('default', function () {
                $('#setUpPaymentForm .has-error').removeClass('has-error');
                $('#setUpPaymentForm').valid();

                $('#paymentMethodBankAccount').fadeIn('default', function() {
                    $('[name="paymentMethodType"]').prop('disabled', '');
                });

            });
        }
        else {
            $('#paymentMethodBankAccount').fadeOut('default', function () {
                $('#setUpPaymentForm .has-error').removeClass('has-error');
                $('#setUpPaymentForm').valid();

                $('#paymentMethodCreditCard').fadeIn('default', function() {
                    $('[name="paymentMethodType"]').prop('disabled', '');
                });
            });
        }
    });

    //Credit Card Logo Display Code
    $('#cardNumber').keyup(validateCardNumber);
    $('#cardNumber').focusout(validateCardNumber);

    //Hack to allow validation when the year is changed.
    $('#expiryYear').change(function() {
        $('#expiryMonth').click();
    });

    //Hiding Bank Account entry fields
	if($('[name="paymentMethodType"]').length > 0) {
		$('#paymentMethodBankAccount').hide();
	}

    //jQuery validate defaults
    setDefaults();

    setupFormValidation();
});

function setDefaults() {
    // override jquery validate plugin defaults
    $.validator.setDefaults({

        /*
         A form group may contain more than one element.
         An example of this is expiryMonth and expiryYear.

         If either one is invalid mark the entire section invalid, otherwise mark the section as valid.
         */
        highlight: function (element) {
            var $formGroup = $(element).closest('.form-group');
            var elementId = $(element).prop('id');

            $formGroup.data(elementId, false);

            $('.successful').empty();
            $('.successful').hide();
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            var valid = true;
            var $formGroup = $(element).closest('.form-group');
            var currentElementId = $(element).prop('id');

            $formGroup.data(currentElementId, true);

            $formGroup.find(':input').each(function () {
                if ($formGroup.data($(this).prop('id')) === false) {
                    valid = false;
                }
            });

            if (valid) {
                $formGroup.removeClass('has-error');
            }
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
}

function displayError(errorMessage) {
    if (typeof errorMessage === "undefined") {
       errorMessage = "An error has occurred while submitting your payment details.";
    }

    showErrorModal('Error', errorMessage);

    $('.mustAgree').change();
}

function setupFormValidation() {
    $.validator.addMethod("isNumeric", function (value, element) {
        var re = /^([0-9\s])+$/;

        return re.test(value);
    }, "Invalid credit card number");

    $.validator.addMethod("validCardType", function (value, element) {
        var cardType = GetCardType(value);
        return (cardType === 'Visa' || cardType === 'MasterCard');
    }, "Only Visa or Mastercards are accepted");

    $.validator.addMethod("validCardNumber", function(value, element) {
        var cardType = GetCardType(value);
        return checkCreditCard (value, cardType);
    }, "Invalid credit card number");

    $.validator.addMethod("validNameOnCard", function(value, element) {
        var re = /^[A-Za-z0-9\.,'&\s]*$/;

        return re.test(value);
    }, "Invalid name on card");

    $.validator.addMethod("isCardCurrent", function(value, element) {
        var date = new Date();
        if ($('#expiryYear').val() !== null  && toNumber($('#expiryYear').val()) <= date.getFullYear()) {
            if ($('#expiryMonth').val() !== null && toNumber($('#expiryMonth').val()) < (date.getMonth() + 1)) {
                return false;
            }
        }

        return true;
    }, "Expiry date is set in the past");

    $.validator.addMethod("validateExpiryMonth", function (value, element) {
        $('#expiryMonth').valid();
        return true;
    }, "");


    $.validator.addMethod("isValidBSB", function (value, element) {
        var re = /^[0-9]{3}[\-]?[0-9]{3}$/;

        return re.test(value.replace(/\s/g, ''));
    }, "Invalid BSB number");


    $.validator.addMethod("BSBexists", function (value, element) {
        var bsb = value.replace(/\s|\-/g, '');
        var username = $('#username').val();

        var requestUrl = "validateBSB/" + bsb + "?clientUsername=" + username;

        var bsbDetails = ajaxRequestSync('GET', requestUrl, null);
        var valid = bsbDetails.bankName != "" && bsbDetails.branchName != "";

        if(valid) {
            $('#bsbDetails').html('<p class="help-block"><span class="glyphicon glyphicon-ok"></span> ' + $.trim(bsbDetails.bankName) + ' - ' + $.trim(bsbDetails.branchName) + '</p>');
            $('#bsbDetails').show();
        }
        else {
            $('#bsbDetails').empty();
            $('#bsbDetails').hide();
        }

        return valid;
    }, "Invalid BSB number");



    $.validator.addMethod("isValidAccountNumber", function (value, element) {
        var re = /^[0-9]+$/;

        return re.test(value.replace(/\s/g, ''));
    }, "Invalid account number");

    $.validator.addMethod("isValidAccountName", function (value, element) {
        var re = /^[A-Za-z0-9\.,'&\s]*$/;

        return re.test(value);
    }, "Invalid account name");


    $("#setUpPaymentForm").validate({
        debug: true,
        focusInvalid: false,
        focusCleanup: true,
        submitHandler: function (form) {

            var options = {
                contentType: 'application/json',

                success: function (data) {

                    if(data.returncode === 0) {
                        $('#setUpPaymentForm').fadeOut('slow', function () {
                            $('#successMessage').fadeIn('slow');
                            $('#setUpPaymentForm').remove();
                        });
                    }
                    else if(data.returncode === 2) {
                        displayError("Provided BSB number is invalid.");

                        var validator = $.data($('#setUpPaymentForm')[0], "validator" );
                        validator.showErrors({"bsb": "Provided BSB number is invalid"});
                    }
                    else if(jQuery.inArray( data.returncode, new Array(996)) != -1) {
                        displayError(data.returnmessage);
                    }
                    else {
                        displayError();
                    }

                },
                error: function () {
                    displayError();
                }
            };

            $('[type="submit"]').addClass('disabled');
            $('[type="submit"]').prop('disabled', 'disabled');

            submitForm(form, options);
        },
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            $('.mustAgree').change();
        },
        rules: {
            /* Bank Account Rules */
            bsb: {
                required: isBankAccount,
                isValidBSB: isBankAccount, /* Here we test if the value looks like a BSB */
                BSBexists: isBankAccount /* Here we go to HL and look up the BSB details */
            },
            accountNumber: {
                required: isBankAccount,
                isValidAccountNumber: isBankAccount
            },
            accountName: {
                required: isBankAccount,
                isValidAccountName: isBankAccount
            },

            /* Credit Card Rules */
            cardNumber: {
                required: isCreditCard,
                isNumeric: isCreditCard,
                validCardType: isCreditCard,
                validCardNumber: isCreditCard
            },
            nameOnCard: {
                required: isCreditCard,
                validNameOnCard: isCreditCard
            },
            expiryMonth: {
                required: isCreditCard,
                isCardCurrent: isCreditCard
            },
            expiryYear: {
                required: isCreditCard,
                validateExpiryMonth: isCreditCard
            }
        },
        messages: {
            /* Bank Account Messages */
            bsb: {
                required: "BSB number is required"
            },
            accountNumber: {
                required: "Account number is required"
            },
            accountName: {
                required: "Account name is required"
            },

            /* Credit Card Messages */
            cardNumber: {
                required: "A credit card number is required"
            },
            nameOnCard: {
                required: "Credit card holder's name is required"
            },
            expiryMonth: {
                required: "Credit card expiry month is required"
            },
            expiryYear: {
                required: "Credit card expiry year is required"
            }
        }
    });
}

function isCreditCard() {
    return ($('[name="paymentMethodType"]:checked').val() === "Credit Card");
}

function isBankAccount() {
    return ($('[name="paymentMethodType"]:checked').val() === "Bank Account");
}

function validateCardNumber() {
    var cardNumber = $('#cardNumber').val();

    var cardType = GetCardType(cardNumber);

    if (cardType !== 'Invalid' && (cardType === 'Visa' || cardType === 'MasterCard') && checkCreditCard(cardNumber, cardType)) {
        if (cardType === 'Visa') {
            $('#cardNumber').css('background', "url('assets/img/card_validation_visa.gif') no-repeat right center");
        }
        else if (cardType === 'MasterCard') {
            $('#cardNumber').css('background', "url('assets/img/card_validation_mastercard.gif') no-repeat right center");
        }
    }
    else {
        $('#cardNumber').css('background', '');
    }

}