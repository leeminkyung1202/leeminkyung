<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_head();
        $this->load->database();
        $this->load->model('Calendars');			// 게시판 관리 model
    }

    public function index()
    {
        echo "인덱스 사용 안함.";
    }

    /**
     * 달력
     */
    public function reserve()
    {
        // 회원 번호 가져오기
        $idVal = $this->session->userdata('id');
        $this->load->model("Auths");
        $memberNum = $this->Auths->adminLevel($idVal);
        $meNumber = $memberNum[0]['no'];                // 로그인 된 회원번호

        // 등록
        if( !empty($this->input->post()) ) {
            $data = array(
                'memberCode'    => $meNumber,
                'content'       => $this->input->post('content'),
                'dateReserve'   => $this->input->post('reserve'),
                'regdate'       => nows()
            );

            $return = $this->Calendars->calendarWrite($data);
            if( !empty($return) ) {
                echo json_encode("등록되었습니다.");
                exit;
            }
            else {
                echo json_encode("잠시후 다시 시도해주세요.");
                exit;
            }
        }
        
        // 데이터 가져오기
        $list = $this->Calendars->calendarList($meNumber);

        $this->_top(); 				// MY_Controller 상단
        $this->load->view('/calendar/reserve', array('list' => $list));
        $this->_footer(); 			// MY_Controller 하단
    }

}
