<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loggers extends CI_Model {
	
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Companies Variables

var $actions	= array();
var $error		= array();


public function actions()
	{
	if($this->uri->segment(3))
		{
		$this->db->where('slid', $this->uri->segment(3));	
		}
	if(isset($_GET['call']))
		{
		$this->db->like('stormanrequest', $_GET['call']);	
		}
		
	$this->actions = $this->db->order_by('stormantime', 'desc')->limit(75)->get('stormanlog')->result_array();	
	}

public function errors()
	{
	if($this->uri->segment(3))
		{
		$this->db->where('stxid', $this->uri->segment(3));	
		}
	if(isset($_GET['call']))
		{
		$this->db->like('errorfunction', $_GET['call']);	
		}
		
	$this->errors = $this->db->order_by('errortime', 'desc')->limit(50)->get('stormanerrors')->result_array();	
	}



}