<?php
class Auths extends MY_Model {

	public function __construct()
	{
        parent::__construct();
	}
	
	/**
	 *	Admin 정보확인 
	 **/
	public function admin($data)
	{
		return $this->_adminMember($data); 		// MY_Model 가져옴
	}
	
	/**
	 *	Admin 레벨, 고유번호 정보확인
	 **/
	public function adminLevel($data)
	{
		$sql = " SELECT `level`, `no` FROM `erp`.`admin` WHERE `id` = '".$data."' ";
		return $this->db->query($sql)->result_array();
	}
		
	/**
	 *  아이디 중복체크
	 */
	public function idOverlap($data)
	{
		$sql = " SELECT `id` FROM `erp`.`admin` WHERE `id` = '".$data."' ";
		return $this->db->query($sql)->result_array();
	}

	/** 
	 *  회원가입 :: 정보 입력
	 */
	public function register($data)
	{
		$this->db->insert('`erp`.`admin`', $data);
		$result = $this->db->insert_id();
		return $result;
	}
    
}
?>