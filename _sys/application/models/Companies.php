<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends CI_Model {
	
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Companies Variables

var $table			= 'companies';
var $index			= 'coid';
var $value			= '';
var $base			= 'admin/companies';
var $link			= 'admin/company';
var $inline			= '0';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Search Settings

var $select			= 'companies.*';
var $joins			= array();
var $alias			= '';
var $fixedfilters	= array();

var $filterby		= 'companyactive';
var $filterlbl		= 'Active';
var $filters		= array('1' => 'Yes, Active', '2' => 'No, Inactive');

var $orderby		= 'companyname';
var $ordering		= 'asc';

var $options		= array('companyname' => 'Company Name', 'companycontact' => 'Contact', 'companyphone' => 'Phone', 'companyemail' => 'Email');

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// File Settings

var $fileinfo		= array();
var $filename		= '';


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Themes

var $themes			= array();

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Email Settings

var $noreply		= 'no-reply@storman.com';
var $headlogo		= '';
var $footlogo		= '';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Controller Functions

public function init()
	{
	// Admin only, use preset options
	
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
	$this->search->no_results = 'Sorry but no companies match your search. Please try searching again or search by a different field.';
	$this->search->no_records = 'No companies have been setup in the system yet.';
	
	$this->search	->column('companyactive', 'Active', '1', 'switcher')
					->column('companyname', 'Name', '5', 'text', 'N/A')
					->column('companycontact', 'Contact', '4', 'text', 'N/A')
					->column('companyphone', 'Phone', '2', 'text', 'N/A');
	
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
	
	if($this->value!='')
		{
		$this->page->record = $this->db->where('coid', $this->value)->get('companies')->row_array();	
		
		$this->page->record['facilities'] 	= isset($this->page->record['coid']) 
											? $this->db->where('coid', $this->page->record['coid'])->get('facilities')->result_array()
											: array();
		}
	
	}

public function facilityids()
	{
	$this->page->record['facilityids'] = array_column($this->db->where('coid', $this->page->user['usid'])->get('facilities')->result_array(), NULL, 'fcid');	
	}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// AJAX Functions

//////////////////////////////////////////////////////////////////
// Save Company
public function save()
	{
	$this->id();
	
	$this->page	->required('companyname', 		'You must enter the name of the company.')
				->required('companycontact', 	'You must enter the company contact name.')
				->required('companyphone', 		'You must enter the company contact phone.')
				->required('companyemail', 		'You must enter the company contact email.')
				;
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		unset($this->page->postdata['companylogotitle'], $this->page->postdata['companyheadertitle'], $this->page->postdata['companyfootertitle']);
		
		if($this->value!='')
			{
			$this->db->update($this->table, $this->page->postdata, array($this->index => $this->value))
				? $this->page->success('The company has been updated.')
				: $this->page->error('There was an error updating the company.');
			}
		else
			{
			$this->secure->pasr = substr(md5(uniqid()), rand(0,8), 8);
			
			$this->page->postdata['pass'] = md5($this->secure->pasr);
			
			$this->secure->enc();
			
			$this->page->postdata['companypass'] = $this->page->postdata['pass'];
			
			unset($this->page->postdata['pass']);
			
			$this->page->postdata['companycreated'] = date('Y-m-d');
			
			if($this->db->insert($this->table, $this->page->postdata))
				{
				$this->value = $this->db->insert_id();
				
				$this->registered();
				}
			else
				{
				$this->page->error('There was an error adding the company.');
				}
			}
		}
			
	$this->page->respond();
	}


public function profile()
	{
	$this->id();
	
	$this->page	->required('companyname', 		'You must enter the name of the company.')
				->required('companycontact', 	'You must enter the company contact name.')
				->required('companyphone', 		'You must enter the company contact phone.')
				->required('companyemail', 		'You must enter the company contact email.')
				;
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->value = isset($this->page->user['usid']) ? $this->page->user['usid'] : '';
		
		if($this->value!='')
			{
			$this->db->update($this->table, $this->page->postdata, array($this->index => $this->value))
					? $this->page->success('Your company profile has been updated.')
					: $this->page->error('There was an error updating your company profile.');
			}
		else
			{
			$this->page->error('It appears as though your ID cannot be found. Try logging out and back in again.');	
			}
		}
			
	$this->page->respond();
	}

//////////////////////////////////////////////////////////////////
// New Company Profile Email
private function registered()
	{
	$this->load->library('email');
	
	$this->email->to($this->page->postdata['companyemail']);
	$this->email->from($this->noreply);
	$this->email->subject('Company Profile Setup - '.$this->page->site['sitename']);
	
	$hlogo = './_med/images/storman_email_header.jpg';
	$flogo = './_med/images/storman_email_footer.jpg';
	
	$this->email->attach($hlogo);
	$this->email->attach($flogo);
	
	$this->headlogo = $this->email->attachment_cid($hlogo);
	$this->footlogo = $this->email->attachment_cid($flogo);
	
	$this->email->message($this->load->view('email/company/register', array(), true));
	
	if(!$this->email->send())
		{
		$this->page->success('The company account was created however there was an error sending an email to the company with their login details. You may need to reset the password.', $this->value);	
		}
	else
		{
		$this->page->success('The company has been created and an email has been sent with their login information.', $this->value);		
		}
	}


