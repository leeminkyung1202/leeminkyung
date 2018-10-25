<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<!-- 죄측 메뉴 :: STR -->
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<!-- 로고 :: STR -->
					<div class="navbar nav_title" style="border: 0;">
						<a href="/" class="site_title"><i class="fa fa-paw"></i> <span>관리자</span></a>
					</div><!-- //navbar -->
					<!-- 로고 :: END -->
		
		            <div class="clearfix"></div>
		
		            <!-- 프로필 :: STR -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="/gentelella-master/production/images/hm1031.jpg" alt="..." class="img-circle profile_img">
						</div>
						
						<div class="profile_info">
							<span>Welcome,</span><h2><?=$this->session->userdata('name')?></h2>
						</div>
					</div><!-- //profile -->
		            <!-- 프로필 :: END -->
					
		            <br />
		
		            <!-- 메뉴 :: STR -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<ul class="nav side-menu">
                                <li>
                                    <a><i class="fa fa-home"></i> 게시판 <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="/board/board">대댓글 가능한 게시판</a></li>
                                    </ul>
                                </li>
								<li>
									<a><i class="fa fa-home"></i> 달력 <span class="fa fa-chevron-down"></span></a>
									
									<ul class="nav child_menu">
										<li><a href="/calendar/reserve">달력</a></li>
									</ul>
								</li>
                                <li>
									<a><i class="fa fa-home"></i> 에디터 <span class="fa fa-chevron-down"></span></a>

									<ul class="nav child_menu">
										<li><a href="/editor/editor">에디터 리스트</a></li>
										<li><a href="/editor/editorDaum">다음 에디터</a></li>
										<li><a href="/editor/editorNaver">네이버 에디터</a></li>
										<li><a href="/editor/editorCk">CK 에디터</a></li>
									</ul>
								</li>
								<li>
									<a><i class="fa fa-home"></i> 지도 <span class="fa fa-chevron-down"></span></a>
									
									<ul class="nav child_menu">
										<li><a href="/map/mapNaver">네이버 지도</a></li>
										<li><a href="/map/mapDaum">다음 지도</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div><!-- //sidebar-menu -->
		            <!-- 메뉴 :: END -->
				</div><!-- //scroll-view -->
			</div><!-- //left_col -->
			<!-- 죄측 메뉴 :: END -->

	        <!-- 탑 :: STR -->
	        <div class="top_nav">
				<div class="nav_menu">
		            <nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div><!-- //toggle -->
		
						<ul class="nav navbar-nav navbar-right">
			                <li class="">
								<a href="/auth/logout"><i class="fa fa-sign-out pull-right" style="margin-top: 9px;"></i> Log Out</a>
							</li>
							
							<!-- 알림 :: STR -->
							<li role="presentation" class="dropdown">
								<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
									<li>
										<a>
											<span class="image"><img src="/gentelella-master/production/images/hm1031.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											
											<span class="message">Film festivals used to be do-or-die moments for movie makers. They were where...</span>
										</a>
									</li>
								</ul><!-- //menu1 -->
							</li><!-- //dropdown -->
			                <!-- 알림 :: END -->
			                
						</ul><!-- //navbar-nav -->
		            </nav>
				</div><!-- //nav_menu -->
	        </div><!-- //top_nav -->
			<!-- 탑 :: END -->
	
			<!-- 내용 :: STR -->
	        <div class="right_col" role="main" style="min-height: 1657px;">