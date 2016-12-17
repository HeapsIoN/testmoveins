<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations extends CI_Model {

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Move In Variables
// See Move-Ins Model for most vars in this class


var $user = array();
var $hashid = '';

var $completed = 'Thanks for placing a reservation using Storman Online.'; // Default complete message. Is placed inside p tag.


public function profile()
	{
	$this->moveins->facinfo('facility');
	
	$this->saveprofile();
	
	if(!isset($this->page->response['error']))
		{
		if($this->moveins->facinfo['facilityresfee']=='1')
			{
			$this->addlead();	
			}
		else
			{
			$this->create();
			
			$this->emailer();
			}
		}
	
	$this->page->respond();
	}

public function proceed()
	{
		
	}


public function summary()
	{
	$this->moveins->getfees();
		
	$rate = isset($this->moveins->order['unitrate']) ? $this->moveins->order['unitrate'] : '';
	$fees = isset($this->moveins->facinfo['fees']['deposit']) ? $this->moveins->facinfo['fees']['deposit'] + $this->moveins->order['unitdeposit'] : $this->moveins->order['unitdeposit'];
	
	$this->moveins->order['resfees'] = $fees;
	
	// Calculate fees that are due	
	if($this->moveins->facinfo['facilityedpubkey']!='' || $this->moveins->facinfo['facilityfirstmonth']=='1')
		{
		$this->moveins->order['total'] = $rate;
		$this->moveins->order['duetoday'] = $fees!='' ? $this->moveins->order['total'] + $fees : $this->moveins->order['total'];
		}
	else
		{
		$this->moveins->order['total'] = $rate;
		$this->moveins->order['duetoday'] = $fees!='' ? $fees : $this->moveins->order['total'];
		}
	
	// Unit Types Grabber
	$u = $this->db	->where(array('facilities.facilitycode' => substr($this->moveins->order['unitcode'],0,5), 'unitcode' => $this->moveins->order['unitcode']))
					->join('facilities', 'facilities.fcid = units.fcid')
					->get('units')->row_array();
	
	//echo '<pre>';die($this->db->last_query());	
	
	$this->moveins->order['unitwebname'] = isset($u['unid']) && $u['unitwebname']!=''
			? $u['unitwebname']
			: $u['unitname']!=''
			? $u['unitname']
			: 'Not Set';
	
	$this->moveins->user['order'] = $this->moveins->order;
	
	// Update the session data
	$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
	
	if($this->moveins->facinfo['facilityedpubkey']!='' && $this->moveins->facinfo['facilitypaymenttype']=='1')
		{
		$this->moveins->edfees();
		
		$this->page->view = array();
		
		$this->moveins->order['feespayable'] = ($this->moveins->order['duetoday'] * $this->moveins->fees['visa']) + $this->moveins->basefees['visa'];
		$this->moveins->order['grandtotal'] = $this->moveins->order['duetoday'] + $this->moveins->order['feespayable'];			
		
		$this->page->view('reservation/payment');
		}
	else
		{
		$this->page->view('reservation/storpay');	
		}
	
	if(!isset($this->moveins->order['duetoday']))
		{
		$this->session->set_flashdata('error', 'Your order details could not be found.');
		header('Location: /unit');
		die();	
		}
	
	return $this;
	}

public function payment()
	{
	$this->moveins->facinfo('facility');
	
	$this->convert();
	
	$this->receipter();	
	
	$this->emailer();
	
	$this->billing();	
	
	$this->page->respond();
	}

private function saveprofile()
	{
	$this->page	->required(
					array(	'customertitle' 		=> 'You must select your title. E.g. Mr, Mrs etc.',
							'customerfirstname'		=> 'You must enter your firstname.',
							'customersurname' 		=> 'You must enter your surname.',

						)
					);	
	
	$this->page->validate();
	
	if($this->page->postdata['customerhomephone']=='' && $this->page->postdata['customerworkphone']=='' && $this->page->postdata['customermobilephone']=='')
		{
		$this->page->error('You must provide at least one phone number. We suggest you include your mobile.');	
		}
	
	if($this->page->postdata['customercode']=='')
		{
		$this->page	->required(
						array(	
								'customeremail'			=> 'You must enter your email address',
								'customeremailc'		=> 'You must confirm your email address',
								'customerpassword' 		=> 'You must set the password for your account.',
								'confirmpassword'		=> 'You must confirm the password for your account.',
								));	
		}
	
	$this->page	->required('ordermoveinday', 'You must set the day you want to reserve the unit from.')
				->required('ordermoveinmonth', 'You must set the month you want to reserve the unit from.')
				->required('ordermoveinyear', 'You must set the year you want to reserve the unit from.')
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
	
	if(isset($this->page->postdata['customeremail']) && isset($this->page->postdata['customeremailc']) && $this->page->postdata['customeremail']!=$this->page->postdata['customeremailc'])
		{
		$this->page->error('Your emails do not match.');	
		}
	
	if(isset($this->page->postdata['customerpassword']) && isset($this->page->postdata['confirmpassword']) && $this->page->postdata['customerpassword']!=$this->page->postdata['confirmpassword'])
		{
		$this->page->error('Your passwords do not match.');	
		}
	
	if(!isset($this->page->response['error']))
		{
		$customerdata = array();
		
		$customerdata = array_merge($this->moveins->customer, $this->page->postdata);	
		
		$customerdata['customerfullname']		= $customerdata['customersurname'].', '.$customerdata['customerfirstname'];
			
		$customerdata['customercontact']		= '';
		
		$customerdata['customeraddress']		= isset($customerdata['customeraddress']) 	? $customerdata['customeraddress'] : '';
		$customerdata['customersuburb']			= isset($customerdata['customersuburb']) 	? $customerdata['customersuburb'] : '';
		$customerdata['customerstate']			= isset($customerdata['customerstate']) 	? $customerdata['customerstate'] : '';
		$customerdata['customerpostcode']		= isset($customerdata['customerpostcode']) 	? $customerdata['customerpostcode'] : '';
		
		$customerdata['customerhome']			= isset($customerdata['customerhome']) 		? $customerdata['customerhome'] : '';
		$customerdata['customerwork']			= isset($customerdata['customerwork']) 		? $customerdata['customerwork'] : '';
		$customerdata['customermobile']			= isset($customerdata['customermobile']) 	? $customerdata['customermobile'] : '';
		$customerdata['customeremail']			= isset($customerdata['customeremail']) 	? $customerdata['customeremail'] : '';
		
		
		$customerdata['dualaccount'] 			= isset($this->moveins->customer['dualaccount']) && $this->moveins->customer['dualaccount']==1 ? true : false;
		$customerdata['organization'] 			= isset($this->moveins->customer['isbusiness']) && $this->moveins->customer['isbusiness']==1 ? true : false;
		
		if(isset($this->page->postdata['customerpassword']) && $this->page->postdata['customerpassword']!='')
			{
			if($this->moveins->facinfo['facilitycustomerencryption']!='')
				{
				$this->remoteencrypt('customerpassword');
				
				$customerdata['customerpass'] = $this->page->postdata['customerpassword'];	
				}
			else
				{
				$customerdata['customerpass'] = $this->page->postdata['customerpassword'];
				}
			}
		
		$customerdata['customerdob']	= isset($this->moveins->customer['customerdob']) ? $this->moveins->customer['customerdob'] : '';
		$customerdata['marketing'] 		= false;
		$customerdata['marketingafter']	= false;
		
		// Load StorMan Caller
		$this->load->model('storman/call');
		
		$this->call	->server($this->moveins->facinfo['facilitywebserviceurl'])
					->port($this->moveins->facinfo['facilitywebserviceport'])
					->facility($this->moveins->facinfo['facilitycode'])
					->password($this->moveins->facinfo['facilitywebservicepass'])
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
					$this->moveins->user['customerpass'] = $customerdata['customerpass'];
					}
				
				$this->moveins->user['customercode'] = $this->page->postdata['customercode'];
				
				$customerdata['customerfirstname'] = isset($this->page->postdata['isbusiness']) && $this->page->postdata['isbusiness']==1 ? $customerdata['customerfullname'] : $customerdata['customerfirstname'];
				
				$this->moveins->user['customer'] = $customerdata;
				
				$this->moveins->user['customer']['dualaccount'] = isset($customerdata['dualaccount']) ? $customerdata['dualaccount'] : false;
				
				unset($this->moveins->user['customer']['WS_ORSuccess'], $this->moveins->user['customer']['WS_ORErrorCode'], $this->moveins->user['customer']['WS_ORErrorDescription']);
				
				$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
				
				if($customerdata['customercode']=='')
					{
					$this->load->library('email');
					
					$this->email->attach('./_med/'.$this->moveins->emailhead);
					$this->email->attach('./_med/'.$this->moveins->emailfoot);
					
					$this->moveins->emailheader = $this->email->attachment_cid('./_med/'.$this->moveins->emailhead);
					$this->moveins->emailfooter = $this->email->attachment_cid('./_med/'.$this->moveins->emailfoot);
					
					$this->email->to($customerdata['customeremail'])
								->from($this->moveins->noreply)
								->subject('Account Created with '.$this->moveins->facinfo['facilityname'])
								->message($this->page->emailmsg('moveins/registered'));
					
					$this->email->send()
						? $this->page->success('Your profile has been created and an email has been sent to '.$customerdata['customeremail'].'.')
						: $this->page->success('Your profile has been created.');
					}
				else
					{
					$this->page->success('Your profile has been saved.');
					}
				}
			}
		}	
	}

