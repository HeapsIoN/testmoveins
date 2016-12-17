function GetCardType(cardNumber) {
    var cards = [];

    cards[0] =  {name: "Visa", 		prefixes: "4"};
    cards[1] =  {name: "MasterCard",	prefixes: "50,51,52,53,54,55"};
    cards[2] =  {name: "DinersClub",		prefixes: "36,38"};
    cards[3] =  {name: "CarteBlanche", prefixes: "300,301,302,303,304,305"};
    cards[4] =  {name: "AmEx",			prefixes: "34,37"};
    cards[5] =  {name: "Discover", 	prefixes: "30,36,38,39,6011,622,62,64,65,68"};
    cards[6] =  {name: "JCB", 			prefixes: "35"};
    cards[7] =  {name: "enRoute", 		prefixes: "2014,2149"};
    cards[8] =  {name: "Solo", 		prefixes: "6334,6767"};
    cards[9] =  {name: "Switch", 		prefixes: "4903,4905,4911,4936,564182,633110,6333,6759"};
    cards[10] = {name: "Maestro", 		prefixes: "5018,5020,5038,6304,6759,6761,6762,6763"};
    cards[11] = {name: "VisaElectron", prefixes: "4026,417500,4508,4844,4913,4917"};
    cards[12] = {name: "LaserCard", 	prefixes: "6304,6706,6771,6709"};

    var match = 'Invalid';

    for (var i=0; i < cards.length; i++) {
        var prefix = [];
        var lengthMatch = 0;

        // Load an array with the valid prefixes for this card
        prefix = cards[i].prefixes.split(",");

        // Now see if any of them match what we have in the card number
        for (var j=0; j < prefix.length; j++) {
            var exp = new RegExp ('^' + prefix[j]);
            if (exp.test (cardNumber) && prefix[j].length > lengthMatch) {
                match = cards[i].name;
                lengthMatch = prefix[j].length;
            }
        }
    }

    //No match found
    return match;
}

function toNumber(text) {
    return +text;
}

function convertFormToJSONString(form){
    var array = jQuery(form).serializeArray();
    var json = {};

    jQuery.each(array, function() {
        if($('[name=' + this.name + ']').is(':checkbox')) {
            json[this.name] = $('[name=' + this.name + ']').is(':checked');
        }
        else {
			if(typeof this.value === 'string') {
				json[this.name] = $.trim(this.value);
			}
			else {
				json[this.name] = this.value || '';
			}
        }
    });

    return JSON.stringify(json);
}

function submitForm (form, options) {
    var data = convertFormToJSONString(form);
    var action = $(form).prop('action');
    var method = $(form).prop('method');

    var defaultOptions = {
        type: method,
        url: action,
        data: data,
        dataType: "json",
        contentType : "application/json; charset=utf-8",
        cache: false
    }

    $.extend(options, defaultOptions);

    return $.ajax(options);
}

function ajaxRequestSync(type, requestUrl, requestData) {
    var results = null;

    if(typeof failureFunction === 'undefined') {
        failureFunction = handleCaughtAjaxException;
    };

    $.ajax({
        type: type,
        url: requestUrl,
        data : requestData,
        dataType : "json",
        cache: false,
        contentType : "application/json; charset=utf-8",
        async: false,
        success: function(data, textStatus, xhr) {
            results = data;
        },
        error : function(jqXHR, textStatus, errorThrown) {
            handleAjaxError(jqXHR, textStatus, errorThrown, type, requestUrl, requestData);
        }
    });

    return results;
}

function ajaxRequest(type, requestUrl, requestData, successFunction, failureFunction) {
    if(typeof failureFunction === 'undefined') {
        failureFunction = handleCaughtAjaxException;
    };

    return $.ajax({
        type: type,
        url: requestUrl,
        data : requestData,
        dataType : "json",
        cache: false,
        contentType : "application/json; charset=utf-8",
        success: function(data, textStatus, xhr) {
            if(data != null && (getReturnObj(data).returnCode == 0)) {
                successFunction(data);
            }
            else {
                failureFunction(data);
            }
        },
        error : function(jqXHR, textStatus, errorThrown) {
            handleAjaxError(jqXHR, textStatus, errorThrown, type, requestUrl, requestData);
        }
    });
}

