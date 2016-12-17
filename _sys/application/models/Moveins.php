<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moveins extends CI_Model {

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Move In Variables

var $sesname	= 'spm_order';	// Name for session
var $user		= array();		// User data
var $faccode	= '';			// Facility Code
var $facinfo	= array();		// Facility info
var $unittypes	= array();		// Unit Types
var $unitcats	= array();		// Unit Categories
var $units		= array();		// Unit Listing
var $order		= array();		// Order details
var $novacancy	= '';			// No vacancy warning
var $cuscode	= '';			// Customer Code
var $customer	= array();		// Customer data
var $unitcode	= '';			// Unit Code
var $unitnum	= '';			// Unit Number
var $agreement	= '';			// Agreement Number
var $signature	= '';			// Signature Image File
var $signsec	= '';			// Secondary Signature Image File
var $pdfname	= '';			// Filename for signature and PDF
var $basefee	= '';			// Base Fee / Flagfall Amount
var $fees		= array();		// List of fees for payments
var $basefees	= array();		// List of the base fees for each payment method
var $devpay		= '0';			// Override Payment Amount for ED

var $emailhead	= '';			// Email Header Image
var $emailfoot	= '';			// Email Footer Image

var $emailheader= '';
var $emailfooter= '';

var $noreply	= 'no-reply@storman.com';	// No reply email address
var $message	= '';			// Completed Message
var $inline		= '0';			// If the calls should be made inline
var $region		= array();		// Regional settings
var $idtypes	= array();		// ID Types


//////////////////////////////////////////////////////////////////
// Initialiser
public function init()
	{
	$this->noreply = 'no-reply@storman.com';
	
	if(isset($_GET['lo']))
		{
		$this->user = $this->session->userdata($this->sesname);
		
		unset($this->user['customer'], $this->user['customercode']);
		
		$this->session->set_userdata($this->sesname, $this->user);
		}
	
	$this->user = $this->session->userdata($this->sesname);
	
	if(isset($this->user['facilitycode']) && $this->user['facilitycode']!='')
		{
		$this->faccode = $this->user['facilitycode'];
		
		$this->facinfo();
		}
	
	if(isset($this->user['customer']) && !empty($this->user['customer']))
		{
		$this->customer = $this->user['customer'];
		$this->customer['customercode'] = isset($this->user['customercode']) ? $this->user['customercode'] : '';
		}
	
	if(isset($this->user['order']) && !empty($this->user['order']))
		{
		$this->order = $this->user['order'];
		
		$movein = isset($this->order['unitfrom']) && $this->order['unitfrom']!='' ? explode('-', $this->order['unitfrom']) : array();
		
		$this->order['moveinday'] 	= isset($movein[2]) ? $movein[2] : '';
		$this->order['moveinmonth'] = isset($movein[1]) ? $movein[1] : '';
		$this->order['moveinyear'] 	= isset($movein[0]) ? $movein[0] : '';
		
		if($_SERVER['REMOTE_ADDR']=='203.206.137.6')
			{
			//die(print_r($this->order));	
			}
		}
	
	$this->emailhead = $this->emailhead!='' ? $this->emailhead : 'images/storman_email_header.jpg';
	$this->emailfoot = $this->emailfoot!='' ? $this->emailfoot : 'images/storman_email_footer.jpg';
	
	$this->regioning();
	
	//echo '<pre>';die(print_r($this->customer));
	
	return $this;
	}

private function regioning()
	{
	$this->load->model('storman/regioning');
	
	$this->regioning->init();
	}

public function offline()
	{
	if(method_exists($this, 'api') && isset($this->api->headercheck) && $this->api->headercheck=='1' && $this->api->headercode!='200')
		{
		$this->page->view = array('movein/offline');
		$this->page	->head('pagetitle', 'System Offline')
					->nosteps(1);	
		}
	
	return $this;
	}

public function inline($i)
	{
	$this->inline = $i; return $this;	
	}

//////////////////////////////////////////////////////////////////
// User Loader
public function userdata($f, $b=NULL)
	{	
	if(isset($this->user[$f]) && $this->user[$f]!='')
		{
		if($this->user[$f]!='')
			{
			echo $this->user[$f];	
			}
		else
			{
			if($b!=NULL)
				{
				echo $b;	
				}
			}	
		}
	else
		{
		if($b!=NULL)
			{
			echo $b;	
			}
		}
	}

public function custdata($f, $b=NULL)
	{
	if(isset($this->customer[$f]))
		{
		if($this->customer[$f]!='')
			{
			echo $this->customer[$f];	
			}
		else
			{
			if($b!=NULL)
				{
				echo $b;	
				}
			}
		}
	else
		{
		if($b!=NULL)
			{
			echo $b;	
			}
		}
	}

public function orderdata($f, $b=NULL)
	{
	if(isset($this->order[$f]))
		{
		if($this->order[$f]!='')
			{
			echo $this->order[$f];	
			}
		else
			{
			if($b!=NULL)
				{
				echo $b;	
				}
			}
		}
	else
		{
		if($b!=NULL)
			{
			echo $b;	
			}
		}
	}

//////////////////////////////////////////////////////////////////
// Facility Finder
public function finder()
	{
	$r = $this->db	->select('facilities.facilitycode, facilities.facilityname, companies.companyname')
					->like('facilityname', $this->page->postdata['term'])	
					->join('companies', 'companies.coid = facilities.coid', 'left')	
					->get('facilities')->result_array();
	
	$l = array();
	
	if(!empty($r))
		{
		foreach($r as $i)
			{
			$n = isset($i['companyname']) ? stripslashes($i['facilityname'].' - '.$i['companyname']) : stripslashes($i['facilityname']);
			
			$l[] = array(	'id' => $i['facilitycode'],
							'label' => $n
							);
			}
		}
	
	!empty($l) 
		? $this->page->response($l)	
		: $this->page->error('No results found.');
	
	$this->page->respond();	
	}

//////////////////////////////////////////////////////////////////
// Facility Loader
public function facility()
	{
	$this->page	->required('facilitycode', 'The facility code is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->user['facilitycode'] = $this->page->postdata['facilitycode'];
		
		$this->session->set_userdata($this->sesname, $this->user);
		
		$this->page->success('Facility set');
		}
			
	$this->page->respond();	
	}

public function facautoset()
	{
	if($this->uri->segment(3) && $this->uri->segment(2)=='facility')
		{
		$f = $this->db->where('facilitycode', $this->uri->segment(3))->get('facilities');
		
		if($f->num_rows()==1)
			{		
			$this->user['facilitycode'] = $this->faccode = $this->uri->segment(3);
			
			$this->session->set_userdata($this->sesname, $this->user);
			
			header('Location: /reservation/unit');
			die();
			}
		else
			{
			$this->page->error('Sorry but the facility code you entered was not found.');	
			}
		}
	elseif($this->uri->segment(2) && $this->uri->segment(1)!='ajax')
		{
		$f = $this->db->where('facilitycode', $this->uri->segment(2))->get('facilities');
		
		if($f->num_rows()==1)
			{		
			$this->user['facilitycode'] = $this->faccode = $this->uri->segment(2);
			
			$this->session->set_userdata($this->sesname, $this->user);
			
			header('Location: /unit');
			die();
			}
		else
			{
			$this->page->error('Sorry but the facility code you entered was not found.');	
			}
		}
		
	return $this;
	}

//////////////////////////////////////////////////////////////////
// Facility Info
public function facinfo($r=NULL)
	{
	if(isset($this->faccode) && empty($this->facinfo))
		{
		$this->facinfo = $this->db->where('facilitycode', $this->faccode)->join('companies', 'companies.coid = facilities.coid', 'left')->get('facilities')->row_array();
		
		if(empty($this->facinfo) && $r!=NULL)
			{
			header('Location: /'.$r);
			$this->session->set_flashdata('error', 'The facility information could not be found.');
			die();	
			}
		elseif(!empty($this->facinfo))
			{			
			$this->facinfo['facilityfullname'] = isset($this->facinfo['companyname']) && $this->facinfo['companyname']!=''
				? $this->facinfo['companyname'].' '.$this->facinfo['facilityname']
				: $this->facinfo['facilityname'];
				
			$this->facinfo['facilityaddress'] = $this->facinfo['facilityaddressb']!='' ? $this->facinfo['facilityaddressa'].' '.$this->facinfo['facilityaddressb'] : $this->facinfo['facilityaddressa'];
			
			if($this->facinfo['facilitylogo']!='')
				{
				$this->facinfo['logo'] = 'facilities/'.$this->facinfo['facilitylogo']; 	
				}
			elseif($this->facinfo['companylogo']!='')
				{
				$this->facinfo['logo'] = 'companies/'.$this->facinfo['companylogo'];	
				}
			else
				{
				$this->facinfo['logo'] = 'images/storman_logo.jpg';	
				}
			
			if($this->facinfo['facilityemailheader']!='')
				{
				$this->emailhead = 'facilities/header/'.$this->facinfo['facilityemailheader']; 	
				}
			elseif($this->facinfo['companyemailheader']!='')
				{
				$this->emailhead = 'companies/header/'.$this->facinfo['companyemailheader'];	
				}
			else
				{
				$this->emailhead = 'images/storman_email_header.jpg';	
				}
			
			if($this->facinfo['facilityemailfooter']!='')
				{
				$this->emailfoot = 'facilities/footer/'.$this->facinfo['facilityemailfooter']; 	
				}
			elseif($this->facinfo['companyemailfooter']!='')
				{
				$this->emailfoot = 'companies/footer/'.$this->facinfo['companyemailfooter'];	
				}
			else
				{
				$this->emailfoot = 'images/storman_logo.jpg';	
				}
			
			
			// Now get the StorMan Data
			$this->load->model('storman/call');
			
			$this->call	->facility($this->facinfo['facilitycode'])
						->password($this->facinfo['facilitywebservicepass'])
						->server($this->facinfo['facilitywebserviceurl'])
						->port($this->facinfo['facilitywebserviceport'])
						->init()
						->retrieveFacility();
			
			if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']==true)
				{
				$fk = '';
				
				$this->facinfo['facilityfees'] = isset($this->api->result['WS_CustFees']) ? $this->api->result['WS_CustFees'] : '';	
				
				foreach($this->api->result['WS_asFacilityCode'] as $k => $c)
					{
					$fk = isset($this->faccode) && $c==$this->faccode ? $k : $fk;	
					}
				
				if($fk!='')
					{
					$this->facinfo['facilitynumber']	= isset($this->api->result['WS_UserCode'][$fk]) 			? $this->api->result['WS_UserCode'][$fk] 			: '';
					$this->facinfo['facilityname'] 		= isset($this->api->result['WS_asFacility_Name'][$fk]) 		? $this->api->result['WS_asFacility_Name'][$fk] 	: $this->facinfo['facilityname'];
					$this->facinfo['facilityemail'] 	= isset($this->api->result['WS_asFacility_Email'][$fk]) 	? $this->api->result['WS_asFacility_Email'][$fk] 	: $this->facinfo['facilityemail'];
					$this->facinfo['facilityphone'] 	= isset($this->api->result['WS_asFacility_Phone'][$fk]) 	? $this->api->result['WS_asFacility_Phone'][$fk] 	: $this->facinfo['facilityphone'];
					$this->facinfo['facilityaddressa'] 	= isset($this->api->result['WS_asFacility_Address'][$fk]) 	? $this->api->result['WS_asFacility_Address'][$fk] 	: $this->facinfo['facilityaddressa'];
					$this->facinfo['facilitysuburb'] 	= isset($this->api->result['WS_asFacility_City'][$fk]) 		? $this->api->result['WS_asFacility_City'][$fk] 	: $this->facinfo['facilitysuburb'];
					$this->facinfo['facilitystate'] 	= isset($this->api->result['WS_asFacility_Suburb'][$fk]) 	? $this->api->result['WS_asFacility_Suburb'][$fk] 	: $this->facinfo['facilitystate'];
					$this->facinfo['facilitypostcode'] 	= isset($this->api->result['WS_asFacility_Postcode'][$fk]) 	? $this->api->result['WS_asFacility_Postcode'][$fk] : $this->facinfo['facilitypostcode'];
					
					}
				}
			}
		}
	
	return $this;
	}

//////////////////////////////////////////////////////////////////
// Facility Unit Loader
public function units()
	{
	//echo '<pre>';die(print_r($this->user));
	
	$this->facinfo();
	
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getUnitTypes();
	
	if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
		{
		header('Location: /facility');
		$this->session->set_flashdata('error', 'There was an error retrieving the facility units. Please try a different facility.');
		die();	
		}
	else
		{
		// Get facility units
		$f = $this->db->where('fcid', $this->facinfo['fcid'])->get('units')->result_array();
		
		$l = array();
		
		if(!empty($f))
			{
			foreach($f as $g)
				{
				$l[$g['unitcode']] = $g;	
				}
			}
		
		foreach($this->api->result['WS_UTRUnitType'] as $k => $c)
			{
			$u = array();
			
			$u['unitcode'] 		= $c;
			$u['unitarea'] 		= isset($this->api->result['WS_UTArea'][$k]) 				? $this->api->result['WS_UTArea'][$k] 			: '';
			$u['unitwidth'] 	= isset($this->api->result['WS_UTUnitTypeWidth'][$k]) 		? $this->api->result['WS_UTUnitTypeWidth'][$k] 	: '';
			$u['unitdepth'] 	= isset($this->api->result['WS_UTUnitTypeLength'][$k]) 		? $this->api->result['WS_UTUnitTypeLength'][$k] : '';
			$u['unitvacant']	= isset($this->api->result['WS_UTNoVacant'][$k]) 			? $this->api->result['WS_UTNoVacant'][$k] 		: '0';
			$u['unitrate'] 		= isset($this->api->result['WS_UTMonthlyRate'][$k]) 		? $this->api->result['WS_UTMonthlyRate'][$k] 	: '';
			$u['unitcategory'] 	= isset($this->api->result['WS_UTUnitCategory'][$k]) 		? $this->api->result['WS_UTUnitCategory'][$k] 	: '';
			$u['unitsizecat'] 	= isset($this->api->result['WS_UTSizeCategory'][$k]) 		? $this->api->result['WS_UTSizeCategory'][$k] 	: '';
			$u['unitdesc'] 		= isset($this->api->result['WS_UTDescription'][$k]) 		? $this->api->result['WS_UTDescription'][$k] 	: '';
			$u['unitdeposit'] 	= isset($this->api->result['WS_arUTUnitTypeDeposit'][$k]) 	? $this->api->result['WS_arUTUnitTypeDeposit'][$k] : '';
			
			$u['unitarea'] 		= $u['unitarea']!='' 		? number_format($u['unitarea'], 2, '.', ',').'sqm' 	: '';
			$u['unitwidth'] 	= $u['unitwidth']!='' 		? number_format($u['unitwidth'], 2, '.', ',') 		: '';
			$u['unitdepth'] 	= $u['unitdepth']!='' 		? number_format($u['unitdepth'], 2, '.', ',') 		: '';
			$u['unitdeposit'] 	= $u['unitdeposit']!='' 	? number_format($u['unitdeposit'], 2, '.', ',') 	: '';
			
			$u['unitname']		= isset($l[$c]['unitname']) 	? $l[$c]['unitname'] 	: $u['unitcategory']!='Not Found' && $u['unitcategory']!='' ? $u['unitcategory'].' - '.$u['unitdesc'] : $u['unitdesc'];
			$u['unitwebdesc']	= isset($l[$c]['unitdesc']) 	? $l[$c]['unitdesc'] 	: '';
			$u['unitimage']		= isset($l[$c]['unitimage'])	? $l[$c]['unitimage'] 	: '';
			
			if($u['unitvacant'] > 0)
				{
				$cat = strtolower(str_replace(' ', '', $u['unitcategory']));
				$siz = strtolower(str_replace(' ', '', $u['unitsizecat']));
				
				switch($this->facinfo['facilityunitmethod'])
					{
					case '2':
					if($cat!='')
						{
					$this->unitcats[$cat] = $u['unitcategory'];
					!empty($this->unitcats) ? array_unique($this->unitcats) : $this->unitcats;
					$u['matchcode'] = $cat;
					$u['unitname']	= isset($l[$c]['unitname'])	? $l[$c]['unitname'] : $u['unitsizecat']!='Not Found' && $u['unitsizecat']!='' ? $u['unitsizecat'].' - '.$u['unitdesc'] : $u['unitdesc'];
						}
					break;
					case '3':
					if($siz!='')
						{
					$this->unittypes[$siz] = $u['unitsizecat'];
					!empty($this->unittypes) ? array_unique($this->unittypes) : $this->unittypes;
					$u['matchcode'] = $siz;
					$u['unitname']	= isset($l[$c]['unitname'])	? $l[$c]['unitname'] : $u['unitcategory']!='Not Found' && $u['unitcategory']!='' ? $u['unitcategory'].' - '.$u['unitdesc'] : $u['unitdesc'];
						}
					break;
					case '4':
					if($siz!='' && $cat!='')
						{
					$this->unittypes[$siz] = $u['unitsizecat'];
					!empty($this->unittypes) ? array_unique($this->unittypes) : $this->unittypes;
					//$this->unitcats[$siz.$cat] = array('category' => $u['unitcategory'], 'size' => $siz);	
					if(isset($this->unitcats[$cat]))
						{
						$this->unitcats[$cat]['sizes'][$siz] = $siz;	
						}
					else
						{
						$this->unitcats[$cat] = array('category' => $u['unitcategory'], 'sizes' => array($siz => $siz));	
						}
					
					$u['matchcode'] = $siz.$cat;
					$u['unitname']	= isset($l[$c]['unitname'])	? $l[$c]['unitname'] : $u['unitcategory']!='Not Found' && $u['unitcategory']!='' ? $u['unitcategory'].' - '.$u['unitdesc'] : $u['unitdesc'];
					$u['unitname'] = $u['unitsizecat']!='Not Found' && $u['unitsizecat']!='' ? $u['unitsizecat'].' - '.$u['unitname'] : $u['unitname'];
						}
					break;
					case '5':
					if($siz!='' && $cat!='')
						{
					$this->unitcats[$cat] = $u['unitcategory'];
					!empty($this->unitcats) ? array_unique($this->unitcats) : $this->unitcats;
					//$this->unittypes[$cat.$siz] = array('category' => $cat, 'size' => $u['unitsizecat']);
					if(isset($this->unittypes[$siz]))
						{
						$this->unittypes[$siz]['cats'][$cat] = $cat;	
						}
					else
						{
						$this->unittypes[$siz] = array('size' => $u['unitsizecat'], 'cats' => array($cat => $cat));	
						}
					
					$u['matchcode'] = $cat.$siz;	
					$u['unitname'] = isset($l[$c]['unitname'])	? $l[$c]['unitname'] : $u['unitsizecat']!='Not Found' && $u['unitsizecat']!='' ? $u['unitsizecat'].' - '.$u['unitdesc'] : $u['unitdesc'];
					$u['unitname'] = $u['unitcategory']!='Not Found' && $u['unitcategory']!='' ? $u['unitcategory'].' - '.$u['unitname'] : $u['unitname'];
						}
					break;
					}
				
				$this->units[$c] = $u;
				}
			}
		
		if(empty($this->units))
			{
			$this->novacancy = 'Sorry but there are no units available at ';
			
			$this->novacancy .= isset($this->facinfo['companyname']) && $this->facinfo['companyname']!=''
				? $this->facinfo['companyname'].' '.$this->facinfo['facilityname'].'.'
				: $this->facinfo['facilityname'].'.';
			}
		
		//echo '<pre>';die(print_r($this->unitcats));
		
		//!empty($this->unitcats) ? array_unique($this->unitcats) : $this->unitcats;
		//!empty($this->unittypes) ? array_unique($this->unittypes) : $this->unittypes;
		}
	
	
	$this->unitnums();
	
	return $this;
	}

public function unitnums()
	{
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getUnitStatus2();
	
	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']==true && !empty($this->api->result['WS_asUTRUnitNo']))
		{
		$l = array();
		
		foreach($this->api->result['WS_asUTRUnitNo'] as $k => $n)
			{
			$m = str_replace(array($this->faccode, strtoupper($this->faccode), strtolower($this->faccode)), '', $n);
			
			$t = isset($this->api->result['WS_Types'][$k]) ? str_replace($this->faccode, '', $this->api->result['WS_Types'][$k]) : '';
			
			if($t!='' && isset($this->api->result['WS_atUTStatus'][$k]) && $this->api->result['WS_atUTStatus'][$k]=='Vacant')
				{
				$l[$t][$n] = $m;	
				}
			}
		
		if(!empty($l))
			{
			$f = fopen($_SERVER['DOCUMENT_ROOT'].'/_med/unitids/'.$this->faccode.'.json', 'w+');
			
			fwrite($f, json_encode($l));
			
			fclose($f);
			}
		}
	}

//////////////////////////////////////////////////////////////////
// Unit Number Selector
public function unitfinder()
	{
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/unitids/'.$this->faccode.'.json'))
		{
		$u = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/_med/unitids/'.$this->faccode.'.json'), true);
		
		$f = isset($u[$this->page->postdata['unitcode']]) ? $u[$this->page->postdata['unitcode']] : array();
		
		$l = array();
		
		if(!empty($f))
			{
			foreach($f as $g)
				{
				if(strpos($g, $this->page->postdata['unitselection'])!==false)
					{
					$l[] = array('label' => $g, 'value' => $g);	
					}
				}
			
			!empty($l)
				? $this->page->response($l)
				: $this->page->response(array(array('label' => 'No matches', 'value' => -1)));
			}
		}
	
	$this->page->respond();
	}

//////////////////////////////////////////////////////////////////
// Unit Selection
public function unit()
	{
	$this->page	->required('unitcode', 'The unit code is missing.')
				//->required('ordermoveinday', 'You must set the day you want to move in.')
				//->required('ordermoveinmonth', 'You must set the month you want to move in.')
				//->required('ordermoveinyear', 'You must set the year you want to move in.')
				;
	
	$this->page->validate();
	
	/*
	if(	$this->page->postdata['ordermoveinday']!='' &&
		$this->page->postdata['ordermoveinmonth']!='' &&
		$this->page->postdata['ordermoveinyear']!='' &&
		checkdate($this->page->postdata['ordermoveinmonth'], $this->page->postdata['ordermoveinday'], $this->page->postdata['ordermoveinyear'])!==true) 
		{
		$this->page->error('The date is invalid.');
		}
		
	$this->page->postdata['ordermovein'] = $this->page->postdata['ordermoveinyear'].'-'.$this->page->postdata['ordermoveinmonth'].'-'.$this->page->postdata['ordermoveinday'];
	
	if($this->page->postdata['ordermovein'] < date('Y-m-d', strtotime('today')))
		{
		$this->page->error('You cannot start a booking in the past.');	
		}
	*/
	if(!isset($this->page->response['error']))
		{
		$this->user['order']['unitcode'] 	= $this->page->postdata['unitcode'];
		$this->user['order']['unitnumber'] 	= isset($this->page->postdata['unitselection']) ? $this->page->postdata['unitselection'] : '';
		//$this->user['order']['unitfrom'] 	= $this->page->postdata['ordermovein'];
		//$this->user['order']['unitto'] 		= date('Y-m-d', strtotime('-1 day', strtotime('+1 month', strtotime($this->page->postdata['ordermovein']))));
		$this->user['order']['unitrate'] 	= $this->page->postdata['unitrate'];
		$this->user['order']['unitdeposit'] = $this->page->postdata['unitdeposit'];
		
		$this->user['order']['unitsizes'] 	= isset($this->page->postdata['unitsizes']) ? $this->page->postdata['unitsizes'] : '';
		$this->user['order']['unitcats'] 	= isset($this->page->postdata['unitcats']) ? $this->page->postdata['unitcats'] : '';
		
		
		$this->session->set_userdata($this->sesname, $this->user);
		
		$this->page->success('Unit set');
		}
			
	$this->page->respond();	
	}

//////////////////////////////////////////////////////////////////
// Customer Login
public function customer()
	{
	$this->facinfo('facility');
	
	//echo '<pre>';die(print_r($this->user));
	
	if(isset($this->user['customer']) && isset($this->user['customercode']) && $this->user['customercode']!='')
		{
		$this->customer = $this->user['customer'];
		$this->customer['customercode'] = $this->user['customercode'];
		
		$this->customer['customersurname'] = isset($this->customer['isbusiness']) && $this->customer['isbusiness']=='1' ? $this->customer['contactname'] : $this->customer['customersurname'];
		}
	else
		{
		$this->cusconvert();
		}
	
	
	$this->idtypes();
	
	//echo '<pre>';die(print_r($this->customer));
	
	return $this;
	}

private function idtypes()
	{
	// Get the marketing types
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getMarketingTypes();
	
	$r = $this->api->result;
	
	if(isset($r['WS_ORSuccess']) && $r['WS_ORSuccess']==1)
		{
		foreach($r['WS_asDescriptions'] as $d)
			{
			$this->idtypes[$d] = $d;
			}
		}
	}

private function cusconvert()
	{
	if(isset($this->user['customer']) && !empty($this->user['customer']))
		{
		unset($this->user['customer']['WS_ORSuccess'], $this->user['customer']['WS_ORErrorCode'], $this->user['customer']['WS_ORErrorDescription']);
		
		$c = array(	'customercode' 			=> 'WS_Inputname',
					
					'customertitle' 		=> 'WS_Title',
					'customerfirstname' 	=> 'WS_FirstName',
					'customerfullname' 		=> 'WS_CustomerName',
					'customerhomephone' 	=> 'WS_PhonePrivate',
					'customerworkphone' 	=> 'WS_PhoneBus',
					'customermobilephone' 	=> 'WS_MobilePhone',
					'customeremail' 		=> 'WS_EmailAddress',
					
					'customeraddress' 		=> 'WS_StreetAddress',
					'customerstate' 		=> 'WS_StreetState',
					'customerpostcode' 		=> 'WS_StreetZIPCode',
					
					'customermailaddress' 	=> 'WS_MailAddress',
					'customermailstate' 	=> 'WS_MailState',
					'customermailpostcode' 	=> 'WS_MailPostZIPCode',
					
					'customerlicense' 		=> 'WS_LicenceNo',
					'customerlicenseissued' => 'WS_PhotoIDType', //'WS_LicenseState', old one
					'customercartype' 		=> 'WS_Vehicle',
					'customercarrego' 		=> 'WS_CarRego',
					
					'customeralttitle' 		=> 'WS_AltTitle',
					'customeraltname' 		=> 'WS_AlternateName',
					'customeraltmobile' 	=> 'WS_AltMobile',
					'customeraltemail' 		=> 'WS_AltEmail',
					
					'customeraltaddress' 	=> 'WS_AlternateAddress',
					'customeraltstate' 		=> 'WS_AlternateState',
					'customeraltpostcode' 	=> 'WS_AlternateZIPCode',
					
					
					);
		
		foreach($c as $k => $f)
			{
			$this->customer[$k] = isset($this->user['customer'][$f]) ? $this->user['customer'][$f] : '';	
			}
		
		$surname = isset($this->customer['customerfullname']) ? explode(',', $this->customer['customerfullname']) : array();
		$this->customer['customersurname'] = isset($surname[0]) ? $surname[0] : '';
		
		$altname = isset($this->customer['customeraltname']) ? explode(',', $this->customer['customeraltname'], 2) : array();
		
		$this->customer['customeraltfirstname'] = isset($altname[1]) ? trim($altname[1]) : '';
		$this->customer['customeraltlastname'] 	= isset($altname[0]) ? trim($altname[0]) : '';
		
		$dob = isset($this->user['customer']['WS_DateofBirth']) ? explode('-', $this->user['customer']['WS_DateofBirth']) : array();
		
		$this->customer['customerdobday'] 	= isset($dob[2]) ? $dob[2] : '';
		$this->customer['customerdobmonth'] = isset($dob[1]) ? $dob[1] : '';
		$this->customer['customerdobyear'] 	= isset($dob[0]) ? $dob[0] : '';
		
		$this->customer['isbusiness'] 		= isset($this->user['customer']['WS_Organization']) && $this->user['customer']['WS_Organization']==true ? 1 : 2;
		$this->customer['dualaccount'] 		= isset($this->user['customer']['WS_SecondCust']) && $this->user['customer']['WS_SecondCust']==true 	? 1 : 2;
		$this->customer['companynumber'] 	= isset($this->user['customer']['WS_ABNNo']) ? $this->user['customer']['WS_ABNNo'] : '';
		
		$this->customer['customerfirstname'] = isset($this->user['customer']['WS_Organization']) && $this->user['customer']['WS_Organization']==true ? $this->customer['customerfullname'] : $this->customer['customerfirstname'];
		
		$this->customer['contactname'] 	= isset($this->user['customer']['WS_Username']) ? $this->user['customer']['WS_Username'] : '';
		
		$this->customer['customersurname'] = $this->customer['isbusiness']=='1' ? $this->customer['contactname'] : $this->customer['customersurname'];	
		
		switch($this->facinfo['facilityregion'])
			{
			case 'CA': // Canada
			case 'TH': // Thailand
			case 'SA': // South Africa
			$this->customer['customersuburb'] 		= isset($this->user['customer']['WS_StreetCity']) 		? $this->user['customer']['WS_StreetCity'] : '';
			$this->customer['customermailsuburb'] 	= isset($this->user['customer']['WS_MailCity']) 		? $this->user['customer']['WS_MailCity'] : '';
			$this->customer['customeraltsuburb'] 	= isset($this->user['customer']['WS_AlternateCity']) 	? $this->user['customer']['WS_AlternateCity'] : '';
			break;
			case 'AU': // Australia
			case 'NZ': // New Zealand
			default:   // Default	
			$this->customer['customersuburb'] 		= isset($this->user['customer']['WS_StreetSuburb']) 	? $this->user['customer']['WS_StreetSuburb'] : '';
			$this->customer['customermailsuburb'] 	= isset($this->user['customer']['WS_MailSuburb']) 		? $this->user['customer']['WS_MailSuburb'] : '';
			$this->customer['customeraltsuburb'] 	= isset($this->user['customer']['WS_AltSuburb']) 		? $this->user['customer']['WS_AltSuburb'] : '';
			break;
			}
		
		unset($this->user['customer']['WS_ORSuccess'], $this->user['customer']['WS_ORErrorCode'], $this->user['customer']['WS_ORErrorDescription']);
		
		$this->customer['customercode'] = isset($this->user['customer']['WS_CustomerID']) ? $this->user['customer']['WS_CustomerID'] : '';
		
		$this->customer['customerpass'] = isset($this->user['customer']['pass']) ? $this->user['customer']['pass'] : '';
		
		$this->user['customer'] = $this->customer;
		
		//die(print_r($this->customer));
		
		$this->session->set_userdata($this->sesname, $this->user);
		}	
	
	return $this;
	}

//////////////////////////////////////////////////////////////////
// Customer Login
public function login()
	{
	$this->page	->required('customerexistingcode', 'You must enter your customer code.')
				->required('customerexistingpass', 'You must enter your password.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->user['customerpass'] = $this->customer['pass'] = $this->page->postdata['customerexistingpass'];
		
		$this->user['customer'] = $this->customer;
		
		$this->session->set_userdata($this->sesname, $this->user);
		
		$this->facinfo();
		
		if(strpos($this->page->postdata['customerexistingcode'], '@') > 0)
			{
			// Load StorMan Caller
			$this->load->model('storman/call');
			
			// Get accounts with that email address
			$this->call	->facility($this->faccode)
						->password($this->facinfo['facilitywebservicepass'])
						->server($this->facinfo['facilitywebserviceurl'])
						->port($this->facinfo['facilitywebserviceport'])
						->data(array(
							'customeremail' => $this->page->postdata['customerexistingcode']
							))
						->init()
						->getCodes();
			
			if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
				{
				switch($this->api->result['WS_ORErrorCode'])
					{
					case '1012':
					$this->page->error('Sorry but no customer was found matching that email. Please check your email and try again.');
					break;
					case '1099':
					$this->page->error('Sorry but no customer was found matching those details.');
					break;
					default:
					$this->page->error('There was an error connecting to the storage platform.');
					break;
					}	
				}
			else
				{
				if(count($this->api->result['WS_atCustCodes']) > 1)
					{
					$accounts = '<p>Multiple account have been found.</p><p>Please select the customer code you want to log in as.</p>';
					
					foreach($this->api->result['WS_atCustCodes'] as $code)
						{
						$accounts .= '<button type="button" class="btn col-xs-12 bg-3 bg-4-hover mrg-b-md txt-1 txt-1-hover select-code" my-id="'.$code.'">'.$code.'</button>';	
						}
					
					
					$this->page->success('Multiple accounts found with that email. Please select')->response('accounts', $accounts);	
					}
				else
					{
					$this->page->postdata['customerexistingcode'] = $this->api->result['WS_atCustCodes'][0];
					
					$this->runlogin();	
					}
				}
			}
		else
			{
			$this->runlogin();	
			}
		}
	
	if($this->inline=='0'){$this->page->respond();}
	}
	
public function confirm()
	{
	if(isset($this->page->postdata['confirmid']))
		{
		$this->page->postdata['customerexistingcode'] = $this->page->postdata['confirmid'];
		$this->page->postdata['customerexistingpass'] = isset($this->customer['pass']) ? $this->customer['pass'] : '';
			
		if(isset($this->customer['pass']) && $this->customer['pass']!='')
			{
			$this->runlogin();		
			}
		else
			{
			$this->page->error('Your password is missing. Please try reloading the page.');	
			}
		}
	
	if($this->inline=='0'){$this->page->respond();}
	}

private function runlogin()
	{
	$this->load->model('storman/call');
		
	if($this->facinfo['facilitycustomerencryption']!='')
		{
		$this->remoteencrypt('customerexistingpass');	
		}
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'customercode' => $this->page->postdata['customerexistingcode'],
					'customerpass' => $this->page->postdata['customerexistingpass']
					))
				->init()
				->loginCustomer();
				
	if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
		{
		switch($this->api->result['WS_ORErrorCode'])
			{
			case '1012':
			$this->page->error('Sorry but no customer was found matching that customer code. Please check your customer code and try again.');
			break;
			case '1029':
			$this->page->error('Sorry but your password appears to be incorrect. Please check your password and try again.');
			break;
			case '1099':
			$this->page->error('No user was found matching those details. Check your email and password and try again.');
			break;
			default:
			$this->page->error('There was an error connecting to the storage platform.');
			break;
			}
		}
	else
		{
		if($this->api->result['WS_CustomerID']=='')
			{
			$this->page->error('Sorry but there was an erro retrieving your customer details.');	
			}
		else
			{
			$this->user['customerpass'] = $this->page->postdata['customerexistingpass'];
			$this->user['customercode'] = $this->page->postdata['customerexistingcode'];
			$this->user['customer'] = $this->api->result;
			
			$this->cusconvert();
			
			$this->page->success('Customer profile found.')->response('customer', $this->customer);
			}
		}	
	}

