<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regioning extends CI_Model {


var $code			= 'AU';
var $currency		= '$';
var $measurements	= 'm';
var $states			= array();
	
	
public function init()
	{
	$ext = explode('.', $_SERVER['HTTP_HOST']);
	
	end($ext);
	
	switch($ext)
		{
		case 'uk' :
		$this->load->config('region_uk');
		break;
		
		case 'nz' :
		$this->load->config('region_nz');
		break;
		
		case 'au' :
		default :
		$this->load->config('region_au');
		break;
		}
	
	$this->code 		= $this->config->item('code') 		? $this->config->item('code') 		: array();
	$this->states 		= $this->config->item('states') 	? $this->config->item('states') 	: array();
	$this->currency 	= $this->config->item('currency') 	? $this->config->item('currency') 	: array();
	$this->measurements = $this->config->item('measure') 	? $this->config->item('measure') 	: array();
	
	// Additional regional settings can be added here for use via $this->region->variable
	
	
	}	
	
public function code()
	{
	echo $this->code;	
	}
		
public function currency()
	{
	echo $this->currency;	
	}

public function measurement()
	{
	echo $this->measurements;	
	}

	
	
}