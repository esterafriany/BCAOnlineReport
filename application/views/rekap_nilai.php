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
						<div class="navbar-brand">
							<a href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(); ?>assets/images/Logo 2.png" width="35" height="35"></a>
						</div>
					</div>
					
					<div class="navbar-collapse collapse">							
						<div class="menu">
							<ul class="nav nav-tabs" role="tablist">
								<li>
									<div class="dropdown">
									    <a id="dLabel" role="button" class="btn btn-primary" data-target="#" href="<?php echo base_url(''); ?>">HOME</a>
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
	
	<div class="container">
	<label id="msg" name="msg" style="color:red"><?php if(isset($result)){ echo $result; } ?></label>
		
	<table width="100%" border=0>
		<tr>
			<td>
				<fieldset class="col-md-6" style="width: 100%;">    	
					<legend>Penguji</legend>
					<table width="100%" >
						<tr>
							<td width="35%">NIP</td>
							<td>:&nbsp;<?php echo $penguji->nip; ?><input name="penguji_id" value="<?php echo $penguji->id; ?>" class="form-control" type="hidden"></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td>:&nbsp;<?php echo $penguji->nama; ?></td>
						</tr>
						<tr>
							<td>Unit Kerja</td>
							<td>:&nbsp;<?php echo $penguji->divisi; ?></td>
						</tr>
					</table>
					
				</fieldset>	
				<br>
			</td>
		</tr>
		<tr>
			<td>
				<fieldset class="col-md-6" style="width: 100%;">    	
					<legend>Peserta</legend>
					<table width="100%" >
						<tr>
							<td width="35%">NIP</td>
							<td>:&nbsp;<?php echo $peserta->nip; ?><input  name="peserta_id" value="<?php echo $peserta->peserta_id; ?>" class="form-control" type="hidden"></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td>:&nbsp;<?php echo $peserta->nama; ?></td>
						</tr>
						<tr>
							<td>Unit Kerja</td>
							<td>:&nbsp;<?php echo $peserta->divisi; ?></td>
						</tr>
						<tr>
							<td>Program </td>
							<td>:&nbsp;<?php echo $peserta->nama_program; ?><input name="program_id" value="<?php echo $peserta->program_id; ?>" class="form-control" type="hidden"></td>
						</tr>
						<tr>
							<td>Angkatan </td>
							<td>:&nbsp;<?php echo $peserta->nama_angkatan; ?><input name="angkatan_id" value="<?php echo $peserta->angkatan_id; ?>" class="form-control" type="hidden"></td>
						</tr>
					</table>
				</fieldset>	
			</td>
		</tr>
	</table>
<br>

<div class="panel-body" style=" padding-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px;">
	<div class="panel panel-default" style="    padding-top: 5px; padding-bottom: 5px;  padding-left: 5px; padding-right: 5px; margin-bottom: 0px;">
		<table id="table_id" class="table table-bordered" cellspacing="0" width="100%">
		  <thead>
			<tr>
				<th><center>Kriteria</center></th>
				<th><center>Bobot</center></th>
				<th><center>Nilai</center></th>
				<th><center>Total</center></th>
			</tr>
		  </thead>
		  <tbody style="padding-bottom: 2px; padding-left: 2px; padding-top: 2px; padding-right: 2px;">
			<?php 
			$i = 1;
			foreach($detail_nilai as $nilai){?>
				 <tr>
				<td><?php echo $i++;?>. <?php echo $nilai->kriteria_penilaian;?></td>
				<td align="center"><?php echo $nilai->komposisi_nilai;?>%</td>
				<td align="center"><?php echo $nilai->nilai;?></td>
				<td align="center"><?php echo $nilai->komposisi_nilai*$nilai->nilai/100;?></td>
				 </tr>
			<?php }?>
		  </tbody>
	 
		  <tfoot>
		  <th colspan="3" style="text-align: right;">Nilai Total</th>
		  <th><center>
			<?php 
				if(count($detail_nilai) !=0){
					echo $nilai->total_nilai;
				}else{
					echo 0;
				}
			?>
		  </center>
		  </th>
		  </tfoot> 
		</table>
		</div>
</div>	
<br>
<div class="panel panel-default" style="margin-bottom: 3px;padding-left: 10px;">
	<table>
		<tr>
			<td>
				<b>Komentar:</b>
			</td>
			
		</tr>
		<tr>
			<td>
				<?php 
					if(count($detail_nilai) !=0) {
						echo $detail_nilai[0]->komentar;
					}else{
						echo "";
					}
				?>
			</td>
		</tr>
	</table>

</div>
<font style="font-size:10px;font-style: italic;">
	Disubmit pada: <?php echo $detail_nilai[0]->tanggal;?>
</font>
</div>
	
	<div class="container">
		<form name="form_penilaian" method="POST" action="<?php echo base_url(''); ?>" class="form-horizontal">
			<table align="right">
				<tr>
					<td align="right">
				
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
							  <button type="submit" class="btn btn-success">Tutup</button>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
  <script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
  <script src="<?php echo base_url('assets/jquery/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
 
 <style type="text/css">
	fieldset {
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
	legend
	{
		font-size:14px;
		font-weight:bold;
		margin-bottom: 0px; 
		width: 80px; 
		border: 1px solid #ddd;
		border-radius: 4px; 
		padding: 5px 5px 5px 10px; 
		background-color: #ffffff;
		color:black;
	}
  </style>
 
  <script type="text/javascript">
  
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
		
		sum = parseFloat(element_array[i].value, 10)*parseInt(element_array_komp[i].value, 10)/100;
		tot += parseFloat(sum);
		document.getElementsByName("total_nilai_display")[i].value = !isNaN(sum) ? sum : 0;
		
		document.getElementsByName("total_nilai" + i)[0].value = sum;
		
		document.getElementsByName("total_nilai_akhir_display")[0].value = !isNaN(parseFloat(tot)) ? tot : 0 ;
		
		document.getElementsByName("total_nilai_akhir")[0].value = !isNaN(parseFloat(tot)) ? tot : 0 ;
		
		var a = document.getElementById("grade_nilai");
		var grade = parseFloat(tot);
		
		if(grade < 70){
			a.innerHTML = "KURANG";
		}else if(grade >= 70 && grade <=75){
			a.innerHTML = "CUKUP";
		}else if(grade >=76 && grade <=85){
			a.innerHTML = "BAIK";
		}else if(grade >=85){
			a.innerHTML = "SANGAT BAIK";
		}
		
		
	    }
	    
	}
  //end of autosum
    
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
	
  </body>
</html>