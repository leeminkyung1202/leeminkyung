<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editors extends MY_Model {
	
	public function __contruct()
	{
		parent::__construct();
	}
	
	/**
     * 에디터 작성
     */
	public function editor($dataViews)
	{
		$this->db->insert('`erp`.`t_editor`', $dataViews);
	}
	
	/**
     * 에디터 목록
     */
	public function editorList()
	{
        $sql = " SELECT * FROM `erp`.`t_editor` ORDER BY `idx` DESC ";
		return $this->db->query($sql)->result_array();
	}

}