private function remoteencrypt($p)
	{
	$f = isset($this->page->postdata[$p]) ? $this->page->postdata[$p] : $p;
	$cu = curl_init();
	
	$k = isset($this->facinfo['facilityremotekey']) ? $this->facinfo['facilityremotekey'] : '';
	
	curl_setopt($cu, CURLOPT_URL, $this->facinfo['facilitycustomerencryption']);
	curl_setopt($cu, CURLOPT_POST, 1);
	curl_setopt($cu, CURLOPT_POSTFIELDS, 'smp_auth='.$k.'&smp_pass='.$f);
	curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec ($cu);
	curl_close ($cu);
	
	$d = json_decode($res, true);
	
	$v = isset($d['success']) && $d['success']==true && isset($d['encrypted']) ? $d['encrypted'] : $f;
	
	if(isset($this->page->postdata[$p]))
		{
		$this->page->postdata[$p] = $v;	
		}
	else
		{
		return $v;	
		}
	}


//////////////////////////////////////////////////////////////////
// Customer Register
public function profile()
	{
	$this->facinfo('facility');
	
	if($this->page->postdata['isbusiness']==1)
		{
		switch($this->facinfo['facilityregion'])
			{
			case 'AU':
			$this->page	->required(
						array(	'customerfirstname'		=> 'You must enter the company / business name.',
								'customersurname' 		=> 'You must enter the company contact surname.',
								
								'customeraddress' 		=> 'You must enter the business address.',
								'customersuburb' 		=> 'You must enter the business suburb / city.',
								'customerstate' 		=> 'You must enter the business state / country or province.',
								'customerpostcode' 		=> 'You must enter the business post / zip code.',
								
								'customermailaddress' 	=> 'You must enter the business mailing address.',
								'customermailsuburb' 	=> 'You must enter the business mailing suburb / city.',
								'customermailstate' 	=> 'You must enter the business mailing state / country or province.',
								'customermailpostcode' 	=> 'You must enter the business mailing post / zip code.',
								
								'customerworkphone' 	=> 'You must enter the business phone number.',
								'customermobilephone' 	=> 'You must enter the business contact mobile / cell phone number.',
								'customeremail' 		=> 'You must enter the business email address.',
								
								'companynumber' 		=> 'You must enter the business ABN or GST Number.',
								
								'customeralttitle' 		=> 'You must select the company owner title. E.g. Mr, Mrs etc.',
								'customeraltfirstname'	=> 'You must enter the owners firstname.',
								'customeraltlastname'	=> 'You must enter the owners surname.',
								
								'customeraltaddress' 	=> 'You must enter the alternate contact address.',
								'customeraltsuburb' 	=> 'You must enter the alternate contact suburb / city.',
								'customeraltstate' 		=> 'You must enter the alternate contact state / country or province.',
								'customeraltpostcode' 	=> 'You must enter the alternate contact post / zip code.',
								
								'customeraltmobile'		=> 'You must enter the alternate contact mobile / cell phone number.',
								'customeraltemail' 		=> 'You must enter the alternate contact email address.',
							)
						);	
			break;
			
			case 'NZ':
			$this->page	->required(
						array(	'customerfirstname'		=> 'You must enter the company / business name.',
								'customersurname' 		=> 'You must enter the company contact surname.',
								
								'customeraddress' 		=> 'You must enter the business address.',
								'customersuburb' 		=> 'You must enter the business suburb / city.',
								'customerpostcode' 		=> 'You must enter the business post / zip code.',
								
								'customermailaddress' 	=> 'You must enter the business mailing address.',
								'customermailsuburb' 	=> 'You must enter the business mailing suburb / city.',
								'customermailpostcode' 	=> 'You must enter the business mailing post / zip code.',
								
								'customerworkphone' 	=> 'You must enter the business phone number.',
								'customermobilephone' 	=> 'You must enter the business contact mobile / cell phone number.',
								'customeremail' 		=> 'You must enter the business email address.',
								
								'companynumber' 		=> 'You must enter the business ABN or GST Number.',
								
								'customeralttitle' 		=> 'You must select the company owner title. E.g. Mr, Mrs etc.',
								'customeraltfirstname'	=> 'You must enter the owners firstname.',
								'customeraltlastname'	=> 'You must enter the owners surname.',
								
								'customeraltaddress' 	=> 'You must enter the alternate contact address.',
								'customeraltsuburb' 	=> 'You must enter the alternate contact suburb / city.',
								'customeraltpostcode' 	=> 'You must enter the alternate contact post / zip code.',
								
								'customeraltmobile'		=> 'You must enter the alternate contact mobile / cell phone number.',
								'customeraltemail' 		=> 'You must enter the alternate contact email address.',
							)
						);	
			break;
			}
		}
	else
		{
		switch($this->facinfo['facilityregion'])
			{
			case 'AU':
			$this->page	->required(
							array(	'dualaccount'			=> 'You must select if this is a dual account or not.',
									'customertitle' 		=> 'You must select your title. E.g. Mr, Mrs etc.',
									'customerfirstname'		=> 'You must enter your firstname.',
									'customersurname' 		=> 'You must enter your surname.',
									
									'customerdobday' 		=> 'You must select the day for your DOB.',
									'customerdobmonth' 		=> 'You must select the month for your DOB.',
									'customerdobyear' 		=> 'You must select the year for your DOB.',
									
									'customeraddress' 		=> 'You must enter your address.',
									'customersuburb' 		=> 'You must enter your suburb / city.',
									'customerstate' 		=> 'You must enter your state / country or province.',
									'customerpostcode' 		=> 'You must enter your post / zip code.',
									
									'customermailaddress' 	=> 'You must enter your mailing address.',
									'customermailsuburb' 	=> 'You must enter your mailing suburb / city.',
									'customermailstate' 	=> 'You must enter your mailing state / country or province.',
									'customermailpostcode' 	=> 'You must enter your mailing post / zip code.',
									
									'customermobilephone' 	=> 'You must enter your mobile / cell phone number.',
									'customeremail' 		=> 'You must enter your email address.',
									
									'customerlicense' 		=> 'You must enter your license number.',
									'customerlicense' 		=> 'You must enter your license number.',
									'customercartype' 		=> 'You must enter your car make and model.',
									'customercarrego' 		=> 'You must enter your license plate / car registration number.',
								)
							);
			break;
			case 'NZ':
			$this->page	->required(
							array(	'dualaccount'			=> 'You must select if this is a dual account or not.',
									'customertitle' 		=> 'You must select your title. E.g. Mr, Mrs etc.',
									'customerfirstname'		=> 'You must enter your firstname.',
									'customersurname' 		=> 'You must enter your surname.',
									
									'customerdobday' 		=> 'You must select the day for your DOB.',
									'customerdobmonth' 		=> 'You must select the month for your DOB.',
									'customerdobyear' 		=> 'You must select the year for your DOB.',
									
									'customeraddress' 		=> 'You must enter your address.',
									'customersuburb' 		=> 'You must enter your suburb / city.',
									'customerpostcode' 		=> 'You must enter your post / zip code.',
									
									'customermailaddress' 	=> 'You must enter your mailing address.',
									'customermailsuburb' 	=> 'You must enter your mailing suburb / city.',
									'customermailpostcode' 	=> 'You must enter your mailing post / zip code.',
									
									'customermobilephone' 	=> 'You must enter your mobile / cell phone number.',
									'customeremail' 		=> 'You must enter your email address.',
									
									'customerlicense' 		=> 'You must enter your license number.',
									'customerlicense' 		=> 'You must enter your license number.',
									'customercartype' 		=> 'You must enter your car make and model.',
									'customercarrego' 		=> 'You must enter your license plate / car registration number.',
								)
							);
			break;
			
			}
		
		if(isset($this->page->postdata['dualaccount']) && $this->page->postdata['dualaccount']=='1' || $this->facinfo['facilityrequirealt']=='1')
			{
			switch($this->facinfo['facilityregion'])
				{
				case 'AU':
				$this->page	->required(
							array(	'customeralttitle' 		=> 'You must select the alternate contact title. E.g. Mr, Mrs etc.',
									'customeraltfirstname'	=> 'You must enter the alternate contact first name.',
									'customeraltlastname'	=> 'You must enter the alternate contact last name.',
									
									'customeraltaddress' 	=> 'You must enter the alternate contact address.',
									'customeraltsuburb' 	=> 'You must enter the alternate contact suburb / city.',
									'customeraltstate' 		=> 'You must enter the alternate contact state / country or province.',
									'customeraltpostcode' 	=> 'You must enter the alternate contact post / zip code.',
									
									'customeraltmobile'		=> 'You must enter the alternate contact mobile / cell phone number.',
									'customeraltemail' 		=> 'You must enter the alternate contact email address.',
									
								)
							);
				break;
				case 'AU':
				$this->page	->required(
							array(	'customeralttitle' 		=> 'You must select the alternate contact title. E.g. Mr, Mrs etc.',
									'customeraltfirstname'	=> 'You must enter the alternate contact first name.',
									'customeraltlastname'	=> 'You must enter the alternate contact last name.',
									
									'customeraltaddress' 	=> 'You must enter the alternate contact address.',
									'customeraltsuburb' 	=> 'You must enter the alternate contact suburb / city.',
									'customeraltpostcode' 	=> 'You must enter the alternate contact post / zip code.',
									
									'customeraltmobile'		=> 'You must enter the alternate contact mobile / cell phone number.',
									'customeraltemail' 		=> 'You must enter the alternate contact email address.',
									
								)
							);
				break;
				
				}
			}
		}
	
	if($this->page->postdata['customercode']=='')
		{
		$this->page	->required(
						array(	'customerpassword' 		=> 'You must set the password for your account.',
								'confirmpassword'		=> 'You must confirm the password for your account.',
								'customeremailc'		=> 'You must confirm your email address'
								));	
		}
	
	$this->page	->required('ordermoveinday', 'You must set the day you want to move in.')
				->required('ordermoveinmonth', 'You must set the month you want to move in.')
				->required('ordermoveinyear', 'You must set the year you want to move in.')
				;
	
	$this->page->validate();
	
	if(	$this->page->postdata['ordermoveinday']!='' &&
		$this->page->postdata['ordermoveinmonth']!='' &&
		$this->page->postdata['ordermoveinyear']!='' &&
		checkdate($this->page->postdata['ordermoveinmonth'], $this->page->postdata['ordermoveinday'], $this->page->postdata['ordermoveinyear'])!==true) 
		{
		$this->page->error('The date is invalid.');
		}
		
	$this->page->postdata['ordermovein'] = $this->page->postdata['ordermoveinyear'].'-'.$this->page->postdata['ordermoveinmonth'].'-'.$this->page->postdata['ordermoveinday'];
	
	if($this->page->postdata['ordermovein'] < date('Y-m-d', strtotime('today')))
		{
		$this->page->error('You cannot start a booking in the past.');	
		}
	
	
	if(	isset($this->page->postdata['customerdobyear']) && $this->page->postdata['customerdobyear']!='' && 
		isset($this->page->postdata['customerdobmonth']) && $this->page->postdata['customerdobmonth']!='' && 
		isset($this->page->postdata['customerdobday']) && $this->page->postdata['customerdobday']!='')
		{
		$this->page->postdata['customerdob'] = date('Y-m-d', strtotime($this->page->postdata['customerdobyear'].'-'.$this->page->postdata['customerdobmonth'].'-'.$this->page->postdata['customerdobday']));
		
		if(checkdate(date('n', strtotime($this->page->postdata['customerdob'])), date('j', strtotime($this->page->postdata['customerdob'])), date('Y', strtotime($this->page->postdata['customerdob'])))===false)
			{
			$this->page->error('Sorry but your date of birth is invalid.');	
			}
		}
	
	if(isset($this->page->postdata['customeremailc']) && isset($this->page->postdata['customeremail']) && $this->page->postdata['customeremailc']!='' && $this->page->postdata['customeremail']!=$this->page->postdata['customeremailc'])
		{
		$this->page->error('Your email addresses do not match.');	
		}
		
	if(isset($this->page->postdata['customerpassword']) && isset($this->page->postdata['confirmpassword']) && $this->page->postdata['customerpassword']!=$this->page->postdata['confirmpassword'])
		{
		$this->page->error('Your passwords do not match.');	
		}
	
	if(!isset($this->page->response['error']))
		{
		if($this->page->postdata['customeraltlastname']!='' && $this->page->postdata['customeraltfirstname']!='')
			{
			$this->page->postdata['customeraltname'] = $this->page->postdata['customeraltlastname'].', '.$this->page->postdata['customeraltfirstname'];
			}
		else
			{
			$this->page->postdata['customeraltname'] = '';	
			}
		
		switch($this->facinfo['facilityregion'])
			{
			case 'CA': // Canada
			case 'TH': // Thailand
			case 'SA': // South Africa
			$this->page->postdata['customercity'] 		= isset($this->page->postdata['customersuburb']) 		? $this->page->postdata['customersuburb'] 		: '';
			$this->page->postdata['customermailcity'] 	= isset($this->page->postdata['customermailsuburb'])	? $this->page->postdata['customermailsuburb'] 	: '';
			$this->page->postdata['customeraltcity'] 	= isset($this->page->postdata['customeraltsuburb']) 	? $this->page->postdata['customeraltsuburb'] 	: '';
			$this->page->postdata['customersuburb'] 	= '';
			$this->page->postdata['customermailsuburb'] = '';
			$this->page->postdata['customeraltsuburb'] 	= '';
			break;
			case 'AU': // Australia
			default:   // Default	
			$this->page->postdata['customercity'] 		= '';
			$this->page->postdata['customermailcity'] 	= '';
			$this->page->postdata['customeraltcity'] 	= '';
			break;	
			case 'NZ': // New Zealand
			default:   // Default	
			$this->page->postdata['customercity'] 		= '';
			$this->page->postdata['customermailcity'] 	= '';
			$this->page->postdata['customeraltcity'] 	= '';
			$this->page->postdata['customerstate'] 		= '';
			$this->page->postdata['customermailstate'] 	= '';
			$this->page->postdata['customeraltstate'] 	= '';
			break;	
			}
		
		$this->page->postdata['organization'] = $this->page->postdata['isbusiness']==1 ? true : false;
		
		$customerdata = array();
		
		$customerdata = $this->page->postdata;	
		
		if($this->page->postdata['isbusiness']==1)
			{
			$customerdata['customertitle']			= '';
			
			$customerdata['customerfullname']		= $customerdata['customerfirstname'];
			$customerdata['customerfirstname']		= '';
			
			$customerdata['organization'] 			= true;
			$customerdata['dualaccount'] 			= false;
			$this->page->postdata['dualaccount']	= '2';
			
			$customerdata['customerdob'] 			= '0000-00-00';
			
			$customerdata['customerhomephone'] 		= '';
			
			$customerdata['companynumber'] 			= str_replace(' ', '', trim($customerdata['companynumber']));
			
			$customerdata['customerlicense'] 		= '';
			$customerdata['customerlicenseissued'] 	= '';
			$customerdata['customercartype'] 		= '';
			$customerdata['customercarrego'] 		= '';
			$customerdata['contactname']			= $customerdata['customersurname'];
			
			$customerdata['customersurname']		= '';
			}
		else
			{
			$customerdata['customerfullname']		= $customerdata['customersurname'].', '.$customerdata['customerfirstname'];
			
			$customerdata['contactname']			= '';
			$customerdata['companynumber'] 			= '';
			$customerdata['dualaccount'] 			= $this->page->postdata['dualaccount']==1 ? true : false;
			
			$customerdata['organization'] 			= false;
			}
		
		if(isset($this->page->postdata['customerpassword']) && $this->page->postdata['customerpassword']!='')
			{
			if($this->facinfo['facilitycustomerencryption']!='')
				{
				$this->remoteencrypt('customerpassword');
				
				$customerdata['customerpass'] = $this->page->postdata['customerpassword'];	
				}
			else
				{
				$customerdata['customerpass'] = $this->page->postdata['customerpassword'];
				}
			}
		
		$customerdata['marketing'] 		= false;
		$customerdata['marketingafter']	= false;
		
		// Load StorMan Caller
		$this->load->model('storman/call');
		
		$this->call	->server($this->facinfo['facilitywebserviceurl'])
					->port($this->facinfo['facilitywebserviceport'])
					->facility($this->facinfo['facilitycode'])
					->password($this->facinfo['facilitywebservicepass'])
					->data($customerdata)
					->init()
					->editCustomer();
		
		if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
			{
			switch($this->api->result['WS_ORErrorCode'])
				{
				case '1012':
				$this->page->error('Sorry but no customer was found matching that customer code. Please check your customer code and try again.');
				break;
				case '1099':
				$this->page->error('There was an error with the configuration for the facility.');
				break;
				default:
				$this->page->error('There was an error connecting to the storage platform.');
				break;
				}
			
			}
		else
			{
			if($this->api->result['WS_CustomerID']=='')
				{
				$this->page->error('Sorry but there was an error retrieving your customer ID. This is required to continue with the order.');	
				}
			else
				{
				$this->page->postdata['customercode'] = isset($this->api->result['WS_CustomerID']) ? $this->api->result['WS_CustomerID'] : $this->page->postdata['customercode'];
				
				//unset($customerdata['customerpass']);
				if(isset($customerdata['customerpass']))
					{
					$this->user['customerpass'] = $customerdata['customerpass'];
					}
				
				$this->user['customercode'] = $this->page->postdata['customercode'];
				$customerdata['customerfirstname'] = $this->page->postdata['isbusiness']==1 ? $customerdata['customerfullname'] : $customerdata['customerfirstname'];
				$this->user['customer'] = $customerdata;
				$this->user['customer']['dualaccount'] = $this->page->postdata['dualaccount'];
				$this->user['order']['unitfrom'] 	= $this->page->postdata['ordermovein'];
				$this->user['order']['unitto'] 		= date('Y-m-d', strtotime('-1 day', strtotime('+1 month', strtotime($this->page->postdata['ordermovein']))));
				
				unset($this->user['customer']['WS_ORSuccess'], $this->user['customer']['WS_ORErrorCode'], $this->user['customer']['WS_ORErrorDescription']);
				
				$this->session->set_userdata($this->sesname, $this->user);
				
				if($customerdata['customercode']=='')
					{
					$this->load->library('email');
					
					$this->email->attach('./_med/'.$this->moveins->emailhead);
					$this->email->attach('./_med/'.$this->moveins->emailfoot);
					
					$this->moveins->emailheader = $this->email->attachment_cid('./_med/'.$this->moveins->emailhead);
					$this->moveins->emailfooter = $this->email->attachment_cid('./_med/'.$this->moveins->emailfoot);
					
					$this->email->to($this->page->postdata['customeremail'])
								->from($this->noreply)
								->subject('Account Created with '.$this->facinfo['facilityname'])
								->message($this->page->emailmsg('moveins/registered'));
					
					$this->email->send()
						? $this->page->success('Your profile has been created and an email has been sent to '.$this->page->postdata['customeremail'].'.')
						: $this->page->success('Your profile has been created.');
					}
				else
					{
					$this->page->success('Your profile has been saved.');
					}
				}
			}
		}
	
	$this->page->respond();
	}


