<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * 	Storman Class
 *
 *	Author: 	Luke Pelgrave
 * 	Date:		2014-04-15		
 *	Version:	v1.0
 *	Details:	Storman API class offering a range of Storman API functions
 *
 */

class API extends CI_Model {

// Connection Configuration
private $serverip		= 'evolution.stellar.storman.com';	// IP / URL of the Storman Server.
private $serverport 	= '29832';				// Port of the Storman Server. 19812 is Storman default for hosted options.
private $facilitycode	= '';					// Used if single facility website.
private $webpass		= '';					// Storman Web Services Password.

// Method Settings
private $format			= 'NUSOAP'; // Options are SOAP or NUSOAP
private $feedtimeout	= '3';		// Number of seconds to try finding the feed before returning FALSE
private $resptimeout	= '20';		// Number of seconds to wait for a response before returning FALSE


// Header Checker
public $headercheck		= 0; 		// Set to 1 if you want the script to verify the server is accessible before connecting.
public $headercode		= NULL;		// Used for checking if server is available.

// Storman Feed and Process Variables
public $feed			= array();	// The feed from Storman.
public $request			= NULL;		// The API call with Storman.
public $params			= array();	// Array of params to pass to Storman API call.
public $response		= NULL;		// Response check
public $result			= array();	// The result from the request
public $successes		= array();	// Array of variables that indicate a successful response

// Error Handling
public $error			= '';		// Nicely formatted error response
public $errorcode		= array();	// Error code for tracking errors.
public $errormsg		= '';		// Error message
public $errors			= array();	// Array for defining error code messages


public function __construct()
	{
	parent::__construct();
	}

public function code($f)
	{
	$this->facilitycode = $f;
	
	return $this;	
	}

public function pass($p)
	{
	$this->webpass = $p;
	
	return $this;	
	}

public function server($s)
	{
	$this->serverip = $s;
	
	return $this;	
	}

public function port($p)
	{
	$this->serverport = $p;
	
	return $this;	
	}

public function request($r)
	{
	$this->request = $r;
	
	return $this;	
	}

public function params($p, $v=NULL)
	{
	if(is_array($p))
		{
		$this->params = !empty($this->params) ? array_merge($this->params, $p) : $p;
		}
	elseif($v!=NULL)
		{
		$this->params[$p] = $v;
		}
	
	return $this;		
	}

public function response($r)
	{
	$this->response = $r;
	
	return $this;	
	}

public function errorcode($c)
	{
	$this->errorcode[] = $c;
	
	return $this;		
	}

public function errormsg($m)
	{
	$this->errormsg = $this->errormsg!='' ? '<br/>'.$m : $m;
	
	return $this;		
	}


/**
 *
 *	Core API Functions
 *
 */

public function process()
	{
	// Get header for 200 response check
	$this->check();
	
	// If header code is not 200 OK response...
	if($this->headercode!='200')
		{
		// Switch between the error code for response
		switch($this->headercode)
			{
			case '404':
			$this->errorcode('404')->errormsg('There was an error connecting to the storage service. Please contact us.');
			break;
			case '503':
			$this->errorcode('503')->errormsg('Our storage service is currently undergoing maintenance. Please try again later.');
			break;
			default:
			$this->errorcode('111')->errormsg('There was an unknown error. Please contact us.');
			break;	
			}
		
		// Record the storman error
		$this->error();
		}
	// If no other errors...
	else
		{
		// Load the library
		$this->load->library('nusoap_base');
		
		// Initialise the feed
		$this->feed = new nusoap_client('https://'.$this->serverip.':'.$this->serverport.'/4DWSDL', true);
		
		// Feed configuration
		$this->feed->timeout = $this->feedtimeout;
		
		$this->feed->response_timeout = $this->resptimeout;
			
		// Check if feed is an object
		if(is_object($this->feed))
			{
			// Run our call
			$this->result = $this->feed->call($this->request, $this->params, '', '', false, true);
			
			//echo '<pre>';die(print_r($this->result['WS_UTDescription']));
			
			if(!isset($this->result['WS_ORSuccess']) || $this->result['WS_ORSuccess']===false)
				{
				// Record the error
				$this->error();
				}
			elseif(isset($this->result['WS_ORSuccess']) && $this->result['WS_ORSuccess']===true)
				{
				// Log our actual response
				$this->logger();	
				}
			else
				{
				// Record the error
				$this->error();
				}
			}
		// If not a feed...
		else
			{
			// Set our codes
			$this->errorcode('101')->errormsg('The system is currently unavailable. Please try again later.')->error();
			}	
		}
	
	return $this;
	}

private function masker()
	{
	$m = array('WS_WebServicePassword', 'WS_Password');
	
	foreach($this->params as $f => $v)
		{
		$this->params[$f] = in_array($f, $m) ? str_repeat('*', strlen($v)) : $v;	
		}
	}

public function error()
	{
	$this->response(false);
	
	if(isset($this->result['WS_ORErrorCode']))
		{
		$this->errorcode($this->result['WS_ORErrorCode'])->errormsg($this->result['WS_ORErrorDescription']);		
		}
	else
		{
		$this->errorcode('0')->errormsg('Unknown error');	
		}
	
	$this->masker();
	
	// Set Data for Recording Error
	$error = array(	'errortime' 		=> date('Y-m-d H:i:s'),
					'errorcode' 		=> json_encode($this->errorcode),
					'errorfunction' 	=> $this->request,
					'errormessage' 		=> trim($this->errormsg),
					'errorparameters' 	=> json_encode($this->params),
					'errorresponse' 	=> json_encode($this->result)					
					);
	
	// Insert the record into the DB
	if(!$this->db->insert('stormanerrors', $error))
		{
		$error['query'] = $this->db->last_query();
					
		$syserr = array(	'systemerrortime' => date('Y-m-d H:i:s'),
							'systemfunction' => 'errorlog',
							'systemerrordata' => json_encode($error)
							);
							
		$this->db->insert('systemerrors', $syserr);	
		}
	
	// Set the error response for sending back to user
	$codes = !empty($this->errorcode) ? implode(',', $this->errorcode) : 'Unknown';
	
	$this->error = $this->errormsg.'. [Error Code: '.$codes.']';
	
	}

public function logger()
	{
	$this->response(true);
	
	$this->masker();
	
	// Set Data for Recording Error
	$action = array(	'stormantime' 		=> date('Y-m-d H:i:s'),
						'stormanrequest' 	=> $this->request,
						'stormanparameters' => json_encode($this->params),
						'stormanresponse' 	=> json_encode($this->result)					
						);
	
	// Insert the record into the DB
	if(!$this->db->insert('stormanlog', $action))
		{
		$error = array(	'systemerrortime' 	=> date('Y-m-d H:i:s'),
						'systemfunction'	=> 'logger',
						'systemerrordata' 	=> $this->db->last_query()
						);
		$this->db->insert('systemerrors', $error);
		}
	}


public function clear()
	{
	unset($this->feed, $this->params, $this->data, $this->request);
	$this->params		= array();
	$this->data			= array();
	$this->request 		= NULL;
	}

/**
 *
 *	Private Functions / Sub Functions
 *
 */

private function check()
	{
	if($this->headercheck==1)
		{
		$url = 'https://'.$this->serverip.':'.$this->serverport.'/4dwsdl';
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_HEADER, 1);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,  2);
		$r = curl_exec($c);
		$code = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		$this->headercode = is_array($code) && !empty($code) || $code!='' ? $code : '200';
		}
	else
		{
		$this->headercode = 200;
		}
	}
	
private function prepare()
	{	
	// For each postdata field
	if(!empty($this->call->data))
		{
		foreach($this->call->data as $key => $data)
			{
			// Swicth out the field name for data modifcation
			switch($key)
				{
				// Boolean Field
				case 'sampleboolean':
				$this->call->data[$key] = $data=='1' || $data=='on' ? 1 : 0;
				break;
				// If not an item to modify
				default:
				$this->call->data[$key] = $data;
				break;				
				}
			}
		}
	
	return $this;
	}




/**
 *
 *	Individual Functions / API Calls
 *
 */

/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CustomerLogin Request Parameters
	
WS_Inputname 			- !REQUIRED! 	- Text(10)	[Concatenation of facility code and customer code. e.g. SSCTYSMITH]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]
WS_Password				- !REQUIRED! 	- Text(50)	[Customer Account Password]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CustomerLogin Response Variables