function handleAjaxError(jqXHR, textStatus, errorThrown, type, requestUrl, requestData) {
    //If the user aborted the ajax call. e.g. Switched pages half way through a request
    //Don't do anything
    if( jqXHR.status == 0) {
        return;
    }

    //Note: Jetty does not return a Date response header, however Glassfish does.
    handleServerError(jqXHR.status, errorThrown, requestUrl, jqXHR.getResponseHeader('Date'));
}

function handleCaughtAjaxException(data) {
    var errorMessages = data.errorMessages;
    if (errorMessages == null) {
        displayAjaxExceptionDialog(data);
    } else {
        displayAjaxExceptionValidationErrorDialog(errorMessages);
    }

}

function displayAjaxExceptionDialog(data) {
    var returnObj = getReturnObj(data);
    var dialogContents = $('<div></div>');
    var convertedMessage = returnObj.returnMessage.replace(/</g, '').replace(/>/g, '');

    showErrorModal('Error', convertedMessage);
}

function displayAjaxExceptionValidationErrorDialog(errorMessages) {

    var errorList = $('<ul></ul>');

    $.each(errorMessages, function (index, elementValue) {
        var errorMessage = $('<li class="error"></li>').html(elementValue);
        errorList.append(errorMessage);
    });

    var contents = '<div><b>Validation errors</b>:</div>';
    $(contents).append(errorList);

    showErrorModal('Validation errors', contents);
}


/**
 * Extract the return details from ajax data
 * @param data (ajax return data)
 * @returns returnObj with properties returnCode, returnMessage
 */
function getReturnObj(data) {

    // set the defaults
    var returnObj = {returnCode: 0, returnMessage: ""};

    // The returnCode could be stored in a couple of different places
    if (data.returnCode) {
        returnObj.returnCode = data.returnCode;
        returnObj.returnMessage = data.returnMessage;
    }

    if (data['return']) {
        returnObj.returnCode = data['return'].returnCode;
        returnObj.returnMessage = data['return'].returnMessage;
    }

    return returnObj;
}

function showErrorModal(errorTitle, errorMessage) {
    var $clone = $('#errorDialog').clone();
    $clone.find('.modal-title').html(errorTitle);
    $clone.find('.modal-body').html(errorMessage);
    $clone.modal('show');
}

/***
 * Initialises and displays the server error slide down.
 *
 * @param errorCode     The HTTP status code received.
 * @param errorMessage  The HTTP status code description.
 * @param requestUrl    The URL that was requested when the error happened.
 * @param date          The date/time the error occurred.
 */
function handleServerError(errorCode, errorMessage, requestUrl, date) {

/*    if(errorCode == 403) { (For the future when we have login support)
        $('#serverError-errorDescription').text('');
        $("#serverError-errorMessage").html('Your session has expired. <a href="/j_spring_security_logout">Please login</a> and try again.');
    }
    else {*/
        var emailMessage = '\n\n\n\n' +
            'Technical Error Details\n' +
            'Code: '        + errorCode + '\n' +
            'Message: '     + errorMessage + '\n' +
            'Date: '        + date + '\n' +
            'Request: '     + requestUrl + '\n' +
            'User Agent: '  + navigator.userAgent;

        emailMessage = encodeURIComponent(emailMessage);

        $('#serverError-errorDescription').text('An error has occurred (Error code: ' + errorCode + ' - ' + errorMessage + ').');
        $('#serverError-errorMessage').html('If this problem persists, email us at <a>support@ezidebit.com.au</a>.');

        //Doing a jQuery onclick instead of setting the href attribute because over a certain length of href,
        // the contents of href gets dumped to the UI instead of "support@ezidebit.com.au" in IE.
        $('#serverError-errorMessage > a').click(function () {
            window.open('mailto:support@ezidebit.com.au?subject=' + encodeURIComponent('Ezidebit Payment Application Error') + '&body=' + emailMessage);
        });
    /*}*/

    $('#serverError').slideDown('fast');
}