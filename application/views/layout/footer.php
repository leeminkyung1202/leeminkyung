</div><!-- //right_col -->
				<!-- 내용 :: END -->
				
		        <!-- 푸터 :: STR -->
				<footer>
					<div class="pull-right">LeeMinKyung</div>
					<div class="clearfix"></div>
				</footer>
				<!-- 푸터 :: END -->
		        
			</div><!-- //main_container -->
		</div><!-- //container -->

	    <!-- jQuery -->
	    <script src="/gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
	    <!-- Bootstrap -->
	    <script src="/gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	    <!-- FastClick -->
	    <script src="/gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
	    <!-- bootstrap-progressbar -->
	    <script src="/gentelella-master/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	    <!-- iCheck -->
	    <script src="/gentelella-master/vendors/iCheck/icheck.min.js"></script>
	    <!-- Skycons -->
	    <script src="/gentelella-master/vendors/skycons/skycons.js"></script>
	    <!-- Flot plugins -->
	    <script src="/gentelella-master/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	    <script src="/gentelella-master/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	    <script src="/gentelella-master/vendors/flot.curvedlines/curvedLines.js"></script>
	    <!-- bootstrap-daterangepicker -->
	    <script src="/gentelella-master/vendors/moment/min/moment.min.js"></script>
	    <script src="/gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>	
	    <!-- Custom Theme Scripts -->
	    <script src="/gentelella-master/build/js/custom.min.js"></script>
		
		<?php
			if( $this->session->flashdata('alert') != '' ){
				echo $this->session->flashdata('alert');
			}		
		?>
	
	</body>
</html>
