<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends CI_Model {

// $directory must be set
var $directory	= '/usr/share/nginx/html/_med/agreements/';
var $html		= '';
var $output		= '';
var $template 	= '';
var $data		= array();
var $filename 	= '';
var $filefolder	= '';
var $response 	= array();
var $outputpath	= '';
var $filepath	= '';

public function __construct()
	{
	// Call the Model constructor
	parent::__construct();
	
	// Load Helper
	$this->load->helper(array('dompdf', 'file'));
	}


public function folder($f)
	{
	$this->filefolder = $f;
	
	return $this;	
	}

public function filename($n)
	{
	$this->filename = $n;
	
	return $this;		
	}

public function template($t)
	{
	$this->template = $t;
	
	return $this;	
	}

/**
 * generate
 *
 * Function used to generate PDF file from template view with data.
 *
 */
public function generate()
	{
	// Set template as variable for PDF
	$this->html = $this->page->pdftpl($this->template);
	
	// Output the pdf as a file
	$this->output = pdf_create($this->html, '', false, false);
	
	// Prep the path
	$this->path();
	
	// Prep the file name
	$this->name();	
	
	// Set the output path and clean path if correct
	$this->outputpath = $this->directory.$this->filefolder.$this->filename.'.pdf';	
	$this->filepath = substr($this->outputpath, 1);
	
	// Write the PDF file and respond
	if(write_file($this->outputpath, $this->output))
		{
		$this->response = array('success' => $this->filepath);	
		}
	else
		{
		$this->response = array('error' => 'error');	
		}
	}

private function path()
	{
	if($this->filefolder!='')
		{
		$this->filefolder = substr($this->filefolder,0,1)=='/' ? substr($this->filefolder,1) : $this->filefolder;
		$this->filefolder = substr($this->filefolder,-1)=='/' ? substr($this->filefolder,0,-1) : $this->filefolder;
		$this->filefolder = $this->filefolder.'/';
		}
	}

private function name()
	{
	if($this->filename=='')
		{
		$this->filename = date('Ymd').sha1(uniqid());
		}
	}

}
