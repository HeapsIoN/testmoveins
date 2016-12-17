<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

public function _remap()
	{
	$this->page->administer();
	
	$this->load->model('companies');
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'save' :
			$this->save();
			break;
			case 'profile' :
			$this->profile();
			break;
			case 'upload' :
			$this->upload();
			break;
			case 'autocomplete' :
			$this->autocomplete();
			break;
			case 'resetpass' :
			$this->resetpass();
			break;
			case 'emailheader' :
			$this->emailheader();
			break;
			case 'emailfooter' :
			$this->emailfooter();
			break;
			case 'removeimg' :
			$this->removeimg();
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
	
public function save()
	{
	$this->companies->save();
	}

public function profile()
	{
	$this->companies->profile();
	}

public function upload()
	{
	$this->companies->logo();
	}

public function emailheader()
	{
	$this->companies->emailheader();
	}

public function emailfooter()
	{
	$this->companies->emailfooter();
	}

public function autocomplete()
	{
	$this->companies->autocomplete();
	}

public function resetpass()
	{
	$this->companies->resetpass();
	}

public function removeimg()
	{
	$this->companies->removeimg();
	}
}