<!-----------------------------------------------------------------------------------------
* 작성자: MK.Lee
* 작성일시: 2018-04-09
* 사용법: 로그인 페이지
* https://demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html
------------------------------------------------------------------------------------------>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script> <!-- 카카오 로그인 -->
<script src="/gentelella-master/vendors/jquery/dist/jquery.min.js"></script> <!-- jQuery -->
<body class="login">

    <!-- 네이버 아이디로 로그인 :: STR -->
	<?php
		// 메시지 띄어줌
		if( $this->session->flashdata('alert') != '' ){
			echo $this->session->flashdata('alert');
		}

		// 네이버아이디로 로그인
		$client_id = "kc3yOAuhOcaTqg4NKWU3"; // 위에서 발급받은 Client ID 입력
		$redirectURI = urlencode("https://lmk.lunaday.net/auth/loginNaver"); //자신의 Callback URL 입력
		$state = "RAMDOM_STATE";
		$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
	?>
    <!-- 네이버 아이디로 로그인 :: END -->

    <!-- 페이스북 아이디로 로그인 :: STR -->
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({appId: '265313460760623', status: true, cookie: true,xfbml: true});
        };

        (function(d){
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement('script'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/en_US/all.js";
            ref.parentNode.insertBefore(js, ref);
        }(document));

        function facebooklogin() {
            //페이스북 로그인 버튼을 눌렀을 때의 루틴.
            FB.login(function(response) {
                var fbname;
                var accessToken = response.authResponse.accessToken;
                FB.api('/me', function(user) {
                    fbname = user.name;
                    //response.authResponse.userID

                    $.ajax({
                        url 		: "/auth/loginFacebook",
                        dataType 	: "json",
                        type 		: "POST",
                        data 		: {
                            id              : user.id,
                            name            : fbname,
                            fbaccesstoken   : accessToken
                        },
                        success:function(data){
                            var url = data['url'];

                            if( url ) {
                                location.replace(url);
                            } else {
                                alert(data['text']);
                            }
                        }
                    });
                });
            });
        }
    </script>
    <!-- 페이스북 아이디로 로그인 :: END -->

	<section class="loginCover">
        <h1><i class="fa fa-paw"></i> 로그인</h1>
		<form action="/auth/login" method="POST" name="loginForm">
			<ul>
				<li><input type="text" name="userId" id="userId" value="" placeholder="ID" /></li>
				<li><input type="password" name="passWord" id="passWord" value="" placeholder="PW" /></li>
			</ul>
            <button type="submit" class="btn btn-default" id="btn">Log in</button>
		</form>
		<a href="/auth/register" class="register">회원가입</a>

		<dl>
			<dt>간편로그인</dt>
			<dd><a href="<?=$apiURL?>"><img src="/gentelella-master/production/images/loginBtnNaver.png" alt="네이버 아이디 로그인" /></a></dd>
            <dd><a id="custom-login-btn" href="javascript:loginWithKakao()"><img src="/gentelella-master/production/images/loginBtnKakao.png" alt="카카오 아이디 로그인" /></a></dd>
            <dd><a href="javascript:;" onclick="facebooklogin()"><img src="/gentelella-master/production/images/loginBtnFacebook.png" alt="페이스북 아이디 로그인" /></a></dd>
        </dl>
        
        <p class="test">테스트 아이디 : test1<br/>테스트 비밀번호 : test1</p>
	</section><!-- //loginCover -->
	
	<script>
	$(function(){
		$("#btn").click(function(){
			if( $("#userId").val() == "" ) {
				alert("아이디를 입력하세요.");
				$("#userId").focus();
				return false;
			}
			
			if( $("#password").val() == "" ) {
				alert("비밀번호를 입력하세요.");
				$("#passWord").focus();
				return false;
			}
		});
	});
	</script>
    
    <!-- 카카오로그인 :: STR -->
    <script>
    Kakao.init('695de41344ffe96437cb2963e5d322c1');
    function loginWithKakao() {
        // 로그인 창을 띄웁니다.
        Kakao.Auth.login({
            success: function(authObj) {
                // 로그인 성공시, API를 호출합니다.
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        //alert(JSON.stringify(res));

                        $.ajax({
                            url 		: "/auth/loginKakao",
                            dataType 	: "json",
                            type 		: "POST",
                            data 		: {
                                id   : res.id,
                                name : res.properties['nickname']
                            },
                            success:function(data){
                                var url = data['url'];

								if( url ) {
                                    location.replace(url);
								} else {
                                    alert(data['text']);
								}
                            }
                        });
                    },
                    fail: function(error) {
                        alert(JSON.stringify(error));
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err));
            }
        });
    };
    </script>
	<!-- 카카오로그인 :: END -->

</body>
</html>