//////////////////////////////////////////////////////////////////
// Update Customers
public function update()
	{
	$t = '';
	
	if(isset($this->page->postdata['newpass']))
		{
		$this->page->required(array('newpass' => 'You must enter your new password.', 'newpasc' => 'You must confirm your new password.'))->validate();
		
		$t = 'pass';
		}
	elseif(isset($this->page->postdata['newemail']))
		{
		$this->page->required(array('newemail' => 'You must enter your new email address.', 'newemaic' => 'You must confirm your new email address.'))->validate();
		
		if(isset($this->page->postdata['newemail']) && isset($this->page->postdata['newemaic']) && $this->page->postdata['newemail']!=$this->page->postdata['newemaic'])
			{
			$this->page->error('The email addresses do not match.');	
			}
		
		$t = 'email';
		}
	elseif(isset($this->page->postdata['acceptterms']))
		{
		
		$t = 'marketing';
		}
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$d = $this->customer;
		
		$d['customeremail'] = isset($this->page->postdata['newemail']) ? $this->page->postdata['newemail'] : $d['customeremail'];
		
		if(isset($this->page->postdata['newpass']))
			{
			if($this->facinfo['facilitycustomerencryption']!='')
				{
				$this->remoteencrypt('newpass');
				}
			
			$d['customerpass'] = $this->page->postdata['newpass'];
			}
		
		$d['marketing'] 		= isset($this->page->postdata['sendmarketing']) ? true : false;
		$d['marketingafter'] 	= isset($this->page->postdata['marketingafter']) ? true : false;
		
		if($d['isbusiness']==1)
			{
			$d['customertitle']			= '';
			
			$d['customerfullname']		= $d['customerfirstname'];
			$d['customerfirstname']		= '';
			
			$d['organization'] 			= true;
			$d['dualaccount'] 			= false;
			
			$d['customerdob'] 			= '0000-00-00';
			
			$d['customerhomephone'] 	= '';
			
			$d['companynumber'] 		= str_replace(' ', '', trim($d['companynumber']));
			
			$d['customerlicense'] 		= '';
			$d['customerlicenseissued'] = '';
			$d['customercartype'] 		= '';
			$d['customercarrego'] 		= '';
			
			$d['contactname']			= $d['customersurname'];
			$d['customersurname']		= '';
			}
		else
			{
			$d['contactname']			= '';
			$d['customerfullname']		= $d['customersurname'].', '.$d['customerfirstname'];
			$d['companynumber'] 		= '';
			$d['dualaccount'] 			= isset($d['dualaccount']) && $d['dualaccount']=='1' ? true : false;
			
			$d['organization'] 			= false;
			}
		/*
		if($d['isbusiness']==1)
			{
			$d['organization'] 			= true;
			
			$d['customerdob'] 			= '0000-00-00';
			
			$d['customerhomephone'] 	= '';
			
			$d['companynumber'] 		= str_replace(' ', '', trim($custsomerdata['companynumber']));
			
			$d['customerlicense'] 		= '';
			$d['customerlicenseissued'] = '';
			$d['customercartype'] 		= '';
			$d['customercarrego'] 		= '';
			}
		else
			{
			$d['companynumber'] 		= '';
			$d['organization'] 			= false;
			$d['dualaccount'] 			= isset($d['dualaccount']) ? $d['dualaccount'] : false;
			}
		*/
		$d['customerdob'] = !isset($d['customerdob']) && isset($d['customerdobyear']) && isset($d['customerdobmonth']) && isset($d['customerdobday'])
			? $d['customerdobyear'].'-'.$d['customerdobmonth'].'-'.$d['customerdobday'] 
			: '';
		
		switch($this->facinfo['facilityregion'])
			{
			case 'CA': // Canada
			case 'TH': // Thailand
			case 'SA': // South Africa
			$d['customercity'] 		= isset($d['customersuburb']) 		? $d['customersuburb'] 		: '';
			$d['customermailcity'] 	= isset($d['customermailsuburb'])	? $d['customermailsuburb'] 	: '';
			$d['customeraltcity'] 	= isset($d['customeraltsuburb']) 	? $d['customeraltsuburb'] 	: '';
			$d['customersuburb'] 	= '';
			$d['customermailsuburb'] = '';
			$d['customeraltsuburb'] 	= '';
			break;
			case 'AU': // Australia
			case 'NZ': // New Zealand
			default:   // Default	
			$d['customercity'] 		= '';
			$d['customermailcity'] 	= '';
			$d['customeraltcity'] 	= '';
			break;	
			}
		
		
		
		//die(print_r($d));
		
		
		// Load StorMan Caller
		$this->load->model('storman/call');
		
		$this->call	->server($this->facinfo['facilitywebserviceurl'])
					->port($this->facinfo['facilitywebserviceport'])
					->facility($this->facinfo['facilitycode'])
					->password($this->facinfo['facilitywebservicepass'])
					->data($d)
					->init()
					->editCustomer();
		
		if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
			{
			switch($this->api->result['WS_ORErrorCode'])
				{
				case '1012':
				$this->page->error('Sorry but no customer was found matching that customer code. Please check your customer code and try again.');
				break;
				case '1099':
				$this->page->error('There was an error with the configuration for the facility.');
				break;
				default:
				$this->page->error('There was an error connecting to the storage platform.');
				break;
				}
			
			}
		else
			{
			switch($t)
				{
				case 'email':
				$this->page->success('Your email address has been updated.')->response('email', $this->page->postdata['newemail']);
				break;
				case 'pass':
				$this->page->success('Your password has been updated.');
				break;
				case 'marketing':
				$this->page->success('Your marketing preferences have been updated.');
				break;
				default:
				$this->page->success('Item updated.');
				break;
				}
			}
		}
		
	$this->page->respond();	
	}


