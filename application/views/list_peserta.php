<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>DAFTAR PESERTA</h3>
	<h4>Program : <?php if(!empty($program)){ echo $program->nama_program;} ?>, Angkatan : <?php if(!empty($angkatan)){ echo $angkatan->nama_angkatan;} ?></h4>

    <br />
	
	<div class="btn-group">
		<table>
			<tr>
				<td>
					<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" data-target="#">
						<?php if(!empty($angkatan)){echo $angkatan->nama_angkatan;}else{ echo "Pilih Angkatan";} ?>  <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
						<?php foreach($listAngkatan as $angkatan) { ?>
							<li><a href="<?php echo base_url("peserta/show_peserta/".$angkatan->angkatan_id."/".$angkatan->program_id); ?>"><?php echo $angkatan->nama_angkatan; ?></a></li>
						<?php } ?>
					</ul>
				</td>
				
				<td>
					<button class="btn btn-success btn-sm dropdown-toggle" onclick="generate_kode_unik(<?php if(isset($angkatan_id)){echo $angkatan_id;}else{echo "";} ?>)"><i class="glyphicon glyphicon-edit"></i> Generate Kode Unik </button>
				</td>
				
				<td>
					<a class="btn btn-success btn-sm" href="<?php echo base_url('peserta/export_excel/'.$angkatan_id.'') ?>"><i class="glyphicon glyphicon-download"></i> Unduh </a>
				</td>
			</tr>
		</table>
	</div>
	<hr>
	<table align="center">
		<?php if(!empty($message)){ ?>
			<tr>
				<td colspan="3">
					<div class="alert alert-warning fade in" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php echo $message; ?>
					</div>
				</td>
			</tr>
		<?php } ?>
		
		<tr>
			<td width="135px">
				<b>Upload Data:</b>
				<a type="button" onclick="show_template()" class="btn btn-secondary btn-sm" data-container="body" data-toggle="popover" style="border-style: double;border-color: #c0baba;border-radius: 4px;" data-placement="right">
						<i class="glyphicon glyphicon-info-sign"></i>
					</a>
			</td>
			<form method="post" action="<?php echo base_url('Peserta/importcsv') ?>" enctype="multipart/form-data">
				<td width="20px">
					<div class="panel panel-default" style="margin-bottom: 0px;">
					
						<input type="hidden" name="angk_id" id="angk_id" value="<?php if(!empty($angkatan_id)){ echo $angkatan_id;} ?>">
						<input type="hidden" name="prg_id" id="prg_id" value="<?php if(!empty($prog_id)){ echo $prog_id; } ?>">
						<input type="hidden" name="nama_prog" value="<?php if(!empty($program)){ echo $program->nama_program;} ?>">
						<input type="hidden" name="nama_angk" value="<?php if(!empty($angkatan)){ echo $angkatan->nama_angkatan;} ?>">
						<input type="file" id="btnPlaceOrder" name="btnPlaceOrder" class="btn btn-sm" style="width: 300px;" name="btnPlaceOrder" required >
				</td>
				<td>
					<input type="submit" class="btn btn-warning btn-sm" value="Import" >
					</div>
					
				</td>
			</form>
		</tr>
	</table>

    <br/><br/>
    <div class="table-responsive">
    <table id="example" class="table table-striped"  cellspacing="0" width="100%" style="font-size: small;">
      <thead>
        <tr>
			<th width="10px">No.</th>
			<th>NIP</th>
			<th>Nama</th>
			<th>Kode Unik</th>
			<th style="min-width:150px;" width="120px">Lampiran</th>
			<th style="width:150px;">Action</th>
        </tr>
      </thead>
      <tbody>
	<?php 
	$i = 1;
	foreach($peserta as $peserta){?>
	     <tr>
			 <td style="padding-left: 2px; padding-right: 2px;"><?php echo $i++;?></td>
			 <td style="padding-left: 2px; padding-right: 2px;"><?php echo $peserta->nip; ?></td>
			 <td style="padding-left: 2px; padding-right: 2px;"><?php echo $peserta->nama; ?></td>
			 <td style="padding-left: 2px; padding-right: 2px;"><?php echo $peserta->kode_unik; ?></td>
			 <td style="padding-left: 2px; padding-right: 2px;">
				<?php if(isset($peserta->file_lampiran) && $peserta->file_lampiran != "") { ?>
					<button class="btn btn-success btn-xs" onclick="show_upload(<?php echo $peserta->peserta_id;?>,<?php echo $peserta->nip;?>)">Re-upload</button> 
					<a href="<?=base_url ()?>peserta/download/<?php echo $peserta->file_lampiran; ?>" target="_blank"><?php echo $peserta->file_lampiran; ?></a> 
					<button class="close" style="cursor: pointer; color: red;" onclick="delete_file('<?php echo $peserta->file_lampiran;?>','<?php echo $peserta->peserta_id;?>')">&times;</button>
					
					
				<?php }else if(isset($peserta->file_lampiran) &&$peserta->file_lampiran == ""){?>
					<button class="btn btn-success btn-xs"onclick="show_upload(<?php echo $peserta->peserta_id;?>,<?php echo $peserta->nip;?>)" >Upload</button>
				<?php } ?>
			 </td>
			 <td style="padding-left: 2px; padding-right: 2px;" width="170px">
				<button class="btn btn-success btn-xs" onclick= "generate_kode_unik_peserta(<?php echo $peserta->peserta_id;?>)"><i class="glyphicon glyphicon-edit"></i> Kode Unik</button>
				<button class="btn btn-danger btn-xs" onclick="unenrol('<?php echo $peserta->peserta_id; ?>','<?php echo $peserta->angkatan_id; ?>')"><i class="glyphicon glyphicon-remove"></i> Remove</button>
			</td>
	    </tr>
	<?php }?>
      </tbody>
    </table>
	</div>	
	</div>
  </div>
  
  <!-- search & paging -->
 
  <script type="text/javascript">
	
  $(document).ready(function() {
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
  
	  $(".search").keyup(function () {
	    var searchTerm = $(".search").val();
	    var listItem = $('.results tbody').children('tr');
	    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
	    
	  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
		return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	    }
	  });
	    
	  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
	    $(this).attr('visible','false');
	  });

	  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
	    $(this).attr('visible','true');
	  });

	  var jobCount = $('.results tbody tr[visible="true"]').length;
	    $('.counter').text(jobCount + ' item');

	  if(jobCount == '0') {$('.no-result').show();}
	    else {$('.no-result').hide();}
			  });
  });
  
    var save_method; //for save method string
    var table;

	function show_template()
    {
      $('#form')[0].reset(); // reset form on modals
      $('#modal_template').modal('show'); // show bootstrap modal
      $('#modal_form_karyawan').modal('hide');
      $('#modal_form_peserta').modal('hide');
      $('.modal-title').text('Template CSV'); // Set Title to Bootstrap modal title
    }
	
	function show_upload(id, nip)
    {
      $('#form')[0].reset(); // reset form on modals
      $('#modal_upload_lampiran').modal('show'); // show bootstrap modal
      $('#modal_form_karyawan').modal('hide');
      $('#modal_form_peserta').modal('hide');
	   $('[name="id_p"]').val(id);
	   $('[name="nip"]').val(nip);
	  $('#modal_template').modal('hide');
      $('.modal-title').text('Upload Lampiran'); // Set Title to Bootstrap modal title
    }
	
    function enrol_peserta()
    {
		$('#form')[0].reset(); // reset form on modals
		//resetForm($('#modal_form_peserta')); 
	
		//set empty table
		var table = $('#tabel_peserta');
		$("#tabel_peserta tbody").remove(); 
	
		//Ajax Load data from ajax
		$.ajax({
			url : "<?php echo site_url('/peserta/ajax_enrol/')?>/",
			type: "GET",
			dataType: "JSON",
			success: function(data){
				for (var i = 0; i < data.length; i++) {
					table.append("<tr><td>" + parseInt(i+1) + "</td><td>" + data[i].nip + "</td><td>" + data[i].nama + 
					"</td><td><input type=\"checkbox\" name=\"enrol[]\" id=\"enrol[]\" value=" + data[i].id + "></td><td> "+
					"</td></tr>");
					
				}
				$('#modal_form_peserta').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Daftar Peserta '); // Set title to Bootstrap modal title
			}, error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
    }
    
    function unenrol_peserta(id)
    {
		if(confirm('Apakah anda yakin ingin unenrol?'))
		{
			var url; 
			url = "<?php echo site_url('/Peserta/unenrol_peserta/')?>" + id ;
			
			$.ajax({
				url : url,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
				   //if success close modal and reload ajax table
				   alert('Berhasil unenrol.');
				   location.reload();// for reload a page
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				alert('Gagal enrol peserta.');
				}
			});
		}
    }
	
	function unenrol(id, ang)
    {
		var url; 
		swal({
			title: "Apakah anda yakin ingin unenrol? ",
			text: "Peserta akan keluar dari program dan angkatan!",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Tutup",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			
			swal({
			  title: "Sukses!",
			  text: "Data sukses ditambah/diubah!",
			  type: "success",
			  confirmButtonText: "OK"
			},
			function(isConfirm){
			  if (isConfirm) {
				  window.location =  "<?php echo base_url();?>peserta/unenrol_peserta/"+id+"/"+ang;
			  }
			});
		});
    }
    
    function enrol_karyawan(angkatan_id, program_id)
    {
		var url;
		
		if($('input[name="enrol[]"]').is(':checked')){
			
			var peserta = [];
			$("input[type=checkbox][name='enrol[]']:checked").each(function() {
				peserta.push($(this).val()); 
			});
			
			//alert(peserta);
			var strArr = JSON.stringify( peserta );
			
			$.ajax({
				url : "<?php echo base_url();?>peserta/enrol2/"+angkatan_id+"/"+program_id,
				type: "POST",
				data: {data:strArr.toString()},
				dataType: "JSON",
				success: function(data)
				{
				   //if success close modal and reload ajax table
				   $('#modal_form').modal('hide');
				   
				  swal({
					  title: "Sukses!",
					  text: "Data sukses ditambah/diubah!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				  
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Gagal","Gagal mendaftarkan peserta.","error");
				}
			});
			
			
		}else{
			swal("Gagal","Tidak ada data yang dipilih.","error");
		}
		
    }
 
    function tambah_karyawan(angkatan_id)
    {
      save_method = 'addkaryawan';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form_karyawan').modal('show'); // show bootstrap modal
      $('#modal_form_peserta').modal('hide');
	  $('[name="angkatan_id"]').val(angkatan_id);
      $('.modal-title').text('Tambah Peserta'); // Set Title to Bootstrap modal title
    }
 
    function save_karyawan()
    {
		var url;
      
		if(document.getElementById('nip').value != "" && document.getElementById('nama_peserta').value != "" && document.getElementById('divisi_peserta').value != ""  ){
			if(save_method == 'addkaryawan')
			{
				url = "<?php echo site_url('/karyawan/karyawan_add')?>";
			}
			else{
				url = "<?php echo site_url('/karyawan/karyawan_update')?>";
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
				   
				  
				  swal({
					  title: "Sukses!",
					  text: "Data sukses ditambah/diubah!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				  
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Gagal","Gagal menambah / menghapus data.","error");
				}
			});
		}else{
			swal("Gagal","Gagal menambahkan data. Pastikan semua field terisi.","error");
		}
    }
	
	function upload_file()
    {
		var url;
      
		if(document.getElementById('userfile').value != ""){
			
			url = "<?php echo site_url('/peserta/do_upload')?>";
			
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
				   
				  swal({
					  title: "Sukses!",
					  text: "File berhasil di upload!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				  
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Gagal","Gagal menambah / menghapus data.","error");
				}
			});
		}else{
			swal("Gagal","Gagal menambahkan data. Pastikan semua field terisi.","error");
		}
    }
 
    function delete_karyawan(id)
    {
      if(confirm('Yakin ingin hapus data karyawan?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('/Peserta/karyawan_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
      }
    }
    
    function generate_kode_unik_peserta(id)
    {
		swal({
			title: "Apakah anda yakin ingin generate kode unik?",
			text: "Kode unik peserta akan di-reset.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Tutup",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			  $.ajax({
				url : "<?php echo site_url('/Peserta/generate_kode_unik_peserta/')?>" +id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal({
					  title: "Sukses!",
					  text: "Kode Unik seluruh peserta berhasil digenerate!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				   
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Oops..","Data gagal di-reset!","error");
				}
			});
		});
		
    }
	
	function delete_file(filename, id)
    {
		swal({
			title: "Apakah anda yakin ingin hapus lampiran?",
			text: "File akan terhapus.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Tutup",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			  $.ajax({
				url : "<?php echo site_url('/Peserta/delete_file/')?>" +filename +"/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal({
					  title: "Sukses!",
					  text: "Lampiran berhasil dihapus!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Oops..","Lampiran gagal dihapus!","error");
				}
			});
		});
		
    }
    
    function generate_kode_unik(angkatan_id)
    {
		swal({
			title: "Apakah anda yakin ingin generate kode unik?",
			text: "Seluruh Kode unik akan di-reset.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Tutup",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			  $.ajax({
				url : "<?php echo site_url('/Peserta/generate_kode_unik/')?>" +angkatan_id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal({
					  title: "Sukses!",
					  text: "Kode Unik seluruh peserta berhasil digenerate!",
					  type: "success",
					  confirmButtonText: "OK"
					},
					function(isConfirm){
					  if (isConfirm) {
						location.reload();
					  }
					});
				   
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal("Oops..","Data di-reset!","error");
				}
			});
		});
    }
    
  </script>
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form_karyawan" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Tambah Karyawan</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
	<!-- Hidden -->
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">NIP</label>
              <div class="col-md-8">
                <input name="nip" id="nip" placeholder="NIP" class="form-control" type="text">
              </div>
	    </div>
	    <div class="form-group">
	      <label class="control-label col-md-3">Nama</label>
              <div class="col-md-8">
                <input name="nama" id="nama_peserta" placeholder="Nama" class="form-control" type="text">
              </div>	  
            </div>
	    <div class="form-group">
	      <label class="control-label col-md-3">Unit Kerja</label>
              <div class="col-md-8">
                <input name="divisi" id="divisi_peserta" placeholder="Unit Kerja" class="form-control" type="text">
              </div>  
            </div>
	    
			<input type="hidden" value="0" name="angkatan_id"/>
			
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save_karyawan()" class="btn btn-primary btn-xs">Simpan</button>
            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Kembali</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form_peserta" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Enrol Peserta</h3>
      </div>
      <div class="modal-body form">
      <div class="table-responsive">
	<div class="form-group pull-right" style="padding-right:0px;">
	    <input type="text" class="search form-control" placeholder="Cari"><br>
		
	</div>
	<button class="btn btn-success btn-sm" onclick="tambah_karyawan('<?php echo $angkatan_id; ?>')"><i class="glyphicon glyphicon-plus"></i> Tambah Baru   </button>
	<span class="counter pull-right"></span>
		<form name="form_enrol" method="POST" action="<?php echo base_url('peserta/enrol'); ?>" class="form-horizontal">
		<!--<form action="#" id="form" class="form-horizontal">-->
		<input type="hidden" name="ang_id" value="<?php echo $angkatan_id; ?>">
		<input type="hidden" name="prg_id" value="<?php echo $prog_id; ?>">
		<div class="col-sm-12 col-sm-offset-0" style="top:20px; bottom:10px;height:500px;">
		
        <table id="tabel_peserta" class="table table-hover table-striped results" cellspacing="0" width="100%">
	      <thead>
			<tr>
				<th width="10px">No.</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Enrol</th>
			</tr>
			<tr class="warning no-result">
			  <td colspan="4"><i class="fa fa-warning"></i> No result</td>
			</tr>
	      </thead>
	      <tbody>
		
	      </tbody>
	    </table>
		</div>
	    </div>
          </div>
          <div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-xs"> Tambah Ke Daftar </button>
			<!--<button type="button" id="btnSave" onclick="enrol_karyawan('<?php echo $angkatan_id; ?>','<?php echo $prog_id; ?>')" class="btn btn-primary btn-xs">Tambah Ke Daftar</button>-->
			<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal"> Tutup </button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_template" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Template</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
		<font style="font-size: smaller;">Judul Kolom :  <b>nip, nama </b></font><br>
		<font style="font-size: smaller;">Nama File: <b>[nama_file].csv</b></font>
		<!-- Hidden -->
			<table align="center" class="table table-bordered" style="font-size: smaller;">
				<tr align="center">
					<td> <b>nip</b> </td>
					<td> <b>nama</b> </td>
				</tr>
				<tr>
					<td> 50265 </td>
					<td> DINO FERDINAL </td>
				</tr>
				<tr>
					<td> 50284 </td>
					<td> WIRYA SETIAWAN </td>
				</tr>
			</table>
        </form>
          </div>
      
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
  <div class="modal fade" id="modal_upload_lampiran" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Upload Lampiran</h3>
      </div>
      <div class="modal-body form" style="height:70px;">
	  <?php echo form_open_multipart('peserta/do_upload/');?> 
		
			<!-- Hidden -->
				<input type="hidden" value="" name="id_p"/>
				<div class="form-body">
					<div class="form-group">
						<label class="control-label col-md-3">File</label>
						<div class="col-md-8">
							<input name="lampiran" id="lampiran" placeholder="File" class="form-control" type="file">
						</div>
					</div>
					<input type="hidden" value="0" name="angkatan_id"/>
					<input type="hidden" value="" name="nip"/>
				</div>
	  </div>
	  <div class="modal-footer">
		<input class="btn btn-primary btn-xs" type = "submit" value = "Upload" /> 
		</form> 
		<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Kembali</button>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <!-- End Bootstrap modal -->  

<?php include 'display/footer2.php';?>	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	

  </body>
</html>