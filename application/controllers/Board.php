<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_head();
		$this->load->database();
		$this->load->library('pagination');		// 라이브러리 연결
		$this->load->model('Boards');			// 게시판 관리 model
	}

	public function index()
	{
		echo "인덱스 사용 안함.";
	}

	/**
	 * 게시판 리스트
	 */
	public function board()
	{
		$table = "t_basicTable"; 	// 테이블 명

		// 검색
		$searchGet = array(
			'seatchTitle'  	=> $this->input->get('seatchTitle'),
			'keyWord' 		=> $this->input->get('keyWord')
		);

		// 리스트 개수
		$totCnt = $this->Boards->listCnt($table, $searchGet);

		/*** 페이징 :: STR ***/
		$page = $this->uri->segment(3); 										// 3번째 파라미터를 가져온다.
		if(empty($page)){ $page = 1; } 											// $page가 없으면 1페이지 보여줌
		$config['base_url'] 			= site_url('/board/board'); 			// 페이지 네비에 포함될 전체 URL
		$config['total_rows'] 			= $totCnt; 								// 게시글 개수
		$config['per_page'] 			= 10; 									// 한 페이지에 보여줄 게시글 수
		$config['use_page_numbers'] 	= TRUE; 								// 미국은 페이징이 10단위임, 그거 ㄴㄴ
		$config['reuse_query_string'] 	= TRUE;									// 문자열 인수를 추가한다.
		$this->pagination->initialize($config); 								// config 설정 값들을 넘겨준다.
		
		$pagination = $this->pagination->create_links(); 		// 보여줄 페이징 없으면 빈 문자열 리턴
		/*** 페이징 :: END ***/

		$paginGet = $this->_paginList($this->input->get(), $page); 				// 파라미터 붙는거
	 	
	 	$paginNum['limit']['ofstart'] 	= ($page - 1) * $config['per_page']; 	// limit 시작 숫자, 한번만 선언하려고 배열에 담았음.
	 	$paginNum['limit']['ofend'] 	= $config['per_page']; 					// limit 끝 숫자
	 	
	 	$num = $totCnt - ( $page - 1 ) * $config['per_page']; 
		 
		// 리스트 가져오기
		$list = $this->Boards->boardList($paginNum, $searchGet);

		// 넘겨줄 데이터
		$dataView = array(
			'list' 			=> $list,
			'num' 			=> $num,
			'pagination' 	=> $pagination,
			'paginGet' 		=> $paginGet,
			'searchGet' 	=> $searchGet
		);

		$paginNum['page'] = $page;

		$this->_top(); 				// MY_Controller 상단
		$this->load->view('/board/board', array('dataView' => $dataView));
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 게시판 작성
	 */
	public function boardWrite($idx = '')
	{
		// 파라미터 붙는거
		$paginNo = $this->_paginClearNO($this->input->get());

		if( !empty($this->input->post()) ){
			$data = array(
				'title' 	=> $this->input->post('title'),
				'content' 	=> $this->input->post('content'),			
				'name' 		=> $this->session->userdata('name'),			
				'regdate' 	=> nows()
			);

			$inserId = $this->Boards->boardWrite($data);
			redirect("/board/boardView/".$inserId);
		}

		if(!empty($idx)) {
			$table = "t_basicTable"; 	// 테이블 명

			$list = $this->Boards->boardView($idx, $table);
		}

		// 넘겨줄 데이터
		$dataView = array(
			'list' 		=> @$list[0],
			'paginNo' 	=> $paginNo
		);

		$this->_top(); 				// MY_Controller 상단
		$this->load->view('/board/boardWrite', array('idx' => $idx, 'dataView' => $dataView));
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 게시판 수정
	 */
	public function boardSave($idx)
	{
		// 파라미터 붙는거
		$paginNo = $this->_paginClearNO($this->input->get());

		if( !empty($this->input->post()) ){
			$data = array(
				'title' 	=> $this->input->post('title'),
				'content' 	=> $this->input->post('content'),			
				'name' 		=> $this->session->userdata('name'),			
				'regdate' 	=> nows()
			);

			$this->Boards->boardSave($idx, $data);
			$this->session->set_flashdata('messages', '수정되었습니다.');
			redirect("/board/boardView/".$idx.$paginNo);
			exit;
		}

		// 넘겨줄 데이터
		$dataView = array(
			'list' 		=> $list[0],
			'paginNo' 	=> $paginNo
		);

		$this->_top(); 				// MY_Controller 상단
		$this->load->view('/board/boardWrite', array('idx' => $idx, 'dataView' => $dataView));
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 게시판 View
	 */
	public function boardView($idx)
	{
		$table = "t_basicTable"; 	// 테이블 명

		$list = $this->Boards->boardView($idx, $table); 			// 게시글 데이터
		$commentList = $this->Boards->commentView($idx); 	// 댓글 데이터
		

		// 조회수
		$data['hits'] = $list[0]['hits'];
		$this->Boards->hits($idx, $data, $table);
		
		$paginGet 	= $this->_paginView($this->input->get()); 		// 파라미터 붙는거
		$paginNo 	= $this->_paginClearNO($this->input->get()); 	// 파라미터 붙는거
		
		// 넘겨줄 데이터
		$dataView = array(
			'list' 			=> $list[0],
			'commentList' 	=> $commentList,
			'paginGet' 		=> $paginGet,
			'paginNo' 		=> $paginNo
		);
		
		$this->_top(); 				// MY_Controller 상단
		$this->load->view('/board/boardView', array('idx' => $idx, 'dataView' => $dataView));
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 게시판 삭제
	 */
	public function boardDelete()
	{
		$idx = $this->input->post('idx');
		$table = $this->input->post('table'); 	// 테이블 명
        
		$commentList = $this->Boards->commentViewNum($idx);	// 데이터 가져오기
		
		$returnData = "잘못된 접근입니다.";	

		if( $commentList[0]['groupOrd'] == 0 ){
			$returnData = "답글이 달린 글은 삭제 하실 수 없습니다.";
		} else if($idx) {
			$this->Boards->delete($idx, $table);
			$returnData = "삭제되었습니다.";
		}
	   
		echo json_encode($returnData);
		exit;
	}

	/**
	 * 게시판 좋아요/싫어요
	 */
	public function boardMood()
	{
		$table 	= $this->input->post('table'); 		// 테이블 명
		$idx 	= $this->input->post('idx'); 		// 고유값
		$divide = $this->input->post('divide'); 	// 좋아요/싫어요 구분 값
				
		$list = $this->Boards->boardView($idx, $table); 	// 기존 값 가져오기

		// 업데이트 후 값 가져오기
		$data[$divide] = $list[0][$divide];
		$num = $this->Boards->mode($idx, $data, $table, $divide);
		$modeNum = $num[0][$divide];

		// 값 넘기기
		$returnData = array('modeNum' => $modeNum, 'divide' => $divide, 'idx' => $idx);
		echo json_encode($returnData);
		exit;
	}

	/**
	 * 게시판 댓글 작성
	 */
	public function commentWrite()
	{
		// 댓글 작성 시 originNo 값(고유값) 주기위해서
		$pageNo = $this->input->post('idx');
		$commentList = $this->Boards->commentView($pageNo);
		
		// 페이지 최상단 고유값
		$commentIdx = $commentList[0]['idx'];
		
		if( !empty($this->input->post()) ){
			$data = array(
				'pageNo' 	=> $pageNo,			
				'originNo' 	=> $commentIdx+1,			
				'content' 	=> $this->input->post('content'),			
				'name' 		=> $this->session->userdata('name'),			
				'regdate' 	=> nows()
			);
			
			$this->Boards->commentWrite($data);

			$paginNo = $this->_paginClearNO($this->input->get()); 	// 파라미터 붙는거
			redirect("/board/boardView/".$data['pageNo'].$paginNo);
		}
	}

	/**
	 * 게시판 댓글 수정
	 */
	public function commentSave()
	{
		$idx = $this->input->post('idx');
		$data = array(
			'content' 	=> $this->input->post('content'),		
			'regdate' 	=> nows()
		);
		
		$returnData = "잘못된 접근입니다.";	
		if($idx) {
			$this->Boards->commentSave($idx, $data);
			$returnData = "수정되었습니다.";
		}
	   
		echo json_encode($returnData);
		exit;
	}

	/**
	 * 게시판 댓글에 댓글 작성
	 */
	public function commentAdd()
	{
		// 답글 작성 시 값 증가 위해서(본글제외)
		$pageNo 		= $this->input->post('idx');				// 고유값
		$commentList 	= $this->Boards->commentViewNum($pageNo);	// 데이터 가져오기
		$commentNum 	= $commentList[0]['groupOrd']; 				// 정렬 기준
		$commentLayer 	= $commentList[0]['groupLayer']; 			// 깊이 구분
		
		if( !empty($this->input->post()) ){
			$data = array(
				'pageNo' 		=> $this->input->post('pageNo'),		
				'originNo' 		=> $this->input->post('orgno'),		
				'groupOrd' 		=> $commentNum+1,		
				'groupLayer' 	=> $commentLayer+1,		
				'content' 		=> $this->input->post('content'),			
				'name' 			=> $this->session->userdata('name'),			
				'regdate' 		=> nows()
			);
			
			$returnData = "잘못된 접근입니다.";	
			if($data['pageNo']) {
				$this->Boards->commentAdd($data, $commentNum);
			}
		
			echo json_encode($returnData);
			exit;
		}
		
	}

}
