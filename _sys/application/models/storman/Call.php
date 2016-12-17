<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Call extends CI_Model {

var $data 		= array();
var $fserver	= '';
var $fport		= '';
var $fcode		= '';
var $fpass		= '';	


public function __construct()
	{
	parent::__construct();
	
	$this->load->model('storman/api');
	}

public function init()
	{
	$this->api->clear();
	
	$this->api->code($this->fcode)->pass($this->fpass)->server($this->fserver)->port($this->fport);
	
	return $this;
	}

public function server($s)
	{
	$this->fserver = $s;
	
	return $this;
	}

public function port($p)
	{
	$this->fport = $p;
	
	return $this;
	}
	
public function facility($f)
	{
	$this->fcode = $f;
	
	return $this;
	}

public function password($f)
	{
	$this->fpass = $f;
	
	return $this;
	}

public function data($d, $v=NULL)
	{
	if(is_array($d))
		{
		$this->data = array_merge($this->data, $d);
		}
	else
		{
		$this->data[$d] = $v;
		}
	
	return $this;
	}


public function loginCustomer()
	{
	$this->api->loginCustomer();
	}

public function editCustomer()
	{
	$this->api->editCustomer();
	}

public function editEmailPass()
	{
	$this->api->editEmailPass();
	}


public function createReservation()
	{
	$this->api->createReservation();
	}

public function getUnitTypes()
	{
	$this->api->getUnitTypes();
	}

public function getUnitStatus2()
	{
	$this->api->getUnitStatus2();
	}

public function getPricing()
	{
	$this->api->getPricing();
	}

public function addSalesLead()
	{
	$this->api->addSalesLead();
	}

public function convertLead()
	{
	$this->api->convertLead();
	}

public function addReceipt()
	{
	$this->api->addReceipt();
	}

public function onlineOrder()
	{
	$this->api->onlineOrder();
	}

public function getInsurance()
	{
	$this->api->getInsurance();
	}

public function addAgreement()
	{
	$this->api->addAgreement();
	}

public function editInsurance()
	{
	$this->api->editInsurance();
	}

public function addPDF()
	{
	$this->api->addPDF();
	}

public function addNote()
	{
	$this->api->addNote();
	}

public function retrieveFacility()
	{
	$this->api->retrieveFacility();
	}

public function setPassword()
	{
	$this->api->setPassword();
	}

public function resetPassword()
	{
	$this->api->resetPassword();
	}


public function getCodes()
	{
	$this->api->getCodes();
	}


public function getEziFees()
	{
	$this->api->getEziFees();
	}

public function getMarketingTypes()
	{
	$this->api->getMarketingTypes();
	}


public function doBilling()
	{
	$this->api->doBilling();
	}

public function addCharge()
	{
	$this->api->addCharge();
	}



}