//////////////////////////////////////////////////////////////////
// Pasword Reset
public function resetpass()
	{
	$this->id();
	
	$this->page	->required('coid', 'The ID for the head office is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		$this->get();
		$this->inline = '0';
		
		$this->secure->pasr = substr(md5(uniqid()), rand(0,8), 8);
		
		$this->page->postdata['pass'] = md5($this->secure->pasr);
		
		$this->secure->enc();
		
		$this->page->postdata['companypass'] = $this->page->postdata['pass'];
		
		unset($this->page->postdata['companyname'], $this->page->postdata['pass']);
		
		if($this->db->update($this->table, array('companypass' => $this->page->postdata['companypass']), array('coid' => $this->page->postdata['coid'])))
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
	
	$this->email->to($this->page->record['companyemail']);
	$this->email->from('no-reply@storman.com');
	$this->email->subject('Company Profile Password Reset - '.$this->page->site['sitename']);
	
	$hlogo = './_med/images/storman_email_header.jpg';
	$flogo = './_med/images/storman_email_footer.jpg';
	
	$this->email->attach($hlogo);
	$this->email->attach($flogo);
	
	$this->headlogo = $this->email->attachment_cid($hlogo);
	$this->footlogo = $this->email->attachment_cid($flogo);
	
	$this->email->message($this->load->view('email/company/reset', array(), true));
	
	if(!$this->email->send())
		{
		$this->page->error('There was an error sending the email with the new password.');
		}
	else
		{
		$this->page->success('The login has been reset and an email has been sent.');
		}
	}

//////////////////////////////////////////////////////////////////
// Company Autocomplete
public function autocomplete()
	{
	$r = $this->db	->like('companyname', $this->page->postdata['term'])	
					->get($this->table)->result_array();
	
	$l = array();
	
	if(!empty($r))
		{
		foreach($r as $i)
			{
			$l[] = array(	'id' => $i['coid'],
							'label' => stripslashes($i['companyname'])
							);
			}
		}
	
	!empty($l) 
		? $this->page->response($l)	
		: $this->page->error('No results found.');
	
	$this->page->respond();	
	}


//////////////////////////////////////////////////////////////////
// Company Logo Upload
public function logo()
	{
	$this->id();
	
	$this->page	->required('coid', 'The ID for the company is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('companies')->allowed(array('jpg', 'png'))->field('companylogo')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('companies', array('companylogo' => $this->filename), array('coid' => $this->page->record['coid'])))
				{
				if($this->page->record['companylogo']!='' && file_exists($this->uploader->path.$this->page->record['companylogo']))
					{
					unlink($this->uploader->path.$this->page->record['companylogo']);	
					}
				
				$this->page	->success('The company logo has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/companies/'.$this->filename,
									'logo' => '<img src="/_med/companies/'.$this->filename.'" alt="" title="Company Logo" class="company-img" />'
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
// Company Email Header
public function emailheader()
	{
	$this->id();
	
	$this->page	->required('coid', 'The ID for the company is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('companies/header')->allowed(array('jpg', 'png'))->field('companyheader')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('companies', array('companyemailheader' => $this->filename), array('coid' => $this->page->record['coid'])))
				{
				if($this->page->record['companyemailheader']!='' && file_exists($this->uploader->path.$this->page->record['companyemailheader']))
					{
					unlink($this->uploader->path.$this->page->record['companyemailheader']);	
					}
				
				$this->page	->success('The company email header has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/companies/header/'.$this->filename,
									'header' => '<img src="/_med/companies/header/'.$this->filename.'" alt="" title="Company Email Header" class="company-img" />'
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
// Company Logo Upload
public function emailfooter()
	{
	$this->id();
	
	$this->page	->required('coid', 'The ID for the company is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('companies/footer')->allowed(array('jpg', 'png'))->field('companyfooter')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('companies', array('companyemailfooter' => $this->filename), array('coid' => $this->page->record['coid'])))
				{
				if($this->page->record['companyemailfooter']!='' && file_exists($this->uploader->path.$this->page->record['companyemailfooter']))
					{
					unlink($this->uploader->path.$this->page->record['companyemailfooter']);	
					}
				
				$this->page	->success('The company email footer has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/companies/footer/'.$this->filename,
									'footer' => '<img src="/_med/companies/footer/'.$this->filename.'" alt="" title="Company Email Footer" class="company-img" />'
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
	
	$this->page	->required('coid', 'The ID for the company is missing.')
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
				$f = 'companylogo';
				$d = '';
				break;
				case 'header':
				$f = 'companyemailheader';
				$d = 'header/';
				break;
				case 'footer':
				$f = 'companyemailfooter';
				$d = 'footer/';
				break;		
				}
			
			if($f!='' && $this->page->record[$f]!='' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/companies/'.$d.$this->page->record[$f]))
				{
				if(unlink($_SERVER['DOCUMENT_ROOT'].'/_med/companies/'.$d.$this->page->record[$f]))
					{
					$this->db->update('companies', array($f => ''), array('coid' => $this->page->record['coid']))
						? $this->page->success('The company '.$this->page->postdata['type'].' has been removed.')
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





}