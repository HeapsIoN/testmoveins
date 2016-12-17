<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

public function _remap()
	{
	$this->page->init();
	
	if($this->uri->segment(3))
		{
		switch($this->uri->segment(3))
			{
			case 'edit':
			$this->edit();
			break;	
			case 'page':
			default :
			$this->index();
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
	$this->page	->head('pagetitle', 'Company Listing')
				->full(1)
				->view('common/menu');
	
	$this->load->model('companies');
	
	
	
	$this->companies->listing();
	}
}
