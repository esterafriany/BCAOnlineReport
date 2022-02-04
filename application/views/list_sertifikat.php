<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>REPORT NILAI	</h3>
	<h4>Program : <?php if(!empty($program)){ echo $program->nama_program;}else{echo "-";} ?>, Angkatan : <?php if(!empty($angkatan)){ echo $angkatan->nama_angkatan;}else{echo "-";} ?></h4>
	<br />
	<table>
		<tr>
			<td>
				<div class="dropdown">
				    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-warning btn-sm" data-target="#">
					<?php if(!empty($program)){echo $program->nama_program;}else{ echo "Pilih Program";} ?> <span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<?php foreach($listprograms as $prg) { 
					if($prg->id !=0){
						?>
							<li><a href="<?php echo base_url("Sertifikat/show_report/".$prg->id); ?>"><?php echo $prg->nama_program; ?></a></li>
						<?php							
						} ?>
					<?php } ?>
				    </ul>
				</div>
				<input type="hidden" name="prog_id" value="<?php if(!empty($id_program)){ echo $id_program; } ?>">
				
			</td>
			<td>
				<div class="dropdown">
				    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-warning btn-sm" data-target="#">
					<?php if(!empty($angkatan)){echo $angkatan->nama_angkatan;}else{ echo "Pilih Angkatan";} ?> <span class="caret"></span>
				    </a>
					
					<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
						<?php if ($listAngkatan <> null) {
							foreach($listAngkatan as $angk) { ?>
								<li><a href="<?php echo base_url("Sertifikat/show_report2/".$id_program."/".$angk->angkatan_id); ?>"><?php echo $angk->nama_angkatan; ?></a></li>
							<?php 
							}
						} ?>
					</ul>
				</div>
				<input type="hidden" name="ang_id" value="<?php if(!empty($ang_id)){ echo $ang_id; } ?>">
			</td>
			<td></td>
			<?php if(empty($ang_id)){ $ang_id = 0; } ?>
			<?php 
				if(!empty($jumlah_penguji)){ 
					$jlh_penguji = $jumlah_penguji->jumlah_penguji; 
				}else{
					$jlh_penguji = 0;
				}
			?>
			<td>
				<!--<a class="btn btn-success btn-sm" href="" id="btnPlaceOrder" name="btnPlaceOrder"><i class="glyphicon glyphicon-download"></i> Import From CSV</a>-->
			</td>
		</tr>
	</table>
	
	<?php if(isset($message)){ ?>
		<div class='alert alert-info'>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php  echo $message; ?>
		</div>
	<?php } ?>

    <br />
	<?php 
		
		if(isset($list_report) ){
			$num = sizeof($list_report); 
			if($num > 0){
				$status_lisan="true";
				$status_tulis="true";
				$i = 1;
				foreach($list_report as $report){
					if($status_tulis == "true"){
						if($report->nilai_tulis == ""){
							$status_tulis = "false";
						}
					}
					if($status_lisan == "true"){
						if($report->nilai_lisan == ""){
							$status_lisan = "false";
						}
					}
				}
			}
		}			
				
	?> 
	<table align="right">
		<tr>
			<td>
				<?php 
				if(isset($status_lisan) && $status_lisan == "true"){ ?>
					<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> Nilai Ujian Lisan</span>
				<?php  }else{ ?>
					<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i> Nilai Ujian Lisan</span>
				<?php } ?>
				|
				<?php 
				if(isset($status_tulis) && $status_tulis == "true"){ ?>
					<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> Nilai Ujian Tulis</span>
				<?php  }else{ ?>
					<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i> Nilai Ujian Tulis</span>
				<?php } ?>
				|
				<?php
					if(isset($status_lisan)){$sl = $status_lisan;}else{$sl = "null";}
					if(isset($status_tulis)){$st = $status_tulis;}else{$st = "null";}
					if(isset($report->program_id)){$p = $report->program_id;}else{$p = "null";}
					if(isset($report->angkatan_id)){$a = $report->angkatan_id;}else{$a = "null";}
					
				?>
					<a class="btn btn-warning btn-xs" id="btnExport" href="<?php echo base_url('sertifikat/export_excel/'.$p.'/'.$a)?>"><i class="glyphicon glyphicon-open"></i> Export To Excel</button>
			</td>
		</tr>
	</table>
	
	<br><br>

    <table id="example" class="table table-hover" cellspacing="0" width="100%" style="font-size: 14;">
      <thead>
        <tr>
			<th width="10px">No.</th>
			<th>NIP - Nama</th>
			<th>Divisi/Unit Kerja</th>
			<th>Nilai Tulis</th>
			<th>Nilai Lisan</th>
			<th>Nilai Akhir</th>
			
			<?php if(isset($id_program)){ ?>
			<?php if($id_program == 4|| $id_program == 5 || $id_program ==26 ){ ?>
			<th>Lulus/Tidak Lulus</th>
			<?php } }?>
			
			<th style="width:110px;">Action</th>
        </tr>
      </thead>
      <tbody id="table_body">
		<?php 
		if(isset($list_report)){
			$i = 1;
			foreach($list_report as $report){ ?>
				<tr>
					<td><?php echo $i++;?></td>
					<td><?php echo $report->nip_peserta;?> - <?php echo $report->nama;?></td>
					<td><?php echo $report->divisi;?></td>
					<td><?php if($report->nilai_tulis != ""){echo $report->nilai_tulis; }else{echo "-";} ?></td>
					<td>
					
					<?php 
					if($report->nilai_lisan != "") {
						if($report->jumlah_penguji <> $report->jumlah_nilai){
							echo round($report->jumlah_nilai_lisan / $report->jumlah_penguji,2); 
						}else{
							echo $report->nilai_lisan; 
						}
						
					}else{
						echo "-";
					} ?>
					
					<?php if($report->jumlah_penguji <> $report->jumlah_nilai){ ?>
						<a type="button" data-container="body" data-toggle="popover" data-placement="right" data-content="Semua penguji belum memberi nilai !">
						  <i class="glyphicon glyphicon-info-sign" style="color: red;"></i>
						</a>
					<?php } ?>
					
					</td>
					<td>
					<?php 
					if($report->nilai_akhir != ""){
						echo $report->nilai_akhir; 
					}else{
						echo "-";
				} ?>
					</td>
					
					<?php if(isset($id_program)){ ?>
					<?php if($id_program == 4|| $id_program == 5 || $id_program ==26 ){ ?>
					<td><?php if($report->nilai_akhir >= 70){echo "Lulus";}else{echo "Tidak Lulus";} ?></td>
					<?php } }?>
			
					
					
					<td>
						<!--<button class="btn btn-danger btn-xs" id="btnSertifikat" onclick="download_sertifikat('<?php echo $report->nip_peserta;?>','<?php echo $report->program_id;?>','<?php echo $report->angkatan_id;?>')">
							<i class="glyphicon glyphicon-print"></i> Sertifikat
						</button>-->
						
						<a class="btn btn-danger btn-xs" id="btnSertifikat" href="<?php echo base_url('sertifikat/print_sertifikat/'.$report->nip_peserta.'/'.$report->program_id.'/'.$report->angkatan_id)?>">
							<i class="glyphicon glyphicon-print"></i> Sertifikat
						</a>
					</td>
				</tr>
		<?php }		
		}?>
      </tbody>
    </table>
