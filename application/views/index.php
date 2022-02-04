<?php include 'display/header2.php';?>
  <body>
	<div class="container">
	
		<table border=0 align="center" style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;height: 100%;width: 100%;">
			<tr style="height: 40%;">
				<td style="vertical-align: bottom;" align="center">
					<div class="wow bounceInDown" data-wow-offset="0" data-wow-delay="0.4s">
						<img src="<?php echo base_url(); ?>assets/images/Logo 1.png" width="300" height="100">
					</div>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: sub;">
					<table align="center" style="margin-top:5%;">
						<tr>
							<td>
								<div class="wow fadeInLeft" data-wow-offset="0" data-wow-delay="0.6s">
								<a href="<?php echo site_url('welcome/penguji');?>">
									<img src="<?php echo base_url(); ?>assets/images/Icon Penguji.png" width="100" height="100">
									</a>
								</div>
								
							</td>
							<td width="90px"></td>
							<td>
								<div class="wow fadeInRight" data-wow-offset="0" data-wow-delay="0.6s">
									<a href="<?php echo site_url('welcome/login_admin');?>">
										<img src="<?php echo base_url(); ?>assets/images/Icon Admin.png" width="100" height="100">
									</a>
								</div>
							
							</td>
						
						</tr>
						<tr>
							<td>
								<div class="wow fadeInLeft" data-wow-offset="0" data-wow-delay="0.6s">
									<h4><a class="btn btn-default" href="<?php echo site_url('welcome/penguji');?>">Penguji</a></h4>
								</div>
								
							</td>
							<td width="90px"></td>
							<td>
								<div class="wow fadeInRight" data-wow-offset="0" data-wow-delay="0.6s">
									<h4><a class="btn btn-default" href="<?php echo site_url('welcome/login_admin');?>">Admin</a></h4> 
								</div>
							
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		
	</div>
	
	<?php include 'display/footer.php';?>
   
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
    <script src="assets/js/jquery-2.1.1.min.js"></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/fancybox/jquery.fancybox.pack.js"></script>
	<script src="assets/js/jquery.easing.1.3.js"></script>
	<script src="assets/js/jquery.bxslider.min.js"></script>
	<script src="assets/js/jquery.prettyPhoto.js"></script>
	<script src="assets/js/jquery.isotope.min.js"></script> 
	<script src="assets/js/functions.js"></script>
	<script>
	wow = new WOW(
	 {
	
		}	) 
		.init();
	</script>
	
  </body>
</html>