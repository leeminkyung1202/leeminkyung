<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 *	Admin 정보확인 
	 **/
	public function _adminMember($data)
	{
		$sql = " 
				SELECT 
					`name`, `id`, `pw` 
				FROM 
					`erp`.`admin` 
				WHERE 
					id = '".$data['id']."'  AND  pw = '".$data['pw']."' 
				";
				
		return $this->db->query($sql)->result_array();
	}
	
}