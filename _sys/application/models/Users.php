<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model {
	
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// User Variables

var $table			= 'users';
var $index			= 'usid';
var $value			= '';
var $base			= 'admin/users';
var $link			= 'admin/user';


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Search Settings

var $select			= 'users.*';
var $joins			= array();
var $alias			= '';
var $fixedfilters	= array();

var $filterby		= 'useradmin';
var $filterlbl		= 'Is Admin';
var $filters		= array('1' => 'Yes, Active', '2' => 'No, Inactive');

var $orderby		= 'username';
var $ordering		= 'asc';

var $options		= array('username' => 'User Name', 'useremail' => 'User Email');


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Controller Functions

public function init()
	{
	
	
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
	$this->search->no_results = 'Sorry but no users match your search. Please try searching again or search by a different field.';
	$this->search->no_records = 'No users have been setup in the system yet.';
	
	$this->search	->column('useractive', 'Active', '1', 'switcher')
					->column('username', 'User Name', '4', 'text', 'N/A')
					->column('useremail', 'User Email', '6', 'text', 'N/A')
					->column('useradmin', 'Admin', '1', 'switcher')
					;
	
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
		$this->page->record = $this->db	->where($this->index, $this->value)
										->get($this->table)->row_array();
		}
	
	$this->page	->view('users/edit');
	}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// AJAX Functions

//////////////////////////////////////////////////////////////////
// Save Unit
public function save()
	{
	$this->id();
	
	$this->page	->required('username', 	'You must enter the name for the user.')
				->required('useremail', 'You must enter the email address for the user.')
				;
	
	$this->page->validate();
	
	if(isset($this->page->postdata['pass']) && isset($this->page->postdata['pasc']) && $this->page->postdata['pass']!=$this->page->postdata['pasc'])
		{
		$this->page->error('The password fields do not match. Try setting them again.');	
		}
	
	if(!isset($this->page->response['error']))
		{
		if($this->value!='')
			{
			$this->db->update($this->table, $this->page->postdata, array($this->index => $this->value))
				? $this->page->success('The user has been updated.')
				: $this->page->error('There was an error updating the user.');
			}
		else
			{
			
			if($this->db->insert($this->table, $this->page->postdata))
				{
				$this->page->success('The unit has been created.', $this->db->insert_id());
				}
			else
				{
				$this->page->error('There was an error adding the unit.');
				} 
			}
		}
			
	$this->page->respond();
	}




}