WS_Login 				- Boolean	[True or False if Login Completed]

// Arrays for agreements
WS_asRAgreeNo			- String	[Will return a string array of agreement numbers]
WS_aiDaytoBill			- Int		[Number of days until billing for agreement]
WS_abSendNotices		- Boolean	[If send notices on agreement]
WS_aiNoticeDaysPrior	- Int		[Days prior notice]
WS_abSendNoticesEmail	- Boolean	[True or False for email notifications for agreement]
WS_abSendNoticesSMS 	- Boolean	[True or False for SMS notifications for agreement]
WS_abAutopay  			- Boolean	[True or False for auto-payments for agreement]
WS_arAutoPayAmt 		- Int		[Authorised amount to pay for an auto payment]

WS_adAuthCCSigned
WS_adAuthCCExpiry
WS_adOutNoticeDate
WS_adMoveOut
WS_arRentAmt

WS_arNewRentAmt
WS_adNewRentFrom

// Arrays for units

WS_asUTRUnitNo 
WS_asUTAgreeNo
WS_arUTInsureVal
WS_arUTRentedValue
WS_arUTNewRentAmt
WS_adUTIncreaseFrom


// Arrays for regular charges

WS_asORCDescription
WS_asORCAnalysis
WS_arORCAmount 
WS_arORCNewAmount 
WS_adORCIncreaseFrom 
WS_asORCAgreeNo

// Arrays for reservations

WS_asRReserveNo
WS_adExpMoveIn

// Arrays for reservations units

WS_asUTResRUnitNo
WS_asUTReservedTo 
WS_arUTQuotedRate 

// Pin / Proximity Card Codes arrays

WS_asPCName
WS_asPCPINCardNo


// Customer Details

WS_Organization		- Boolean
WS_Title			- String(15)	[Mr, Mrs, Ms, Dr]
WS_CustomerName		- String(50)	[Lastname, Firstname]
WS_FirstName		- String(20)	
WS_DateofBirth		- Date
WS_UserName			- String(40)
WS_ABNNo 			- String(11)

WS_MailAddress 		- Text
WS_MailSuburb		- String(255)
WS_MailCity			- String(30)
WS_MailState		- String(30)
WS_MailPostZIPCode	- String(10)
WS_MailCountry		- String(50)

WS_StreetAddress 	- Text
WS_StreetSuburb		- String(255)
WS_StreetCity		- String(30)
WS_StreetState		- String(30)
WS_StreetZIPCode	- String(10)
WS_Country			- String(50)

WS_PhonePrivate		- String(25)	[Home phone]
WS_PhoneBus 		- String(25)	[Work phone]
WS_PhoneBusExt 		- String(10)	[Work phone ext.]
WS_MobilePhone 		- String(25)	[Mobile phone]
WS_PrimaryPhone		- Option		[1:Home, 2:Work, 3:Mobile]
WS_EmailAddress		- String(80)

WS_Employer 		- String(40)
WS_LicenceNo		- String(30)
WS_LicenseState 	- String(50)
WS_Vehicle			- String(50)
WS_CarRego 			- String(30)

WS_MarketSrce 		- String(30)
WS_CustType  		- String(30)
WS_BusType 			- String(30)
WS_ReasonRenting 	- String(30)
WS_MarketingOptOut 	- Boolean


WS_AltContact		- Text			[Carriage return list of authorised people to speak about account]


WS_AltTitle			- String(15)	[Mr, Mrs, Ms, Dr]
WS_AlternateName	- String(40)

WS_AlternateAddress - Text
WS_AltSuburb		- String(255)
WS_AlternateCity	- String(30)
WS_AlternateState	- String(30)
WS_AlternateZIPCode	- String(10)
WS_AltCountry		- String(50)

WS_AlternatePhone	- String(25)	[Home phone]
WS_AltBusiness 		- String(25)	[Work phone]
WS_AltBusExt 		- String(10)	[Work phone ext.]
WS_AltMobile 		- String(25)	[Mobile phone]
WS_AltEmail 		- String(80)

WS_AutoEmailCC 		- Boolean		[ If True the customer will automatically be emailed when their credit card is processed]

WS_AccessList		- Text			[Carriage return list of authorised people to speak about account]


WS_CustomerID		- String(10)
WS_FaxNo			- String(25) 

WS_Custom1			- String(80)
WS_Custom2 			- String(80)
WS_Custom3			- String(80)
WS_Custom4			- String(80)


WS_customerProfileID		- String(255)
WS_customerPaymentProfID	- String(255)
WS_customerProfileID		- String(255)


WS_CCNo				- String(30)	[Last 4 digits of card on file]
WS_CCExpiry
WS_CCName 
WS_CCValidFrom 

WS_BankAccountName
WS_BankAcct 
WS_BankName
WS_BSB 


WS_GatePIN
WS_WebID 
WS_adPTD 
WS_adMoveIn
WS_adUTMoveIn
WS_adNextBillDate
WS_adLastBillDate
WS_adLastBillAmt
WS_arBalOwing
WS_adReservedDate
WS_arBalance
WS_adUTSize
}*/

public function loginCustomer()
	{
	$this	->request('WS_CustomerLogin2')
			->prepare()
			->params(array(	
							'WS_Inputname' 			=> $this->call->data['customercode'],
							'WS_WebServicePassword' => $this->webpass,						
							'WS_Password' 			=> $this->call->data['customerpass']
							))
			->process();
	}



/* {
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CustomerEdit Request Parameters
	
WS_Inputname			- !REQUIRED! 	- Text(10)	[Min. 5 characters. First 5 characters are facility code. If only facility code is passed, will create a new customer]
WS_Password				- Optional		- Text(20)	[Customer Online Password]

WS_Organization 		- Optional		- Boolean	[True if a company]
WS_Title				- Optional		- Text(15)	[Salutation e.g. Mr, Ms, Mrs]
WS_CustomerName 		- Optional		- Text(50)	[Customer name, usually last name, firstname]
WS_FirstName 			- Optional		- Text(50)	[First name of customer]
WS_DateofBirth 			- Optional		- Date		[DOB of customer]
WS_UserName 			- Optional		- Text(40)	[Contact person, usually for an organization]

WS_ABNNo				- Optional		- Text(11)	[AU:ABN, US:SSN, Other:GST/TAX/VAT]

WS_MailAddress 			- Optional		- Text(~)	[First part of mailing address]
WS_MailSuburb 			- Optional		- Text(255)	[Suburb of mailing address AU/NZ Only]
WS_MailCity 			- Optional		- Text(30)	[City of the mailing address]
WS_MailState 			- Optional		- Text(30)	[UK:Country, CA,SA,TH:Province, NZ:Not applicable]
WS_MailPostZIPCode 		- Optional		- Text(10)	[Mailing Postcode/Zip Code]
WS_MailCountry 			- Optional		- Text(50)	[Mailing address country]

WS_StreetAddress 		- Optional		- Text(~)	[First part of street address]
WS_StreetSuburb 		- Optional		- Text(255)	[Suburb of street address AU/NZ Only]
WS_StreetCity 			- Optional		- Text(30)	[City of the street address]
WS_StreetState 			- Optional		- Text(30)	[UK:Country, CA,SA,TH:Province, NZ:Not applicable]
WS_StreetPostZIPCode 	- Optional		- Text(10)	[Street Postcode/Zip Code]
WS_Country 				- Optional		- Text(50)	[Street address country]

WS_PhonePrivate			- Optional		- Text(25)	[Home phone of customer]
WS_PhoneBus				- Optional		- Text(25)	[Business phone of customer]
WS_PhoneBusExt			- Optional		- Text(25)	[Extension of business phone for customer]
WS_MobilePhone			- Optional		- Text(25)	[Mobile phone of customer]
WS_PrimaryPhone			- Optional		- Integer	[1:Home, 2:Business, 3:Mobile, 4:Military]
WS_EmailAddress			- Optional		- Text(80)	[Email address of the customer]
WS_Employer				- Optional		- Text(40)	[Name of employer, if applicable]
WS_LicenceNo 			- Optional		- Text(30)	[Drivers license number]
WS_LicenseState			- Optional		- Text(50)	[Driver license state of issue]
WS_Vehicle				- Optional		- Text(50)	[Customer vehicle type]
WS_CarRego				- Optional		- Text(30)	[Customer vehicle registration]

WS_MarketSrce 			- Optional		- Text(30)	[Use market sources from Storman. e.g. Internet Search, Friend]
WS_CustType 			- Optional		- Text(30)	[Use customer types from Storman. e.g. Residential, Business, Government]
WS_BusType 				- Optional		- Text(30)	[Use business types from Storman. e.g. Industrial,Real Estate]
WS_ReasonRenting		- Optional		- Text(30)	[Use market sources from Storman. e.g. Internet Search, Friend]
WS_MarketingOptOut		- Optional		- Boolean	[Opt out of marketing material]

// Credit Card, Direct Debit and Payment Configurations can also be added. See API docs for full field support

WS_GatePIN				- Optional		- Text(~)	[If passed blank, it will generate a new one]

WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CustomerEdit Response Variables

WS_Edit					- Boolean	[Will return true/false values]
WS_asOutPCName			- Array		[Names of each of the users]
WS_asOutPCPINCardNo		- Array		[PIN Code / Proximity Card number for each user]
WS_CustomerID			- Text(10)	[Customer code of customer being edited. Invalid if not found / not created]
	
} */