//////////////////////////////////////////////////////////////////
// Customer Register
public function resetpass()
	{
	$this->page	->required('user', 'You must enter your customer code.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->facinfo();
		
		if($this->facinfo['facilitycustomerencryption']!='')
			{
			$this->remotereset();	
			}
		else
			{
			// Load StorMan Caller
			$this->load->model('storman/call');
			
			$this->call	->facility($this->faccode)
						->password($this->facinfo['facilitywebservicepass'])
						->server($this->facinfo['facilitywebserviceurl'])
						->port($this->facinfo['facilitywebserviceport'])
						->data(array(
							'customercode' => $this->page->postdata['user']
							))
						->init()
						->resetPassword();
						
			if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
				{
				switch($this->api->result['WS_ORErrorCode'])
					{
					case '1012':
					$this->page->error('Sorry but no customer was found matching that customer code. Please check your customer code and try again.');
					break;
					case '1099':
					$this->page->error('There was an error with the configuration for the facility.');
					break;
					default:
					$this->page->error('There was an error connecting to the storage platform.');
					break;
					}
				
				}
			else
				{
				$this->page->success('Your password has been reset and an email has been sent to your email account with the details.');
				}
			}
		}
			
	$this->page->respond();		
	}

private function remotereset()
	{
	// Set the Variables
	$c = isset($this->page->postdata['user']) 	? $this->page->postdata['user'] 	: '';
	$e = isset($this->page->postdata['email']) 	? $this->page->postdata['email'] 	: '';
	
	// Initialise CURL
	$cu = curl_init();
	curl_setopt($cu, CURLOPT_URL, $this->facinfo['facilitycustomerencryption']);
	curl_setopt($cu, CURLOPT_POST, 1);
	// Define POST Data
	curl_setopt($cu, CURLOPT_POSTFIELDS, 'smp_auth='.$k.'&smp_code='.$c.'&smp_email='.$e);
	curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
	// Execute
	$re = curl_exec ($cu);
	// Close Connection
	curl_close ($cu);
	// Decode response from JSON to Array
	$d = json_decode($re, true);
	// Check for responses
	isset($d['success']) && $d['success']==true 
		? $this->page->success('Your password has been reset and an email has been sent to your email account with the details.')
		: $this->page->error('There was an error resetting your password.');
	}


