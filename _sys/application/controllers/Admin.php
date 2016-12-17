<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Routing
public function _remap()
	{
	//phpinfo();die();
	
	$this->page->administer();
	
	$this->page->css('admin.css');
	
	switch($this->uri->segment(2))
		{
		// Logout
		case 'logout' :
		$this->logout();	
		break;
		
		// Dashboard
		case 'dashboard' :
		$this->dashboard();	
		break;
		
		// Companies
		case 'companies' :
		$this->companies();	
		break;
		case 'company' :
		$this->company();	
		break;
		
		// Facilities
		case 'facilities' :
		$this->facilities();	
		break;
		case 'facility' :
		$this->facility();	
		break;
		
		// Units
		case 'units' :
		$this->units();	
		break;
		case 'unit' :
		$this->unit();	
		break;
		
		// Profile
		case 'profile' :
		$this->profile();	
		break;
		
		
		// Storman Log
		case 'log' :
		$this->logs();	
		break;
		
		// Storman Log
		case 'errors' :
		$this->errors();	
		break;
		
		// Scripter Testing
		case 'scripter' :
		$this->scripter();	
		break;
		
		// Login / Default
		case 'login' :
		default :
		$this->index();	
		break;
		}
	
	$this->page->output();
	}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Login	
public function index()
	{
	$this->page	->head('pagetitle', 'Administration Login')
				->js('login.inc.js')
				->view('login');
	}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Logout	
