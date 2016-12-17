<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

public function _remap()
	{
	$this->page->administer();
	
	$this->load->model('units');
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'save' :
			$this->save();
			break;
			case 'upload' :
			$this->upload();
			break;
			case 'copy' :
			$this->copyunits();
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
	$this->units->save();
	}

public function upload()
	{
	$this->units->photo();
	}

public function copyunits()
	{
	$this->units->copyunits();
	}

public function removeimg()
	{
	$this->units->removeimg();
	}

}