private function addlead()
	{
	$lead = $this->moveins->user;
	
	$lead['isbusiness'] 	= isset($lead['organization']) ? $lead['organization'] : false;
	
	$lead['analysiscode'] 	= array($this->moveins->faccode.'RF');
	$lead['unitrate'] 		= array($this->moveins->order['unitrate']);
	$lead['unitsizes'] 		= array($this->moveins->order['unitsizes']);
	$lead['unittype'] 		= array($this->moveins->order['unitcode']);
	$lead['resdate'] 		= date('Y-m-d', strtotime($this->page->postdata['ordermovein']));
	$lead['note'] 			= array('Lead added via the Storman Reservations system.');
	
	$this->moveins->user['order']['unitfrom'] = $lead['resdate'];
	
	$this->call	->server($this->moveins->facinfo['facilitywebserviceurl'])
				->port($this->moveins->facinfo['facilitywebserviceport'])
				->facility($this->moveins->facinfo['facilitycode'])
				->password($this->moveins->facinfo['facilitywebservicepass'])
				->data($lead)
				->init()
				->addSalesLead();
	
	if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
		{
		/*
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
		*/
		$this->page->error('There was an error adding your enquiry into the storage platform.');
		}
	else
		{
		$this->moveins->user['order']['saleslead'] = isset($this->api->result['WS_CTContactNo']) ? $this->api->result['WS_CTContactNo'] : '';
		
		$this->page->success('Enquiry saved into storage platform. Continuing.');
		}
	
	$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
	}

