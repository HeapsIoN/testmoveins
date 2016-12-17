<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Model {


////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Page Variables
var $siteid		= '';		// Site ID for Globals
var $site		= array();	// Site Globals
var $head		= array();	// Head Data
var $foot		= array();	// Foot Data
var $menu		= array();	// Menu Data
var $theme		= 'storman';// Site Theme		
var $view		= array();	// Page View
var $common		= array();	// Common View Includer
var $css		= array();	// Additional CSS Files
var $js			= array();	// Additional CSS Files
var $full		= '0';		// Toggle Menu Display / Full Screen
var $toolbar	= array();	// Toolbar
var $nosteps	= '0';		// Include the steps or not
var $steps		= array();	// Move-In Steps
var $step		= '';		// Current Step
var $product	= 'Storman Move-Ins';

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// User and Customer
var $user 		= array();	// User Info
var $customer	= array();	// Customer Info



////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Page Form Variables
var $required 	= array();	// Required fields array
var $postdata 	= array(); 	// Postdata (merge of post and get)
var $response 	= array();	// Response variables	


////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Page Form Variables
var $search		= array();	// Search Record
var $record		= array();	// Page Record
var $opts		= array();	// Option Array Sets




////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Page Setup

////////////////////////////////////////////////////////////////
// Page Initialiser - Admin
public function administer()
	{
	date_default_timezone_set('Australia/Brisbane');
	
	$this	->themer()
			->load()
			->data()
			->user();
	}

////////////////////////////////////////////////////////////////
// Page Initialiser
public function init()
	{
	date_default_timezone_set('Australia/Brisbane');
	
	$this	->themer()
			->load()			
			->data()
			->steps();
	}
	
////////////////////////////////////////////////////////////////
// Global Definitions
public function load($i=NULL)
	{
	if($this->session->userdata('siteid'))
		{
		$i = $this->session->userdata('siteid');
		}
		
	$this->siteid = $i!=NULL ? $i : $this->siteid;
		
	$this->site = $this->db->where('siteid', $this->siteid)->get('master')->row_array();
	
	if(!$this->session->userdata('theme'))
		{
		$this->theme = isset($this->site['sitetheme']) ? $this->site['sitetheme'] : $this->theme;
		}
	
	$this->head('sitename', $this->site['sitename']);
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// Data
public function data()
	{
	$this->postdata = $this->input->post();
	
	$this->postdata = !empty($_GET) ? array_merge($this->postdata, $this->input->get()) : $this->postdata;
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// User
public function user()
	{
	// Session Checker
	$this->secure->load();
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// Theme and Master Settings
public function themer()
	{
	$this->siteid = 1;
	
	switch($_SERVER['HTTP_HOST'])
		{
		case 'signup.storageking.com.au':
		case 'signup.storageking.storman.com':
		$this->siteid = 2;
		break;
		case 'signup.kss.com.au':
		case 'signup.kennards.storman.com':
		$this->siteid = 3;
		break;
		case 'signup.democompany.storman.com':
		case 'demosign.storman.com':
		$this->siteid = 4;
		break;
		}
	
	if(isset($_GET['theme']))
		{
		$this->theme = $_GET['theme'];
		$this->session->set_userdata('theme', $_GET['theme']);	
		}
	
	if($this->session->userdata('theme'))
		{
		$this->theme = $this->session->userdata('theme');
		}
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// User
public function customer()
	{
	// Session Checker
	$this->page->customer = $this->session->userdata('storman_moveinclient');
	
	return $this;	
	}

public function nosteps($s)
	{
	$this->nosteps = $s;
	
	return $this;	
	}

public function step($s)
	{
	$this->step = $s;
	
	return $this;	
	}

public function steps()
	{
	if($this->uri->segment(1)=='reservation')
		{
		$this->steps = array(	
				'0' => array(
					'name' 			=> 'Facility Selection',
					'lockedfrom'	=> '3',
					'url'			=> 'facility'
					),
				'1' => array(
					'name' 			=> 'Select Your Space',
					'lockedfrom'	=> '3',
					'url'			=> 'unit'
					),
				'2' => array(
					'name' 			=> 'Reserve Your Unit',
					'lockedfrom'	=> '3',
					'url'			=> 'customer'
					),
				'3' => array(
					'name' 			=> 'Booking Fee',
					'lockedfrom'	=> '4',
					'url'			=> 'payment'
					),
				'4' => array(
					'name' 			=> 'Reservation Summary',
					'lockedfrom'	=> '4',
					'url'			=> 'completed'
					),
				);
		
		if($this->uri->segment(2) && $this->uri->segment(2)!='facility')
			{
			//unset($this->steps[0]);	
			}
	
		}
	else
		{
		$this->steps = array(	
						'0' => array(
							'name' 			=> 'Facility Selection',
							'lockedfrom'	=> '4',
							'url'			=> 'facility'
							),
						'1' => array(
							'name' 			=> 'Unit Selection',
							'lockedfrom'	=> '4',
							'url'			=> 'unit'
							),
						'2' => array(
							'name' 			=> 'Your Profile',
							'lockedfrom'	=> '4',
							'url'			=> 'customer'
							),
						'3' => array(
							'name' 			=> 'Contract Review',
							'lockedfrom'	=> '4',
							'url'			=> 'contract'
							),
						'4' => array(
							'name' 			=> 'Payment Summary',
							'lockedfrom'	=> '5',
							'url'			=> 'summary'
							),
						'5' => array(
							'name' 			=> 'Order Payment',
							'lockedfrom'	=> '5',
							'url'			=> 'payment'
							),
						'6' => array(
							'name' 			=> 'Order Completed',
							'lockedfrom'	=> '5',
							'url'			=> 'completed'
							),
						);
		
		if($this->uri->segment(2))
			{
			$q = $this->db->where('facilitycode', $this->uri->segment(2))->get('facilities');
			
			if($q->num_rows()==1)
				{
				//unset($this->steps[0]);	
				}
			}
		
		}
	
	
	}


////////////////////////////////////////////////////////////////
// Fullscreen Layout
public function full($s)
	{
	// Session Checker
	$this->full = $s;
	
	return $this;	
	}



////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Data Builders

////////////////////////////////////////////////////////////////
// Header Builder
public function head($k, $v=NULL)
	{
	if(is_array($k))
		{
		foreach($k as $n => $i)
			{
			$this->head[$n] = $i;	
			}
		}
	elseif($v!=NULL)
		{
		$this->head[$k] = $v;	
		}
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// Footer Builder
public function foot($k, $v=NULL)
	{
	if(is_array($k))
		{
		foreach($k as $n => $i)
			{
			$this->foot[$n] = $i;	
			}
		}
	elseif($v!=NULL)
		{
		$this->foot[$k] = $v;	
		}
	
	return $this;	
	}

////////////////////////////////////////////////////////////////
// View Builder
public function view($v)
	{
	if(is_array($v))
		{
		$this->view = array_merge($this->view, $v);	
		}
	else
		{
		$this->view[] = $v;
		}
	
	$this->view = array_unique($this->view);
	
	return $this;	
	}


////////////////////////////////////////////////////////////////
// Toolbar Builder
public function toolbar($id, $type, $icn, $lbl, $opts=array())
	{
	$t = array(	'id' 	=> $id,
				'type'	=> $type,
				'icon'	=> $icn,
				'lbl'	=> $lbl,
				);
	
	if(!empty($opts))
		{
		$t = array_merge($t, $opts);	
		}
	
	$this->toolbar[] = $t;
	
	return $this;	
	}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Data Validation

//////////////////////////////////////////////////////////////////
// Required Builder
public function required($k, $v=NULL)
	{
	if(is_array($k))
		{
		foreach($k as $l => $m)
			{
			$this->required[$l] = $m;	
			}
		}
	else
		{
		$this->required[$k] = $v;	
		}
	
	return $this;
	}

//////////////////////////////////////////////////////////////////
// Validator
public function validate()
	{
	if(!empty($this->required))
		{
		foreach($this->required as $k => $m)
			{
			if(!isset($this->postdata[$k]) || $this->postdata[$k]=='')
				{
				$this->error($m);	
				}
			}
		}
	
	return $this;
	}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Response Handling

public function success($m, $i=NULL)
	{
	$this->response['success'] = isset($this->response['success']) ? $this->response['success'].'<br />'.$m : $m;
	
	if($i!=NULL)
		{
		$this->response['itemid'] = $i;	
		}
	
	return $this;
	}

public function error($m)
	{
	$this->response['error'] = isset($this->response['error']) ? $this->response['error'].'<br />'.$m : $m;
	
	return $this;
	}

public function response($k, $v=NULL)
	{
	if(is_array($k))
		{
		foreach($k as $l => $m)
			{
			$this->response[$l] = $m;	
			}
		}
	else
		{
		$this->response[$k] = $v;	
		}
	
	return $this;	
	}

public function respond()
	{
	$this->output->set_content_type('application/json')->set_output(json_encode($this->response));
	}

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Data Outputters

////////////////////////////////////////////////////////////////
// Head Data Output
public function site($k, $pre=NULL, $pst=NULL)
	{
	if(isset($this->site[$k]))
		{
		if($pre!=NULL){echo $pre;}
		
		echo $this->site[$k];	
		
		if($pst!=NULL){echo $pst;}
		}
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// Head Data Output
public function heading($k, $pre=NULL, $pst=NULL)
	{
	if(isset($this->head[$k]))
		{
		if($pre!=NULL){echo $pre;}
		
		echo $this->head[$k];	
		
		if($pst!=NULL){echo $pst;}
		}
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// Head Data Output
public function footing($k, $pre=NULL, $pst=NULL)
	{
	if(isset($this->foot[$k]))
		{
		if($pre!=NULL){echo $pre;}
		
		echo $this->foot[$k];	
		
		if($pst!=NULL){echo $pst;}
		}
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// Record Output
public function record($k, $pre=NULL, $pst=NULL)
	{
	if(isset($this->record[$k]))
		{
		if($pre!=NULL){echo $pre;}
		
		echo $this->record[$k];	
		
		if($pst!=NULL){echo $pst;}
		}
	
	return $this;
	}


////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Include Builders

////////////////////////////////////////////////////////////////
// CSS Builder
public function css($f)
	{
	if(is_array($f))
		{
		foreach($f as $i)
			{
			$this->css[] = $i;	
			}
		}
	else
		{
		$this->css[] = $f;	
		}
	
	$this->css = array_unique($this->css);
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// JS Builder
public function js($f)
	{
	if(is_array($f))
		{
		foreach($f as $i)
			{
			$this->js[] = $i;	
			}
		}
	else
		{
		$this->js[] = $f;	
		}
	
	$this->js = array_unique($this->js);
	
	return $this;
	}


////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Page Display

////////////////////////////////////////////////////////////////
// JS Builder
public function commoners($v)
	{
	if(is_array($v))
		{
		foreach($v as $i)
			{
			$this->common[] = $i;	
			}
		}
	else
		{
		$this->common[] = $v;	
		}
	
	$this->common = array_unique($this->common);
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// Common Page Elements
public function common($view)
	{
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->theme.'/views/common/'.$view.'.php'))
		{
		$this->load->view('../../'.$this->theme.'/views/common/'.$view, array());	
		}
	else
		{
		$this->load->view('common/'.$view, array());
		}
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// View Output
public function commons()
	{
	if(!empty($this->common))
		{
		foreach($this->common as $view)
			{
			if($this->theme!='storman' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->theme.'/views/common/'.$view.'.php'))
				{
				$this->load->view('../../'.$this->theme.'/views/common/'.$view, array());	
				}
			else
				{
				$this->load->view('common/'.$view, array());	
				}
			}
		}
	
	return $this;
	}

////////////////////////////////////////////////////////////////
// View Output
public function viewer()
	{
	if(!empty($this->view))
		{
		foreach($this->view as $view)
			{
			if($this->theme!='storman' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->theme.'/views/pages/'.$view.'.php'))
				{
				$this->load->view('../../'.$this->theme.'/views/pages/'.$view, array());	
				}
			else
				{
				$this->load->view('pages/'.$view, array());	
				}
			}
		}
	
	return $this;
	}


////////////////////////////////////////////////////////////////
// Load Email Message
public function emailmsg($tpl)
	{
	if($this->theme!='storman' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->theme.'/views/email/'.$tpl.'.php'))
		{
		$view = $this->load->view('../../'.$this->theme.'/views/email/'.$tpl, array(), true);	
		}
	else
		{
		$view = $this->load->view('email/'.$tpl, array(), true);	
		}
	
	return $view;
	}

////////////////////////////////////////////////////////////////
// Load PDF Template
public function pdftpl($tpl)
	{
	if($this->theme!='storman' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->theme.'/views/pdfs/'.$tpl.'.php'))
		{
		$view = $this->load->view('../../'.$this->theme.'/views/pdfs/'.$tpl, array(), true);	
		}
	else
		{
		$view = $this->load->view('pdfs/'.$tpl, array(), true);	
		}
	
	return $view;
	}

////////////////////////////////////////////////////////////////
// Page Output
public function output()
	{
	if($this->uri->segment(1)=='admin' || $this->nosteps=='1')
		{
		$this	->common('header')
				->commons()
				->viewer()
				->common('footer');	
		}
	else
		{
		$this	->common('header')
				->commons()
				->common('steps')
				->viewer()
				->common('footer');
		}
	}	
	
}