public function logout()
	{
	$this->session->unset_userdata('storman_movein');
	$this->session->set_flashdata('success', 'See you next time.');
	header('Location: /admin/login');
	die();
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Dashboard
public function dashboard()
	{
	$this->page	->head('pagetitle', 'Administration Dashboard')
				->js('charts/chart.min.js')
				->js('dashboard.inc.js')
				->full(1)
				->commoners('menu')
				->view('dashboard/'.$this->page->user['group']);
	
	
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Companies
public function companies()
	{
	$this->secure->permission(array('admin'));
	
	$this->page	->head('pagetitle', 'Head Office Listing')
				->full(1)
				->commoners('menu')
				->commoners('toolbar');
	
	$this->load->model('companies');
	
	$this->companies->init()->listing();
	
	$this->page	->toolbar('company-edit', 'link', 'plus', 'New Head Office', array('link' => '/admin/company'));
	}

public function company()
	{
	$this->secure->permission(array('admin'));
	
	$this->page	->head('pagetitle', 'Company Manager')
				->view('company/edit')
				->full(1)
				->commoners('menu')
				->commoners('toolbar')
				->js('ajax.uploads.js')
				->js('uploads.inc.js')
				->js('company.inc.js')
				->css('company.css');
	
	$this->load->model('companies');
	
	$this->companies->init()->get();
	
	$s = isset($this->page->record['coid']) && $this->page->record['coid']!='' ? '' : array('style' => 'needs-id');
	
	$this->page	->toolbar('company-save', 'save', 'save', 'Save Head Office')
				->toolbar('company-list', 'link', 'navicon', 'Head Office Listing', array('link' => '/admin/companies'))
				->toolbar('company-edit', 'link', 'plus', 'New Head Office', array('link' => '/admin/company'))
				->toolbar('company-reset', 'button', 'refresh', 'Reset Password', $s);
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Facilities
public function facilities()
	{
	$this->secure->permission(array('admin', 'company'));
	
	$this->page	->head('pagetitle', 'Facility Listing')
				->full(1)
				->commoners('menu')
				->commoners('toolbar');
	
	$this->load->model('facilities');
	
	$this->facilities->init()->listing();
	
	$this->page	->toolbar('facility-edit', 'link', 'plus', 'New Facility', array('link' => '/admin/facility'));
	}

public function facility()
	{
	$this->secure->permission(array('admin', 'company'));
	
	$this->page	->head('pagetitle', 'Facility Manager')
				->full(1)
				->commoners('menu')
				->commoners('toolbar')
				->js('tinymce/tinymce.min.js')
				->js('tinymce.init.js')
				->js('ajax.uploads.js')
				->js('uploads.inc.js')
				->js('facility.inc.js');
	
	$this->load->model('facilities');
	
	$this->facilities->init()->get();
	
	$this->page	->toolbar('facility-save', 'save', 'save', 'Save Facility')
				->toolbar('facility-list', 'link', 'navicon', 'Facility Listing', array('link' => '/admin/facilities'))
				->toolbar('facility-edit', 'link', 'plus', 'New Facility', array('link' => '/admin/facility'));
				//->toolbar('facility-reset', 'button', 'refresh', 'Reset Password');
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Facilities
public function units()
	{
	$this->secure->permission(array('admin', 'company'));
	
	$this->page	->head('pagetitle', 'Unit Listing')
				->full(1)
				->commoners('menu')
				->commoners('toolbar');
	
	$this->load->model('units');
	
	if($this->page->user['group']=='facility')
		{
		$this->units->copyunits();
		
		$this->units->init()->listing();	
		}
	else
		{
		$this->units->init()->listing();
		}
	
	//$this->page	->toolbar('unit-edit', 'link', 'plus', 'New Unit', array('link' => '/admin/unit'));
	}

public function unit()
	{
	$this->secure->permission(array('admin', 'company'));
	
	$this->page	->head('pagetitle', 'Unit Manager')
				->full(1)
				->commoners('menu')
				->commoners('toolbar')
				->js('ajax.uploads.js')
				->js('uploads.inc.js')
				->js('tinymce/tinymce.min.js')
				->js('tinymce.init.js')
				->js('units.inc.js');
	
	$this->load->model('units');
	
	$this->units->init()->get();
	
	$this->secure->record();
	
	$this->page	->toolbar('unit-save', 'save', 'save', 'Save Unit')
				->toolbar('unit-list', 'link', 'navicon', 'Unit Listing', array('link' => '/admin/units'));
				//->toolbar('unit-edit', 'link', 'plus', 'New Unit', array('link' => '/admin/unit'));
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// Dashboard
public function profile()
	{
	$this->page	->head('pagetitle', 'Profile Manager')
				->full(1)
				->commoners('menu')
				->commoners('toolbar');
	
	switch($this->page->user['group'])
		{
		case 'admin':
		$this->page->view('users/profile');
		$this->secure->get();
		break;
		case 'company':
		$this->page->view('company/profile');
		$this->load->model('companies');
		$this->companies->value($this->page->user['usid'])->get();
		$this->page	->js('ajax.uploads.js')
					->js('uploads.inc.js')
					->js('company.inc.js');
		$this->page	->toolbar('company-save', 'save', 'save', 'Save Head Office Profile');
		break;
		case 'facility':
		$this->page->view('facility/profile');
		$this->load->model('facilities');
		$this->facilities->value($this->page->user['usid'])->get();
		$this->page	->js('tinymce/tinymce.min.js')
					->js('ajax.uploads.js')
					->js('uploads.inc.js')
					->js('facility.inc.js');
		
		$this->page	->toolbar('facility-save', 'save', 'save', 'Save Facility Profile');
		break;	
		}
	
	}


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// StorMan Log
public function logs()
	{
	$this->secure->permission(array('admin'));
	
	$this->page	->head('pagetitle', 'StorMan Call Log')
				->full(1)
				->commoners('menu')
				->view('logs/storman');
	
	$this->load->model('loggers');
	
	$this->loggers->actions();
	}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
// StorMan Errors
public function errors()
	{
	$this->secure->permission(array('admin'));
	
	$this->page	->head('pagetitle', 'StorMan Error Log')
				->full(1)
				->commoners('menu')
				->view('logs/errors');
	
	$this->load->model('loggers');
	
	$this->loggers->errors();
	}



public function scripter()
	{
	if($_SERVER['REMOTE_ADDR']=='203.206.137.6')
		{
		$this->load->model('moveins');	
		
		$this->moveins->faccode = 'TTCVS';
		
		$this->moveins->facinfo();
		
		$this->moveins->customer = array(	'customerfirstname' => 'Luke',
											'customersurname' => 'Script',
											'customeremail' => 'email@lukepelgrave.com.au'
											);
		
		$this->moveins->order = array(		'receiptid' => 'TEST001',
											'amountcharged' => '99.45',
											'orderfees' => '2.50',
											'pdf' => '20160510c9f6117cc34888a04e4d21d9d301c151000000175',
											'agreement' => 'TESTAGREE',
											'total' => '99.45',
											'unitnums' => '3'
											);
		
		
		
		$this->moveins->pdfname = '20160510c9f6117cc34888a04e4d21d9d301c151000000175';
		
		$this->moveins->facinfo['facilityrequirepayment'] = '2';
		
		$this->moveins->placed();
		
		echo '<pre>';die('testing placed');
		}
	else
		{
		die('Restricted');	
		}
	}




}
