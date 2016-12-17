<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'login' :
			$this->login();
			break;
			case 'reset' :
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
	
public function login()
	{
	$this->load->model('secure');
	
	$this->secure->login();
	}

public function resetpass()
	{
	$this->load->model('secure');
	
	$this->secure->resetpass();
	}
}