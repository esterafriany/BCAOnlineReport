<?php include 'display/header2.php';?>
  <body>
	<div class="text-center">
		<div class="wow bounceInDown" data-wow-offset="0" data-wow-delay="0.4s">
			<br/><BR><BR>
			<a href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(); ?>assets/images/Logo 1.png" width="220" height="80"></a>
		</div>
	</div>
	<div class="container" style="padding-top:25px; padding-bottom:45px;">
	<table align="center" width="300" border=0>
		<tr>
			<td>
			<div class="wow fadeInLeft" data-wow-offset="0" data-wow-delay="0.6s">
				<?php if (!empty ($error) && $error == TRUE){ ?> 
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Anda sudah tidak dapat melakukan penilaian. Jumlah penguji untuk peserta ini sudah 3 orang.
					</div>
				<?php } ?>
				
				<?php if (!empty ($error2) && $error2 == TRUE){ ?> 
					<div class="alert alert-danger" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Peserta Salah!
					</div>
				<?php } ?>
				
				<?php if (!empty ($error3) && $error3 == TRUE){ ?> 
					<div class="alert alert-danger" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Anda sudah melakukan penilaian, penilaian tidak dapat diulang!
					</div>
				<?php } ?>
				
				<?php if (!empty ($error4) && $error4 == TRUE){ ?> 
					<div class="alert alert-danger" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Tidak ada ujian lisan untuk peserta ini.
					</div>
				<?php } ?>
				
				<?php if (!empty ($error5) && $error5 == TRUE){ ?> 
					<div class="alert alert-danger" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  NIP penguji salah!
					</div>
				<?php } ?>
				
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="wow fadeInLeft" data-wow-offset="0" data-wow-delay="0.6s">
					<div class="panel panel-default col-sm-14" style="width: 310px;">
						<div class="panel-heading"><center><img src="<?php echo base_url(); ?>assets/images/Icon Penguji.png" width="80" height="80"><br>MULAI PENILAIAN</center></div>
						<div class="panel-body">
							
							<?php echo validation_errors(); ?>
							<form name="form_login" method="POST" action="<?php echo base_url('welcome/mulai_penilaian'); ?>" class="form-horizontal">
							  <div class="form-group" style="margin-bottom:2px; height:40px;margin-right:0px; margin-left:0px;">
								
								  <input type="text" class="form-control" name= "kode_unik" placeholder="Kode Unik Peserta" required="required" oninvalid="this.setCustomValidity('Isi Kode Unik Peserta')" oninput="setCustomValidity('')" autocomplete="off">
								
							  </div>
							  <div class="form-group" style="margin-right:0px; margin-left:0px;">
								  <input type="text" class="form-control" name="nip" placeholder="NIP Penguji" required="required" oninvalid="this.setCustomValidity('Isi NIP Penguji')" oninput="setCustomValidity('')" autocomplete="off">
							  </div>
						</div>
						<div class="panel-footer"><center>
						<button type="submit" class="btn btn-default" style="background-color: #281ba0;color: white;font-weight: lighter;">  Mulai  </button>
						</center></div>
						
						</form>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</div>

<?php include 'display/footer.php';?>	
	
	<script type="text/javascript">
			window.setTimeout(function() {
				$(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove(); 
				});
			}, 4000);
	</script>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox.pack.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.easing.1.3.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.prettyPhoto.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.isotope.min.js"></script> 
	<script src="<?php echo base_url(); ?>assets/js/functions.js"></script>
	<script>
	wow = new WOW(
	 {
	
		}	) 
		.init();
	</script>
	
  </body>
</html>