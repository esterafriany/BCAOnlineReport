<?php include 'display/header.php';?>
<div class="container">
	<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>GANTI PASSWORD</h3>
	
    <br />
	<br/>
	
	<div class="vertical-align-middle">
	<table width="320" cellspacing="0" width="70%" align="center">
        <tr>
			<td>
			
			<?php if(isset($msg) && $msg != "NULL") { ?>
				<div class="alert alert-warning" role="alert"><?php echo $msg; ?></div>
			<?php } ?>
			
				<div class="panel panel-success">
					<div class="panel-body">
						<form method="POST" action="<?php echo base_url('login/submit_password'); ?>" id="form" class="form-horizontal">
						<!-- Hidden -->
							<input type="hidden" value="" name="id"/>
							<div class="form-body">
								<div class="form-group">
								 
								  <div class="col-md-12">
									<input name="password_lama" id="password_lama" placeholder="Password Lama" class="form-control" type="password">
								  </div>
								</div>
								
								<div class="form-group">
									<div class="col-md-12">
										<input name="password_baru" id="password_baru" placeholder="Password Baru" class="form-control" type="password">
									</div>	  
								</div>
								
								<div class="form-group">
									<div class="col-md-12">
										<input name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control" type="password">
									</div>  
								</div>
							
								<input type="hidden" value="0" name="angkatan_id"/>
							
							
							
							</div>
							
					</div>
					<div class="panel-footer">
							<input type="submit" value="Save" class="btn btn-primary" style="margin-top: 0px;">
						</div>
					</form>
				</div>
			</td>
        </tr>
    </table>
	</div>
	
	</div>
  </div>
  <br/><br/><br/>
  
  <!-- search & paging -->
  <script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
 
  
	

<?php include 'display/footer2.php';?>	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
    <!-- <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox.pack.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.easing.1.3.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.prettyPhoto.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/functions.js"></script>
	
	 <!-- search & paging -->
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.bdt.js" type="text/javascript"></script>

  </body>
</html>