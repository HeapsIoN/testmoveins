<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movein extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	$this->load->model('moveins');
	
	$this->moveins->init();
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'finder' :
			$this->finder();
			break;
			case 'facility' :
			$this->facility();
			break;
			case 'unit' :
			$this->unit();
			break;
			case 'unitfinder' :
			$this->unitfinder();
			break;
			case 'login' :
			$this->login();
			break;
			case 'confirm' :
			$this->confirm();
			break;
			case 'profile' :
			$this->profile();
			break;
			case 'update' :
			$this->update();
			break;
			case 'accept' :
			$this->accept();
			break;
			case 'summary' :
			$this->summary();
			break;
			case 'receipter' :
			$this->receipter();
			break;
			case 'suburb' :
			$this->suburb();
			break;
			case 'resetpass' :
			$this->resetpass();
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

public function finder()
	{
	$this->moveins->finder();
	}
	
public function facility()
	{
	$this->moveins->facility();
	}

public function unit()
	{
	$this->moveins->unit();
	}

public function unitfinder()
	{
	$this->moveins->unitfinder();
	}

public function login()
	{
	$this->moveins->login();
	}

public function confirm()
	{
	$this->moveins->confirm();
	}

public function profile()
	{
	$this->moveins->profile();
	}

public function update()
	{
	$this->moveins->update();
	}

public function accept()
	{
	$this->moveins->accept();
	}

public function summary()
	{
	$this->moveins->summary();
	}

public function receipter()
	{
	$this->moveins->receipter();
	}

public function suburb()
	{
	$this->moveins->suburb();
	}

public function resetpass()
	{
	$this->moveins->resetpass();
	}

}