//////////////////////////////////////////////////////////////////
// Contract Loader
public function contract()
	{
	// Get the facility info, redirect to 'facility' URL if empty
	$this->facinfo('facility');
	
	//echo '<pre>';die(print_r($this->facinfo['facilityfees']));
	
	if(empty($this->customer))
		{
		$this->session->set_flashdata('error', 'Sorry but your profile information was missing. Please try again.');	
		header('Location: /customer');
		die();
		}
		
	// Check unit is still available
	$this->available();
	
	// Get the facility insurance
	$this->insurance();
	
	// Get the facility fees
	$this->getfees();
	
	// Add the sales lead to StorMan
	$this->addlead();
	
	//echo '<pre>';die(print_r($this->order));
	
	// Return object for chaining
	return $this;
	}

private function insurance()
	{
	// Load StorMan Caller
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getInsurance();
	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
		{
		//echo '<pre>';die(print_r($this->api->result)); // Debug output
		
		$this->facinfo['insurance'] = array();
		$this->facinfo['insrates'] = array();
		
		$rates = array();
		
		if(!empty($this->api->result['WS_InsuranceTypeID']))
			{
			foreach($this->api->result['WS_InsuranceTypeID'] as $k => $v)
				{
				$r = array();
				
				$r['start'] 	= isset($this->api->result['WS_StartValue'][$k]) 		? $this->api->result['WS_StartValue'][$k] 		: '';
				$r['end'] 		= isset($this->api->result['WS_EndValue'][$k]) 			? $this->api->result['WS_EndValue'][$k] 		: '';
				$r['premium'] 	= isset($this->api->result['WS_Premium'][$k]) 			? $this->api->result['WS_Premium'][$k] 			: '';
				$r['repeat'] 	= isset($this->api->result['WS_Repeat'][$k]) 			? $this->api->result['WS_Repeat'] [$k]			: '';
				$r['increment'] = isset($this->api->result['WS_RepeatValue'][$k]) 		? $this->api->result['WS_RepeatValue'] [$k]		: '';
				$r['typeid'] 	= isset($this->api->result['WS_InsuranceTypeID'][$k]) 	? $this->api->result['WS_InsuranceTypeID'][$k] 	: '';
				$r['rounding'] 	= isset($this->api->result['WS_Rounding'][$k]) 			? $this->api->result['WS_Rounding'][$k] 		: '0';
				
				$this->facinfo['insurance'][$r['start']] = $r;
				
				$round = 0;
				
				
				
				if($r['repeat']=='1')
					{
					$range = range($r['start'], $r['end'], $r['increment']);
					
					foreach($range as $rate)
						{
						if($rate!=0)
							{
							$m = $rate / $r['increment'];
							/*
							if($r['premium'] < 1)
								{
								$prem = round(($m * $r['premium']), 2);
								}
							else
								{
								*/
								if($r['rounding']==0 || $r['rounding']==1)
									{
									$round = 2;	
									$prem = round(($m * $r['premium']), 2);
									}
								elseif($r['rounding'] > 1 && $r['rounding'] < 100)
									{
									$prem = number_format(($m * $r['premium']), 2, '.', ',');
									
									$v = explode('.', $prem);
									
									$d = $v[0];
									$c = $v[1];
									
									if($c!=0)
										{
										$q = $c/$r['rounding'];
										
										if($q > 1)
											{
											$c = (ceil($q))*$r['rounding'];
											}
										else
											{
											$c = $r['rounding'];
											}
										
										$prem = $d + ($c/100);
										}
									else
										{
										$prem = $d;// + ($r['rounding']/100);	
										}
									}
								elseif($r['rounding'] == 100)
									{
									$round = 0;	
									$prem = ceil(($m * $r['premium']));
									}
							//	}
							$this->facinfo['insrates'][$rate] = '$'.number_format($rate, 2, '.',',').' = $'.number_format($prem, 2, '.',',').'/mth';
							$this->facinfo['insfees'][$rate] = number_format($prem, 2, '.',',');
							}
						}
					}
				else
					{
					if($r['rounding']==0 || $r['rounding']==1)
						{
						$round = 2;	
						$prem = round($r['premium'], 2);
						}
					elseif($r['rounding'] > 1 && $r['rounding'] < 100)
						{
						$prem = round($r['premium'], 2);
								
						$v = explode('.', $prem);
						
						$d = $v[0];
						$c = $v[1];
						
						$q = $c/$r['rounding'];
						
						if($q > 1)
							{
							$c = (ceil($q))*$r['rounding'];
							}
						else
							{
							$c = $r['rounding'];
							}
						
						$prem = $d + ($c/100);	
						}
					elseif($r['rounding'] == 100)
						{
						$round = 0;	
						$prem = ceil($r['premium']);
						}
					
					$this->facinfo['insrates'][$r['end']] = '$'.number_format($r['end'], 2, '.',',').' = $'.number_format($prem, 2, '.',',').'/mth';	
					$this->facinfo['insfees'][$r['end']] = number_format($prem, 2, '.',',');
					}
				}
			
			asort($this->facinfo['insurance']);
			ksort($this->facinfo['insrates']);
			ksort($this->facinfo['insfees']);
			
			}
		}	
	
	//echo '<pre>';die(print_r($this->facinfo));
	
	return $this;
	}

