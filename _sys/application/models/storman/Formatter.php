<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Formatter extends Storman {


public function __construct()
	{
	parent::__construct();
	}



public function unittypes()
	{
	if(!empty($this->api->result) && isset($this->api->result['WS_UTRUnitType']))
		{
		foreach($this->api->result['WS_UTRUnitType'] as $k => $t)
			{
			if($this->api->result['WS_UTNoVacant'][$k] > 0)
				{
				$this->storman->unittypes[] = array('unittype' 	=> $this->api->result['WS_UTRUnitType'][$k],
													'category' 	=> $this->api->result['WS_UTUnitCategory'][$k],
													'sizecat' 	=> $this->api->result['WS_UTSizeCategory'][$k],
													'desc' 		=> $this->api->result['WS_UTDescription'][$k],
													'width' 	=> $this->api->result['WS_UTUnitTypeWidth'][$k],
													'length' 	=> $this->api->result['WS_UTUnitTypeLength'][$k],
													'depth' 	=> $this->api->result['WS_UTMonthlyRate'][$k],
													'area' 		=> $this->api->result['WS_UTArea'][$k].'sqm',
													'total'		=> $this->api->result['WS_UTNoTotal'][$k],
													'vacant'	=> $this->api->result['WS_UTNoVacant'][$k],
													'monthly'	=> $this->api->result['WS_UTMonthlyRate'][$k],
													'bcode'		=> $this->api->result['WS_UTBillPlanCode'][$k]
													);
				}
			}
		}
	}



}

