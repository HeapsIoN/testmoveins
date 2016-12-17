<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Units extends CI_Model {
	
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Companies Variables

var $table			= 'units';
var $index			= 'unid';
var $value			= '';
var $base			= 'admin/units';
var $link			= 'admin/unit';

var $inline			= '0';

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Search Settings

var $select			= 'units.*';
var $joins			= array('facilities' => 'fcid');
var $alias			= '';
var $fixedfilters	= array();

var $filterby		= 'unitactive';
var $filterlbl		= 'Active';
var $filters		= array('1' => 'Yes, Active', '2' => 'No, Inactive');

var $orderby		= 'unitname';
var $ordering		= 'asc';

var $options		= array(); // Set in listing call dynamically based on user group

var $facility		= array();


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Controller Functions

public function init()
	{
	switch($this->page->user['group'])
		{
		case 'facility' :
		$this->options = array('unitname' => 'Unit Name', 'unitcode' => 'Unit Code');
		break;
		case 'company' :
		$this->select	= 'units.*, facilities.facilityname, facilities.facilitycode, facilities.coid';
		$this->options 	= array('unitname' => 'Unit Name', 'unitcode' => 'Unit Code', 'facilitycode' => 'Facility Code', 'facilityname' => 'Facility Name');
		$this->fixedfilters = array('facilities.coid' => $this->page->user['usid']);
		break;
		case 'admin' :
		default :
		$this->select	= 'units.*, facilities.facilityname, facilities.facilitycode';
		$this->options 	= array('unitname' => 'Unit Name', 'unitcode' => 'Unit Code', 'facilitycode' => 'Facility Code', 'facilityname' => 'Facility Name');
		break;
		}
	
	return $this;	
	}


//////////////////////////////////////////////////////////////////
// Company Listing
public function listing()
	{
	$this->load->model('search');
	
	$this->page	->view('search/header')
				->view('search/listing')
				->view('search/footer');
	
	// Options and Settings
	$this->search->no_results = 'Sorry but no units match your search. Please try searching again or search by a different field.';
	$this->search->no_records = 'No units have been setup in the system yet.';
	
	$this->search	->column('unitactive', 'Active', '1', 'switcher')
					->column('unitcode', 'Code', '1', 'text', 'N/A')
					->column('unitname', 'Unit Name', '3', 'text', 'N/A')
					->column('unitwebname', 'Unit Web Name', '3', 'text', 'N/A')
					->column('unitwidth', 'Width', '1', 'text', 'N/A')
					->column('unitdepth', 'Depth', '1', 'text', 'N/A')
					->column('unitrate', 'Rate', '1', 'currency', 'N/A')
					->column('unitimage', 'Has Image', '1', 'isset');
	
	//////////////////////////////////////////
	// Common Settings
	$this->search->table		= $this->table;
	$this->search->index 		= $this->index;
	$this->search->sessname		= $this->table;
	$this->search->base 		= $this->base;
	$this->search->link 		= $this->link;
	
	$this->search->select		= $this->select;
	$this->search->joins 		= $this->joins;
	$this->search->alias 		= $this->alias;
	
	$this->search->options 		= $this->options;
	
	$this->search->filterby 	= $this->filterby;
	$this->search->filterlbl 	= $this->filterlbl;
	$this->search->filters 		= $this->filters;
	$this->search->fixedfilters = $this->fixedfilters;
	
	$this->search->orderby 		= $this->orderby;
	$this->search->ordering 	= $this->ordering;
	
	// Run the Search
	$this->search->run();	
	}

public function copyunits()
	{
	$fcid = isset($this->page->postdata['fcid']) ? $this->page->postdata['fcid'] : $this->page->user['usid'];
		
	$this->facility = $this->db->where('fcid', $fcid)->get('facilities')->row_array();
	
	if($this->page->user['group']=='company' && $this->page->user['usid']!=$this->facility['coid'])
		{
		$this->page->error('Sorry but you do not have permission to access that resource.');	
		}
	
	if(!empty($this->facility) && !isset($this->page->response['error']))
		{
		$this->load->model('storman/call');
		
		$this->call	->facility($this->facility['facilitycode'])
					->password($this->facility['facilitywebservicepass'])
					->server($this->facility['facilitywebserviceurl'])
					->port($this->facility['facilitywebserviceport'])
					->init()
					->getUnitTypes();
		
		if(!isset($this->api->result['WS_ORSuccess']) || $this->api->result['WS_ORSuccess']!==true)
			{
			$this->page->error('There was an error loading the remote unit types listing. Local data only!');
			}
		else
			{
			$u = $i = array();
			
			$q = $this->db->where('fcid', $fcid)->get('units')->result_array();
			
			$e = array_column($q, 'unitcode', 'unitcode');
			
			//die(print_r($e));
			
			foreach($this->api->result['WS_UTRUnitType'] as $k => $r)
				{
				if(!empty($e) && isset($e[$r]))
					{
					$u[] = array(	'unid' 			=> $e[$r],
									'unitwidth' 	=> $this->api->result['WS_UTUnitTypeWidth'][$k],
									'unitdepth' 	=> $this->api->result['WS_UTUnitTypeLength'][$k],
									'unitrate' 		=> $this->api->result['WS_UTMonthlyRate'][$k],
									'unitname' 		=> $this->api->result['WS_UTDescription'][$k],
									'unitdesc' 		=> $this->api->result['WS_UTDescription'][$k],
									);	
					}
				else
					{
					$i[] = array(	'fcid' 			=> $fcid,
									'unitactive' 	=> '1',
									'unitcreated' 	=> date('Y-m-d'),
									'unitcode' 		=> $r,
									'unitwidth' 	=> $this->api->result['WS_UTUnitTypeWidth'][$k],
									'unitdepth' 	=> $this->api->result['WS_UTUnitTypeLength'][$k],
									'unitrate' 		=> $this->api->result['WS_UTMonthlyRate'][$k],
									'unitname' 		=> $this->api->result['WS_UTDescription'][$k],
									'unitwebname' 	=> '',
									'unitimage' 	=> '',
									'unitdesc' 		=> $this->api->result['WS_UTDescription'][$k],
									'unitwebdesc' 	=> '',
									);	
					}
				}
			
			if(!empty($u))
				{
				$this->db->update_batch('units', $u, 'unid')
					? $this->page->success('Updated unit type data has been copied across from StorMan.')
					: $this->page->success('No units needed to be updated.');
				}
			
			if(!empty($i))
				{
				$this->db->insert_batch('units', $i)
					? $this->page->success('New unit types have been copied across from StorMan.')
					: $this->page->error('Sorry but there was an error inserting the new unit types.');	
				}
			}
		}
	
	if(!isset($this->page->response['success']) && !isset($this->page->response['error']))
		{
		$this->page->success('No unit data to update.');
		}
	
	if($this->inline!='1')
		{
		$this->page->respond();
		}
	}

//////////////////////////////////////////////////////////////////
// Record ID
public function id()
	{
	$this->value 	= $this->uri->segment(3) 
					? $this->uri->segment(3) 
					: '';
	
	$this->value 	= !empty($this->page->postdata) && isset($this->page->postdata[$this->index])
					? $this->page->postdata[$this->index]
					: $this->value;
	}
	
//////////////////////////////////////////////////////////////////
// Company Loader
public function get()
	{
	$this->id();
	
	if($this->uri->segment(3))
		{
		$this->page->record = $this->db	->select('units.*, facilities.facilityname, companies.companyname')
										->where($this->index, $this->value)
										->join('facilities', 'facilities.fcid = units.fcid', 'left')
										->join('companies', 'companies.coid = facilities.coid', 'left')
										->get($this->table)->row_array();
			
		if(isset($this->page->record['companyname']) && $this->page->record['companyname']!='')
			{
			$this->page->record['facilityname'] .= ' - '.$this->page->record['companyname']; 	
			}
		}
	
	$this->page	->view('unit/edit');
	}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// AJAX Functions

//////////////////////////////////////////////////////////////////
// Save Unit
public function save()
	{
	$this->id();
	
	$this->page	->required('fcid', 		'You must assign the unit to a facility.')
				->required('unitcode', 	'You must enter the unit code.')
				->required('unitwidth', 'You must enter the unit width.')
				->required('unitdepth', 'You must enter the unit depth.')
				->required('unitrate', 	'You must enter the unit rate.')
				;
	
	$this->page->validate();
	
	$this->secure->record(true);
	
	if(!isset($this->page->response['error']))
		{
		unset($this->page->postdata['filetitle'], $this->page->postdata['unitphototitle'], $this->page->postdata['facilityname']);
		
		
		if($this->value!='')
			{
			$this->db->update($this->table, $this->page->postdata, array($this->index => $this->value))
				? $this->page->success('The unit has been updated.')
				: $this->page->error('There was an error updating the unit.'.$this->db->last_query());
			}
		else
			{
			$this->db->insert($this->table, $this->page->postdata)
				? $this->page->success('The unit has been created.', $this->db->insert_id())
				: $this->page->error('There was an error adding the unit.');
			}
		}
			
	$this->page->respond();
	}


//////////////////////////////////////////////////////////////////
// Upload Unit Photo
public function photo()
	{
	$this->id();
	
	$this->page	->required('unid', 'The ID for the unit is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		$this->inline = '1';
		
		$this->get();
		
		$this->load->model('uploader');
		
		$this->uploader->folder('units')->allowed(array('jpg', 'png'))->field('unitphoto')->upload();
	
		if(!isset($this->page->response['error']))
			{
			$this->fileinfo = $this->uploader->fileinfo;
			
			$this->filename = $this->fileinfo['file_name'];
			
			if($this->db->update('units', array('unitimage' => $this->filename), array('unid' => $this->page->record['unid'])))
				{
				if($this->page->record['unitimage']!='' && file_exists($this->uploader->path.$this->page->record['unitimage']))
					{
					unlink($this->uploader->path.$this->page->record['unitimage']);	
					}
				
				
				$this->page	->success('The unit photo has been uploaded.')
							->response(
								array(
									'file' => $this->filename, 
									'path' => '/_med/units/'.$this->filename
									)
								);
					
				}
			else
				{
				unlink($this->uploader->path.$this->filename);	
				}
			}
		}
	
	$this->page->respond();	
	}



public function removeimg()
	{
	$this->id();
	
	$this->get();
	
	$this->page	->required('unid', 'The ID for the unit is missing.');
	
	$this->page->validate();
	
	if(!isset($this->page->response['error']))
		{
		if(empty($this->page->record))
			{
			$this->page->error('Sorry but the unit could not be found.');	
			}
		else
			{
			if($this->page->record['unitimage']!='' && file_exists($_SERVER['DOCUMENT_ROOT'].'/_med/units/'.$d.$this->page->record['unitimage']))
				{
				if(unlink($_SERVER['DOCUMENT_ROOT'].'/_med/units/'.$d.$this->page->record['unitimage']))
					{
					$this->db->update('units', array('unitimage' => ''), array('unid' => $this->page->record['unid']))
						? $this->page->success('The unit image has been removed.')
						: $this->page->error('The image was removed however the DB was not updated.');	
					}
				else
					{
					$this->page->error('There was an error removing the file.');	
					}
				}
			else
				{
				$this->page->error('The unit with that ID has no image.');	
				}
			}
		}
		
	
	$this->page->respond();	
	}



}