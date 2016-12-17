<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facilities extends CI_Model {
	
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Facility Variables

var $table			= 'facilities';
var $index			= 'fcid';
var $value			= '';
var $base			= 'admin/facilities';
var $link			= 'admin/facility';
var $inline			= '0';
var $pulled			= '0';

var $headlogo		= '';
var $footlogo		= '';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Search Settings

var $select			= 'facilities.*, companies.companyname';
var $joins			= array('companies' => 'coid');
var $alias			= '';
var $fixedfilters	= array();

var $filterby		= 'facilityactive';
var $filterlbl		= 'Active';
var $filters		= array('1' => 'Yes, Active', '2' => 'No, Inactive');

var $orderby		= 'facilityname';
var $ordering		= 'asc';

var $options		= array('facilityname' => 'Facility Name', 'facilitycode' => 'Facility Code', 'companyname' => 'Company', 'facilityemail' => 'Email');


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Controller Functions

public function init()
	{
	if($this->page->user['group']=='company')
		{
		$this->fixedfilters = array('facilities.coid' => $this->page->user['usid']);	
		}
	
	
	return $this;	
	}

//////////////////////////////////////////////////////////////////
// Company Listing
public function listing()
	{
	$this->load->model('search');
	
	$this->page	->view('search/header')
				->view('search/listing')
				->view('search/footer');
	
	// Options and Settings
	$this->search->no_results = 'Sorry but no facilities match your search. Please try searching again or search by a different field.';
	$this->search->no_records = 'No facilities have been setup in the system yet.';
	
	$this->search	->column('facilityactive', 'Active', '1', 'switcher')
					->column('facilitycode', 'Code', '1', 'text', 'N/A')
					->column('facilityname', 'Name', '5', 'text', 'N/A')
					->column('facilitycontact', 'Contact', '3', 'text', 'N/A')
					->column('facilityphone', 'Phone', '2', 'text', 'N/A');
	
	
	//////////////////////////////////////////
	// Common Settings
	$this->search->table		= $this->table;
	$this->search->index 		= $this->index;
	$this->search->sessname		= $this->table;
	$this->search->base 		= $this->base;
	$this->search->link 		= $this->link;
	
	$this->search->select		= $this->select;
	$this->search->joins 		= $this->joins;
	$this->search->alias 		= $this->alias;
	
	$this->search->options 		= $this->options;
	
	$this->search->filterby 	= $this->filterby;
	$this->search->filterlbl 	= $this->filterlbl;
	$this->search->filters 		= $this->filters;
	$this->search->fixedfilters = $this->fixedfilters;
	
	$this->search->orderby 		= $this->orderby;
	$this->search->ordering 	= $this->ordering;
	
	// Run the Search
	$this->search->run();	
	
	//die('tracing');
	}

//////////////////////////////////////////////////////////////////
// Record ID
public function id()
	{
	$this->value 	= $this->uri->segment(3) 
					? $this->uri->segment(3) 
					: $this->value;
	
	$this->value 	= !empty($this->page->postdata) && isset($this->page->postdata[$this->index])
					? $this->page->postdata[$this->index]
					: $this->value;
	
	return $this;
	}

public function value($v)
	{
	$this->value = $v;
	
	return $this;	
	}
	
//////////////////////////////////////////////////////////////////
// Company Loader
public function get()
	{
	$this->id();
	
	if($this->value!='' && $this->value!=NULL)
		{
		$this->page->record = $this->db->select($this->select)->where($this->index, $this->value)->join('companies', 'companies.coid = facilities.coid', 'left')->get($this->table)->row_array();	
		
		$this->pull();
		}
	
	if(empty($this->page->record))
		{
		$this->page->record['facilitycompletedmessage'] = '<p><b>Important note:</b> Please be aware that when you arrive at the site, you will be given the opportunity to ensure the space is suitable for your purposes. You will also be required to present your ID to be copied, at the facility/site before you can obtain access.</p>';	
		
		$this->page->record['facilityezicardvisa'] = 'V';
		$this->page->record['facilityezicardmaster'] = 'M';
		$this->page->record['facilityezicardamex'] = 'A';
		$this->page->record['facilityezicarddiners'] = 'D';
		}
	
	if($this->inline=='0')
		{
		$this->page->view('facility/edit');
		}
	}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// AJAX Functions

//////////////////////////////////////////////////////////////////
// Save Company
public function save()
	{
	$this->id();
	
	$this->page	->required('facilitycode', 				'You must enter the facility code.')
				->required('facilitywebservicepass', 	'You must enter the facility web services pass. Enter TBC if not known yet.')
				->required('facilitywebserviceurl', 	'You must enter the facility web services URL. Enter TBC if not known yet.')
				;
	
	$this->page->validate();
	
	$this->unique();
	
	if($this->page->postdata['facilityedpubkey']!='' && $this->page->postdata['facilityezivisa']=='2' && $this->page->postdata['facilityezimastercard']=='2' && $this->page->postdata['facilityeziamex']=='2' && $this->page->postdata['facilityezidiners']=='2')
		{
		$this->page->error('You must select at least 1 card type that you accept.');	
		}
	
	if($this->page->user['group']=='company')
		{
		$this->page->postdata['coid'] = $this->page->user['usid'];
		}
	
	if(!isset($this->page->response['error']))
		{
		unset($this->page->postdata['filetitle']);
		
		unset($this->page->postdata['companyname'], $this->page->postdata['facilitylogotitle'], $this->page->postdata['facilityheadertitle'], $this->page->postdata['facilityfootertitle'], $this->page->postdata['facilityprivacytitle'], $this->page->postdata['facilityinsurancetitle'], $this->page->postdata['facilityattachmenttitle'], $this->page->postdata['facilityresattachtitle']);
		
		if($this->value!='')
			{
			
			
			$this->db->update($this->table, $this->page->postdata, array($this->index => $this->value))
				? $this->page->success('The facility has been updated.')
				: $this->page->error('There was an error updating the facility.');
			}
		else
			{
			/*
			$this->secure->pasr = substr(md5(uniqid()), rand(0,8), 8);
			
			$this->page->postdata['pass'] = md5($this->secure->pasr);
			
			$this->secure->enc();
			
			$this->page->postdata['facilitypass'] = $this->page->postdata['pass'];
			*/
			
			$this->page->postdata['facilitycreated'] = date('Y-m-d');
			
			if($this->db->insert($this->table, $this->page->postdata))
				{
				$this->value = $this->db->insert_id();
				
				$this->page->record = $this->db->where($this->index, $this->value)->get($this->table)->row_array();
				
				$this->pull();
				
				$this->page->response('facility', $this->page->record);
				/*
				if(isset($this->page->record['facilityemail']) && $this->page->record['facilityemail']!='')
					{
					//$this->registered();
					$this->page->success('The facility has been created and the information was retrieved from Storman.', $this->value);
					}
				elseif($this->pulled=='1')
					{
					$this->db->update('facilities', $this->page->record, array('fcid' => $this->page->record['fcid']));
					$this->page->success('The facility was created however the facility email in StorMan is not set and a registration email was not sent.');	
					}
				*/
				if($this->pulled=='1')
					{
					$this->page->success('The facility has been created and the information was retrieved from Storman.', $this->value);	
					}
				else
					{
					$this->page->success('The facility was created however there was an error getting the facility record from StorMan. Please check the account info and verify that it is correct as the profile will not display contact information or have all the facility data until this is rectified.');
					}
				}
			else
				{
				$this->page->error('There was an error adding the facility.');
				}
			}
		}
			
	$this->page->respond();
	}

private function unique()
	{
	$this->value=='' 
		? $this->db->where('facilitycode', $this->page->postdata['facilitycode'])
		: $this->db->where(array('facilitycode' => $this->page->postdata['facilitycode'], 'fcid !=' => $this->page->postdata['fcid']));
	
	$c = $this->db->get('facilities')->num_rows();
	
	if($c > 0)
		{
		$this->page->error('A facility already exists with that facility code.');	
		}
	}


private function pull()
	{
	if($this->page->record['facilitywebserviceurl']!='' && $this->page->record['facilitywebserviceport']!='' && $this->page->record['facilitywebservicepass']!='')
		{
		// Now get the StorMan Data
		$this->load->model('storman/call');
		
		$this->call	->facility($this->page->record['facilitycode'])
					->password($this->page->record['facilitywebservicepass'])
					->server($this->page->record['facilitywebserviceurl'])
					->port($this->page->record['facilitywebserviceport'])
					->init()
					->retrieveFacility();
		
		if(isset($this->api->result['WS_ORSuccess']) && $this->api->result['WS_ORSuccess']==true)
			{
			$this->pulled = '1';
			
			$fk = '';
			
			foreach($this->api->result['WS_asFacilityCode'] as $k => $c)
				{
				$fk = $c==$this->page->record['facilitycode'] ? $k : $fk;	
				}
			
			if(isset($this->api->result['WS_asFacility_Name'][$fk]))
				{
				$this->page->record['facilityname'] 	= isset($this->api->result['WS_asFacility_Name'][$fk]) 		? $this->api->result['WS_asFacility_Name'][$fk] 	: $this->page->record['facilityname'];
				$this->page->record['facilityemail'] 	= isset($this->api->result['WS_asFacility_Email'][$fk]) 	? $this->api->result['WS_asFacility_Email'][$fk] 	: $this->page->record['facilityemail'];
				$this->page->record['facilityphone'] 	= isset($this->api->result['WS_asFacility_Phone'][$fk]) 	? $this->api->result['WS_asFacility_Phone'][$fk] 	: $this->page->record['facilityphone'];
				$this->page->record['facilityaddressa'] = isset($this->api->result['WS_asFacility_Address'][$fk]) 	? $this->api->result['WS_asFacility_Address'][$fk] 	: $this->page->record['facilityaddressa'];
				$this->page->record['facilitysuburb'] 	= isset($this->api->result['WS_asFacility_City'][$fk]) 		? $this->api->result['WS_asFacility_City'][$fk] 	: $this->page->record['facilitysuburb'];
				$this->page->record['facilitystate'] 	= isset($this->api->result['WS_asFacility_Suburb'][$fk]) 	? $this->api->result['WS_asFacility_Suburb'][$fk] 	: $this->page->record['facilitystate'];
				$this->page->record['facilitypostcode'] = isset($this->api->result['WS_asFacility_Postcode'][$fk]) 	? $this->api->result['WS_asFacility_Postcode'][$fk] : $this->page->record['facilitypostcode'];	
				}
			}
		}
	}


//////////////////////////////////////////////////////////////////
// New Facility Profile Email
private function registered()
	{
	$this->load->library('email');
	
	$this->email->to($this->page->record['facilityemail']);
	$this->email->from('no-reply@storman.com');
	$this->email->subject('Facility Profile Setup - '.$this->page->site['sitename']);
	
	
	$hlogo = './_med/images/storman_email_header.jpg';
	$flogo = './_med/images/storman_email_footer.jpg';
	
	$this->email->attach($hlogo);
	$this->email->attach($flogo);
	
	$this->headlogo = $this->email->attachment_cid($hlogo);
	$this->footlogo = $this->email->attachment_cid($flogo);
	
	$this->email->message($this->load->view('email/facility/register', array(), true));
	
	if(!$this->email->send())
		{
		$this->page->success('The facility profile was created however there was an error sending an email to the facility with the login details. You may need to reset the password.', $this->value);	
		}
	else
		{
		$this->page->success('The facility has been created and an email has been sent with their login information.', $this->value);		
		}
	}

//////////////////////////////////////////////////////////////////
// Password Reset
public function resetpass()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		$this->get();
		$this->inline = '0';
		
		$this->secure->pasr = substr(md5(uniqid()), rand(0,8), 8);
		
		$this->page->postdata['pass'] = md5($this->secure->pasr);
		
		$this->secure->enc();
		
		$this->page->postdata['facilitypass'] = $this->page->postdata['pass'];
		
		if($this->db->update($this->table, array('facilitypass' => $this->page->postdata['facilitypass']), array('fcid' => $this->page->postdata['fcid'])))
			{
			$this->resetter();
			}
		else
			{
			$this->page->error('There was an error updating the facility with the new password.');
			}
		}
			
	$this->page->respond();	
	}