public function editCustomer()
	{
	//$this->clear();
	
	$iname = isset($this->call->data['customercode']) && $this->call->data['customercode']!='' ? $this->call->data['customercode'] : $this->facilitycode;
	
	// Set The Request
	$this	->request('WS_CustomerEdit2')
			->prepare()
			->params(array(	
							///////////////////////////////////////////////////////////////////////////
							// Customer Info
							
							// Customer Code and Password
							'WS_Inputname' 			=> $iname,
							//'WS_Password'			=> $this->call->data['customerpass'],
							// Personal Info
							'WS_Organization'		=> isset($this->call->data['organization']) ? $this->call->data['organization'] : false,
							'WS_Title'				=> isset($this->call->data['customertitle']) ? $this->call->data['customertitle'] : '',
							'WS_CustomerName'		=> isset($this->call->data['customerfullname']) ? $this->call->data['customerfullname'] : '',
							'WS_FirstName'			=> isset($this->call->data['customerfirstname']) ? $this->call->data['customerfirstname'] : '',
							'WS_DateofBirth'		=> isset($this->call->data['customerdob']) ? $this->call->data['customerdob'] : '',
							'WS_Username'			=> isset($this->call->data['contactname']) ? $this->call->data['contactname'] : '',
							//dualaccount
							'WS_SecondCust'			=> isset($this->call->data['dualaccount']) ? $this->call->data['dualaccount'] : false,
							'WS_ABNNo'				=> isset($this->call->data['companynumber']) ? $this->call->data['companynumber'] : '',
							// Mailing Details
							'WS_MailAddress'		=> isset($this->call->data['customermailaddress']) ? $this->call->data['customermailaddress'] : '',
							'WS_MailSuburb'			=> isset($this->call->data['customermailsuburb']) ? $this->call->data['customermailsuburb'] : '',
							'WS_MailCity'			=> isset($this->call->data['customermailcity']) ? $this->call->data['customermailcity'] : '',
							'WS_MailState'			=> isset($this->call->data['customermailstate']) ? $this->call->data['customermailstate'] : '',
							'WS_MailPostZIPCode'	=> isset($this->call->data['customermailpostcode']) ? $this->call->data['customermailpostcode'] : '',
							// Address Details
							'WS_StreetAddress'		=> isset($this->call->data['customeraddress']) ? $this->call->data['customeraddress'] : '',
							'WS_StreetSuburb'		=> isset($this->call->data['customersuburb']) ? $this->call->data['customersuburb'] : '',
							'WS_StreetCity'			=> isset($this->call->data['customercity']) ? $this->call->data['customercity'] : '',
							'WS_StreetState'		=> isset($this->call->data['customerstate']) ? $this->call->data['customerstate'] : '',
							'WS_StreetZIPCode'		=> isset($this->call->data['customerpostcode']) ? $this->call->data['customerpostcode'] : '',
							// Contact Info
							'WS_PhonePrivate'		=> isset($this->call->data['customerhomephone']) ? $this->call->data['customerhomephone'] : '',
							'WS_PhoneBus'			=> isset($this->call->data['customerworkphone']) ? $this->call->data['customerworkphone'] : '',
							'WS_MobilePhone'		=> isset($this->call->data['customermobilephone']) ? $this->call->data['customermobilephone'] : '',
							'WS_EmailAddress'		=> isset($this->call->data['customeremail']) ? $this->call->data['customeremail'] : '',
							// License and Vehicle Info
							'WS_LicenceNo'			=> isset($this->call->data['customerlicense']) ? $this->call->data['customerlicense'] : '',
							'WS_PhotoIDType'		=> isset($this->call->data['customerlicenseissued']) ? $this->call->data['customerlicenseissued'] : '',
							'WS_Vehicle'			=> isset($this->call->data['customercartype']) ? $this->call->data['customercartype'] : '',
							'WS_CarRego'			=> isset($this->call->data['customercarrego']) ? $this->call->data['customercarrego'] : '',
							
							// Marketing Info
							'WS_MarketingOptOut'			=> $this->call->data['marketing'],
							'WS_MarketingOptOutInactive'	=> $this->call->data['marketingafter'],
							
							
							
							///////////////////////////////////////////////////////////////////////////
							// Alternate Contact Person
							
							// Alternate Personal Info
							'WS_AltTitle'			=> isset($this->call->data['customeralttitle']) ? $this->call->data['customeralttitle'] : '',
							'WS_AlternateName'		=> isset($this->call->data['customeraltname']) ? $this->call->data['customeraltname'] : '',
							// Alternate Address Details
							'WS_AlternateAddress'	=> isset($this->call->data['customeraltaddress']) ? $this->call->data['customeraltaddress'] : '',
							'WS_AltSuburb'			=> isset($this->call->data['customeraltsuburb']) ? $this->call->data['customeraltsuburb'] : '',
							'WS_AlternateCity'		=> isset($this->call->data['customeraltcity']) ? $this->call->data['customeraltcity'] : '',
							'WS_AlternateState'		=> isset($this->call->data['customeraltstate']) ? $this->call->data['customeraltstate'] : '',
							'WS_AlternateZIPCode'	=> isset($this->call->data['customeraltpostcode']) ? $this->call->data['customeraltpostcode'] : '',
							// Alternate Contact Info
							'WS_AlternatePhone'		=> isset($this->call->data['customeraltphone']) ? $this->call->data['customeraltphone'] : '',
							'WS_AltMobile'			=> isset($this->call->data['customeraltmobile']) ? $this->call->data['customeraltmobile'] : '',
							'WS_AltEmail'			=> isset($this->call->data['customeraltemail']) ? $this->call->data['customeraltemail'] : '',
							
							///////////////////////////////////////////////////////////////////////////
							// Alternate Contact Person
							'WS_ORCustomerEmailSend'=> FALSE,
							'WS_WebID'				=> $this->call->data['customeremail'],
							'WS_WebServicePassword' => $this->webpass,
							));
	
	if(isset($this->call->data['customerpass']) && $this->call->data['customerpass']!='')
		{
		$this->params('WS_Password',$this->call->data['customerpass']); 	
		}
	
	
	// Process the SOAP Call
	$this->process();
	}


public function editEmailPass()
	{
	//$this->clear();
	
	$iname = isset($this->call->data['customercode']) && $this->call->data['customercode']!='' ? $this->call->data['customercode'] : $this->facilitycode;
	
	// Set The Request
	$this	->request('WS_CustomerEdit')
			->prepare()
			->params(array(	
							///////////////////////////////////////////////////////////////////////////
							// Customer Info
							
							// Customer Code and Password
							'WS_Inputname' 			=> $iname,
							// Personal Info
							'WS_CustomerName'		=> $this->call->data['customersurname'].', '.$this->call->data['customerfirstname'],
							'WS_FirstName'			=> $this->call->data['customerfirstname'],
							
							// Mailing Details
							'WS_MailAddress'		=> $this->call->data['customermailaddress'],
							'WS_MailSuburb'			=> $this->call->data['customermailsuburb'],
							'WS_MailCity'			=> $this->call->data['customermailcity'],
							'WS_MailState'			=> $this->call->data['customermailstate'],
							'WS_MailPostZIPCode'	=> $this->call->data['customermailpostcode'],
							
							// Contact Info
							'WS_MobilePhone'		=> $this->call->data['customermobilephone'],
							'WS_EmailAddress'		=> $this->call->data['customeremail'],
							'WS_WebID'				=> $this->call->data['customeremail'],
							
							///////////////////////////////////////////////////////////////////////////
							// Alternate Contact Person
							'WS_WebServicePassword' 	=> $this->webpass,
							));
	
	if(isset($this->call->data['customerpass']) && $this->call->data['customerpass']!='')
		{
		$this->params('WS_Password',$this->call->data['customerpass']); 	
		}
	
	
	// Process the SOAP Call
	$this->process();
	}