private function create()
	{
	$res = array();
	
	$ph = isset($this->moveins->user['customer']['customermobile']) && $this->moveins->user['customer']['customermobile']!=''
		? $this->moveins->user['customer']['customermobile']
		: isset($this->moveins->user['customer']['customerhome']) && $this->moveins->user['customer']['customerhome']!=''
		? $this->moveins->user['customer']['customerhome']
		: isset($this->moveins->user['customer']['customerwork'])
		? $this->moveins->user['customer']['customerwork']
		: '';
	
	//echo '<pre>';die(print_r($this->moveins->user));
	
	$res['customername'] 	= $this->moveins->user['customer']['customersurname'].', '.$this->moveins->user['customer']['customerfirstname'];
	$res['customeremail'] 	= $this->moveins->user['customer']['customeremail'];
	$res['customerphone'] 	= $ph;
	
	$res['resdate'] 		= $this->moveins->order['unitfrom'];
	$res['unittype']		= $this->moveins->order['unitcode'];	
	
	$res['customercode'] 	= $this->moveins->user['customercode'];
	$res['customerpass'] 	= $this->moveins->user['customerpass'];
	
	$this->call	->server($this->moveins->facinfo['facilitywebserviceurl'])
				->port($this->moveins->facinfo['facilitywebserviceport'])
				->facility($this->moveins->facinfo['facilitycode'])
				->password($this->moveins->facinfo['facilitywebservicepass'])
				->data($res)
				->init()
				->createReservation();
	
	if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
		{
		$this->page->error('There was an error adding your reservation into the storage platform.');
		}
	else
		{
		$this->moveins->user['order']['reservation'] = isset($this->api->result['WS_ReservationID']) ? $this->api->result['WS_ReservationID'] : '';
		
		$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
		
		$this->page->success('The reservation has been created.');
		}
	}

