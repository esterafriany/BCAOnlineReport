<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Otomasi Ujian Lisan</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	
	<!--<link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />	-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
	<link href="<?php echo base_url(); ?>assets/css/prettyPhoto.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />	
	
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/jqueryui/jquery-ui.css'); ?>" />
	
	<!--sweetalert-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweet-alert.css">
	<script src="<?php echo base_url(); ?>assets/js/sweet-alert.min.js"></script>
	
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
						<div class="navbar-brand" style="padding-top: 10px;">
							<a class="btn" onclick="home()" style="padding-top: 2px;padding-bottom: 0px;"><img src="<?php echo base_url(); ?>assets/images/Logo 2.png" width="35" height="35"></a>
						</div>
					</div>
					
					<div class="navbar-collapse collapse">							
						<div class="menu">
							<ul class="nav nav-tabs" role="tablist">
								<li>
									<div class="dropdown">
										<a id="dLabel" role="button" class="btn btn-primary" data-target="#" onclick="home()"><i class="glyphicon glyphicon-home"></i></a>
										<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu"></ul>
									</div>
								</li>		
								<br><br><br>		
							</ul>
						</div>
					</div>						
				</div>
			</div>	
		</nav>		
	</header>
	
	<form name="form_penilaian" id="form_penilaian" method="POST" action="<?php echo base_url('UjianLisan_penguji/submit_nilai'); ?>" class="form-horizontal">
	<div class="container">
	<div class="panel panel-primary">
	  <div class="panel-heading">Penilaian Ujian Lisan</div>
	  <div class="panel-body" style="padding-top:0px; padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:smaller;">
		<div class="panel panel-success" style="margin-bottom:0px;">
			<div class="panel-heading"><font style="font-weight: bold;">Penguji</font></div>
			<div class="panel-body">
				<table width="100%" >
					<tr>
						<td width="35%">NIP</td>
						<td>:<?php echo $penguji->nip; ?><input name="penguji_id" value="<?php echo $penguji->id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:<?php echo $penguji->nama; ?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:<?php echo $penguji->divisi; ?></td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="panel panel-warning" style="margin-bottom:0px;">
			<div class="panel-heading"><font style="font-weight: bold;">Peserta</font></div>
			<div class="panel-body">
				<table width="100%" >
					<tr>
						<td width="35%">NIP</td>
						<td>:<?php echo $peserta->nip; ?><input  name="peserta_id" value="<?php echo $peserta->peserta_id; ?>" class="form-control" type="hidden"></td>
						<input name="nip_peserta" value="<?php echo $peserta->nip; ?>" class="form-control" type="hidden">
					</tr>
					<tr>
						<td>Nama</td>
						<td>:<?php echo $peserta->nama; ?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:<?php echo $peserta->divisi; ?></td>
					</tr>
					<tr>
						<td>Program </td>
						<td>:<?php echo $peserta->nama_program; ?><input name="program_id" value="<?php echo $peserta->program_id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td>Angkatan </td>
						<td>:<?php echo $peserta->nama_angkatan; ?><input name="angkatan_id" value="<?php echo $peserta->angkatan_id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td></td>
						<td align="right">
							<?php if($peserta->file_lampiran != "") { ?>
								<!--<a class="btn btn-success btn-xs" href="<?=base_url ()?>peserta/download/<?php echo $peserta->file_lampiran; ?>"><?php echo $peserta->file_lampiran; ?></a> -->
								
								<!--lampiran berupa image<button type="button" class="btn btn-success btn-xs" onClick="confirmation2('<?php echo base_url('uploads/'); echo $peserta->file_lampiran; ?>')">Lihat Lampiran</button>-->
								<a href="<?=base_url ()?>peserta/download/<?php echo $peserta->file_lampiran; ?>" target="_blank" style="color: #337ab7;font-size: 13px;">Lihat Lampiran <i class="glyphicon glyphicon-download"></i></a>
								
							<?php }else if($peserta->file_lampiran == ""){?>
								<button type="button" class="btn btn-danger btn-xs">Tidak ada lampiran</button>
							<?php } ?>
							
							
						</td>
					</tr>
				</table>
			</div>
		</div>
		</div>
	  </div>
	</div>
	<div class="container">
		
		<br />
		<label id="msgNilai" name="msgNilai" style="color:red"></label>
		<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" align="center">
		  <thead>
			<tr>
				<th width="10px"><center>No.</center></th>
				<th><center>Kriteria</center></th>
				<th style="width:120px;"><center>Bobot</center></th>
				<th>
					<center>Nilai 
						<a type="button" data-container="body" data-toggle="popover" data-placement="right" data-content="Desimal dipisahkan tanda titik.">
						  <i class="glyphicon glyphicon-info-sign"></i>
						</a>
					</center>
				</th>
				<th><center>Total</center></th>
			</tr>
		  </thead>
		  <tbody>
			<?php 
			$i = 1;
			$j = 0;
			foreach($kriterias as $kriteria){
				?>
					<tr>
						<td><?php echo $i++;?></td>
						<td>
							<?php echo $kriteria->kriteria_penilaian;?>
							<input name="kriteria_id[]" value="<?php echo $kriteria->id; ?>" class="form-control" type="hidden">
							
							<a type="button" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo $kriteria->keterangan_penilaian;?> ">
							  <i class="glyphicon glyphicon-info-sign"></i>
							</a>
						</td>
						<td>
							<input name="komposisi_nilai[]" class="form-control" type="hidden" value="<?php echo $kriteria->komposisi_nilai;?>" disable><?php echo $kriteria->komposisi_nilai;?>%
						</td>
						<td width="100"><input name="nilai[]" style="padding-top:0px; padding-left:0px;padding-bottom:0px;padding-right:0px;" class="form-control" type="number" autocomplete="off" >
						</td>
						<td width="100">
							<input disabled name="total_nilai_display" onchange="set_value()" class="form-control" style="padding-top:0px; padding-left:0px;padding-bottom:0px;padding-right:0px;" type="text">
							<input name="total_nilai<?php echo $j; ?>" class="form-control" type="hidden">
						</td>
					</tr>
				<?php 
				$j++;
			}
			?>
		  </tbody>
			
		  <tfoot align="center" valign="mid">
			<tr>
				<td colspan="4">Total Nilai</td>
				<td width="100">
					<input disabled name="total_nilai_akhir_display" id="total_nilai_akhir_display" class="form-control" style="padding-top:0px; padding-left:0px;padding-bottom:0px;padding-right:0px;" type="text">
					<input name="total_nilai_akhir" class="form-control" type="hidden" >
					<b>Grade: </b> <label id="grade_nilai" name="grade_nilai"></label><!--<input type="text" name="grade_nilai" id="grade_nilai" />-->
				</td>
			</tr>
		  </tfoot>
		</table>
		<div class="well well-sm" style="font-size:smaller;">
			1. KURANG	<70 <br>
			2. CUKUP 70 – 75<br>
			3. BAIK 76 – 85<br>
			3. SANGAT BAIK >85
		</div>
			<div class="form-group">
				<label for="username" class="col-sm-3 control-label">Komentar(*)</label>
				<div class="col-sm-7">
				  <textarea name="komentar" id="komentar" class="form-control" rows="4" cols="50"></textarea>
				  <label id="msg" name="msg" style="color:red"></label>
				</div>
			</div>
			
			
		<div class="form-group" align="right">
			<div class="col-sm-12">
			  <!--<button type="button" class="btn btn-success" onclick="return confirm('\u2022 Anda tidak dapat melakukan perubahan nilai setelah submit.\n\u2022 Pastikan komentar terisi.\n\nAPAKAH ANDA YAKIN INGIN SUBMIT?');">Submit Nilai</button>-->
			  
			  <button type="button" class="btn btn-success" onClick="confirmation();" >Submit Nilai</button>
			</div>
		</div>	
	</div>
	 
	 <div id="confirm" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
			<div style="position: absolute;top: 35%;left: 0;height: 100%;width: 100%;font-size: 18px;">
				<table align="center" border=0>
					<tr>
						<td>
							<div class="col-md-10" align="center">
								<div class="panel panel-default" style="padding-top: 10px; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
								
									<table align="center" style="" border=0 width="100%">
										<tr>
											<td valign="top" width="30px">
												<i class="fa fa-arrow-circle-right" aria-hidden="true"></i><br>
											</td>
											<td>
												 Anda tidak dapat melakukan perubahan nilai setelah submit.<br>
											</td>
										</tr>
										<tr>
											<td>
											</td>
											
										</tr>
										<tr>
											<td colspan=2>
												<br>	
												<center>
													APAKAH ANDA YAKIN INGIN SUBMIT?
													<br><br>
													<button type="button" class="btn btn-success" onClick="check();">Ya</button>
													<button type="button" class="btn btn-success" onClick="uncheck();">Tidak</button>
												</center>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div id="confirm2" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;overflow:auto;">
			<div style="position: absolute;top: 20%;left: 0;height: 100%;width: 100%;font-size: 18px;">
				<table align="center" border=0 id="tabel_peserta">
					<tr>
						<td>
							<div class="col-md-10" align="center">
								<div class="panel panel-default" style="padding-top: 10px; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
								
									<table align="center" style="" border=0 width="100%">
										
									</table>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
	
	<div class="loader"></div>
	<div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
		<div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
			<center><img src="<?php echo base_url(); ?>assets/images/load.gif" alt="Loading"></center>
			Submit on Progress...
		</div>
	</div>
  <script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
  <script src="<?php echo base_url('assets/jquery/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
 
 <style type="text/css">	
	.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('<?php echo base_url(); ?>assets/images/load.gif') 50% 50% no-repeat rgb(249,249,249);
		opacity: .8;
	}
 </style>
 
  <script type="text/javascript">
  $(window).load(function() {
		$(".loader").fadeOut("slow");
	});
	
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	//autosum
	//Get a list of input fields to sum
	var elements = document.getElementsByName("nilai[]");
	var element_array = Array.prototype.slice.call(elements);
	
	
	var elements_komp = document.getElementsByName("komposisi_nilai[]");
	var element_array_komp = Array.prototype.slice.call(elements_komp);

	var elements_nilai = document.getElementsByName("total_nilai_display[]");
	var element_array_nilai = Array.prototype.slice.call(elements_nilai);
	
	//Assign the keyup event handler
	for(var i=0; i < element_array.length; i++){
	    element_array[i].addEventListener("keyup", sum_values);
	}

	//Function to sum the values and assign it to the last input field
	function sum_values(){
	    var sum = 0;
	    var tot = 0;
	    for(var i=0; i < element_array.length; i++){
		
		sum = parseFloat(parseFloat(element_array[i].value, 10)*parseInt(element_array_komp[i].value, 10)/100).toFixed(2);
		tot += parseFloat(sum);
		document.getElementsByName("total_nilai_display")[i].value = !isNaN(sum) ? sum : 0;
		
		document.getElementsByName("total_nilai" + i)[0].value = sum;
		
		document.getElementsByName("total_nilai_akhir_display")[0].value = !isNaN(parseFloat(tot)) ? parseFloat(tot).toFixed(2) : 0 ;
		document.getElementsByName("total_nilai_akhir")[0].value = !isNaN(parseFloat(tot)) ? parseFloat(tot) : 0 ;
		var a = document.getElementById("grade_nilai");
		var grade = parseFloat(tot);
			if(grade < 70.5){
				a.innerHTML = '<font style="color:red">KURANG</font>';
			}else if(grade >= 70.5 && grade <75.5){
				a.innerHTML = '<font style="color:blue">CUKUP</font>';
			}else if(grade >=75.5 && grade <=85.4){
				a.innerHTML = '<font style="color:green">BAIK</font>';
			}else if(grade >= 85.5){
				a.innerHTML = '<font>SANGAT BAIK</font>';
			}
	    }
	    
	}
  //end of autosum
  
  $(document).ready( function () {

  } );
  
    var save_method; //for save method string
    var table;
 

 
    function detail_kriteria(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/UjianLisan_penguji/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
			document.getElementById("nama_kriteria").innerHTML = data.kriteria_penilaian;
			document.getElementById("detail_kriteria").innerHTML = data.keterangan_penilaian;
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Kriteria Penilaian'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
	  });
    }
	
	
 
	function lihat_kriteria(id){
		save_method = 'kriteria';
 
		//Ajax Load data from ajax
		$.ajax({
			url : "<?php echo site_url('/kriteria/')?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
	 
				$('[name="id"]').val(data.id);
				$('[name="nama_program"]').val(data.nama_program);
	 
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		});
	}
 
    function save()
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo site_url('/program/program_add')?>";
      }
      else
      {
        url = "<?php echo site_url('/program/program_update')?>";
      }
 
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
              location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
 
    function home()
    {
      if(confirm('Apakah anda yakin ingin meninggalkan halaman ini? Data nilai tidak akan tersimpan.'))
      {
		var url="<?php echo base_url();?>";
        window.location = url+"welcome/home/";
      }
    }
	
	function check() {
		//alert(document.getElementById("komentar").value);
		if(document.getElementById("komentar").value == "" && (document.getElementById("total_nilai_akhir_display").value == "" || document.getElementById("total_nilai_akhir_display").value == "0")){
			$("#confirm").hide();
			document.getElementById('msg').innerHTML = 'Komentar harus diisi!';
			document.getElementById('msgNilai').innerHTML = 'Nilai harus diisi!';
		
		}else if(document.getElementById("total_nilai_akhir_display").value == "" || document.getElementById("total_nilai_akhir_display").value == "0"){
			$("#confirm").hide();
			document.getElementById('msgNilai').innerHTML = 'Nilai harus diisi!';
			document.getElementById('msg').innerHTML = '';
		
		}else if(document.getElementById("komentar").value == ""){
			$("#confirm").hide();
			document.getElementById('msg').innerHTML = 'Komentar harus diisi!';
			document.getElementById('msgNilai').innerHTML = '';
		}else{
			$("#checking").show();
			document.getElementById("form_penilaian").submit();
		}
		
	}
	
	function uncheck() {
		$("#confirm").hide();
	}
	
	function uncheck2() {
		$("#confirm2").hide();
	}
	
	function confirmation() {
		$("#confirm").show();
	}
	
	function confirmation2(nama_file) {
		
		$("#confirm2").show();
	}
	
	function confirmation2(nama_file)
    {	
		//set empty table
		var table = $('#tabel_peserta');
		$("#tabel_peserta tbody").remove(); 

		table.append("<tr><td><img src='"+nama_file+"' width=100% height=100%/> </td></tr>");
		table.append("<tr><td><br></td></tr><tr><td align=\"center\"><button type=\"button\" class=\"btn btn-success\" onClick=\"uncheck2();\">Kembali</button></td></tr>");
		$("#confirm2").show();
    }
	
  </script>
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Kriteria Penilaian</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
				<h4 style="padding-left:10px;padding-right:10px;text-align:left;" id="nama_kriteria"></h4>
				<div class="col-md-8">
					<textarea id="detail_kriteria" disabled cols="39%" rows="6"></textarea>
				</div>
            </div>
          </div>
        </form>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
  
  <br/><br/><br/>

<?php include 'display/footer2.php';?>
 
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
		wow = new WOW({}).init();
	</script>
  </body>
</html>