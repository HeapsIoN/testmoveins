<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Model {

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Uploader Variables
var $path		= '';
var $fullpath	= '/usr/share/nginx/html/_med/';
var $folder 	= 'images';
var $fieldname 	= 'fileupload';
var $filename	= '';
var $fileinfo	= array();
var $postdata 	= array();
var $response 	= array();
var $settings 	= array();
var $allowed	= array();
var $setname	= '';
var $randomname	= TRUE;
var $overwrite	= FALSE;
var $maketn		= '0';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Media Resizing Variables
var $resize		= '';
var $resizing	= array();
var $resizeerr	= '';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Media Cropping Variables
var $crop	= array();

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Media Removal Variables
var $remove		= '';
var $removal	= array();

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// FTP Config [Used for handling permissions]
var $fcfg		= array();
var $fhost		= '119.17.160.184';
var $fuser		= 'Luke';
var $fpass		= 'DrXXv5j645CsP7Z7';



public function __construct()
	{
	parent::__construct();
	}




public function folder($v)
	{
	$this->folder = $v;
	
	return $this;
	}

public function field($v)
	{
	$this->fieldname = $v;
	
	return $this;
	}

public function allowed($a)
	{
	$this->allowed = $a;
	
	return $this;
	}


public function name($v)
	{
	$this->setname = $v;
	
	$this->encrypted(FALSE)->overwrite(TRUE);
	
	return $this;
	}

public function encrypted($v)
	{
	$this->randomname = $v;
	
	return $this;
	}

public function overwrite($v)
	{
	$this->overwrite = $v;
	
	return $this;
	}

public function thumb($v)
	{
	$this->maketn = $v;
	
	return $this;
	}

public function settings($k, $v=NULL)
	{
	if(is_array($k))
		{
		foreach($k as $l => $m)
			{
			$this->settings[$l] = $m;	
			}
		}
	else
		{
		$this->settings[$k] = $v;	
		}
	
	return $this;
	}





// Upload Settings
public function init()
	{
	$this->path = $this->folder!='' ? $this->fullpath.$this->folder.'/' : $this->fullpath;
	
	$this->settings['upload_path'] 		= $this->path;
	$this->settings['allowed_types'] 	= !empty($this->allowed) ? $this->allowed : '*';
	$this->settings['encrypt_name'] 	= $this->randomname;
	$this->settings['overwrite'] 		= $this->overwrite;
	$this->settings['file_ext_tolower'] = TRUE;
	
	//die(print_r($this->settings));
	
	if($this->setname!='')
		{
		$this->settings['file_name'] 	= $this->setname;
		$this->settings['encrypt_name'] = FALSE;
		}
	}

private function writable()
	{
	$this->load->library('ftp');
	
	$this->fcfg['hostname'] = $this->fhost;
	$this->fcfg['username'] = $this->fuser;
	$this->fcfg['password'] = $this->fpass;
	$this->fcfg['debug'] 	= TRUE;
	
	$this->ftp->connect($this->fcfg);
	
	$this->ftp->chmod('/_med/'.$this->folder.'/', 0777);
	}

private function unwritable()
	{
	//$this->ftp->chmod('/_med/'.$this->folder.'/', 0775);
	
	$this->ftp->close();
	}


// Upload Script	
public function upload()
	{
	//$this->writable();
	
	if(!isset($this->page->response['error']))
		{
		$this->init();
				
		$this->load->library('upload');
		
		$this->upload->initialize($this->settings);
		
		if($this->upload->do_upload($this->fieldname))
			{
			$this->fileinfo = $this->upload->data();
			
			$this->filename = $this->fileinfo['file_name'];
			
			$this->thumbnail();
			}
		else
			{
			$this->page->error('There was an error uploading the file.<br />'.$this->upload->display_errors('', ''));	
			}
		}
	
	//$this->unwritable();
	}


// Media Manager Deleting
public function delete()
	{
	$this->admin->required = array(	'folder' => 'The file directory is missing.',
									'file' => 'The file name is missing.',
									);
									
	$this->admin->validate();

	if(!isset($this->admin->response['error']))
		{
		$this->folder = $this->admin->postdata['folder'];
		$this->remove($this->admin->postdata['file']);
		
		if(isset($this->removal['success']))
			{
			$this->admin->success($this->removal['success']);	
			}
		elseif(isset($this->removal['missing']))
			{
			$this->admin->error($this->removal['missing']);	
			}
		elseif(isset($this->removal['error']))
			{
			$this->admin->error($this->removal['error']);	
			}
		}
	
	$this->admin->respond();	
	}

// Removal Script
public function remove($file=NULL)
	{
	if($file==NULL)
		{
		$this->removal['missing'] = 'Sorry but the name is empty.';	
		}
	elseif(!file_exists($this->fullpath.$this->folder.'/'.$file))
		{
		$this->removal['missing'] = 'The file does not exist. Check file path: '.$this->folder.'/'.$file;	
		}
	else
		{
		if(unlink($this->fullpath.$this->folder.'/'.$file))
			{
			if(file_exists($this->fullpath.$this->folder.'/tn/'.$file))
				{
				unlink($this->fullpath.$this->folder.'/tn/'.$file);	
				}
				
			$this->removal['success'] = 'Your file has been removed.';
			}
		else
			{
			$this->removal['error'] = 'Sorry but there was an error removing the file.';
			}
		}
	}


// Thumbnail Generation
public function thumbnail()
	{
	if($this->maketn!='0' && $this->fileinfo['is_image']=='1')
		{
		$this->resizing['image_library'] 	= 'gd2';
		
		$this->resizing['source_image'] 	= $this->fullpath.$this->folder.'/'.$this->filename;
		$this->resizing['new_image'] 		= $this->fullpath.$this->folder.'/tn/'.$this->filename;
		
		$this->resizing['maintain_ratio'] 	= TRUE;
		$this->resizing['width']         	= 250;
		$this->resizing['height']       	= 250;
		
		$this->load->library('image_lib', $this->resizing);
		
		if($this->image_lib->resize())
			{
			$this->fileinfo['thumbnail'] = '1';	
			}
		else
			{
			$this->fileinfo['thumbnail'] = '0';
			
			if(isset($this->image_lib->error_msg) && !empty($this->image_lib->error_msg))
				{
				foreach($this->image_lib->error_msg as $msg)
					{
					$this->resizeerr .= $msg.'<br />';	
					}
				}
			
			$this->admin->response('img_lib', $this->resizeerr);
			}
		}
	
	}



// Media Manager Cropping
public function crop()
	{
	$this->admin->required = array(	'editfile' => 'The file name is missing.',
									'directory' => 'The file directory is missing.',
									'xc' => 'The starting X coordinate is missing or invalid.',
									'yc' => 'The starting Y coordinate is missing or invalid.',
									'wc' => 'The width is invalid.',
									'hc' => 'The height is invalid.',
									);
									
	$this->admin->validate();

	if(!isset($this->admin->response['error']))
		{
		$this->folder = $this->admin->postdata['directory'];
		$this->filename = $this->admin->postdata['editfile'];
		
		$this->crop();	
		}
	
	$this->admin->respond();
	}

// Crop Script
public function cropper()
	{
	$this->crop['source_image'] 	= $this->fullpath.$this->folder.'/'.$this->filename;
	$this->crop['maintain_ratio'] 	= false;
	
	$this->crop['width'] 			= $this->admin->postdata['wc'];
	$this->crop['height'] 			= $this->admin->postdata['hc'];
	$this->crop['x_axis'] 			= $this->admin->postdata['xc'];
	$this->crop['y_axis'] 			= $this->admin->postdata['yc'];
	
	$this->load->library('image_lib');
	
	$this->image_lib->initialize($this->crop); 
	
	if(!$this->image_lib->crop())
		{
		$this->admin->error($this->image_lib->display_errors());	
		}
	else
		{
		if($this->crop['width'] > 250 && $this->crop['width'] > 250)
			{
			$this->thumb(1);
			
			$this->thumbnail();
			
			$this->admin->success('Image cropped and thumbnail generated.');
			}
		else
			{
			unlink($this->fullpath.$this->folder.'/tn/'.$this->filename);
			
			$this->admin->success('Image cropped but smaller than thumbnails size so no thumb created.');	
			}
		}
	}




}