private function resetter()
	{
	$this->load->library('email');
	
	$hlogo = './_med/images/storman_email_header.jpg';
	$flogo = './_med/images/storman_email_footer.jpg';
	
	$this->email->attach($hlogo);
	$this->email->attach($flogo);
	
	$this->headlogo = $this->email->attachment_cid($hlogo);
	$this->footlogo = $this->email->attachment_cid($flogo);
	
	$this->email->to($this->page->record['facilityemail']);
	$this->email->from('no-reply@storman.com');
	$this->email->subject('Facility Profile Password Reset - '.$this->page->site['sitename']);
	$this->email->message($this->load->view('email/facility/reset', array(), true));
	
	if(!$this->email->send())
		{
		$this->page->error('There was an error sending the email to the facility.');
		}
	else
		{
		$this->page->success('The facility password has been reset and an email has been sent.');
		}
	}

//////////////////////////////////////////////////////////////////
// Company Autocomplete
public function autocomplete()
	{
	$r = $this->db	->select($this->select)
					->like('facilityname', $this->page->postdata['term'])	
					->join('companies', 'companies.coid = facilities.coid', 'left')	
					->get($this->table)->result_array();
	
	$l = array();
	
	if(!empty($r))
		{
		foreach($r as $i)
			{
			$n = isset($i['companyname']) ? stripslashes($i['facilityname'].' - '.$i['companyname']) : stripslashes($i['facilityname']);
			
			$l[] = array(	'id' => $i['fcid'],
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
// Facility Logo Upload
public function logo()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities')->allowed(array('jpg', 'png'))->field('facilitylogo')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilitylogo' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilitylogo']!='' && file_exists($this->uploader->path.$this->page->record['facilitylogo']))
					{
					unlink($this->uploader->path.$this->page->record['facilitylogo']);	
					}
				
				$this->page	->success('The facility logo has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/'.$this->filename,
									'logo' => '<img src="/_med/facilities/'.$this->filename.'" alt="" title="Facility Logo" class="facility-img" />'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}

//////////////////////////////////////////////////////////////////
// Facility Email Header
public function emailheader()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/header')->allowed(array('jpg', 'png'))->field('facilityheader')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityemailheader' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityemailheader']!='' && file_exists($this->uploader->path.$this->page->record['facilityemailheader']))
					{
					unlink($this->uploader->path.$this->page->record['facilityemailheader']);	
					}
				
				$this->page	->success('The facility email header has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/header/'.$this->filename,
									'header' => '<img src="/_med/facilities/header/'.$this->filename.'" alt="" title="Facility Email Header" class="facility-img" />'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}

//////////////////////////////////////////////////////////////////
// Facility Email Header
public function emailfooter()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/footer')->allowed(array('jpg', 'png'))->field('facilityfooter')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityemailfooter' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityemailfooter']!='' && file_exists($this->uploader->path.$this->page->record['facilityemailfooter']))
					{
					unlink($this->uploader->path.$this->page->record['facilityemailfooter']);	
					}
				
				$this->page	->success('The facility email footer has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/footer/'.$this->filename,
									'footer' => '<img src="/_med/facilities/footer/'.$this->filename.'" alt="" title="Facility Email Footer" class="facility-img" />'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}


//////////////////////////////////////////////////////////////////
// Facility Privacy Policy Upload
public function privacy()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/privacy')->allowed(array('pdf'))->field('facilityprivacy')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityprivacypolicy' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityprivacypolicy']!='' && file_exists($this->uploader->path.$this->page->record['facilityprivacypolicy']))
					{
					unlink($this->uploader->path.$this->page->record['facilityprivacypolicy']);	
					}
				
				$this->page	->success('The facility privacy disclosure statement has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/privacy/'.$this->filename,
									'privacy' => '<a href="/_med/facilities/privacy/'.$this->filename.'" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Privacy Disclosure Statement</a>'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}


//////////////////////////////////////////////////////////////////
// Facility Insurance Policy Upload
public function insurance()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/insurance')->allowed(array('pdf'))->field('facilityinsurance')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityinsurancepolicy' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityinsurancepolicy']!='' && file_exists($this->uploader->path.$this->page->record['facilityinsurancepolicy']))
					{
					unlink($this->uploader->path.$this->page->record['facilityinsurancepolicy']);	
					}
				
				$this->page	->success('The facility insurance policy has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/insurance/'.$this->filename,
									'insurance' => '<a href="/_med/facilities/insurance/'.$this->filename.'" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Insurance Policy</a>'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}

//////////////////////////////////////////////////////////////////
// Facility Insurance Policy Upload
public function emailfile()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/emailfile')->allowed(array('pdf'))->field('facilityattachment')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityemailfile' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityemailfile']!='' && file_exists($this->uploader->path.$this->page->record['facilityemailfile']))
					{
					unlink($this->uploader->path.$this->page->record['facilityemailfile']);	
					}
				
				$this->page	->success('The facility email PDF attachment has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/emailfile/'.$this->filename,
									'emailfile' => '<a href="/_med/facilities/emailfile/'.$this->filename.'" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Email Attachment</a>'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}


//////////////////////////////////////////////////////////////////
// Facility Reservations Email Upload
public function resfile()
	{
	$this->id();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('facilities/resfile')->allowed(array('pdf'))->field('facilityresattach')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('facilities', array('facilityresfile' => $this->filename), array('fcid' => $this->page->record['fcid'])))
				{
				if($this->page->record['facilityresfile']!='' && file_exists($this->uploader->path.$this->page->record['facilityresfile']))
					{
					unlink($this->uploader->path.$this->page->record['facilityresfile']);	
					}
				
				$this->page	->success('The facility reservation email PDF attachment has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/facilities/resfile/'.$this->filename,
									'emailfile' => '<a href="/_med/facilities/resfile/'.$this->filename.'" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Reservation Email Attachment</a>'
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}


public function removeimg()
	{
	$this->id();
	
	$this->get();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.')
				->required('type', 'The type of image you want to remove is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		if(empty($this->page->record))
			{
			$this->page->error('Sorry but the record could not be found.');	
			}
		else
			{
			$f = $d = '';
			
			switch($this->page->postdata['type'])
				{
				case 'logo':
				$f = 'facilitylogo';
				$d = '';
				break;
				case 'header':
				$f = 'facilityemailheader';
				$d = 'header/';
				break;
				case 'footer':
				$f = 'facilityemailfooter';
				$d = 'footer/';
				break;		
				}
			
			if($f!='' && $this->page->record[$f]!='' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/facilities/'.$d.$this->page->record[$f]))
				{
				if(unlink($_SERVER['DOCUMENT_ROOT'].'/_med/facilities/'.$d.$this->page->record[$f]))
					{
					$this->db->update('facilities', array($f => ''), array('fcid' => $this->page->record['fcid']))
						? $this->page->success('The facility '.$this->page->postdata['type'].' has been removed.')
						: $this->page->error('The image was removed however the DB was not updated.');	
					}
				else
					{
					$this->page->error('There was an error removing the file.');	
					}
				}
			else
				{
				$this->page->error('The type was invalid.');	
				}
			}
		}
		
	
	$this->page->respond();	
	}



public function removepdf()
	{
	$this->id();
	
	$this->get();
	
	$this->page	->required('fcid', 'The ID for the facility is missing.')
				->required('type', 'The type of image you want to remove is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		if(empty($this->page->record))
			{
			$this->page->error('Sorry but the record could not be found.');	
			}
		else
			{
			$f = $d = $l = '';
			
			switch($this->page->postdata['type'])
				{
				case 'privacy':
				$f = 'facilityprivacypolicy';
				$d = 'privacy/';
				$l = 'privacy disclosure statement';
				break;
				case 'insurance':
				$f = 'facilityinsurancepolicy';
				$d = 'insurance/';
				$l = 'insurance policy';
				break;
				case 'emailfile':
				$f = 'facilityemailfile';
				$d = 'emailfile/';
				$l = 'email attachment';
				break;		
				}
			
			if($f!='' && $this->page->record[$f]!='' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/facilities/'.$d.$this->page->record[$f]))
				{
				if(unlink($_SERVER['DOCUMENT_ROOT'].'/_med/facilities/'.$d.$this->page->record[$f]))
					{
					$this->db->update('facilities', array($f => ''), array('fcid' => $this->page->record['fcid']))
						? $this->page->success('The facility '.$l.' PDF has been removed.')
						: $this->page->error('The '.$l.' PDF was removed however the DB was not updated.');	
					}
				else
					{
					$this->page->error('There was an error removing the file.');	
					}
				}
			else
				{
				$this->page->error('The type was invalid.');	
				}
			}
		}
		
	
	$this->page->respond();	
	}

}