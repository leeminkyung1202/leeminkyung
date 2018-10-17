<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$urlAdd = $this->uri->segment(2);                           // 2번째 url 주소를 가져옴.(내가 가져오고 싶은건 'login' 로그인 페이지)
				
		if( $urlAdd != 'login' && $urlAdd != 'loginNaver' && $urlAdd != 'loginKakao' && $urlAdd != 'loginFacebook' && $urlAdd != 'register' ){          // 'login' 페이지가 아니면
			if( $this->session->userdata('logged_in') == FALSE ){   // 로그인이 안되어 있으면				
				$this->session->set_flashdata('alert', '로그인 후 이용하세요.');
				redirect('/auth/login');
			}
		}
	}
	
	/*
	 *  Layout : 상단 head 부분
	 * */
	function _head()
	{
		$this->load->view('/layout/head');
	}
	
	/*
	 *  Layout : 상단 Top
	 * */
	function _top()
	{
		$this->load->view('/layout/top');
	}
	
	/*
	 *  Layout : 하단
	 * */
	function _footer()
	{
		$this->load->view('/layout/footer');
	}

		/**
	 *	리스트 검색 링크
	 **/
	function _paginList($searchGet = '', $page)
	{
		$paginAnd = '';
		
		if (!empty($searchGet)) {
			foreach($searchGet as $key => $value) {
				$paginAnd .= '&'.$key.'='.$value;
			}
		}
		return '?page='.$page.$paginAnd;
	}
	
	/**
	 *	View 목록, 삭제 링크
	 **/
	function _paginView($data = '')
	{
		$reData = "";
		$ands	= "";
		$page	= "";
		foreach( $data as $key => $val)
		{
			if(!empty($reData)) {
				$ands = '&';
			}
			
			if($key == 'page') {
				$page = $val."?";
			} else {
				$reData .= $ands.$key."=".$val;
			}
		
		}
		return $page.$reData;
	}
			
	/**
	 *	수정 검색 링크
	 **/
	function _paginClearNO($searchGet = '')
	{
		$paginAnd = "";
		
		if(!empty($searchGet)) {			
			$paginAnd = $_SERVER['REDIRECT_QUERY_STRING'];
		}
		
		return '?'.$paginAnd;
    }
    
    /**
     * 네이버 로그인 토큰 발급
     */
    function generate_state()
    {
        $mt = microtime();  // 현재의 Unix 타임 스탬프를 마이크로 초로 반환
        $rand = mt_rand();  // 무작위 값 생성
        
        return md5($mt . $rand);
    }
}
	
	





