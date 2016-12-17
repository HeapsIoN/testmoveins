<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	$this->load	->model('moveins')
				->model('reservations');
	
	$this->moveins->init();
	
	$this->page->js('reservation/reservations.inc.js');
	
	$this->page->product = 'Storman Reservations';
	
	if($this->uri->segment(2))
		{
		switch($this->uri->segment(2))
			{
			case 'facility':
			default:
			$this->facility();
			break;
			case 'unit':
			$this->unit();
			break;
			case 'customer':
			$this->customer();
			break;
			case 'summary':
			case 'payment':
			$this->payment();
			break;
			case 'completed':
			$this->completed();
			break;
			case 'logout':
			$this->logout();
			break;
			case 'movein':
			$this->movein();
			break;
			}
		}
	else
		{
		$this->facility();	
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
	
	$this->page	->head('pagetitle', 'Select Your Space')
				->view('movein/unit')
				->js('movein/unit.inc.js')
				->js('movein/unit'.$this->moveins->facinfo['facilityunitmethod'].'.inc.js')
				->step(1);
	
	}

public function customer()
	{
	$this->page	->head('pagetitle', 'Reserve Your Unit')
				->view('reservation/customer')
				->js('reservation/customer.inc.js')
				->step(2);
	
	$this->moveins->customer()->offline();	
	}

public function payment()
	{
	$this->page	->head('pagetitle', 'Booking Fee')
				->step(3);
	
	$this->reservations->summary();
	
	$this->moveins->offline();
	
	//echo '<pre>';die(print_r($this->moveins->customer));
	}

public function completed()
	{
	$this->page	->head('pagetitle', 'Reservation Summary')
				->view('reservation/placed')
				->step(4);
	
	$this->reservations->completed();				
	}


public function movein()
	{
	$this->page	->head('pagetitle', 'Reservation MoveIn')
				->view('reservation/movein')
				->js('reservation/movein.inc.js')
				->nosteps(1);
	
	$this->reservations->movein();				
	}


public function logout()
	{
	if(isset($_GET['ds']))
		{
		$this->session->sess_destroy();
		header('Location: /reservation/facility');	
		}
	else
		{
		$this->session->unset_userdata($this->moveins->sesname);
		header('Location: /reservation/facility/'.$this->moveins->user['facilitycode']);
		}
	
	die();
	}


}
