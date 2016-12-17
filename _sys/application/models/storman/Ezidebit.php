<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * 	Ezidebit Class
 *
 *	Author: 	Luke Pelgrave
 * 	Date:		2016-01-12		
 *	Version:	v1.0
 *	Details:	EziDebit API class offering a range of Storman API functions
 *
 */

class Ezidebit extends CI_Model {

// Connection Configuration
private $liveurl		= 'https://api.ezidebit.com.au/v3-5/nonpci';		// Live URL
private $devurl 		= 'https://api.demo.ezidebit.com.au/v3-5/nonpci';	// Dev URL
private $testmode		= '1';												// 1 = Dev, 0 = Live
private $digitalkey		= '';												// Digital Key
private $publickey		= '';												// Public Key

// Method Settings
private $format			= 'NUSOAP'; // Options are SOAP or NUSOAP
private $feedtimeout	= '3';		// Number of seconds to try finding the feed before returning FALSE
private $resptimeout	= '15';		// Number of seconds to wait for a response before returning FALSE


// Header Checker
public $headercheck		= 2; 		// Set to 1 if you want the script to verify the server is accessible before connecting.
public $headercode		= NULL;		// Used for checking if server is available.

// Feed and Process Variables
public $feed			= array();	// The feed from EziDebit.
public $request			= NULL;		// The API call with EziDebit.
public $data			= array();	// Data builder
public $params			= array();	// Array of params to pass to EziDebit API call.
public $response		= NULL;		// Response check
public $result			= array();	// The result from the request
public $resultfield		= NULL;		// Field name for status of EziDebit API Call.
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


public function dkey($k)
	{
	$this->digitalkey = $k;
	
	return $this;	
	}

public function pkey($k)
	{
	$this->publickey = $k;
	
	return $this;	
	}

public function request($r)
	{
	$this->request = $r;
	
	return $this;	
	}

public function data($p, $v=NULL)
	{
	if(is_array($p))
		{
		$this->data = !empty($this->data) ? array_merge($this->data, $p) : $p;
		}
	elseif($v!=NULL)
		{
		$this->data[$p] = $v;
		}
	
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
		if($this->testmode=='1')
			{
			$this->feed = new nusoap_client($this->devurl.'?singleWsdl', true);
			}
		else
			{
			$this->feed = new nusoap_client($this->liveurl.'?singleWsdl', true);	
			}
		
		$this->feed->soap_defencoding = 'UTF-8';
		
		// Feed configuration
		$this->feed->timeout = $this->feedtimeout;
		
		$this->feed->response_timeout = $this->resptimeout;
			
		// Check if feed is an object
		if(is_object($this->feed))
			{
			// Run our call
			$this->result = $this->feed->call($this->request, $this->params, '', '', false, true);
			
			if(!isset($this->result['Error']) || isset($this->result['Error']) && $this->result['Error']!=='0')
				{
				// Record the error
				$this->error();
				}
			else
				{
				// Log our actual response
				$this->logger();	
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

public function error()
	{
	$this->response(false);
	
	if(isset($this->result['Error']))
		{
		$this->errorcode($this->result['Error'])->errormsg($this->result['ErrorMessage']);		
		}
	else
		{
		$this->errorcode('0')->errormsg('Unknown error');	
		}
	
	// Set Data for Recording Error
	$error = array(	'errortime' 		=> date('Y-m-d H:i:s'),
					'errorcode' 		=> json_encode($this->errorcode),
					'errorfunction' 	=> $this->request,
					'errormessage' 		=> trim($this->errormsg),
					'errorparameters' 	=> json_encode($this->params),
					'errorresponse' 	=> json_encode($this->result)					
					);
	
	// Insert the record into the DB
	$this->db->insert('stormanerrors', $error);
	
	// Set the error response for sending back to user
	$codes = !empty($this->errorcode) ? implode(',', $this->errorcode) : 'Unknown';
	
	$this->error = $this->errormsg.'. [Error Code: '.$codes.']';
	
	}

public function logger()
	{
	$this->response(true);
	
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
	unset($this->feed, $this->params, $this->data, $this->resultfield, $this->request);
	$this->params		= array();
	$this->data			= array();
	$this->resultfield 	= NULL;
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
		$header = get_headers('http://'.$this->serverip.':'.$this->serverport.'/4dwsdl');
		$headercode = is_array($header) && isset($header[0]) ? explode(' ', $header[0]) : array();	
		$this->headercode = !empty($headercode) && isset($headercode[1]) ? $headercode[1] : '200';
		}
	else
		{
		$this->headercode = 200;
		}
	}
	
private function prepare()
	{	
	// For each postdata field
	if(!empty($this->data))
		{
		foreach($this->data as $key => $data)
			{
			// Swicth out the field name for data modifcation
			switch($key)
				{
				// Boolean Field
				case 'sampleboolean':
				$this->data[$key] = $data=='1' || $data=='on' ? 1 : 0;
				break;
				// If not an item to modify
				default:
				$this->data[$key] = $data;
				break;				
				}
			}
		}
	
	return $this;
	}





/*{
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// GetCustomerFees Request Parameters

DigitalKey				- !REQUIRED! 	- Text(36)	[ED Digital Key]
EziDebitCustomerID		- !REQUIRED! 	- Text(~)	[ED Customer ID - Either This or Sys Ref, not both]
YourSystemReference		- !REQUIRED! 	- Text(50)	[ED System Reference - Either This or ED Customer ID, not both]
PaymentSource			- !REQUIRED! 	- Text(~)	[ALL, SCHEDULED, WEB or PHONE]
Username				- Optional 		- Text(~)	[Reference, e.g. Webuser]


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// WS_AddPDF Response Variables

WS_ORSuccess			- Boolean	[True if submitted]
WS_ORErrorCode			- Int		[Error Code ID]
WS_ORErrorDescription	- Boolean	[Error Code Message]

}*/

public function GetCustomerFees()
	{
	//$this->clear();
	
	$this	->request('GetCustomerFees')
			->prepare()
			->params(array(	
							'DigitalKey'			=> $this->digitalkey,
							'EziDebitCustomerID'	=> $this->data['customerid'],
							'YourSystemReference'	=> $this->data['ref'],
							'PaymentSource'			=> $this->data['sources'],
							//'Username'				=> 'Webuser',
							))
			->process();
	}



}
