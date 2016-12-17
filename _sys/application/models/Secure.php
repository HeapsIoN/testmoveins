<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secure extends CI_Model {
	
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Security Variables


////////////////////////////////////////////////////////////////
// Encryption Hash
// Changing this will render all passwords invalid
var $hkey	= 'BNyu63@)iYt6*iH!2^uuIUbiU&h908B(7b(O*&BH(*h(B(*J08h*&T%^FV*^%tcvU';


var $pasr	= '';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Login, Encrypt and Set

public function login()
	{
	$this->page->required(array(
		'user' => 'You must input your username / email address.',
		'pass' => 'You must input your password.',
		))
		->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->enc();
		
		$a = $this->db	->where(array('useremail' => $this->page->postdata['user'], 'userpass' => trim($this->page->postdata['pass'])))
						->get('users');
		
		if($a->num_rows()=='1')
			{
			$r = $a->row_array();
			
			$this->admin($r);
			
			$this->page->success('Login successful.')->response('redirect', '/admin/companies');
			}
		elseif($a->num_rows() > '1')
			{
			$this->page->error('Sorry but there seems to be multiple accounts with those details. Please contact support.');
			}
		else
			{
			$c = $this->db	->where(array('companyemail' => $this->page->postdata['user'], 'companypass' => $this->page->postdata['pass']))
							->get('companies');
						
			if($c->num_rows()=='1')
				{
				$r = $c->row_array();
				
				$this->admin($r);
				
				$this->page->success('Login successful.')->response('redirect', '/admin/profile');
				}
			else
				{
				$f = $this->db	->where(array('facilityemail' => $this->page->postdata['user'], 'facilitypass' => $this->page->postdata['pass']))
								->get('facilities');
				
				if($f->num_rows()=='1')
					{
					$r = $f->row_array();
					
					$this->admin($r);
					
					$this->page->success('Login successful.')->response('redirect', '/admin/profile');
					}
				else
					{			
					$this->page->error('Sorry but no account was found matching those details.');	
					}
				}
			}
		}
	
	$this->page->respond();
	}

public function enc()
	{
	$this->page->postdata['pass'] = sha1($this->hkey.$this->page->postdata['pass']);
	
	return $this;
	}

private function admin($r)
	{
	if(isset($r['usid']))
		{
		$this->page->user = array(	'ili'		=> '1',
									'usid' 		=> $r['usid'],
									'admin' 	=> $r['useradmin'],
									'name' 		=> $r['username'],
									'email'		=> $r['useremail'],
									'group'		=> 'admin'
									);
		}
	elseif(isset($r['fcid']))
		{
		$this->page->user = array(	'ili'		=> '1',
									'usid' 		=> $r['fcid'],
									'admin' 	=> '2',
									'name' 		=> $r['facilityname'],
									'email'		=> $r['facilityemail'],
									'group'		=> 'facility'
									);	
		}
	elseif(isset($r['coid']))
		{
		$this->page->user = array(	'ili'		=> '1',
									'usid' 		=> $r['coid'],
									'admin' 	=> '2',
									'name' 		=> $r['companyname'],
									'email'		=> $r['companyemail'],
									'group'		=> 'company'
									);	
		}
	
	
	$this->session->set_userdata('storman_movein', $this->page->user);
	}

public function get()
	{
	$this->page->record = $this->db->where('usid', $this->page->user['usid'])->get('users')->row_array();
	}

public function load()
	{
	$this->page->user = $this->session->userdata('storman_movein');
	
	$this->kayako();
	
	$exc = array('admin/login', 'ajax/portal/login', 'admin/logout');
	
	if(!in_array($this->uri->uri_string(), $exc))
		{
		if(empty($this->page->user))
			{
			$this->session->set_flashdata('error', 'You must be logged in to view that page.');
			header('Location: /admin/login');
			die();	
			}
		}
	
	return $this; 	
	}

public function permission($groups=array())
	{
	if(!empty($groups) && !in_array($this->page->user['group'], $groups))
		{
		$this->session->set_flashdata('error', 'You must be logged in to view that page.');
		header('Location: /admin/login');
		die();
		}
	
	return $this;
	}

public function record($p=NULL)
	{
	if($p!=NULL)
		{
		if($this->page->user['group']=='facility' && isset($this->admin->postdata['fcid']) && $this->admin->postdata['fcid']!='' && $this->admin->postdata['fcid']!=$this->page->user['usid'])
			{
			$this->admin->error('Your do not have permission to edit that resource.');
			}
		elseif($this->page->user['group']=='company' && isset($this->admin->postdata['coid']) && $this->admin->postdata['coid']!='' && $this->admin->postdata['coid']!=$this->page->user['usid'])
			{
			$this->admin->error('Your do not have permission to edit that resource.');
			}
		}
	else
		{
		if($this->page->user['group']=='facility' && isset($this->admin->record['fcid']) && $this->admin->record['fcid']!='' && $this->admin->record['fcid']!=$this->page->user['usid'])
			{
			$this->admin->error('Your do not have permission to view that resource.');
			}
		elseif($this->page->user['group']=='company' && isset($this->admin->record['coid']) && $this->admin->record['coid']!='' && $this->admin->record['coid']!=$this->page->user['usid'])
			{
			$this->admin->error('Your do not have permission to view that resource.');
			}
		}
	
	return $this;
	}

public function kayako()
	{
	//die(print_r($_COOKIE));
	
	$ses = isset($_COOKIE['SWIFT_sessionid20']) ? $_COOKIE['SWIFT_sessionid20'] : '';
	
	if($ses!='')
		{
		$staff = $this->db->db_select('staff')->where('sessionid', $ses)->order_by('staffloginlogid', 'DESC')->row_array();
		
		if(!empty($staff))
			{
			$this->page->user = array(	'ili'		=> '1',
										'usid' 		=> $staff['staffid'],
										'admin' 	=> '1',
										'name' 		=> $staff['staffname'],
										'email'		=> $staff['staffemail'],
										'group'		=> 'admin'
										);	
			}
		}
	}

public function resetpass()
	{
	
	$this->page->required(array(
		'user' => 'You must input your email address.',
		))
		->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->enc();
		
		$a = $this->db	->where(array('useremail' => $this->page->postdata['user']))
						->get('users');
		
		if($a->num_rows()=='1')
			{
			// Reset system user
			$this->page->error('Sorry but that access level cannot be reset from here.');
			}
		elseif($a->num_rows() > '1')
			{
			$this->page->error('Sorry but there seems to be multiple accounts with those details. Please contact support.');
			}
		else
			{
			$c = $this->db	->where(array('companyemail' => $this->page->postdata['user']))
							->get('companies');
						
			if($c->num_rows()=='1')
				{
				$this->load->model('companies');
				
				$r = $c->row_array();
				
				$this->page->postdata['coid'] = $r['coid'];
				
				$this->companies->resetpass();
				}
			else
				{
				$f = $this->db	->where(array('facilityemail' => $this->page->postdata['user']))
								->get('facilities');
				
				if($f->num_rows()=='1')
					{
					// Reset Facility
					$this->load->model('facilities');
				
					$r = $c->row_array();
				
					$this->page->postdata['fcid'] = $r['fcid'];
				
					$this->facilities->resetpass();
					}
				else
					{			
					$this->page->error('Sorry but no account was found matching those details.');	
					}
				}
			}
		}
	
	$this->page->respond();	
	}



}