<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	$this->load	->model('moveins')
				->model('reservations');
	
	$this->moveins->init();
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'profile' :
			$this->profile();
			break;
			case 'place' :
			$this->place();
			break;
			case 'receipter' :
			$this->receipter();
			break;
			case 'movein' :
			$this->movein();
			break;
			case 'payment' :
			$this->payment();
			break;
			case 'confirm' :
			$this->confirm();
			break;
			default :
			$this->page->error('The request is unknown.')->respond();
			break;	
			}
		}
	else
		{
		$this->page->error('The request is missing.')->respond();
		}
	}

public function profile()
	{
	$this->reservations->profile();
	}

public function place()
	{
	$this->reservations->place();
	}

public function receipter()
	{
	$this->reservations->receipter();
	}

public function movein()
	{
	$this->reservations->movein();
	}

public function confirm()
	{
	$this->reservations->confirm();
	}

public function payment()
	{
	$this->reservations->payment();
	}


}