public function getfees()
	{
	// Create code list
	$codes 	= array();
	$qtys 	= array();
	$cfg	= array();
	
	if($this->facinfo['facilitydeposit']!='')
		{
		$c = substr($this->facinfo['facilitydeposit'],0,5) != $this->faccode ? $this->faccode.$this->facinfo['facilitydeposit'] : $this->facinfo['facilitydeposit'];
		$codes[] = $c;
		$qtys[] = 1;
		$cfg[$c] = 'deposit';
		}
	
	if($this->facinfo['facilitycleaningfee']!='')
		{
		$c = substr($this->facinfo['facilitycleaningfee'],0,5) != $this->faccode ? $this->faccode.$this->facinfo['facilitycleaningfee'] : $this->facinfo['facilitycleaningfee'];
		$codes[] = $c;
		$qtys[] = 1;
		$cfg[$c] = 'cleaning';
		}
	
	if($this->facinfo['facilityadminfee']!='')
		{
		$c = substr($this->facinfo['facilityadminfee'],0,5) != $this->faccode ? $this->faccode.$this->facinfo['facilityadminfee'] : $this->facinfo['facilityadminfee'];
		$codes[] = $c;
		$qtys[] = 1;
		$cfg[$c] = 'admin';
		}
	
	if($this->facinfo['facilitychequefee']!='')
		{
		$c = substr($this->facinfo['facilitychequefee'],0,5) != $this->faccode ? $this->faccode.$this->facinfo['facilitychequefee'] : $this->facinfo['facilitychequefee'];
		$codes[] = $c;
		$qtys[] = 1;
		$cfg[$c] = 'cheque';
		}
	
	if($this->facinfo['facilitylatefee']!='')
		{
		$c = substr($this->facinfo['facilitylatefee'],0,5) != $this->faccode ? $this->faccode.$this->facinfo['facilitylatefee'] : $this->facinfo['facilitylatefee'];
		$codes[] = $c;
		$qtys[] = 1;
		$cfg[$c] = 'late';
		}
	
	
	if(!empty($codes))
		{
		// Load StorMan Caller
		$this->load->model('storman/call');
		
		$this->call	->facility($this->faccode)
					->password($this->facinfo['facilitywebservicepass'])
					->server($this->facinfo['facilitywebserviceurl'])
					->port($this->facinfo['facilitywebserviceport'])
					->data(array('analysiscode' => $codes, 'analysisqtys' => $qtys))
					->init()
					->getPricing();
		
		if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
			{
			$this->facinfo['fees'] = array();
			
			//echo '<pre>';die(print_r($this->api->result));
			
			foreach($this->api->result['WS_asAnalysisOut'] as $k => $v)
				{
				if(in_array($v, $codes) && $v!=':INVALID' && isset($this->api->result['WS_aTotAmt'][$k]) && $this->api->result['WS_aTotAmt'][$k]!='0')
					{
					$this->facinfo['fees'][$cfg[$v]] = isset($this->api->result['WS_aTotAmt'][$k]) ? number_format($this->api->result['WS_aTotAmt'][$k],2,'.',',') : '';
					}
				}
			}
		}
	
	//$this->facinfo['fees']['late'] 		= $this->facinfo['facilitylatefee']!='' ? $this->facinfo['facilitylatefee'] : false;
	$this->facinfo['fees']['dayslate'] 	= $this->facinfo['facilitylatedays']!='' ? $this->facinfo['facilitylatedays'] : false;
	$this->facinfo['fees']['moveout'] 	= $this->facinfo['facilitymoveoutnotice']!='' ? $this->facinfo['facilitymoveoutnotice'] : '';
	
	return $this;
	}


//////////////////////////////////////////////////////////////////
// Add Sales Lead
public function available()
	{
	$this->units();
	
	if(!isset($this->units[$this->order['unitcode']]) || $this->units[$this->order['unitcode']]['unitvacant']<=0)
		{
		if($this->inline=='1')
			{
			$this->page->error('Sorry but it appears as though the unit type you wanted is no longer available. Please go back to the unit selection and select a new unit type.');
			}
		else
			{
			$this->session->set_flashdata('error', 'Sorry but it appears as though the unit type you wanted is no longer available. Please select a new unit type.');
			header('Location: /unit');
			die();
			}
		}
	
	return $this;
	}


//////////////////////////////////////////////////////////////////
// Add Sales Lead
public function addlead()
	{
	$this->load->model('storman/call');
	
	
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'customertitle'		=> $this->customer['customertitle'],
					'customerfirstname'	=> $this->customer['isbusiness']==1 ? '' : $this->customer['customerfirstname'],
					'customerfullname'	=> $this->customer['customerfullname'],
					'customercontact'	=> $this->customer['contactname'],
					'customeraddress'	=> $this->customer['customermailaddress'],
					'customersuburb'	=> $this->customer['customermailsuburb'],
					'customerstate'		=> $this->customer['customermailstate'],
					'customerpostcode'	=> $this->customer['customermailpostcode'],
					'customermobile'	=> $this->customer['customermobilephone'],
					'customerhome'		=> $this->customer['customerhomephone'],
					'customerwork'		=> $this->customer['customerworkphone'],
					'customeremail'		=> $this->customer['customeremail'],
					'isbusiness'		=> $this->customer['isbusiness']==1 ? true : false,					
					'required'			=> $this->user['order']['unitfrom'],
					'resdate'			=> $this->user['order']['unitfrom'],
					'analysiscode'		=> array($this->faccode.'RF'),
					'unitprice'			=> array($this->user['order']['unitrate']),
					'unitrate'			=> array($this->user['order']['unitrate']),
					'unitsize'			=> array($this->user['order']['unitcode']),
					'unitsizes'			=> array($this->user['order']['unitcode']),
					'unittypecode'		=> array($this->user['order']['unitcode']),
					'unittype'			=> array($this->user['order']['unitcode']),
					'note'				=> array('Order via Signup System')
					
					))
				->init()
				->addSalesLead();
	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
		{
		$this->user['order']['lead'] = $this->api->result['WS_CTContactNo'];
		
		$this->session->set_userdata($this->sesname, $this->user);
		}
	else
		{
		//$this->page->error('There was a problem adding your enquiry to the storage system.');	
		}
	
	return $this;	
	}


//////////////////////////////////////////////////////////////////
// Sign and Accept Agreement
public function accept()
	{
	$this->page	->required('acceptterms', 'You must accept the terms and conditions for the agreement.')
				->required('insuranceprovider', 'You must select the insurance provider. You can select no coverage if preferred.')
				->required('output', 'You must sign the agreement.');
	
	if($this->customer['dualaccount']=='1')
		{
		$this->page->required('output-2', 'The secondary contact must sign the agreement.');
		}
	
	if($this->facinfo['facilityprivacypolicy']!='')
		{
		$this->page->required('privacyaccepted', 'You must accept the privacy policy for the facility.');	
		}
	
	if($this->facinfo['facilityrequirestorer']=='1')
		{
		$this->page->required('storercheck', 'You must accept and consent to the Storer Check or you cannot apply for storage at this facility.');	
		}
	
	$this->page->postdata['insnote'] = '';
	
	if(isset($this->page->postdata['insuranceprovider']) && $this->page->postdata['insuranceprovider']!='')
		{
		switch($this->page->postdata['insuranceprovider'])
			{
			// Facility
			case '1':
			$this->page->required('insurance', 'You must select the amount of coverage you require.');	
			$this->page->postdata['insopt'] = 'I accept insurance facilitated by the Facility Owner as detailed in the separate insurance agreement and the insurance level I have chosen is adequate protection for the value of Goods stored.';
			if($this->facinfo['facilityinsurancepolicy']!='')
				{
				$this->page->required('insuranceaccepted', 'You must confirm you have read the insurance policy for the facility.');
				
				$this->page->postdata['insnote'] = 'The storer chose: "I accept insurance facilitated by the Facility Owner as detailed in the separate insurance agreement and the insurance level I have chosen is adequate protection for the value of Goods stored." The coverage they selected was: $'.$this->page->postdata['insurance'].'. They also confirmed that they read and accepted the insurance policy for the facility.';	
				}
			else
				{
				$this->page->postdata['insnote'] = 'The storer chose: "I accept insurance facilitated by the Facility Owner as detailed in the separate insurance agreement and the insurance level I have chosen is adequate protection for the value of Goods stored." The coverage they selected was: $'.$this->page->postdata['insurance'].'.';	
				}
			break;
			// Broker
			case '2':
			$this->page->required('insurancebroker', 'You must input the name of your insurance provider / broker');
			$this->page->postdata['insnote'] = 'The storer chose: "I have adequately insured the value of the Goods with my own insurance company or broker who is '.$this->page->postdata['insurancebroker'].'"';
			$this->page->postdata['insopt'] = 'I have adequately insured the value of the Goods with my own insurance company or broker who is '.$this->page->postdata['insurancebroker'].'.';
			break;
			// None
			case '3':
			$this->page->postdata['insnote'] = 'The storer chose "I do not accept insurance facilitated by the Facility Owner nor do I have the contents insured with any insurance broker or insurance company. I elect to self insure and take the risk of loss or damage to goods stored."';
			$this->page->postdata['insopt'] = 'I do not accept insurance facilitated by the Facility Owner nor do I have the contents insured with any insurance broker or insurance company. I elect to self insure and take the risk of loss or damage to goods stored.';
			break;
			}
		}
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		// Add Agreement into Storman, capture Agreement ID into session
		$this->agreement();
		
		// If no error adding the agreement, continue
		if(!isset($this->page->response['error']))
			{
			// Update the client for marketing data
			$this->update();
			
			// Get the fees for the facility
			$this->getfees();
			
			$this->settotal();
			
			// Now generate signature, generate PDF and attach PDF into StorMan
			$this->makepdf();
			
			// Now add the note to the customer profile for recording the IP
			$this->addipnote();
			}
		}
	
	$this->page->respond();
	}

