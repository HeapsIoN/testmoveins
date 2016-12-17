<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facility extends CI_Controller {

public function _remap()
	{
	$this->page->administer();
	
	$this->load->model('facilities');
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'save' :
			$this->save();
			break;
			case 'units' :
			$this->units();
			break;
			case 'upload' :
			$this->upload();
			break;
			case 'autocomplete' :
			$this->autocomplete();
			break;
			case 'emailheader' :
			$this->emailheader();
			break;
			case 'emailfooter' :
			$this->emailfooter();
			break;
			case 'resetpass' :
			$this->resetpass();
			break;
			case 'removeimg' :
			$this->removeimg();
			break;
			case 'privacy' :
			$this->privacy();
			break;
			case 'insurance' :
			$this->insurance();
			break;
			case 'emailfile' :
			$this->emailfile();
			break;
			case 'removepdf' :
			$this->removepdf();
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
	$this->facilities->save();
	}

public function upload()
	{
	$this->facilities->logo();
	}

public function emailheader()
	{
	$this->facilities->emailheader();
	}

public function emailfooter()
	{
	$this->facilities->emailfooter();
	}

public function autocomplete()
	{
	$this->facilities->autocomplete();
	}

public function resetpass()
	{
	$this->facilities->resetpass();
	}

public function removeimg()
	{
	$this->facilities->removeimg();
	}

public function privacy()
	{
	$this->facilities->privacy();
	}

public function insurance()
	{
	$this->facilities->insurance();
	}

public function emailfile()
	{
	$this->facilities->emailfile();
	}

public function resfile()
	{
	$this->facilities->resfile();
	}
		
public function removepdf()
	{
	$this->facilities->removepdf();
	}
}