/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_SetPassword Request Parameters
	
WS_Inputname 			- !REQUIRED! 	- Text(10)	[Concatenation of facility code and customer code. e.g. SSCTYSMITH]
WS_Password				- !REQUIRED! 	- Text(50)	[Customer Account Password]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_SetPassword Response Variables

WS_ORSuccess			- Boolean	[Will return true/false values]
WS_ORErrorCode			- Integer	[Will return a numerical code for the error to match the WS_ORErrorDescription field]
WS_ORErrorDescription	- Text(~)	[Will return a textual description of the WS_ErrorCode]


}*/

public function setPassword()
	{
	$this	->request('WS_SetPassword')
			->prepare()
			->params(array(	
							'WS_Inputname' 			=> $this->call->data['customercode'],
							'WS_Password' 			=> $this->call->data['customerpass'],
							'WS_WebServicePassword' => $this->webpass							
							))
			->process();
	}


/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_SetPassword Request Parameters
	
WS_CustomerID 			- !REQUIRED! 	- Text(10)	[Concatenation of facility code and customer code. e.g. SSCTYSMITH]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_SetPassword Response Variables

WS_ORSuccess			- Boolean	[Will return true/false values]
WS_ORErrorCode			- Integer	[Will return a numerical code for the error to match the WS_ORErrorDescription field]
WS_ORErrorDescription	- Text(~)	[Will return a textual description of the WS_ErrorCode]


}*/

public function resetPassword()
	{
	$this	->request('WS_ResetCustPassword')
			->prepare()
			->params(array(	
							'WS_CustomerID' 		=> $this->call->data['customercode'],
							'WS_WebServicePassword' => $this->webpass							
							))
			->process();
	}





/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddContact Request Parameters
	
WS_CTContactName		- !REQUIRED! 	- Text(40)		[Customer name, usually last name, firstname]
WS_CTTitle				- !REQUIRED!	- Text(15)		[Salutation e.g. Mr, Ms, Mrs]
WS_CTFirstName 			- !REQUIRED!	- Text(20)		[First name of customer]
WS_CTUserName 			- Optional		- Text(40)		[Customer name, usually last name, firstname]
	

WS_CTMailAddress 		- Optional		- Text(~)		[First part of mailing address]
WS_CTMailCity 			- Optional		- Text(30)		[City of the mailing address]
WS_CTMailState 			- Optional		- Text(30)		[UK:Country, CA,SA,TH:Province, NZ:Not applicable]
WS_CTMailZIPCode  		- Optional		- Text(10)		[Mailing Postcode/Zip Code]
WS_CTMailCountry 		- Optional		- Text(50)		[Mailing address country]


WS_CTContactPhone		- Optional		- Text(15)		[Home phone of the sales enquiry - N.B. This is used for matching previous quotes]
WS_CTPhoneBus			- Optional		- Text(15)		[Business phone of sales enquiry]
WS_CTMobilePhone 		- Optional		- Text(15)		[Mobile phone of sales enquiry]
WS_CTEmailAddress		- Optional		- Text(80)		[Email address of sales enquiry]
WS_CTOrganization 		- Optional		- Boolean		[True if a company]

WS_CTMarketSrce			- Optional		- Text(30)		[Use market sources from Storman. e.g. Internet Search, Friend]
WS_CTCustType 			- Optional		- Text(30)		[Use customer types from Storman. e.g. Residential, Business, Government]
WS_CTCategory 			- Optional		- Text(30)		[How the enquiry got in contact e.g. Walk-In, Phone Call]

WS_CTStoredBefore 		- Optional		- Integer		[0:Unknown, 1:Yes, 2:No]
WS_CTStoredGoods		- Optional		- Text(40)		[What they want to store in the unit]

WS_CTWhenRequired		- Optional 		- Text(10) 		[YYYY-MM-DD]
WS_CTExpDuration		- Optional		- Integer		[Expected time for rental]

WS_CTFacility			- !REQUIRED!	- Integer		[Expected time for rental]

// Quote Data
WS_asQTAnalysisCode		- !REQUIRED!	- StrArr(8)		[Unique identifier for analysis code in Storman]
WS_asQTPrice			- !REQUIRED!	- IntArr(30)	[Price for the unit. Usually 1 month]
WS_asQTSize				- !REQUIRED!	- StrArr(30)	[Size for the unit / qty for stock. Size for unit must be pre-fixed with "Unit Type:"]
WS_asQTUnitTypeCode 	- !REQUIRED!	- StrArr(15)	[Unit Type ID in Storman]
WS_asQTNote 			- Optional		- StrArr(80)	[Additional notes for the quote]
WS_CTOldContactNo		- Optional		- Text(~)



WS_WebServicePassword 	- !REQUIRED! 	- Text(~)		[Storman Web Services Password]
WS_CallTakenBy			- Optional		- Text(~)		[Name of the person who took the enquiry]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CustomerEdit Response Variables

WS_CTContactNo			- Text(15)	[With return enquiry ID if completed otherwise; Invalid:No match to old number found, Incorrect Password: Wrong Web services password.]
	
}*/

public function addSalesLead()
	{
	//$this->clear();
	
	$this	->request('WS_AddContact1')
			->prepare()
			->params(array(	
							'WS_CTFacility'				=> $this->facilitycode,
							
							// Personal Info
							'WS_CTContactName'			=> $this->call->data['customerfullname'],
							'WS_CTTitle'				=> $this->call->data['customertitle'],
							'WS_CTFirstname'			=> $this->call->data['customerfirstname'],
							'WS_CTUserName'				=> $this->call->data['customercontact'],
							
							// Mailing Details
							'WS_CTMailAddress'			=> $this->call->data['customeraddress'],
							'WS_CTMailCity'				=> $this->call->data['customersuburb'],
							'WS_CTMailState'			=> $this->call->data['customerstate'],
							'WS_CTMailZIPCode'			=> $this->call->data['customerpostcode'],
														
							// Contact Info
							'WS_CTContactPhone'			=> $this->call->data['customerhome'],
							'WS_CTPhoneBus'				=> $this->call->data['customerwork'],
							'WS_CTMobilePhone'			=> $this->call->data['customermobile'],
							'WS_CTEmailAddress'			=> $this->call->data['customeremail'],
							'WS_CTOrganization' 		=> $this->call->data['isbusiness'],
							
							'WS_CTMarketSrce'			=> 'Web',
							'WS_CTCustType'				=> '',
							'WS_CTCategory'				=> 'Web',
							'WS_CTStoredBefore'			=> 0,
							'WS_CTStoredGoods'			=> '',
							
							'WS_ContactDate'			=> $this->call->data['resdate'],
							'WS_CTExpDuration'			=> '',
							
							
							
							'WS_asQTAnalysisCode'		=> $this->call->data['analysiscode'],
							'WS_asQTPrice'				=> $this->call->data['unitrate'],
							'WS_asQTSize'				=> $this->call->data['unitsizes'],
							'WS_asQTUnitTypeCode'		=> $this->call->data['unittype'],
							'WS_asQTNote'				=> $this->call->data['note'],
							'WS_CTOldContactNo'			=> '',
							'WS_CallTakenBy'			=> 'Website',
							'WS_CTFollowUpDate'			=> $this->call->data['resdate'],
							
							'WS_WebServicePassword' 	=> $this->webpass
							));
	
	
	if(isset($this->call->data['customerpassword']))
		{
		$this->params('WS_Password', $this->call->data['customerpassword']);
		}
	
	// Process the SOAP Call
	$this->process();
	}