private function agreement()
	{
	// Check if a business or not
	$ctype = $this->customer['isbusiness']==1 ? 'Business' : 'Residential';
	
	// Load the StorMan call library
	$this->load->model('storman/call');
	
	$unitnum = $this->order['unitnumber']!='' ? strtoupper($this->faccode).$this->order['unitnumber'] : '';
	
	// Config call and process
	$this->call	->facility(strtoupper($this->faccode))
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'faccode' 		=> strtoupper($this->faccode), 
					'name' 			=> $this->customer['customersurname'].', '.$this->customer['customerfirstname'],
					'email' 		=> $this->customer['customeremail'],
					'phone' 		=> str_replace(' ', '', $this->customer['customermobilephone']),
					'unittype' 		=> str_replace(array($this->faccode, strtolower($this->faccode), strtoupper($this->faccode)), '', $this->order['unitcode']),
					'unitnumber'	=> $this->order['unitnumber']!='' ? $this->faccode.$this->order['unitnumber'] : '',
					'movein' 		=> $this->order['unitfrom'],
					'customercode' 	=> $this->customer['customercode'],
					'custtype' 		=> $ctype,
					'enquiryno' 	=> $this->order['lead'],
					));
	
	if(isset($this->page->postdata['sendnotices']) && $this->page->postdata['sendnotices']=='1')
		{
		$this->call->data('notices', true);	
		}
	
	$this->call	->init()
				->addAgreement();
	
	// If API call was successful...
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
		{
		// Save some variables into the user
		$this->user['order']['agreement'] 		= $this->api->result['WS_AgreementID'];
		$this->user['order']['unitnums'] 		= $this->api->result['WS_UnitsOccupied'];
		$this->user['order']['customercode'] 	= $this->api->result['WS_CustomerID'];
		$this->user['order']['insurance'] 		= isset($this->page->postdata['insurance']) && $this->page->postdata['insurance']!='' && isset($this->page->postdata['insurance']) ? $this->page->postdata['insurance'] : '';
		$this->user['order']['insnote'] 		= $this->page->postdata['insnote'];
		$this->user['order']['insopt']			= $this->page->postdata['insopt'];
		$this->user['order']['insoptval']		= $this->page->postdata['insuranceprovider'];
		
		$this->user['order']['storercheck'] 	= isset($this->page->postdata['storercheck']) && $this->page->postdata['storercheck']=='1' ? $this->page->postdata['storercheck'] : '';
		
		if($this->facinfo['facilityfirstmonth']=='1' && $this->facinfo['facilityedpubkey']=='')
			{
			$this->call	->facility(strtoupper($this->faccode))
						->password($this->facinfo['facilitywebservicepass'])
						->server($this->facinfo['facilitywebserviceurl'])
						->port($this->facinfo['facilitywebserviceport'])
						->data(array(
							'agreement' 		=> strtoupper($this->faccode).$this->user['order']['agreement'], 
							))
						->init()
						->doBilling();	
			}
		
		$this->insurrate();
		
		// Set some more variables
		$this->order = array_merge($this->order, $this->user['order']);
		
		// Add the ID Check Note with Alert
		$this->addidchecknote();
		
		// Record the privacy
		$this->addprvnote();
		
		
		
		// Now add the insurance settings to the agreement
		$this->setinsurance();
		
		// Update the session data
		$this->session->set_userdata($this->sesname, $this->user);
		
		// Set the response
		$this->page->success('Thanks for your order. The agreement has been added to the system and you will be redirected momentarily.');
		
		if($this->facinfo['facilityrequirepayment']=='1')
			{
			$this->page->response('redirect', '/summary');	
			}
		else
			{
			$this->page->response('redirect', '/completed');	
			}
		}
	// Else if the call failed...
	else
		{
		// Set the error message
		$this->page->error('There was a problem adding your order to the storage system.');	
		}
	}

private function insurrate()
	{
	/*
	// Load StorMan Caller
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getInsurance();
	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
		{
		$rate = '';
		foreach($this->api->result['WS_InsuranceTypeID'] as $k => $v)
			{
			if(	$rate=='' 
				&& isset($this->user['order']['insurance']) 
				&& isset($this->api->result['WS_StartValue'][$k]) 
				&& isset($this->api->result['WS_EndValue'][$k]) 
				&& $this->user['order']['insurance'] > $this->api->result['WS_StartValue'][$k] 
				&& $this->user['order']['insurance'] <= $this->api->result['WS_EndValue'][$k])
				{
				$i = isset($this->api->result['WS_RepeatValue'][$k])	? $this->api->result['WS_RepeatValue'] [$k]		: '';
				$m = $this->user['order']['insurance'] / $i;
				$r = isset($this->api->result['WS_Premium'][$k]) 		? $this->api->result['WS_Premium'][$k] 			: '';
				$p = $m * $r;
				$rate = $p;
				}
			
			}
		
		$this->order['insurrate'] = $this->user['order']['insurrate'] = $rate;
		}
	*/
	$this->insurance();
	
	if(isset($this->facinfo['insfees'][$this->user['order']['insurance']]) && $this->user['order']['insoptval']=='1')
		{
		$this->order['insurrate'] = $this->user['order']['insurrate'] =	$this->facinfo['insfees'][$this->user['order']['insurance']];
		}
	
	//echo '<pre>';die(print_r($this->facinfo['insfees']).print_r($this->user['order']));
	
	}

private function setinsurance()
	{
	if(isset($this->order['agreement']))
		{
		$this->addinsnote();
		
		$units = $this->user['order']['unitnums']!='' ? explode(',', $this->user['order']['unitnums']) : array();
		
		$u = array();
		$c = array();
		$a = array();
		
		if(!empty($units))
			{
			foreach($units as $k => $unit)	
				{
				$u[] = strtoupper($this->faccode).$unit;
				$c[] = 'WEB-TBC';
				$a[] = $this->user['order']['insurance'];
				}
			}		
		
		// Now lets add the insurance
		$this->call	->facility($this->faccode)
					->password($this->facinfo['facilitywebservicepass'])
					->server($this->facinfo['facilitywebserviceurl'])
					->port($this->facinfo['facilitywebserviceport'])
					->data(array(
						'agreement' 	=> $this->faccode.$this->order['agreement'],
						'insurance' 	=> $this->user['order']['insurance'],
						'insurcert' 	=> 'WEB-TBC',
						'units' 		=> $u,
						'certs' 		=> $c,
						'amounts' 		=> $a
						))
					->init()
					->editInsurance();
		
		//echo '<pre>';die(print_r($this->api->result));
		
		if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
			{
			$this->addinsnote();	
			}
		
		}
	}

private function addprvnote()
	{
	$this->call->data = array();
	
	if($this->facinfo['facilityprivacypolicy']!='')
		{
		$this->load->model('storman/call');
		
		$this->call	->facility($this->faccode)
					->password($this->facinfo['facilitywebservicepass'])
					->server($this->facinfo['facilitywebserviceurl'])
					->port($this->facinfo['facilitywebserviceport'])
					->data(array(
						'assignto' 		=> $this->customer['customercode'],
						'notecontents' 	=> 'The storer acknowledged that they have read the privacy policy',
						'category' 		=> 'Web',
						))
					->init()
					->addNote();
		}
	
	$this->call->data = array();
	
	return $this;
	}

private function addidchecknote()
	{
	$this->call->data = array();
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'assignto' 		=> $this->customer['customercode'],
					'notealert'		=> '1',
					'notecontents' 	=> "Please obtain a photocopy/scan of this Customer's Photo Identification when moving in. Remove note when added.",
					'category' 		=> 'Web',
					))
				->init()
				->addNote();

	$this->call->data = array();

	return $this;
	}

private function addinsnote()
	{
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'assignto' 		=> $this->customer['customercode'],
					'notecontents' 	=> $this->page->postdata['insnote'],
					'category' 		=> 'Web',
					))
				->init()
				->addNote();
	
	return $this;
	}

public function makepdf()
	{
	$this->pdfname = date('Ymd').md5($this->user['customercode']).$this->user['order']['agreement'];
		
	$this->signature();
	
	$this->customer['signature'] 	= './_med/agreements/sigs/'.$this->pdfname.'-1.jpg';
	$this->customer['signsec'] 		= file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/agreements/sigs/'.$this->pdfname.'-2.jpg') ? './_med/agreements/sigs/'.$this->pdfname.'-2.jpg' : '';
	
	$this->load->model('pdf');
	
	$this->pdf	->filename($this->pdfname)
				->template('agreement')
				->generate();
				
	if(isset($this->pdf->response['error']))
		{
		$this->page->error('There was an error generating the PDF.'.$this->pdf->response['error']);	
		}
	else
		{
		// Set Session Data
		$this->order['pdf'] = $this->user['order']['pdf'] = $this->pdfname;
		
		$this->session->set_userdata($this->sesname, $this->user);
		
		// Now attach it into StorMan
		$this->addpdf();
		
		// Now Email the Agreement to the Customer and Facility
		$this->emailagreement();	
		}	
	}

private function emailagreement()
	{
	/*
	$this->emailhead = isset($this->facinfo['facilityemailheader']) && $this->facinfo['facilityemailheader']!='' ? 'facilities/header/'.$this->facinfo['facilityemailheader'] : 'images/storman_email_header.jpg';
	$this->emailfoot = isset($this->facinfo['facilityemailfooter']) && $this->facinfo['facilityemailfooter']!='' ? 'facilities/footer/'.$this->facinfo['facilityemailfooter'] : 'images/storman_email_footer.jpg';
	*/
	
	// Rename the PDF
	$nicename = 'Self-Storage-Agreement-'.$this->order['agreement'];
	
	rename($_SERVER['DOCUMENT_ROOT'].'/_med/agreements/'.$this->order['pdf'].'.pdf', $_SERVER['DOCUMENT_ROOT'].'/_med/agreements/'.$nicename.'.pdf');
	
	$this->load->library('email');	
	
	$this->email->to($this->customer['customeremail']);
	$this->email->from($this->noreply);
	$this->email->bcc($this->facinfo['facilityemail']);
	$this->email->subject('Order Placed with '.$this->moveins->facinfo['facilityname']);
	
	$this->email->attach('./_med/'.$this->emailhead);
	$this->email->attach('./_med/'.$this->emailfoot);
	
	$this->emailheader = $this->email->attachment_cid('./_med/'.$this->emailhead);
	$this->emailfooter = $this->email->attachment_cid('./_med/'.$this->emailfoot);
	
	$this->email->attach('./_med/agreements/'.$nicename.'.pdf');
	
	$this->email->message($this->page->emailmsg('moveins/agreement'));
	
	if($this->email->send())
		{
		$this->page->success('The agreement has been added to the system and a copy has been emailed to you.');
		}
	else
		{
		$this->page->success('The agreement has been added to the system but there was a problem sending it via email.');		
		}
	
	// Rename PDF back
	rename($_SERVER['DOCUMENT_ROOT'].'/_med/agreements/'.$nicename.'.pdf', $_SERVER['DOCUMENT_ROOT'].'/_med/agreements/'.$this->order['pdf'].'.pdf');
	}

private function signature()
	{
	$this->load->helper('sigimg_helper');
	
	$this->signature = sigJsonToImage($this->page->postdata['output']);
	
	imagejpeg($this->signature, './_med/agreements/sigs/'.$this->pdfname.'-1.jpg');
	
	if(isset($this->page->postdata['output-2']))
		{
		$this->signsec = sigJsonToImage($this->page->postdata['output-2']);
		
		imagejpeg($this->signsec, './_med/agreements/sigs/'.$this->pdfname.'-2.jpg');
		}
	}

private function addpdf()
	{
	$pdf 	= './_med/agreements/'.$this->pdfname.'.pdf';
	$b64pdf = chunk_split(base64_encode(file_get_contents($pdf)));
	
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'file' 			=> $b64pdf,
					'customercode' 	=> $this->customer['customercode'],
					'filename' 		=> date('Ymd').'-'.$this->user['order']['agreement'],
					'extension' 	=> '.pdf',
					'thumb' 		=> '',
					))
				->init()
				->addPDF();
	
	}

private function addipnote()
	{
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	else 
		{
		$ip = $_SERVER['REMOTE_ADDR'];
		}
		
	$this->load->model('storman/call');
	
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->data(array(
					'assignto' 		=> $this->customer['customercode'],
					'notecontents' 	=> 'Online Order Placed via IP: '.$ip,
					'category' 		=> 'Web',
					))
				->init()
				->addNote();
	
	return $this;
	}


private function settotal()
	{
	if(!isset($this->order['insurrate']))
		{
		$this->insurrate();	
		}
	
	//$this->getfees();
		
	$rate = isset($this->order['unitrate']) ? $this->order['unitrate'] : '';
	$fees = isset($this->facinfo['fees']['deposit']) ? $this->facinfo['fees']['deposit'] + $this->order['unitdeposit'] : $this->order['unitdeposit'];
	
	// Calculate fees that are due	
	if($this->facinfo['facilityedpubkey']!='' || $this->facinfo['facilityfirstmonth']=='1')
		{
		$this->order['total'] = isset($this->order['insurrate']) ? $rate + $this->order['insurrate'] : $rate;
		$this->order['duetoday'] = $fees!='' ? $this->order['total'] + $fees : $this->order['total'];
		}
	else
		{
		$this->order['total'] = isset($this->order['insurrate']) ? $rate + $this->order['insurrate'] : $rate;
		$this->order['duetoday'] = $fees!='' ? $fees : $this->order['total'];
		}
	
	$this->user['order'] = $this->order;	
	}

//////////////////////////////////////////////////////////////////
// Sign and Accept Agreement
public function summary()
	{
	//$this->settotal();
	
	//echo '<pre>';die(print_r($this->facinfo).print_r($this->order));
	
	// Update the session data
	$this->session->set_userdata($this->sesname, $this->user);
	
	return $this;
	}


//////////////////////////////////////////////////////////////////
// Payment Processing
public function payment()
	{
	//$this->order['total'] = isset($this->order['insurrate']) ? $this->order['unitrate'] + $this->order['insurrate'] : $this->order['unitrate'];
	$this->summary();
	
	if($this->facinfo['facilityedpubkey']!='')
		{
		$this->edfees();
		
		$this->order['feespayable'] = ($this->order['duetoday'] * $this->fees['visa']) + $this->basefees['visa'];
		$this->order['grandtotal'] = $this->order['duetoday'] + $this->order['feespayable'];			
		
		$this->page->view('movein/payment');
		}
	else
		{
		$this->page->view('movein/storpay');	
		}
	
	if(!isset($this->order['duetoday']))
		{
		$this->session->set_flashdata('error', 'Your order details could not be found.');
		header('Location: /unit');
		die();	
		}
	
	return $this;
	}