public function convert()
	{	
	$lead = array();
	
	$lead['saleslead'] = $lead['resno'] = isset($this->moveins->user['order']['saleslead']) && $this->moveins->user['order']['saleslead']!='' ? $this->moveins->user['order']['saleslead'] : '';
	$lead['required'] = $lead['date'] = isset($this->moveins->user['order']['unitfrom']) ? $this->moveins->user['order']['unitfrom'] : '';
	
	$this->call	->server($this->moveins->facinfo['facilitywebserviceurl'])
				->port($this->moveins->facinfo['facilitywebserviceport'])
				->facility($this->moveins->facinfo['facilitycode'])
				->password($this->moveins->facinfo['facilitywebservicepass'])
				->data($lead)
				->init()
				->convertLead();
	
	if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
		{
		$this->page->error('There was an error converting your enquiry into a reservation.');	
		}
	else
		{
		$this->moveins->user['order']['ccode'] = isset($this->api->result['WS_CustomerID']) ? $this->api->result['WS_CustomerID'] : '';
		$this->moveins->user['order']['reservation'] = $this->moveins->user['order']['resid'] = isset($this->api->result['WS_ReservationID']) ? $this->api->result['WS_ReservationID'] : '';
		
		
		$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
		
		$this->page->success('Your reservation has been confirmed and your unit is booked.');	
		}
	}

private function receipter()
	{
	$d = array(	'itemid' 				=> $this->moveins->facinfo['facilitycode'].str_replace($this->moveins->user['customercode'], '', $this->page->postdata['paymentid']),
				'cardcode' 				=> $this->moveins->facinfo['facilitycode'].$this->page->postdata['cardcode'],
				'exchangeid'			=> $this->page->postdata['exchangeid'],
				'receipt' 				=> $this->page->postdata['receiptid'],						
				'uuid' 					=> $this->page->postdata['paymentuuid'],
				'amount' 				=> $this->page->postdata['paymentamount'],
				'reservation'			=> $this->moveins->facinfo['facilitycode'].$this->moveins->order['reservation'],
				'agreement'				=> $this->moveins->facinfo['facilitycode'].$this->moveins->order['reservation']
				);
	
	$this->moveins->user['order']['receiptid'] 		= $this->page->postdata['receiptid'];
	$this->moveins->user['order']['orderfees'] 		= $this->page->postdata['feescharged'];
	$this->moveins->user['order']['amountcharged'] 	= $this->page->postdata['amountcharged'];
	
	$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
			
	$this->call	->facility($this->moveins->faccode)
				->password($this->moveins->facinfo['facilitywebservicepass'])
				->server($this->moveins->facinfo['facilitywebserviceurl'])
				->port($this->moveins->facinfo['facilitywebserviceport'])
				->data($d)
				->init()
				->addReceipt();
	
	if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']===true)
		{
		// Do nothing for reservations
		}
	}

private function emailer()
	{
	// Load the email library
	$this->load->library('email');	
	
	$this->email->to($this->moveins->user['customer']['customeremail']);
	$this->email->bcc($this->moveins->facinfo['facilityemail']);
	$this->email->from($this->moveins->noreply);
		
	$this->email->attach('./_med/'.$this->moveins->emailhead);
	$this->email->attach('./_med/'.$this->moveins->emailfoot);
	
	$this->moveins->emailheader = $this->email->attachment_cid('./_med/'.$this->moveins->emailhead);
	$this->moveins->emailfooter = $this->email->attachment_cid('./_med/'.$this->moveins->emailfoot);
	
	if($this->moveins->facinfo['facilityresfile']!='')
		{
		$this->email->attach('./_med/facilities/resfile/'.$this->moveins->facinfo['facilityresfile'], 'attachment', 'Welcome.pdf');	
		}
	
	if($this->moveins->facinfo['facilityresfee']=='1')
		{
		$this->email->subject('Thanks for your reservation and payment with '.$this->moveins->facinfo['facilityname']);
		$this->email->message($this->page->emailmsg('reservation/payment'));	
		}
	else
		{
		$this->email->subject('Thanks for your reservation with '.$this->moveins->facinfo['facilityname']);
		$this->email->message($this->page->emailmsg('reservation/placed'));
		}
	
	$this->email->send();
	}