/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_ConvertContact1 Request Parameters

WS_CTContactNo			- !REQUIRED! 	- Text(5)	[Sales Lead ID]
WS_MoveInDate			- !REQUIRED! 	- Date		[Date of the expcted move-in]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_ConvertContact1 Response Variables

WS_CustomerID			- Text(10)	[Will return string of customer ID / code.]
WS_ReservationID		- Text(8)	[Will return string of reservation number.]
WS_ORSuccess			- Boolean	[Will return true/false values]
WS_ORErrorCode			- Integer	[Will return a numerical code for the error to match the WS_ORErrorDescription field]
WS_ORErrorDescription	- Text(~)	[Will return a textual description of the WS_ErrorCode]


}*/

public function convertLead()
	{
	//$this->clear();
	
	$this	->request('WS_ConvertContact1')
			->prepare()
			->params(array(	'WS_CTContactNo'		=> $this->call->data['saleslead'],
							'WS_MoveInDate'			=> $this->call->data['required'],
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}





/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CreateReservation Request Parameters
	
WS_ORFacilityCode 		- !REQUIRED! 	- Text(5)	[Facility 5 digit code]
WS_ORCustomerName 		- !REQUIRED! 	- Text(50)	[Customer name]
WS_ORCustomerEmail 		- Optional		- Text(80)	[Customer email]	
WS_ORCustomerEmailSend 	- Optional		- Boolean	[Send email to customer confirming reservation. Set to no because the site will handle emails]
WS_ORFacilityEmailSend 	- Optional		- Boolean	[Send email to facility advising of reservation. Set to no because the site will handle emails]
WS_ORCustomerPhone 		- Optional		- Text(25)	[Customer phone]

WS_ORUnitTypeCode 		- !REQUIRED! 	- Text(15)	[UnitType code determines type of unit to reserve.]
WS_ORDateUnitRequired 	- !REQUIRED! 	- Text(10) 	[YYYY-MM-DD]
WS_ORUnitRateSelected 	- Optional		- Text(1)	[Monthly (M) or Weekly (W)]	

WS_Username 			- Optional		- Text(10)	[CustomerCode if an existing customer]
WS_CustPass 			- Optional		- Text(20)	[Updates the password for online services, such as StorPay]

WS_ORUnitSelect 		- Optional		- Text(~)	[Use to specify exact unit to rent]
WS_OREnquiryNo 			- Optional		- Text(10)	[Use to update sales enquiry to new outcome]

WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

WS_CTCustType 			- Optional		- Text(~)	[Use customer types from Storman. e.g. Residential, Business, Government. Will set Contacts(CustType) and Customer(CustType)]
WS_CallTakenBy 			- Optional		- Text(~)	[Set name of person who placed reserevation. Will set Reservation(CallTakenBy), Reservation(UserLogin), Contacts(CallTakenBy)]
WS_CTStoredBefore 		- Optional		- Integer	[If not set to 0, Contacts(StoredBefore) is set]
WS_MarketSrce 			- Optional		- Text(~)	[Use marketing sources from Storman. e.g. Internet, Friend. Will set Customer(MarketSrce) and Contacts(MarketSrce)]
WS_CustomRate 			- Optional		- Real		[Sets unit quoted rate]
WS_CustomRateSet 		- Optional		- Boolean	[If true, quoted rate is set to the WS_CustomRate field]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CreateReservation Response Variables

WS_ORSuccess			- Boolean	[Will return true/false values]
WS_ORErrorCode			- Integer	[Will return a numerical code for the error to match the WS_ORErrorDescription field]
WS_ORErrorDescription	- Text(~)	[Will return a textual description of the WS_ErrorCode]
WS_CustomerID			- Text(10)	[Will return string of customer ID / code.]
WS_ReservationID		- Text(8)	[Will return string of reservation number.]

}*/

public function createReservation()
	{
	//$this->clear();
	
	$this	->request('WS_CreateReservation')
			->prepare()
			->params(array(	// Core Info
							'WS_ORFacilityCode'			=> $this->facilitycode, 							// REQUIRED!!!
							'WS_ORCustomerName' 		=> $this->call->data['customername'], 				// REQUIRED!!!
							'WS_ORCustomerEmail' 		=> $this->call->data['customeremail'],
							
							// Use Website upon response for handling
							'WS_ORCustomerEmailSend' 	=> 0,
							'WS_ORFacilityEmailSend' 	=> 0,
							
							'WS_ORCustomerPhone' 		=> $this->call->data['customerphone'],
							
							// UnitType Code
							'WS_ORUnitTypeCode'			=> $this->call->data['unittype'],					// REQUIRED!!!
							'WS_ReservedDate'			=> $this->call->data['resdate'], 					// REQUIRED!!! YYYY-MM-DD format
							'WS_ORUnitRateSelected'		=> 'M',												// Monthly (M) or Weekly (W)
							
							// Existing Customer Details
							'WS_Username'				=> $this->call->data['customercode'], 				// Required
							'WS_CustPass'				=> $this->call->data['customerpass'],				// Required
							
							// Web Services Password
							'WS_WebServicePassword' 	=> $this->webpass,
							
							// Marketing Info
							'WS_CTCustType'				=> 'Website',
							'WS_CallTakenBy'			=> 'Website',
							'WS_CTStoredBefore'			=> 0,
							'WS_MarketSrce'				=> 'Website',
							
							// Rate Handling
							//'WS_CustomRate'				=> $this->call->data['unitrate'],
							//'WS_CustomRateSet'			=> 1
							))
			->process();
	}



/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetReservationInfo Request Parameters
	
WS_vtReservationNumber	- !REQUIRED! 	- Text(13)	[Concatenation of FacilityCode and Reservation Number. e.g. SSCTY00001234]
WS_vtPassword			- !REQUIRED!	- Text(20)	[Password to confirm access to customer agreement]




///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetReservationInfo Response Variables
	
WS_vtStorerName			- Text(~)	[Name of the customer]
WS_vdLastBillDate		- Date		[Date of reservation and when the deposit was billed]
WS_vdNextDueDate		- Date		[Next billing / due date]
WS_vrDueNowAmt			- Real		[Amount currently owing]
WS_vrNextDueAmt 		- Real		[Next due amount]
WS_vrTotalDueAmt		- Real		[Amount currently owing]
WS_vrLastBillAmt		- Real		[Amount of last bill]
WS_vtEmailAddress		- Text(~)	[Email address of the customer]
WS_vtError				- Text(~)	[Error response:
										0: Agreement / Password Correct, Agreement info supplied
										1: No password entered in Storman
										2: No password supplied for Logon
										3: Incorrect password supplied for logon
										4: Incorrect agreement supplied for logon
										5: Duplicate agreement found
									]
WS_viRestrictions		- Integer	[Return -1]
WS_vtAllowPartPayment	- Text(~)	[0: Must pay all of DueNowAmt, 1: Can pay all of part of DueNowAmt]
	
}*/

public function getReservationInfo()
	{
	//$this->clear();
		
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetUnitTypes Request Parameters
	
WS_FacilityCode			- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]
WS_VacantAll			- !REQUIRED! 	- Boolean	[True excludes unit with status 'Unavailable']

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetUnitTypes Response Variables
	
WS_UTDescription		- Array		[String array of the unit descriptions]
WS_UTMonthlyRate		- Array		[Float array of the unit prices]
WS_UTBillPlanCode		- Array		[String array of the billing plan code for each unit]
WS_UTDispOnlineReserve	- Array		[Set if the unit should appear online]
WS_UTRCSpecial 			- Array		[Boolean array indicating if on special or not]
WS_UTRUnitType 			- Array		[String array with the unique identifier for the units]
WS_UTUnitCategory		- Array		[String array with the unit category]
WS_UTSortOrder 			- Array		[Integer array]
WS_UTNoVacant 			- Array		[Integer array indicating the number of available units for that unit type]
WS_UTSizeCategory 		- Array		[String array of the unit size category]
WS_UTMonthlySpecialRate	- Array		[Float array of special rates for units]
WS_UTNoTotal			- Array		[Float array of the counts available for each type]
WS_UTUnitTypeLength		- Array		[Float array unit lengths]
WS_UTUnitTypeWidth		- Array		[Float array unit widths]
}*/