//////////////////////////////////////////////////////////////////
// Reservation Summary and Payment Prep
/*
public function ressummary()
	{
	$this->getfees();
		
	$rate = isset($this->order['unitrate']) ? $this->order['unitrate'] : '';
	$fees = isset($this->facinfo['fees']['deposit']) ? $this->facinfo['fees']['deposit'] + $this->order['unitdeposit'] : $this->order['unitdeposit'];
	
	$this->order['resfees'] = $fees;
	
	// Calculate fees that are due	
	if($this->facinfo['facilityedpubkey']!='' || $this->facinfo['facilityfirstmonth']=='1')
		{
		$this->order['total'] = isset($this->order['insurrate']) ? $rate + $this->order['insurrate'] : $rate;
		$this->order['duetoday'] = $fees!='' ? $this->order['total'] + $fees : $this->order['total'];
		}
	else
		{
		$this->order['total'] = isset($this->order['insurrate']) ? $rate + $this->order['insurrate'] : $rate;
		$this->order['duetoday'] = $fees!='' ? $fees : $this->order['total'];
		}
	
	$this->user['order'] = $this->order;
	
	//echo '<pre>';die(print_r($this->page->view));
	
	// Update the session data
	$this->session->set_userdata($this->sesname, $this->user);
	
	if($this->facinfo['facilityedpubkey']!='')
		{
		$this->edfees();
		
		$this->page->view = array();
		
		$this->order['feespayable'] = ($this->order['duetoday'] * $this->fees['visa']) + $this->basefees['visa'];
		$this->order['grandtotal'] = $this->order['duetoday'] + $this->order['feespayable'];			
		
		$this->page->view('reservation/payment');
		}
	else
		{
		$this->page->view('reservation/storpay');	
		}
	
	
	
	if(!isset($this->order['duetoday']))
		{
		$this->session->set_flashdata('error', 'Your order details could not be found.');
		header('Location: /unit');
		die();	
		}
	
	return $this;
	}
*/

public function edfees()
	{
	$this->page->view('movein/payment');
	
	// Now lets add the insurance
	$this->call	->facility($this->faccode)
				->password($this->facinfo['facilitywebservicepass'])
				->server($this->facinfo['facilitywebserviceurl'])
				->port($this->facinfo['facilitywebserviceport'])
				->init()
				->getEziFees();
	
	$this->fees['visa'] 			= 0;
	$this->fees['mastercard'] 		= 0;
	$this->fees['amex'] 			= 0;
	$this->fees['diners'] 			= 0;
	
	$this->basefee 					= 0;
	
	$this->basefees['visa'] 		= 0;
	$this->basefees['mastercard'] 	= 0;
	$this->basefees['amex'] 		= 0;
	$this->basefees['diners'] 		= 0;
	
	//echo '<pre>';die(print_r($this->api->result));
	
	// Check for a result	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']==true && isset($this->api->result['WS_CCtype1']) && !empty($this->api->result['WS_CCtype1']))
		{
		// For each card type in the result
		foreach($this->api->result['WS_CCtype1'] as $k => $c)
			{
			// Make the name lowercard
			$n = strtolower($c);
			
			// Check the card type is supported by the facility
			if(isset($this->facinfo['facilityezi'.$n]) && $this->facinfo['facilityezi'.$n]=='1')
				{
			
				$this->fees[$n] 		= $this->api->result['WS_PercentFee1'][$k]/100;
				$this->basefees[$n] 	= $this->api->result['WS_FixedFee1'][$k];
			
				}
			
			/*
			// Clear the type if both the rate and fee are 0
			if($this->fees[$n]=='0' && $this->basefees[$n]=='0')
				{
				unset($this->fees[$n], $this->basefees[$n]);	
				}
			*/
			}
		}
	
	//echo '<pre>';die(print_r($this->fees).print_r($this->basefees));
	
	}


//////////////////////////////////////////////////////////////////
// Payment Receipter
public function receipter()
	{
	//die(print_r($this->facinfo));
	//$this->db->insert('systemerrors', array('stormantime' => date('Y-m-d h:i:s'), 'stormanrequest' => 'Payment Receipt', 'stormanparameters' => '', 'stormanparameters' => json_encode($this->page->postdata)));
	
	$this->page->required(array(	'paymentid' 	=> 'The ID for your payment is missing.',
									'paymentamount' => 'The amount is missing.',
									'receiptid' 	=> 'The receipt number is missing.',
									'exchangeid' 	=> 'The exchange ID number is missing.',
									'paymentresult' => 'The payment result is missing.',
									'paymentcode' 	=> 'The payment code number is missing',
									'paymenttext' 	=> 'The payment message is missing.'									
									));	
		
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		if($this->page->postdata['paymentresult']=='A')
			{
			$this->load->model('storman/call');
			
			$d = array(	'itemid' 				=> $this->facinfo['facilitycode'].str_replace($this->user['customercode'], '', $this->page->postdata['paymentid']),
						'cardcode' 				=> $this->facinfo['facilitycode'].$this->page->postdata['cardcode'],
						'exchangeid'			=> $this->page->postdata['exchangeid'],
						'receipt' 				=> $this->page->postdata['receiptid'],						
						'uuid' 					=> $this->page->postdata['paymentuuid'],
						'amount' 				=> $this->page->postdata['paymentamount'],
						'agreement'				=> $this->facinfo['facilitycode'].$this->order['agreement']
						);
			
			$this->order['receiptid'] = $this->page->postdata['receiptid'];
			$this->order['orderfees'] = $this->page->postdata['feescharged'];
			$this->order['amountcharged'] = $this->page->postdata['amountcharged'];
					
			$this->call	->facility($this->faccode)
						->password($this->facinfo['facilitywebservicepass'])
						->server($this->facinfo['facilitywebserviceurl'])
						->port($this->facinfo['facilitywebserviceport'])
						->data($d)
						->init()
						->addReceipt();
			
			if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
				{
				// Payment made, now trigger email
				$this->paycomplete();
				}
			else
				{
				// Payment made but receipting failed
				$this->payrecfail();
				}
			}
		else
			{
			// Payment failed			
			$this->page->error('Your payment was not completed with the following message: '.$this->page->postdata['paymenttext'].'.<br />Error Code: ED-'.$this->page->postdata['paymentcode']);	
			}
		}
	
	$this->page->respond();	
	}

public function paycomplete()
	{
	// Load the email library
	$this->load->library('email');	
	
	//$this->email->to('email@lukepelgrave.com.au');
	$this->email->to($this->customer['customeremail']);
	$this->email->bcc($this->facinfo['facilityemail']);
	$this->email->from($this->noreply);
	$this->email->subject('Thanks for your payment to '.$this->moveins->facinfo['facilityname']);
	
	
	$this->email->attach('./_med/'.$this->emailhead);
	$this->email->attach('./_med/'.$this->emailfoot);
	
	$this->emailheader = $this->email->attachment_cid('./_med/'.$this->emailhead);
	$this->emailfooter = $this->email->attachment_cid('./_med/'.$this->emailfoot);
	
	$this->email->attach('./_med/agreements/'.$this->order['pdf'].'.pdf', 'attachment', 'Self-Storage-Agreement-'.$this->order['agreement'].'.pdf');
	
	if($this->facinfo['facilityprivacypolicy']!='')
		{
		$this->email->attach('./_med/facilities/privacy/'.$this->facinfo['facilityprivacypolicy'], 'attachment', 'Privacy-Disclosure-Statement.pdf');
		}
	
	if($this->facinfo['facilityinsurancepolicy']!='' && isset($this->order['insoptval']) && $this->order['insoptval']=='1')
		{
		$this->email->attach('./_med/facilities/insurance/'.$this->facinfo['facilityinsurancepolicy'], 'attachment', 'Insurance-Policy.pdf');	
		}
	
	if($this->facinfo['facilityemailfile']!='')
		{
		$this->email->attach('./_med/facilities/emailfile/'.$this->facinfo['facilityemailfile'], 'attachment', 'Welcome.pdf');	
		}
	
	$this->email->message($this->page->emailmsg('moveins/payment'));
	
	if($this->email->send())
		{
		$this->session->set_flashdata('payment', 'Thanks for your payment.<br />An email has been sent with the details of your payment.');
		
		$this->page->success('Payment processed and email sent.');
		}
	else
		{
		$this->session->set_flashdata('payment', 'Thanks for your payment.<br />The payment was processed however there was an error recording this into the storage platform and an issue was encountered while emailing the facility the details of your payment. Please make a note of the the receipt number and advise the facility.');
		
		$this->page->success('Payment processed.');
		}
	}

public function payrecfail()
	{
	$this->load->library('email');	
	
	//$this->email->to('email@lukepelgrave.com.au');
	$this->email->to($this->customer['customeremail']);
	$this->email->bcc($this->facinfo['facilityemail']);
	$this->email->from($this->noreply);	
	$this->email->subject('Thanks for your payment to '.$this->moveins->facinfo['facilityname']);
	
	$this->email->attach('./_med/agreements/'.$nicename.'.pdf', 'attachment', 'Self-Storage-Agreement-'.$this->order['agreement'].'.pdf');
	
	$this->email->attach('./_med/'.$this->emailhead);
	$this->email->attach('./_med/'.$this->emailfoot);
	
	$this->emailheader = $this->email->attachment_cid('./_med/'.$this->emailhead);
	$this->emailfooter = $this->email->attachment_cid('./_med/'.$this->emailfoot);
	
	$this->email->message($this->page->emailmsg('moveins/payment'));
	
	if($this->email->send())
		{
		$this->session->set_flashdata('payment', 'Thanks for your payment.<br />The payment was processed however there was an error recording this into the storage platform.<br />An email has been sent to the facility advising of your payment.');
		
		$this->page->success('Payment processed');
		}
	else
		{
		$this->session->set_flashdata('payment', 'Thanks for your payment.<br />The payment was processed however there was an error recording this into the storage platform and an issue was encountered while emailing the facility the details of your payment. Please make a note of the the receipt number and advise the facility.');
		
		$this->page->success('Payment processed');
		}
	}


//////////////////////////////////////////////////////////////////
// Completed Status Message
public function completed()
	{
	$this->placed();
	
	$this->order = array();	
	
	unset($this->customer['order']);
	
	$this->session->set_userdata($this->sesname, $this->user);
	
	$this->message = $this->session->flashdata('payment') ? $this->session->flashdata('payment') : '<p>Thanks for your order. Your payment has been processed.</p>';
	}


//////////////////////////////////////////////////////////////////
// Suburb Finder
public function placed()
	{
	if($this->facinfo['facilityrequirepayment']!='1')
		{
		// Load the email library
		$this->load->library('email');	
		
		//$this->email->to('email@lukepelgrave.com.au');
		$this->email->to($this->customer['customeremail']);
		$this->email->bcc($this->facinfo['facilityemail']);
		$this->email->from($this->noreply);
		$this->email->subject('Thanks for your order with '.$this->moveins->facinfo['facilityname']);
		
		
		$this->email->attach('./_med/'.$this->emailhead);
		$this->email->attach('./_med/'.$this->emailfoot);
		
		$this->emailheader = $this->email->attachment_cid('./_med/'.$this->emailhead);
		$this->emailfooter = $this->email->attachment_cid('./_med/'.$this->emailfoot);
		
		
		$this->email->attach('./_med/agreements/'.$this->order['pdf'].'.pdf', 'attachment', 'Self-Storage-Agreement-'.$this->order['agreement'].'.pdf');
		
		if($this->facinfo['facilityprivacypolicy']!='')
			{
			$this->email->attach('./_med/facilities/privacy/'.$this->facinfo['facilityprivacypolicy'], 'attachment', 'Privacy-Disclosure-Statement.pdf');
			}
		
		if($this->facinfo['facilityinsurancepolicy']!='' && isset($this->order['insoptval']) && $this->order['insoptval']=='1')
			{
			$this->email->attach('./_med/facilities/insurance/'.$this->facinfo['facilityinsurancepolicy'], 'attachment', 'Insurance-Policy.pdf');	
			}
		
		if($this->facinfo['facilityemailfile']!='')
			{
			$this->email->attach('./_med/facilities/emailfile/'.$this->facinfo['facilityemailfile'], 'attachment', 'Welcome.pdf');	
			}
		
		$this->email->message($this->page->emailmsg('moveins/placed'));
		
		$this->email->send();
		
		}
	}



//////////////////////////////////////////////////////////////////
// Suburb Finder
public function suburb()
	{
	$r = $this->db	->like('suburbname', $this->page->postdata['term'])
					->or_like('suburbpostcode', $this->page->postdata['term'])
					->get('suburbs')->result_array();
	
	$l = array();
	
	if(!empty($r))
		{
		foreach($r as $s)
			{
			$l[] = array(	'sbid' => $s['sbid'],
							'label' => $s['suburbname'].', '.$s['suburbstate'].' '.$s['suburbpostcode'],
							'suburb' => $s['suburbname'],
							'state' => $s['suburbstate'],
							'postcode' => $s['suburbpostcode']
							);	
			}
		}
	
	!empty($l) 
		? $this->page->response($l)	
		: $this->page->error('No results found.');
	
	$this->page->respond();	
	}

}