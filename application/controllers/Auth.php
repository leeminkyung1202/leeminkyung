<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Auth extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_head();
		$this->load->model("Auths");
	}

	public function index()
	{
		echo "사용 안함";
	}
		
	/*
	 *  로그인
	 * */
	public function login()
	{
		if( !empty($this->input->post()) ){	// post값이 있으면
			
			// 비밀번호 암호화
			$password = $this->input->post("passWord");
			$passwordHash = hash("sha256", $password);
				
			$data = array(
							"id" => $this->input->post("userId"),
							"pw" => $passwordHash
			);
			
			// level 가져오기
			$level = $this->Auths->adminLevel($data['id']);
			
			// 입력된 아이디와 비밀번호 일치할 경우
			$result = $this->Auths->admin($data);
			
			// level이 10이면 관리자 승인 필요, 아니면 로그인
			if( $level[0]['level'] == 10 ){
				$this->session->set_flashdata("alert", "관리자 승인이 필요합니다.");
				redirect("/auth/login");

			} else if( !empty($result) ){
				$newData = array(
									"logged_in" 	=> TRUE,
									"name" 			=> $result[0]["name"],
									"id"			=> $result[0]["id"]
				);
								
				$this->session->set_userdata($newData);		// 세션 데이터 추가
				redirect("/mains");
								
			} else {
				$this->session->set_flashdata("alert", "일치하는 정보가 없습니다.");
				redirect("/auth/login");
			}
		}
		
		$this->load->view("/auth/login"); 	// 로그인 페이지 로드
	}
	
	/*
	 *  로그아웃
	 * */
	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/auth/login");
	}
	
	/*
	 *  회원가입
	 * */
	public function register()
	{
		// 아이디 중복체크
		$idVal = $this->input->post('idVal');
		if( !empty($idVal) ){
			$idOverlap = $this->Auths->idOverlap($idVal);

			if( !empty($idOverlap) ){
				$returnData = "이미 사용중인 아이디 입니다.";
			} else {
				$returnData = "";
			}
			echo json_encode($returnData);
			exit;
		}
		
		// form validation
        $this->form_validation->set_rules("userName", "이름을", "required"); 
		$this->form_validation->set_rules("userId", "아이디를", "required");
        $this->form_validation->set_rules("passWord", "비밀번호를", "required|matches[passConf]");
        $this->form_validation->set_rules("passConf", "비밀번호 확인을", "required");

		if( $this->form_validation->run() == FALSE ){ // 입력을 다시 해야할 경우
			$this->load->view("/auth/register"); 	// 회원가입 페이지
		} else {
			
			if( !empty($this->input->post()) ){

				// 비밀번호 암호화
				$password = $this->input->post("passWord");
				$passwordHash = hash("sha256", $password);
				
				$data = array(
								"id" 	=> $this->input->post("userId"),
								"pw" 	=> $passwordHash,
								"name" 	=> $this->input->post("userName"),
								"data" 	=> nows()
				);
				$result = $this->Auths->register($data); 	// 디비 insert
				
				if( !empty($result) ){
					$this->session->set_flashdata("alert", "회원가입을 환영합니다. 관리자 승인이 필요합니다.");
					$this->load->view("/auth/login");
				} else {
					$this->session->set_flashdata("alert", "회원가입이 실패하였습니다.");
					$this->load->view("/auth/register");
				}
			}
		}
		
	}


	/**
	 * 네이버 아이디 로그인
	 */
	public function loginNaver()
	{
		$state = $this->generate_state(); 	// 상태 토큰으로 사용할 랜덤 문자열을 생성

		// 네이버 로그인 콜백 예제
		$client_id = "kc3yOAuhOcaTqg4NKWU3";
		$client_secret = "41l2J3pojF";
		$code = $this->input->get("code");
		//$state = $this->input->get("state");
		$redirectURI = urlencode("http://198.13.57.19");
		$url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
		
		// 토큰 값 가져오기, 가져와서 다시 네이버로 던져야함! 그럼 네이버가 회원 정보를 줌
		$is_post = false;
		$ch = curl_init(); 	// curl_init : 세션 초기화
		curl_setopt($ch, CURLOPT_URL, $url); 	// curl_setopt : curl에 대한 옵션 설정
		curl_setopt($ch, CURLOPT_POST, $is_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array();
		$response = curl_exec ($ch); 	// curl_exec : curl에 대한 세션 실행
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 	// curl_getinfo : curl에 대한 정보 얻기
		//echo "status_code:".$status_code."";
		curl_close ($ch); 	// curl_close : curl 세션 닫기

        // 토큰 값 가져오기 성공/실패 결과 출력(access_token : 발급받은 토큰, refresh_token : 갱신 토큰, token_type : 토큰 타입, expires_in : 토큰의 유효 기간/초단위)
		if($status_code == 200) 
		{
			$result = json_decode($response, TRUE); 	// 토큰 가져와서 배열로 던져주기
			
			// 회원 프로필 가져오기
			$token = $result['access_token'];
			$header = "Bearer ".$token; // Bearer 다음에 공백 추가
			$url = "https://openapi.naver.com/v1/nid/me";
			$is_post = false;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = array();
			$headers[] = "Authorization: ".$header;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//echo "status_code:".$status_code."<br>";
			curl_close ($ch);

			if($status_code == 200) {
				$profile = json_decode($response, TRUE); 		// 프로필 정보
				$idVal = $profile['response']['email']; 		// 아이디
				$idOverlap = $this->Auths->idOverlap($idVal); 	// DB에 아이디 여부 확인

				// DB에 아이디가 있으면 로그인, 그게 아니면 회원가입
				if( !empty($idOverlap) )
				{
					// level 가져오기
					$level = $this->Auths->adminLevel($idVal);

					// level이 10이면 관리자 승인 필요, 아니면 로그인
					if( $level[0]['level'] == 10 ){
						$this->session->set_flashdata("alert", "관리자 승인이 필요합니다.");
						redirect("/auth/login");

					} else if( !empty($result) ){
						$newData = array(
											"logged_in" 	=> TRUE,
											"name" 			=> $profile['response']['name'],
											"id"			=> $profile['response']['email']
						);
										
						$this->session->set_userdata($newData);		// 세션 데이터 추가
						redirect("/mains");
										
					}
				}
				else {
					// 회원가입
					$data = array(
									"id" 	=> $profile['response']['email'],
									"pw" 	=> 'naver',
									"name" 	=> $profile['response']['name'],
									"data" 	=> nows()
					);
					$result = $this->Auths->register($data); 	// 디비 insert
					
					if( !empty($result) ){
						$this->session->set_flashdata("alert", "회원가입을 환영합니다. 관리자 승인이 필요합니다.");
						$this->load->view("/auth/login");
					} else {
						$this->session->set_flashdata("alert", "회원가입이 실패하였습니다.");
						$this->load->view("/auth/login");
					}
				}
			} else {
				echo "프로필 Error 내용:".$response;
			}

		} else {
			echo "토큰 Error 내용:".$response;
        }

	}


	/**
	 * 카카오 아이디 로그인
	 */
	public function loginKakao()
	{
        $idVal = $this->input->post('id');
        $idOverlap = $this->Auths->idOverlap($idVal); 	// DB에 아이디 여부 확인
		
        // DB에 아이디가 있으면 로그인, 그게 아니면 회원가입
        if( !empty($idOverlap) )
        {
            // level 가져오기
            $level = $this->Auths->adminLevel($idVal);

            // level이 10이면 관리자 승인 필요, 아니면 로그인
            if( $level[0]['level'] == 10 ){
				$returnData = array( "text" => "관리자 승인이 필요합니다." );
				
            } else {
                $newData = array(
                                    "logged_in" 	=> TRUE,
                                    "name" 			=> $this->input->post('name'),
                                    "id"			=> $idVal
                );
                                
                $this->session->set_userdata($newData);		// 세션 데이터 추가
				$returnData = array( "url" => "/mains" );
            }
        }
        else {
            // 회원가입
            $data = array(
                            "id" 	=> $idVal,
                            "pw" 	=> 'kakao',
                            "name" 	=> $this->input->post('name'),
                            "data" 	=> nows()
            );
            $result = $this->Auths->register($data); 	// 디비 insert
            
            if( !empty($result) ){
				$returnData = array( "text" => "회원가입을 환영합니다. 관리자 승인이 필요합니다." );
				
            } else {
				$returnData = array( "text" => "회원가입을 실패하였습니다." );
            }
		}
		echo json_encode($returnData);
		exit;
    }


	/**
	 * 페이스북 아이디 로그인
	 */
	public function loginFacebook()
	{
        $idVal = $this->input->post('id');
        $idOverlap = $this->Auths->idOverlap($idVal); 	// DB에 아이디 여부 확인

        // DB에 아이디가 있으면 로그인, 그게 아니면 회원가입
        if( !empty($idOverlap) )
        {
            // level 가져오기
            $level = $this->Auths->adminLevel($idVal);

            // level이 10이면 관리자 승인 필요, 아니면 로그인
            if( $level[0]['level'] == 10 ){
                $returnData = array( "text" => "관리자 승인이 필요합니다." );

            } else {
                $newData = array(
                    "logged_in" 	=> TRUE,
                    "name" 			=> $this->input->post('name'),
                    "id"			=> $idVal
                );

                $this->session->set_userdata($newData);		// 세션 데이터 추가
                $returnData = array( "url" => "/mains" );
            }
        }
        else {
            // 회원가입
            $data = array(
                "id" 	=> $idVal,
                "pw" 	=> 'facebook',
                "name" 	=> $this->input->post('name'),
                "data" 	=> nows()
            );
            $result = $this->Auths->register($data); 	// 디비 insert

            if( !empty($result) ){
                $returnData = array( "text" => "회원가입을 환영합니다. 관리자 승인이 필요합니다." );

            } else {
                $returnData = array( "text" => "회원가입을 실패하였습니다." );
            }
        }
        echo json_encode($returnData);
        exit;
    }
	 
}