</div>
</div>
  
<style type="text/css">
.font {
	font-family: 'TangerineBold';
}
</style>
 
  <script type="text/javascript">
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	
	$(document).ready( function () {
		$('#example').DataTable( {
		"pagingType": "full",
		preDrawCallback: function (settings) {
			var api = new $.fn.dataTable.Api(settings);
			var pagination = $(this)
				.closest('.dataTables_wrapper')
				.find('.dataTables_paginate');
			pagination.toggle(api.page.info().pages > 1);
		}
		} );
		
		document.getElementById("btnExport").setAttribute("disabled", "disabled"); 
		
		if($('[name="ang_id"]').val().length !=0 && $('[name="prog_id"]').val().length !=0){
		   document.getElementById('btnExport').removeAttribute("disabled");
		}
	});
    
	$("#printBtn").click(function(){
		printcontent($("#content").html());
	});

	function printcontent(content){
		var mywindow = window.open('', '', '');
		mywindow.document.write('<html><title>Cetak Sertifikat <style media="print"> .font { font-family: \"TangerineBold\"; } </style></title><body>');
		mywindow.document.write("");
		mywindow.document.write(content);
		mywindow.document.write('</body></html>');
		mywindow.document.close();
		mywindow.print();
		return true;
	}
	
	function export_to_excel(status_lisan, status_tulis, program_id, angkatan_id){
		var url;
		if(status_lisan == 'true' && status_tulis == 'true') {
			url = "<?php echo site_url('/sertifikat/export_excel')?>/" + program_id +"/" + angkatan_id,
		
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
				   
					location.reload();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Gagal","Gagal export data.","error");
				}
			});
		}else{ 
			swal("Warning","Nilai Ujian Lisan dan/atau Tulis belum lengkap","warning");
		}
    }
	
    var save_method; //for save method string
    var table;
 
    function download_sertifikat(id, prg_id, ang_id)
    {
		save_method = 'download';
		$('#form')[0].reset(); // reset form on modals
 
		//Ajax Load data from ajax
		$.ajax({
        url : "<?php echo site_url('/Sertifikat/get_sertifikat/')?>/" + id +"/" + prg_id + "/" + ang_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			document.getElementById('nama_program').innerHTML = data.nama_program_lengkap;
			document.getElementById('nama_angkatan').innerHTML = data.nama_angkatan + " - Tahun 2016";
			document.getElementById('nama_peserta').innerHTML = data.nama;
			document.getElementById('nip_peserta').innerHTML = "NIP : " + data.nip_peserta;
			document.getElementById('divisi').innerHTML = data.divisi;
			document.getElementById('nilai_rata_rata').innerHTML = "<hr/>" + data.nilai_rata ;
			document.getElementById('nilai_akhir').innerHTML = data.nilai_akhir + "<hr/>";
			document.getElementById('nilai_tulis').innerHTML = data.nilai_tulis;
			document.getElementById('nilai_lisan').innerHTML = data.nilai_lisan;
			
			printcontent($("#content").html());
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
	  });
    }
  </script>
 