public function getUnitTypes()
	{
	//$this->clear();
	
	$this	->request('WS_GetUnitTypes2')
			->prepare()
			->params(array(	
							'WS_FacilityCode' 		=> $this->facilitycode,
							'WS_WebServicePassword' => $this->webpass,
							'WS_VacantAll'			=> false,
							'WS_RetrieveAll'		=> false
							))
			->process();
	}



/*{

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetUnitStatuses Request Parameters
	
WS_FacilityID			- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]




///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetUnitStatuses Response Variables
	
WS_asUTRUnitNo			- Array		[String array of the unit numbers]
WS_asUTAgreeNo			- Array		[String array of rge agreement numbers]
WS_atUTStatus			- Array		[String array of status for each unit]
WS_atUTBldgLocation		- Array		[String array of location of unit in building]
WS_atCustomerName		- Array		[String array of customer names]
WS_UTDescription		- Array		[String array of unit descriptions]
WS_Error				- Boolean	[Advising if successful or not]	
}*/

public function getUnitStatus()
	{
	//$this->clear();
	
	$this	->request('WS_GetUnitStatuses')
			->prepare()
			->params(array(	
							'WS_FacilityID' 		=> $this->facilitycode,
							'WS_WebServicePassword' => $this->webpass
							))
			->process();	
	}

public function getUnitStatus2()
	{
	//$this->clear();
	
	$this	->request('WS_GetUnitStatuses2')
			->prepare()
			->params(array(	
							'WS_FacilityID' 		=> $this->facilitycode,
							'WS_WebServicePassword' => $this->webpass
							))
			->process();	
	}




/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetIns Request Parameters

WS_FacilityID			- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetIns Response Variables

