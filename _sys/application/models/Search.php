<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Model {

var $template		= array('search/listing');
var $pageuri		= 4;
var $data	 		= '';
var $sess			= array();

// Search Core
var $table	 		= '';
var $index	 		= '';
var $portal			= '';
var $base 			= '';
var $link 			= '';
var $user			= array();
var $sessname 		= '';
var $process 		= '';

// Search Field and Columns
var $lookfor 		= '';
var $lookin 		= '';
var $searched		= '1';
var $searchopts 	= array();


// Select and Joins
var $select	 		= '';
var $selectraw 		= '';

var $joins 			= array();
var $alias			= '';


// Filter
var $filter 		= '';
var $filterby 		= '';
var $filterlbl 		= '';
var $filters 		= array();
var $fixedfilters 	= array();

// Ordering
var $orderby	 	= '';
var $ordering	 	= '';

// Limits
var $limits			= array(5, 10, 15, 25, 50);
var $limit			= '10';
var $pagenum		= '0';
var $offset			= '0';

// Empty Lists
var $no_results 	= 'Sorry but no results could be found matching your search. Try another search.';
var $no_records 	= 'The table does not contain any records yet.';

// List and Result
var $query			= '';
var $options		= array();
var $columns		= array();
var $result			= array();
var $total			= '';
var $paging			= array();



public function __construct()
	{
	parent::__construct();
	
	$this->page->js('search.inc.js');
	}

public function run()
	{
	$this->orderby = isset($this->page->postdata['orderby']) ? $this->page->postdata['orderby'] : $this->orderby;
	$this->ordering = isset($this->page->postdata['ordering']) ? $this->page->postdata['ordering'] : $this->ordering;
	
	// Check for postdata
	$this->data = $this->input->post();
	
	$this->sess = $this->session->userdata('smp_search'.$this->sessname);
	
	// If postdata is set then define and store in the session
	if(!empty($this->data))
		{
		foreach($this->data as $f => $v)
			{
			$this->$f = $v;	
			}
		
		$this->session->set_userdata('smp_search'.$this->sessname, $this->data);
		}
	// If no postdata, check for a session
	elseif(!empty($this->sess))
		{
		foreach($this->sess as $f => $v)
			{
			$this->$f = $v;	
			}	
		}
	
	// Otherwise it will use the defaults
	
	// Now define the offset
	$this->pagenum 	= $this->uri->segment($this->pageuri, 1);
	$this->offset 	= $this->pagenum > 1 ? ($this->pagenum - 1) * $this->limit : 0;
	
	//echo '<pre>';die(print_r($this->data).print_r('Num:'.$this->pagenum.'<br />').print_r('Lim:'.$this->limit.'<br />').print_r('Off:'.$this->offset.'<br />'));
	
	// Start the query cache
	$this->db->start_cache();
	
	// Build the Query
	if($this->select!='')
		{
		$this->db->select($this->select);	
		}
	
	if(!empty($this->joins))
		{
		foreach($this->joins as $tbl => $join)
			{
			if(is_array($join))
				{
				$par = $this->alias!='' ? $this->alias : $tbl;
				
				if(isset($join[2]))
					{
					$this->db->join($par, $tbl.'.'.$join[0].' = '.$join[2].'.'.$join[1], 'left');	
					}
				else
					{
					$this->db->join($par, $tbl.'.'.$join[0].' = '.$this->table.'.'.$join[1], 'left');	
					}
				}
			else
				{
				$par = $this->alias!='' ? $this->alias : $tbl;
				
				$this->db->join($par, $tbl.'.'.$join.' = '.$this->table.'.'.$join, 'left');	
				}
			}
		}
	
	
	if($this->lookfor!='')
		{
		$this->db->like($this->lookin, $this->lookfor);	
		$this->searched = '2';
		}
	
	if($this->filter!='')
		{
		$this->db->where($this->filterby, $this->filter);	
		}
	
	if(!empty($this->fixedfilters))
		{
		$this->db->where($this->fixedfilters);	
		}
	
	// Stop the cache
	$this->db->stop_cache();
	
	// Run the count query first
	$this->total = $this->db->get($this->table)->num_rows();
	
	// Add the limit and offset
	if($this->offset > 0)
		{
		$this->db->limit($this->limit, $this->offset);	
		}
	else
		{
		$this->db->limit($this->limit);	
		}
	
	$this->db->order_by($this->orderby, $this->ordering);
	
	// Now run the final query
	$this->result = $this->db->get($this->table)->result_array();
	
	// Set the Paging
	$this->load->library('pagination');
	
	$this->paging['base_url'] 			= '/'.$this->base.'/page/';
    $this->paging['total_rows'] 		= $this->total;
    $this->paging['per_page'] 			= $this->limit;
	$this->paging['uri_segment'] 		= $this->pageuri;
	$this->paging['use_page_numbers'] 	= TRUE;
	$this->paging['page_query_string'] 	= FALSE;
	
	$this->pagination->initialize($this->paging);
	
	$this->base = $this->base;	
	}

public function column($field, $label, $width, $type, $empty=NULL, $options=array())
	{
	$this->columns[$field] = array('label' => $label, 'width' => $width, 'type' => $type, 'empty' => $empty);
	
	if(!empty($options))
		{
		foreach($options as $f => $v)
			{
			$this->columns[$field][$f] = $v;	
			}
		}
	
	return $this;
	}


}