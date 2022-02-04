<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Otomasi Ujian Lisan</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css_paging/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/font.css" media="all">
	
	<!--<link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />	-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css" media="all">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox.css" type="text/css" media="all"/>
	<link href="<?php echo base_url(); ?>assets/css/prettyPhoto.css" rel="stylesheet" media="all"/>
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" media="all"/>	
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/jqueryui/jquery-ui.css'); ?>" media="all"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/font.css"/>
	
	<!--sweetalert-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweet-alert.css">
	<script src="<?php echo base_url(); ?>assets/js/sweet-alert.min.js"></script>
	<style type="text/css">
		.font {
			font-family: 'AlexBrushRegular';
		}
	</style>
	
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery-1.12.js"></script>
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js_paging/dataTables.bootstrap.min.js"></script>
  </head>
  <body>
	<header>
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="navigation">
				<div class="container">					
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse.collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="navbar-brand">
							<a href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(); ?>assets/images/Logo 2.png" width="35" height="35"></a>
						</div>
					</div>
					
					<div class="navbar-collapse collapse">							
						<div class="menu">
							<ul class="nav nav-tabs" role="tablist">
								<li>
									<div class="dropdown">
									    <a id="dLabel" role="button" class="btn btn-primary" data-target="#" href="<?php echo base_url('admin/'); ?>"><i class="glyphicon glyphicon-home"></i></a>
										<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
									</div>
								</li>
								<?php if($this->session->userdata("role")!=1){ ?>
								<li>
									<div class="dropdown">
									    <a id="dLabel" role="button" class="btn btn-primary" data-target="#" href="<?php echo base_url('program'); ?>">PROGRAM</a>
										<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
									</div>
								</li>
								
								<li>
									<div class="dropdown">
									    <a id="dLabel" role="button" class="btn btn-primary" data-target="#" href="<?php echo base_url('karyawan'); ?>">KARYAWAN</a>
										<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
									</div>
								</li>
								
								<?php } ?>
								
								<li role="presentation">
									<div class="dropdown">
									    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#">
										Penilaian <span class="caret"></span>
									    </a>
										<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
											<?php if($this->session->userdata("role")!=1){ ?>
											<li><a href="<?php echo base_url('UjianTulis'); ?>">Ujian Tulis</a></li>
											<?php } ?>
											<li><a href="<?php echo base_url('UjianLisan'); ?>">Ujian Lisan</a></li>
											<li><a href="<?php echo base_url('Sertifikat'); ?>">Sertifikat</a></li>
											<?php if($this->session->userdata("role")!=1){ ?>
											<li><a href="<?php echo base_url('UjianLisan/jadwal'); ?>">Jadwal Ujian Lisan</a></li>
										
											<?php } ?>
										</ul>
									</div>
								</li>
								
								<?php  if($this->session->userdata("login")=='login'){ ?>
									<li>
										<div class="dropdown">
										    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#">
												<?php echo $this->session->userdata("nama"); ?>&nbsp;<i class="glyphicon glyphicon-user"></i><span class="caret"></span>
											</a>
											<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
												<?php if($this->session->userdata("role")==3){ ?>
												<li><a href="<?php echo base_url('karyawan/manage_user'); ?>">Manage User</a></li>
												<li><a href="<?php echo base_url('audittrail'); ?>">Audit Trail</a></li>
												<?php } ?>
												<li><a href="<?php echo base_url('karyawan/ganti_password'); ?>">Ganti Password</a></li>
												<li><a href="<?php echo base_url('login/logout'); ?>">Keluar</a></li>
											</ul>
										</div>
									</li>
									
								<?php
								}else{ ?>
									<li>
										<div class="dropdown">
										    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="<?php echo base_url('welcome/login_admin'); ?>"><i class="glyphicon glyphicon-log-in"></i>  LOGIN</a>
										</div>
									</li>
									
								<?php
								}
								?>		
							</ul>
						</div>
					</div>						
				</div>
			</div>	
		</nav>		
	</header>