private function billing()
	{
	$b = array();
	
	$b['reservation'] 	= isset($this->moveins->user['order']['reservation']) && $this->moveins->user['order']['reservation']!='' ? $this->moveins->user['order']['reservation'] : '';
	$b['analysis'] 		= $this->moveins->faccode.'RF';
	$b['customercode'] 	= $this->moveins->user['customercode'];
	$b['total'] 		= isset($this->moveins->user['order']['receiptid']) ? $this->moveins->user['order']['receiptid'] : '';
	
	if($b['reservation']!='')
		{
		$this->call	->facility(strtoupper($this->moveins->faccode))
							->password($this->moveins->facinfo['facilitywebservicepass'])
							->server($this->moveins->facinfo['facilitywebserviceurl'])
							->port($this->moveins->facinfo['facilitywebserviceport'])
							->data($b)
							->init()
							->addCharge();
		}
	}


private function hasher()
	{
	$f = $this->uri->segment(3) ? $this->uri->segment(3) : $this->moveins->faccode;
	
	$h = hash('sha256', $this->moveins->order['reservation']);
	
	$b = substr($h,0,8).'-'.$this->moveins->order['reservation'].'-'.substr($h,12,8);
	
	$this->hashid = $b.'-'.substr(hash('sha256', $b.$f),8,8);	
	}


public function completed()
	{
	$this->hasher();
	
	
	$this->moveins->getfees();
	
	$rate = isset($this->moveins->order['unitrate']) ? $this->moveins->order['unitrate'] : '';
	$fees = isset($this->moveins->facinfo['fees']['deposit']) ? $this->moveins->facinfo['fees']['deposit'] + $this->moveins->order['unitdeposit'] : $this->moveins->order['unitdeposit'];
	
	$this->moveins->order['resfees'] = $fees;
	
	//echo '<pre>';die(print_r($this->moveins));
	
	// Unit Types Grabber
	$u = $this->db	->where(array('facilities.facilitycode' => substr($this->moveins->order['unitcode'],0,5), 'unitcode' => $this->moveins->order['unitcode']))
					->join('facilities', 'facilities.fcid = units.fcid')
					->get('units')->row_array();
	
	//echo '<pre>';die($this->db->last_query());	
	
	$this->moveins->order['unitwebname'] = isset($u['unid']) && $u['unitwebname']!=''
			? $u['unitwebname']
			: $u['unitname']!=''
			? $u['unitname']
			: 'Not Set';
	
	// Calculate fees that are due	
	if($this->moveins->facinfo['facilityedpubkey']!='' || $this->moveins->facinfo['facilityfirstmonth']=='1')
		{
		$this->moveins->order['total'] = $rate;
		$this->moveins->order['duetoday'] = $fees!='' ? $this->moveins->order['total'] + $fees : $this->moveins->order['total'];
		}
	else
		{
		$this->moveins->order['total'] = $rate;
		$this->moveins->order['duetoday'] = $fees!='' ? $fees : $this->moveins->order['total'];
		}
	
	$this->moveins->user['order'] = $this->moveins->order;
	
	// Update the session data
	$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);	
	}


public function movein()
	{
	/*
	$u = explode('-', $this->uri->segment(4));
	
	$this->moveins->user['order']['reservation'] = $this->moveins->order['reservation'] = isset($u[1]) ? $u[1] : '';
	
	$this->hasher();
	
	if($this->moveins->order['reservation']!='' && $this->uri->segment(4)==$this->hashid)
		{
		$this->moveins->user['facilitycode'] = $this->moveins->faccode = $this->uri->segment(3) ? $this->uri->segment(3) : $this->moveins->faccode;
		
		$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
		}
	elseif($this->moveins->order['reservation']!='' && $this->uri->segment(4)!=$this->hashid)
		{	
		
		}
	else
		{
			
		}
	*/
	$this->moveins->user['facilitycode'] = $this->moveins->faccode = $this->uri->segment(3) ? $this->uri->segment(3) : $this->moveins->faccode;
	
	$this->moveins->user['order']['reservation'] = $this->moveins->order['reservation'] = $this->uri->segment(4) ? $this->uri->segment(4) : '';
	
	if($this->moveins->order['reservation']!='')
		{
		$this->session->set_userdata($this->moveins->sesname, $this->moveins->user);
		}
	}

public function mover()
	{
	$this->moveins	->inline(1)
					->login();
	
	
	
	
	}

public function confirm()
	{
	$this->moveins	->inline(1)
					->confirm();	
	
	
	}

}