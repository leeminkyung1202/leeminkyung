<?php if( ! defined('BASEPATH')) exit('No direct script access allowd');

/*
 *  nows() :: data 함수와 같음. $stamp은 포맷 변경
 *  function_exists('a') -> a라는 함수가 있는지 없는지 확인 할 수 있는 함수
 * */
if( !function_exists('nows') ) {
	function nows($stamp = '') {
		if(empty($stamp)) {
			$stamp = 'Y-m-d H:i:s';
		}
		return date($stamp);
	}
}

/*
 *  출력을 보기 편하게 해줌
 * */
if( !function_exists('debugs') ) {
	function debugs($variable, $type = 'echo', $advance = true, $backtrace = null) {
		if(empty($backtrace)) {
			$backtrace = debug_backtrace();
		}
		$message  = "== ".nows()." ========================\n";
		$message .= "Debug in <strong>".$backtrace[0]['file']."</strong>, line <strong>".$backtrace[0]['line']."</strong>\n";
		$message .= "--------------------------------------------\n";
		
		if($advance === TRUE)
		{
			ob_start(); 						// 출력 버퍼링 활성화 :: 스크립트의 모든 출력을 내부 버퍼에 저장 후 실제로 전송하지 않음.
			print_r($variable);
			$debugging = ob_get_contents(); 	// 출력 버퍼의 내용을 반환 :: 출력버퍼가 없을 경우 FALSE를 반환
			ob_end_clean(); 					// 출력 버퍼를 지우고 출력 버퍼링을 종료
		}
		else
		{
			$debugging = var_export($variable, true); 	// var_export :: var_dump와 동일
		}
		
		if( !empty($debugging) && $debugging != 'NULL' ) {
			$message .= $debugging;
		} else {
			$message .= sprintf($variable);
		}
		$message .= "\n";
		$message .= "============================================\n";
		
		switch($type) {
			case 'devel':
			case 'echo':
				echo "<pre>";
				echo $message;
				echo "</pre>";
				break;
			case 'exit':
				echo "<pre>";
				echo $message;
				echo "</pre>";
				exit(0);
				break;
			case 'log':
				break;
		}
	}
}