WS_EndValue	 			- Array(~)	[Insurance Rate End Values]
WS_Facility	 			- Array(~)	[Facility Codes]
WS_Premium	 			- Array(~)	[Rate Premiums]
WS_InsuranceTypeID		- Array(~)	[Primary Key]
WS_Repeat	 			- Array(~)	[Repeat Values]
WS_StartValue 			- Array(~)	[Start Values]
WS_Verify	 			- Array(~)	[Rate Verifications]

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function getInsurance()
	{
	//$this->clear();
	
	$this	->request('WS_GetIns2')
			->prepare()
			->params(array(	
							'WS_FacilityID'			=> $this->facilitycode,
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}







/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CancelReservation Request Parameters
	
WS_ResNo				- !REQUIRED! 	- Text(13)	[Reservation number, including facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_CancelReservation Response Variables
	
WS_Edit 				- Boolean	[True if reservation was cancelled]
}*/

public function cancelReservation()
	{
	//$this->clear();	
	
	$this	->request('WS_CancelReservation')
			->prepare()
			->params(array(	
							'WS_ResNo' 				=> $this->call->data['resno'],
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_ConvertReservation Request Parameters
	
WS_ResNo				- !REQUIRED! 	- Text(13)	[Reservation number, including facility code]
WS_RAgreeNo				- !REQUIRED! 	- Text(14)	[Agreement number to convert to. If blank, will create a new agreement]
WS_MoveInDate 			- !REQUIRED!	- Date		[The date of the move in]
WS_Locked				- !REQUIRED!	- Boolean	[If true, will locked the customer and status for the new agreement]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_ConvertReservation Response Variables

WS_RAgreeNo				- Text(14)	[The agreement number the reservation was converted to]
WS_Edit 				- Boolean	[True if reservation was converted into an agreement]
WS_CustomerID			- Text(10)	[Customer code of the customer. Invalid if not found / could not be created.]
WS_UnitsOccupied		- Text(~)	[Unit numbers used for the agreement, separated by commas]
}*/

public function convertReservation()
	{
	//$this->clear();	
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetAgreementInfo Request Parameters
	
WS_vtAgreementNumber 	- !REQUIRED! 	- Text(14)	[Concatenation of facility code and agreement number. e.g. SSCTY000012345]
WS_vtPassword			- !REQUIRED! 	- Text(20)	[Password to confirm access to the agreement]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetAgreementInfo Response Variables

WS_vtStorerName 		- Text(~)	[Customer name]
WS_vdLastBillDate 		- Date		[Last billing date]
WS_vdNextDueDate		- Date		[Next billing date]
WS_vrDueNowAmt			- Real		[Amount currently owing]
WS_vrNextDueAmt 		- Real		[Next amount due]
WS_vrTotalDueAmt		- Real		[Amount currently owing]
WS_vrLastBillAmt 		- Real		[Last billed amount]
WS_vtEmailAddress  		- Text(~)	[Customer email address]
WS_vtError				- Text(~)	[Error response:
										0: Agreement / Password Correct, Agreement info supplied
										1: No password entered in Storman
										2: No password supplied for Logon
										3: Incorrect password supplied for logon
										4: Incorrect agreement supplied for logon
										5: Duplicate agreement found
									]
WS_viRestrictions		- Integer	[Return -1]
WS_vtAllowPartPayment	- Text(~)	[0: Must pay all of DueNowAmt, 1: Can pay all of part of DueNowAmt]
}*/

public function getAgreement()
	{
	//$this->clear();
	
	$this	->request('WS_GetAgreementInfoNoPW')
			->prepare()
			->params(array(	
							'WS_vtAgreementNumber' 	=> $this->call->data['agrno'],
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetPricing Request Parameters
	
WS_asAnalysis 			- !REQUIRED! 	- Text(14)	[Concatenation of facility code and agreement number. e.g. SSCTY000012345]
WS_aQuantity			- !REQUIRED! 	- Text(20)	[Password to confirm access to the agreement]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetPricing Response Variables

WS_vtStorerName 		- Text(~)	[Customer name]
WS_vdLastBillDate 		- Date		[Last billing date]
WS_vdNextDueDate		- Date		[Next billing date]
WS_vrDueNowAmt			- Real		[Amount currently owing]
WS_vrNextDueAmt 		- Real		[Next amount due]
WS_vrTotalDueAmt		- Real		[Amount currently owing]
WS_vrLastBillAmt 		- Real		[Last billed amount]
WS_vtEmailAddress  		- Text(~)	[Customer email address]
WS_vtError				- Text(~)	[Error response:
										0: Agreement / Password Correct, Agreement info supplied
										1: No password entered in Storman
										2: No password supplied for Logon
										3: Incorrect password supplied for logon
										4: Incorrect agreement supplied for logon
										5: Duplicate agreement found
									]
WS_viRestrictions		- Integer	[Return -1]
WS_vtAllowPartPayment	- Text(~)	[0: Must pay all of DueNowAmt, 1: Can pay all of part of DueNowAmt]
}*/

public function getPricing()
	{
	//$this->clear();
	
	$this	->request('WS_GetPricing')
			->prepare()
			->params(array(	
							'WS_asAnalysis' 		=> $this->call->data['analysiscode'],
							'WS_aQuantity' 			=> $this->call->data['analysisqtys'],
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}





/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddReceiptTrx Request Parameters
	
WS_asAnalysis 			- !REQUIRED! 	- Text(14)	[Concatenation of facility code and agreement number. e.g. SSCTY000012345]
WS_aQuantity			- !REQUIRED! 	- Text(20)	[Password to confirm access to the agreement]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetPricing Response Variables

WS_vtStorerName 		- Text(~)	[Customer name]
WS_vdLastBillDate 		- Date		[Last billing date]
WS_vdNextDueDate		- Date		[Next billing date]
WS_vrDueNowAmt			- Real		[Amount currently owing]
WS_vrNextDueAmt 		- Real		[Next amount due]
WS_vrTotalDueAmt		- Real		[Amount currently owing]
WS_vrLastBillAmt 		- Real		[Last billed amount]
WS_vtEmailAddress  		- Text(~)	[Customer email address]
WS_vtError				- Text(~)	[Error response:
										0: Agreement / Password Correct, Agreement info supplied
										1: No password entered in Storman
										2: No password supplied for Logon
										3: Incorrect password supplied for logon
										4: Incorrect agreement supplied for logon
										5: Duplicate agreement found
									]
WS_viRestrictions		- Integer	[Return -1]
WS_vtAllowPartPayment	- Text(~)	[0: Must pay all of DueNowAmt, 1: Can pay all of part of DueNowAmt]
}*/

public function addReceipt()
	{
	//$this->clear();
	
	$this	->request('WS_AddReceiptTrx1')
			->prepare()
			->params(array(	
							'WS_SeqNo' 				=> '0',
							'WS_AgreeNo2' 			=> $this->call->data['agreement'],
							'WS_Analysis'			=> $this->call->data['cardcode'],
							'WS_BankBranch'			=> '',
							'WS_CCAuthNo'			=> $this->call->data['exchangeid'],
							'WS_CCTransID'			=> $this->call->data['uuid'],
							'WS_Description'		=> 'Online payment via website',
							'WS_Drawer'				=> '',
							'WS_TotAmt'				=> $this->call->data['amount'],
							'WS_TrxDate'			=> date('Y-m-d'),
							'WS_UserLogin'			=> 'Website',
							'WS_DateBanked'			=> date('Y-m-d'),
							'WS_OriginalReceipt'	=> $this->call->data['receipt'],
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}






/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_OnlineOrder Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_ORCustomerName		- !REQUIRED! 	- Text(~)	[Customer Name]
WS_ORCustomerEmail		- !REQUIRED! 	- Text(~)	[Customer Email]
WS_ORCustomerPhone		- !REQUIRED! 	- Text(~)	[Customer Phone]
WS_StreetAddress		- !REQUIRED! 	- Text(~)	[Customer Address]
WS_StreetSuburb			- !REQUIRED! 	- Text(~)	[Customer Suburb]
WS_StreetCity			- !REQUIRED! 	- Text(~)	[Customer City]
WS_StreetState			- !REQUIRED! 	- Text(~)	[Customer State]
WS_StreetZIPCode		- !REQUIRED! 	- Text(~)	[Customer Postcode]

WS_CustPass				- !REQUIRED! 	- Text(~)	[Customer Password]
WS_CTCustType			- !REQUIRED! 	- Text(~)	[Customer Type]

WS_CallTakenBy			- !REQUIRED! 	- 'Boxshop'	[Customer Password]

WS_asQTAnalysisCode		- !REQUIRED! 	- Array		[List of Analysis Codes]
WS_asQTPrice			- !REQUIRED! 	- Array		[List of Prices]
WS_asAnalysisQty		- !REQUIRED! 	- Array		[List of Qtys]
WS_asDiscount			- Optional	 	- Array		[List of Discounts on Each Item]

WS_MerchPlanID			- !REQUIRED! 	- Array		[List of Merchandise Plan Codes]
WS_MerchPlanQty			- !REQUIRED! 	- Array		[List of Merchandise Plan Qtys]

WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_OnlineOrder Response Variables

WS_CustomerID	 		- Text(~)	[Customer Code]
WS_AgreementID 			- Text(~)	[Agreement / Credit Sale ID]
WS_OrderID	 			- Text(~)	[Order ID]

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function onlineOrder()
	{
	//$this->clear();
	
	$this	->request('WS_OnlineOrder')
			->prepare()
			->params(array(	
							'WS_ORFacilityCode'		=> $this->call->data['faccode'],
							
							'WS_ORCustomerName'		=> $this->call->data['name'],
							'WS_ORCustomerEmail'	=> $this->call->data['email'],
							'WS_ORCustomerPhone'	=> $this->call->data['phone'],
							
							'WS_StreetAddress'		=> $this->call->data['address'],
							'WS_StreetSuburb'		=> $this->call->data['suburb'],
							'WS_StreetCity'			=> '',
							'WS_StreetState'		=> $this->call->data['state'],
							'WS_StreetZIPCode'		=> $this->call->data['postcode'],
							
							'WS_CustPass'			=> '',
							'WS_CTCustType'			=> 'Other',
							
							'WS_CallTakenBy'		=> 'BoxShop',
							
							'WS_asQTAnalysisCode'	=> $this->call->data['items'],
							'WS_asQTPrice'			=> $this->call->data['prices'],
							'WS_asAnalysisQty'		=> $this->call->data['qtys'],
							'WS_asDiscount'			=> $this->call->data['discounts'],
							
							'WS_MerchPlanID'		=> $this->call->data['packids'],
							'WS_MerchPlanQty'		=> $this->call->data['packqtys'],
							
							'WS_WebServicePassword' => $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddAgreement Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_ORCustomerName		- !REQUIRED! 	- Text(~)	[Customer Name]
WS_ORCustomerEmail		- !REQUIRED! 	- Text(~)	[Customer Email]
WS_ORCustomerEmailSend	- !REQUIRED! 	- Boolean	[Send Customer Email upon Creation]
WS_ORFacilityEmailSend	- !REQUIRED! 	- Boolean	[Send Facility Email upon Creation]
WS_ORCustomerPhone		- !REQUIRED! 	- Text(~)	[Customer Phone]
WS_ORUnitTypeCode		- !REQUIRED! 	- Text(~)	[Unit Type Code]
WS_MoveInDate			- !REQUIRED! 	- Date		[Move In Date]
WS_Username				- !REQUIRED! 	- Text(10)	[Customer Code]
WS_ORWeekly				- !REQUIRED! 	- Boolean	[True for weekly, false for monthly]
WS_CustPass				- Optional	 	- Text(~)	[Customer Password]
WS_Locked				- !REQUIRED! 	- Boolean	[Lock customer and agreement]
WS_OREnquiryNo			- Optional	 	- Text(~)	[Sales Enquiry Number]
WS_AdHoc				- !REQUIRED! 	- Boolean	[True for AdHoc, False for Regular]
WS_CTCustType			- !REQUIRED! 	- Text(~)	[Customer Type Residential, Government, Commercial, Other]
WS_CallTakenBy			- !REQUIRED! 	- 'MoveIns'	[User that is submitting the order]
WS_stDigAgmtID			- Optional	 	- Text(~)	[Digital Storage Agreement ID]
WS_inDigAgmtID			- Optional	 	- Text(~)	[Insurance PDS ID]

WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddAgreement Response Variables

WS_CustomerID	 		- Text(~)	[Customer Code]
WS_AgreementID 			- Text(~)	[Agreement / Credit Sale ID]
WS_OrderID	 			- Text(~)	[Order ID]

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function addAgreement()
	{
	//$this->clear();
	
	$this	->request('WS_AddAgreement3')
			->prepare()
			->params(array(	
							'WS_ORFacilityCode'			=> $this->facilitycode,
							
							'WS_ORCustomerName'			=> $this->call->data['name'],
							'WS_ORCustomerEmail'		=> $this->call->data['email'],
							'WS_ORCustomerEmailSend'	=> false,
							'WS_ORFacilityEmailSend'	=> false,
							'WS_ORCustomerPhone'		=> $this->call->data['phone'],
							
							'WS_ORUnitTypeCode'			=> $this->call->data['unittype'],
							'WS_MoveInDate'				=> $this->call->data['movein']
							));
	
	if(isset($this->call->data['notices']))
		{
						
		$this->params(array('WS_SendNoticesSMS'			=> true,
							'WS_SendNoticesEmail'		=> true
							));
		}
	
						
	$this->params(array(	'WS_SendNotices'			=> false,
							'WS_SendOptionalInvoices'	=> false,
							'WS_SendOptionalStatements'	=> false,							
							
							'WS_Username'				=> $this->call->data['customercode'],
							
							'WS_ORWeekly'				=> false,
							'WS_Locked'					=> false,
							'WS_OREnquiryNo'			=> $this->call->data['enquiryno'],
							'WS_AdHoc'					=> false,
							
							'WS_CTCustType'				=> $this->call->data['custtype'],
							'WS_CallTakenBy'			=> 'Website',
							
							'WS_WebServicePassword' 	=> $this->webpass
							));
	
	
	if(isset($this->call->data['unitnumber']))
		{
						
		$this->params(array('WS_ORUnitSelect' => $this->call->data['unitnumber']));
		}
	
	
	
	$this->process();
	}




/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_EditAgreement Request Parameters

WS_RAgreeNo					- !REQUIRED! 	- String(5)	[The agreement number]
WS_DaytoBill				- Optional	 	- Int(~)	[Day of month to bill]
WS_MthsAdv					- Optional	 	- Float(~)	[Mths in advance to bill]
WS_vAutoPay					- Optional	 	- Boolean	[Use autopayments or not]
WS_AutopayAmt				- Optional	 	- Float(~)	[Amount to pay]
WS_AutoPayType				- Optional	 	- String(~)	[Auto pay type]
WS_NewBillingPlan			- Optional	 	- String(~)	[New billing plan, if changing]
WS_SendNotices				- Optional	 	- Boolean	[Send notices]
WS_SendOptionalInvoices		- Optional	 	- Boolean	[Send optional invoices]
WS_SendOptionalStatements	- Optional	 	- Boolean	[Send optional statements]
WS_NoticeDaysPrior			- Optional	 	- Float(~)	[Day prior to billing date to send reminder]
WS_SendNoticesEmail			- Optional	 	- Boolean	[Send notices by email]
WS_SendNoticesSMS			- Optional	 	- Boolean	[Send notices by SMS]
WS_NoticePlanNo				- Optional	 	- Float(~)	[Agreement notice plan]
WS_InsureValue				- Optional	 	- Float(~)	[Insurance Value]
WS_InsureCertNo				- Optional	 	- Float(~)	[Insurance Certificate]
WS_AnticipateMoveOut		- Optional	 	- Date		[Expected Move Out Date]
WS_AuthCCSigned				- Optional	 	- Date		[Date CC auth signed]
WS_AuthCCExpiry				- Optional	 	- Date		[Autpay Expiry Date]
WS_MoveInDate				- Optional	 	- Date		[Move In Date]
WS_End_Date					- Optional	 	- Date		[Expected move out date]
WS_OutNoticeDate			- Optional	 	- Date		[Date noteice of move out was provided]

WS_WebServicePassword 		- !REQUIRED! 	- Text(~)	[Storman Web Services Password]



///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_EditAgreement Response Variables

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function editInsurance()
	{
	//$this->clear();
	
	$this	->request('WS_EditInsurance1')
			->prepare()
			->params(array(	
							'WS_ORFacilityCode'			=> $this->facilitycode,
							'WS_RAgreeNo'				=> $this->call->data['agreement'],
							'WS_UpdateAgree'			=> TRUE,
							'WS_InsureCert'				=> $this->call->data['insurcert'],
							'WS_InsureAmt'				=> $this->call->data['insurance'],
							
							'WS_asUnitNo'				=> $this->call->data['units'],
							'WS_asInsureCert'			=> $this->call->data['certs'],
							'WS_asInsureAmt'			=> $this->call->data['amounts'],
							
							'WS_WebServicePassword' 	=> $this->webpass
							))
			->process();
	}





/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddPDF Request Parameters

WS_Picture				- !REQUIRED! 	- Text(5)	[File encoded as base 64]
WS_Cust_Code			- !REQUIRED! 	- Text(~)	[Customer Name]
WS_File_Name			- !REQUIRED! 	- Text(~)	[Filename]
WS_Extension			- !REQUIRED! 	- Text(~)	[File extenstion, .pdf or .jpg]
WS_Thumbnail			- !REQUIRED! 	- Base64(~)	[Picture to be used as thumbnail]


WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddPDF Response Variables

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function addPDF()
	{
	//$this->clear();
	
	$this	->request('WS_AddPDF')
			->prepare()
			->params(array(	
							'WS_Picture'			=> $this->call->data['file'],
							'WS_Cust_Code'			=> $this->call->data['customercode'],
							'WS_File_Name'			=> $this->call->data['filename'],
							'WS_Extension'			=> $this->call->data['extension'],
							'WS_Thumbnail'			=> $this->call->data['thumb'],
							
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddNote Request Parameters

WS_NoteID				- !REQUIRED! 	- Text(5)	[Customer ID, Agreement No or Sales Enquiry]
WS_Note					- !REQUIRED! 	- Text(~)	[Note Contents]
WS_NoteAlert			- !REQUIRED! 	- Text(~)	[If this should be an alert when opening profile]
WS_NoteCategory			- !REQUIRED! 	- Text(~)	[Category for note]

WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddPDF Response Variables

WS_NoteReturnID			- String	[Customer Code note assigned to]
WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function addNote()
	{
	//$this->clear();
	
	if(isset($this->call->data['notealert']) && $this->call->data['notealert']=='1')
		{
		$this	->request('WS_AddNote1')
				->prepare()
				->params(array(	
								'WS_NoteID'				=> $this->call->data['assignto'],
								'WS_Note'				=> $this->call->data['notecontents'],
								'WS_NoteAlert'			=> TRUE,
								'WS_NoteCategory'		=> $this->call->data['category'],
								'WS_WebServicePassword'	=> $this->webpass
								))
				->process();
		}
	else
		{
		$this	->request('WS_AddNote1')
				->prepare()
				->params(array(	
								'WS_NoteID'				=> $this->call->data['assignto'],
								'WS_Note'				=> $this->call->data['notecontents'],
								'WS_NoteAlert'			=> FALSE,
								'WS_NoteCategory'		=> $this->call->data['category'],
								'WS_WebServicePassword'	=> $this->webpass
								))
				->process();
		}
	}





/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(5)	[The unique facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Response Variables

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/
public function retrieveFacility()
	{
	//$this->clear();
	
	$this	->request('WS_RetrievingFacilityDetailsExt')
			->prepare()
			->params(array(	
							'WS_FacilityCode'		=> $this->facilitycode,
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Request Parameters

WS_WebID				- !REQUIRED! 	- Text(~)	[Email address for customer]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Response Variables

WS_atCustCodes			- Array		[Array of customer codes matching the email]
WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/
public function getCodes()
	{
	//$this->clear();
	
	$this	->request('WS_GetCustCodes')
			->prepare()
			->params(array(	
							'WS_WebID'				=> $this->call->data['customeremail'],
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetEziFees1 Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(~)	[Facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Response Variables

WS_CCtype1				- Array		[Array of card types]
WS_FixedFee1			- Array		[Array of card fixed fee, if applicable]
WS_PercentFee1			- Array		[Array of card transaction fee, if applicable]
WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/
public function getEziFees()
	{
	//$this->clear();
	
	$this	->request('WS_GetEziFees1')
			->prepare()
			->params(array(	
							'WS_ORFacilityCode'		=> $this->facilitycode,
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}



/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_GetEziFees1 Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(~)	[Facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Response Variables

WS_CCtype1				- Array		[Array of card types]
WS_FixedFee1			- Array		[Array of card fixed fee, if applicable]
WS_PercentFee1			- Array		[Array of card transaction fee, if applicable]
WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/
public function getMarketingTypes()
	{
	//$this->clear();
	
	$this	->request('WS_GetMarketingTypes1')
			->prepare()
			->params(array(	
							'WS_ORFacilityCode'		=> $this->facilitycode,
							'WS_TypeCode'			=> 'FI',
							'WS_TypeSites'			=> FALSE,
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}




/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_DoBilling1 Request Parameters

WS_ORFacilityCode		- !REQUIRED! 	- Text(~)	[Facility code]
WS_WebServicePassword 	- !REQUIRED! 	- Text(~)	[Storman Web Services Password]

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_RetrievingFacilityDetailsExt Response Variables

WS_CCtype1				- Array		[Array of card types]
WS_FixedFee1			- Array		[Array of card fixed fee, if applicable]
WS_PercentFee1			- Array		[Array of card transaction fee, if applicable]
WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/
public function doBilling()
	{
	//$this->clear();
	
	$this	->request('WS_DoBilling1')
			->prepare()
			->params(array(	
							'WS_AgreeNo2'			=> $this->call->data['agreement'],
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}




/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// AddChargeTrx1 Request Parameters



}*/
public function addCharge()
	{
	//$this->clear();
	
	$this	->request('WS_AddChargeTrx1')
			->prepare()
			->params(array(	
							'WS_SeqNo'				=> '0',
							'WS_AgreeNo2'			=> $this->call->data['reservation'],
							'WS_Analysis'			=> $this->call->data['analysis'],
							'WS_Customer'			=> $this->call->data['customercode'],
							'WS_Description'		=> '',
							'WS_TotAmt'				=> $this->call->data['total'],
							'WS_TrxDate'			=> date('Y-m-d'),
							'WS_UserLogin'			=> 'OnlineStore',
							'WS_Quantity'			=> '',
							'WS_Narration'			=> 'Order placed via online reservations',
							'WS_WebServicePassword'	=> $this->webpass
							))
			->process();
	}


}
