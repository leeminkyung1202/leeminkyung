<!-----------------------------------------------------------------------------------------
* 작성자: MK.Lee
* 작성일시: 2018-07-12
* 사용법: 회원가입 페이지
------------------------------------------------------------------------------------------>
<body class="login">

<?php
	echo validation_errors(); 	// controllers 단에서 한번 더 입력 값 검사 후 메시지 띄어줌.
?>

<section class="loginCover">
	<form action="/auth/register" method="POST" name="loginForm">
		<ul>
			<li>
				<i class="fa fa-smile-o"></i><input type="text" name="userName" id="userName" value="<?=set_value('userName')?>" placeholder="NAME" />
			</li>
			<li>
				<i class="fa fa-smile-o"></i><input type="text" name="userId" id="userId" value="<?=set_value('userId')?>" minlength="5" maxlength="12" placeholder="ID" />
				<span class="idOverlap"></span>
			</li>
			<li>
				<i class="fa fa-unlock-alt"></i><input type="password" name="passWord" id="passWord" value="<?=set_value('passWord')?>" placeholder="PW" />
			</li>
			<li>
				<i class="fa fa-unlock-alt"></i><input type="password" name="passConf" id="passConf" value="<?=set_value('passConf')?>" placeholder="PW2" />
			</li>
		</ul>
		<button type="submit" id="btn">회원가입</button>
	</form>
</section><!-- //loginCover -->

<script>
$(document).ready(function(){
	// 키 입력시 발생되는 이벤트
	$("#userId").keyup(function(){
		var idVal = $("#userId").val();
		
		if(idVal) {
			$.ajax({
				url 		: "/auth/register",
				dataType 	: "json",
				type 		: "POST",
				data 		: {
								idVal : idVal
				},
				success:function(data){
					$(".idOverlap").html(data);
				}
			});
		}
	});
});
</script>

<script>
$(function(){	
	// 유효성 검사
	$("#btn").click(function(){
		if( $("#userName").val() == "" ) {
			alert("이름을 입력하세요.");
			$("#userName").focus();
			return false;
		}
		
		if( ($("#userId").val() == "") || ($(".idOverlap").text() != "") ) {
			alert("아이디를 입력하세요.");
			$("#userId").focus();
			return false;
		}
		
		if( !/^[a-z0-9_-]{5,13}$/.test($("#userId").val()) ) {
			alert("아이디는 소문자 또한 숫자로 5~12자리를 사용해야 합니다.");
			$("#userId").focus();
			return false;
		}

		if( $("#passWord").val() == "" ) {
			alert("비밀번호를 입력하세요.");
			$("#passWord").focus();
			return false;
		}
		
		if( !/^[a-zA-Z](?=.*[a-zA-Z])(?=.*[0-9]).{4,9}$/.test($("#passWord").val()) ) {
			alert("비밀번호는 숫자와 영문자 조합으로 5~10자리를 사용해야 합니다.");
			$("#passWord").focus();
			return false;
		}
		
		if( $("#passConf").val() == "" ) {
			alert("비밀번호 확인을 입력하세요.");
			$("#passConf").focus();
			return false;
		}
		
		if ( $("#passWord").val() != $("#passConf").val() && $("#passWord").val() != '' ) {
			alert('비밀번호와 비밀번호 확인이 같지 않습니다.');
			$("#passConf").focus();
			return false;
		}
	});
});
</script>

</body>
</html>