<div id="content" hidden="true">
<img src="<?php echo base_url()?>assets/images/border.jpg" style="position: absolute;width: 100%;height:auto; left:0px; top:0px; z-index:-1;">
<br><br>
<table align="center" width="80%">
	<tr align="center">
		<td><h2 name="nama_program" id="nama_program"></h2></td>
	</tr>
	<tr align="center">
		<td>
			<h4 id="nama_angkatan"></h4>
		</td>
	</tr>
	<tr align="center">
		<td>
			<h3 id="nama_peserta" class="fontsforweb_fontid_1061"><br></h3>
			<h4 id="nip_peserta"></h4>
			
		</td>
	</tr>
	<tr align="center">
		<td>
			<h4 id="divisi"></h4>
		</td>
	</tr>
	<tr align="center">
		<td>
			<table width="100%" style="border-style: none;" border=0>
				<tr>
					<td width="2%">No. </td>
					<td>Jenis Ujian </td>
					<td align="center">Nilai</td>
				</tr>
				<tr>
					<td align="center">1</td>
					<td>Ujian Tertulis</td>
					<td id="nilai_tulis" align="center"></td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>Ujian Lisan</td>
					<td id="nilai_lisan" align="center"></td>
				</tr>
				<tr>
					<td colspan="2">Nilai Rata-rata Kelas</td>
					<td id="nilai_rata_rata" align="center"></td>
				</tr>
				<tr>
					<td colspan="2">Nilai Akhir : Ujian Tertulis (20%) + Ujian Lisan (80%)</td>
					<td id="nilai_akhir" align="center"></td>
				</tr>
			</table>
		</td>
	</tr>
	<br>
	<tr align="center">
		<td><br>Jakarta, <?php echo date("d F Y") ?> </td>
	</tr>
</table>
<br>
<table align="center">
	<tr align="center">
		<td width="20%">
			Kepala Divisi
			<br><br><br><br>
			(Lena Setiawati)
		</td>
		<td width="60%">
		</td>
		<td width="20%">
			Kepala Biro
			<br><br><br><br>
			(L. Melly Gunawan)
		</td>
	</tr>
</table> 
</div>
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Program</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          
 
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
	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	
  </body>
</html>