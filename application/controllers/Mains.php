<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mains extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_head();
		$this->load->database();
	}

	public function index()
	{
		$this->_top(); 				// MY_Controller 상단
		$this->load->view('main');
		$this->_footer(); 			// MY_Controller 하단
	}
}
