<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_head();
		$this->load->database();
	}

	public function index()
	{
		echo "인덱스 사용 안함.";
	}

	/**
	 * 네이버 지도
	 */
	public function mapNaver()
	{
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/map/mapNaver');
		$this->_footer(); 			// MY_Controller 하단
	}

	/**
	 * 다음 지도
	 */
	public function mapDaum()
	{
        $this->_top(); 				// MY_Controller 상단
		$this->load->view('/map/mapDaum');
		$this->_footer(); 			// MY_Controller 하단
	}

}
