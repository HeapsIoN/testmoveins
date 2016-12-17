<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	$this->load->model('moveins');
	
	$this->moveins->init();
	
	$this->page->js('movein/moveins.inc.js');
	
	if($this->uri->segment(1))
		{
		switch($this->uri->segment(1))
			{
			case 'facility':
			$this->facility();
			break;
			case 'unit':
			$this->unit();
			break;
			case 'customer':
			$this->customer();
			break;
			case 'contract':
			$this->contract();
			break;
			case 'summary':
			$this->summary();
			break;
			case 'payment':
			$this->payment();
			break;
			case 'completed':
			$this->completed();
			break;
			case 'logout':
			$this->logout();
			break;
			case 'script':
			$this->script();
			break;	
			}
		}
	else
		{
		$this->index();	
		}
	
	$this->page->output();
	}
	
public function index()
	{
	$this->page	->head('pagetitle', 'Under Construction')
				->view('home')
				->nosteps(1);
				
	}

public function facility()
	{
	$this->page	->head('pagetitle', 'Facility Selection')
				->view('movein/facility')
				->js('movein/facility.inc.js')
				->step(0);
	
	$this->moveins	->facautoset()
					->facinfo()
					->offline();			
	}

public function unit()
	{
	$this->moveins->units('facility')->offline();
	
	$this->page	->head('pagetitle', 'Unit Selection')
				->view('movein/unit')
				->js('movein/unit.inc.js')
				->js('movein/unit'.$this->moveins->facinfo['facilityunitmethod'].'.inc.js')
				->step(1);
	
	}

public function customer()
	{
	$this->page	->head('pagetitle', 'Customer Login / Register')
				->view('movein/customer')
				->js('movein/customer.inc.js')
				->step(2);
	
	$this->moveins->customer()->offline();	
	}

public function contract()
	{
	$this->page	->head('pagetitle', 'Storage Contract')
				->view('movein/contract')
				->css('signaturepad.css')
				->js('signaturepad/jquery.signaturepad.js')
				->js('movein/contract.inc.js')
				->step(3);
	
	$this->moveins->contract()->offline();				
	}

public function summary()
	{
	$this->page	->head('pagetitle', 'Payment Summary')
				->view('movein/summary')
				->step(4);
	
	$this->moveins->summary()->offline();
	}

public function payment()
	{
	$this->page	->head('pagetitle', 'Online Payments')
				->step(5);
	
	$this->moveins->payment()->offline();
	}

public function completed()
	{
	$this->page	->head('pagetitle', 'Order Completed')
				->view('movein/completed')
				->step(6);
	
	$this->moveins->completed();				
	}


public function logout()
	{
	if(isset($_GET['ds']))
		{
		$this->session->sess_destroy();
		header('Location: /facility');	
		}
	else
		{
		$this->session->unset_userdata($this->moveins->sesname);
		header('Location: /facility/'.$this->moveins->user['facilitycode']);
		}
	
	die();
	}


public function script()
	{
	if($_SERVER['REMOTE_ADDR']=='203.206.137.6')
		{
		//echo '<pre>';die(print_r($this->moveins->facinfo));
		
		$this->moveins->paycomplete();
		
		echo '<pre>';die('testing again');
		}
	}



}
