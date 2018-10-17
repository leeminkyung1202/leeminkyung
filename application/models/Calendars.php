<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendars extends MY_Model {
	
	public function __contruct()
	{
		parent::__construct();
	}

    /**
     * 캘린더 일정 등록
     */
    public function calendarWrite($dataViews)
    {
        $this->db->insert('`erp`.`calendar`', $dataViews);
        $inserId = $this->db->insert_id(); 					// 방금 insert 된 레코드의 ID 반환

        return $inserId;
    }

    /**
     * 캘린더 일정 가져오기
     */
    public function calendarList($meNumber)
    {
        $sql = " SELECT `dateReserve`,`content` FROM `erp`.`calendar` WHERE `memberCode` = ".$meNumber." ORDER BY `idx` DESC ";
        return $this->db->query($sql)->result_array();
    }

}