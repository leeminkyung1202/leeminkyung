<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends MY_Model {
	
	public function __contruct()
	{
		parent::__construct();
	}
	
	/**
	 * 리스트 개수
	 */
	public function listCnt($table, $searchGet = '')
	{
		$where = "";
		if(!empty($searchGet['keyWord'])) {
			$where .= " AND ".$table.".`".$searchGet['seatchTitle']."` LIKE '%".$searchGet['keyWord']."%' ";
		}
		
		$sql = " SELECT COUNT(*) AS cnt FROM ".$table." WHERE 1=1 ".$where." ";
		
		$data = $this->db->query($sql)->row();
		return $data->cnt;
	}

	/**
	 *	조회수
	 **/
	public function hits($idx, $data, $table)
	{
		$data['hits'] += 1;  	// 조회 수
		
		$this->db->where('idx', $idx);
		$this->db->update($table, $data);
	}

	/**
	 *	좋아요/싫어요
	 **/
	public function mode($idx, $data, $table, $divide)
	{
		$data[$divide] += 1;

		$this->db->where('idx', $idx);
		$this->db->update($table, $data);

		// 업데이트 후 SELECT
		$sql = " SELECT `".$divide."` FROM ".$table." WHERE ".$table.".idx = ".$idx." ";
		return $this->db->query($sql)->result_array();
		
	}

	/**
	 *	삭제
	 **/
	public function delete($idx, $table)
	{
		$this->db->delete($table, array('idx' => $idx));
	}
    
    /**
     * 게시판 작성
     */
	public function boardWrite($dataViews)
	{
		$this->db->insert('`erp`.`t_basicTable`', $dataViews);
		$inserId = $this->db->insert_id(); 					// 방금 insert 된 레코드의 ID 반환
		
		return $inserId;
	}

	/**
     * 게시판 수정
     */
	public function boardSave($idxVal, $data)
	{
		$this->db->where('idx', $idxVal);
		$this->db->update('`erp`.`t_basicTable`', $data);
	}
	
	/**
	 *	게시판 list
	 **/
	public function boardList($paginNum, $searchGet)
	{
		// 검색
		$where = "";
		if(!empty($searchGet['keyWord'])) {
			$where .= " AND t_basicTable.`".$searchGet['seatchTitle']."` LIKE '%".$searchGet['keyWord']."%' ";
		}
		
		// limit 문
		if(!empty($paginNum['limit'])) {
			$limit['limit'] = " LIMIT ".$paginNum['limit']['ofstart'].",".$paginNum['limit']['ofend'];
		}

		$sql = " SELECT * FROM `erp`.`t_basicTable` WHERE 1=1 ".$where." ORDER BY `idx` DESC ".$limit['limit']." ";
		return $this->db->query($sql)->result_array();
	}
	
	/**
	 *	게시판 View
	 **/
	public function boardView($idx, $table)
	{
		$sql = " SELECT * FROM ".$table." WHERE ".$table.".idx = ".$idx." ";
		return $this->db->query($sql)->result_array();
	}

	/**
     * 게시판 댓글 작성
     */
	public function commentWrite($dataViews)
	{
		$this->db->insert('`erp`.`t_basicTableConment`', $dataViews);
		$inserId = $this->db->insert_id(); 					// 방금 insert 된 레코드의 ID 반환
		
		return $inserId;
	}
    	
	/**
	 *	게시판 댓글 View
	 **/
	public function commentView($idx)
	{
		$sql = " SELECT * FROM `erp`.`t_basicTableConment` WHERE t_basicTableConment.pageNo = '".$idx."' ORDER BY `originNo` DESC, `groupOrd` ASC ";
		return $this->db->query($sql)->result_array();
	}

	/**
     * 게시판 댓글 수정
     */
	public function commentSave($idxVal, $data)
	{
		$this->db->where('idx', $idxVal);
		$this->db->update('`erp`.`t_basicTableConment`', $data);
	}

	/**
     * 게시판 댓글에 댓글 작성
     */
	public function commentAdd($dataViews, $commentNum)
	{
		// 댓글에 댓글 순서 정렬을 위해서 update
		$sql = " UPDATE t_basicTableConment SET groupOrd = groupOrd + 1 WHERE pageNo = ".$dataViews['pageNo']." AND  originNo = ".$dataViews['originNo']." AND  groupOrd > ".$commentNum." ";
		$this->db->query($sql);
		
		// 댓글 insert
		$this->db->insert('`erp`.`t_basicTableConment`', $dataViews);
	}

	/**
	 *	게시판 댓글에 댓글 View
	 **/
	public function commentViewNum($idx)
	{
		$sql = " SELECT `groupOrd`, `content`, `groupLayer` FROM `erp`.`t_basicTableConment` WHERE t_basicTableConment.idx = '".$idx."' ";
		return $this->db->query($sql)->result_array();
	}

}