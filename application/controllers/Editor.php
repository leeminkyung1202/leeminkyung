<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editor extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_head();
		$this->load->database();
		$this->load->model('Editors');			// 게시판 관리 model
	}

	public function index()
	{
		echo "인덱스 사용 안함.";
	}

	/**
	 * 에디터 목록
	 */
	public function editor()
	{
        // 리스트 가져오기
		$list = $this->Editors->editorList();
        
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/editor/editor', array('list' => $list));
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 에디터
	 */
	public function editorSubmit()
	{
        if( !empty($this->input->post()) ){
			$data = array(
				'editor' 	=> $this->input->post('editor'),
				'content' 	=> $this->input->post('content'),		
				'regdate' 	=> nows()
			);

			$this->Editors->editor($data);
			redirect("/editor/editor");
		}
	}

	/**
	 * 다음 에디터
	 */
	public function editorDaum()
	{
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/editor/editorDaum');
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 네이버 에디터
	 */
	public function editorNaver()
	{
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/editor/editorNaver');
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * CK 에디터
	 */
	public function editorCk()
	{
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/editor/editorCk');
		$this->_footer(); 			// MY_Controller 하단
	}

}
