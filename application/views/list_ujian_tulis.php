<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>DAFTAR NILAI UJIAN TULIS 	</h3>
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
								<li><a href="<?php echo base_url("UjianTulis/show_ujian_tulis/".$prg->id); ?>"><?php echo $prg->nama_program; ?></a></li>
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
							<li><a href="<?php echo base_url("UjianTulis/show_ujian_tulis2/".$id_program."/".$angk->angkatan_id); ?>"><?php echo $angk->nama_angkatan; ?></a></li>
						<?php 
						}
						} ?>
					</ul>
				</div>
			</td>
			<?php if(empty($ang_id)){ $ang_id = 0; } ?>
			<?php 
				if(!empty($jumlah_penguji)){ 
					$jlh_penguji = $jumlah_penguji->jumlah_penguji; 
				}else{
					$jlh_penguji = 0;
				}
			?>
		</tr>
		
	</table>
	<hr>

	<table align="center">
		<?php if(!empty($message)){ ?>
			<tr>
				<td colspan="3">
					<div class="alert alert-success fade in" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php echo $message; ?>
					</div>
				</td>
			</tr>
		<?php } ?>
		<form method="post" action="<?php echo base_url('UjianTulis/importcsv') ?>" enctype="multipart/form-data">
		<tr>
			<td width="135px">
				<b>Upload Data:</b>
				<a type="button" onclick="show_template()" class="btn btn-secondary btn-sm" data-container="body" data-toggle="popover" style="border-style: double;border-color: #c0baba;border-radius: 4px;" data-placement="right">
						<i class="glyphicon glyphicon-info-sign"></i>
					</a>
			</td>
			<td width="20px">
				<div class="panel panel-default" style="margin-bottom: 0px;">
				  
						<input type="hidden" name="angk_id" id="angk_id" value="<?php if(!empty($ang_id)){ echo $ang_id; } ?>">
						<input type="hidden" name="prg_id" id="prg_id" value="<?php if(!empty($id_program)){ echo $id_program; } ?>">
						<input type="hidden" name="nama_prog" value="<?php if(!empty($program)){ echo $program->nama_program;} ?>">
						<input type="hidden" name="nama_angk" value="<?php if(!empty($angkatan)){ echo $angkatan->nama_angkatan;} ?>">
						
						<input type="file" id="btnPlaceOrder" name="btnPlaceOrder" class="btn btn-sm" accept=".csv"  style="width: 300px;"  disabled="disabled" required >
				</div>
			</td>
			
			<td>
				<input type="submit" id="import" name="import" class="btn btn-warning btn-sm" value="Import" >
				</div>
			</td>
			</form>
		</tr>
	</table>

    <br />
    <table id="example" class="table table-striped table-hover" cellspacing="0" width="100%" style="font-size: 14;">
      <thead>
        <tr>
			<th width="10px">No.</th>
			<th>NIP - Nama</th>
			<th>Program</th>
			<th>Angkatan</th>
			<th>Posttest Score</th>
			<th style="width:110px;">Action</th>
        </tr>
      </thead>
      <tbody id="table_body">
		<?php 
		if(isset($ujian_tulis)){
			$i = 1;
			foreach($ujian_tulis as $tulis){?>
				 <tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $tulis->id_peserta;?> - <?php echo $tulis->nama;?></td>
				<td><?php echo $tulis->nama_program;?></td>
				<td><?php echo $tulis->nama_angkatan;?></td>
				<td><?php echo $tulis->posttest_score;?></td>
				
				<td>
					<button class="btn btn-danger btn-xs" onclick="delete_ujian_tulis(<?php echo $tulis->id;?>, <?php echo $tulis->angkatan_id;?>,<?php echo $tulis->id_program;?>)"><i class="glyphicon glyphicon-trash"></i></button>
					<!--<button class="btn btn-warning btn-xs" onclick="edit_ujian_tulis(<?=$tulis->id;?>, <?=$tulis->id_program;?>, <?=$tulis->angkatan_id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>-->
				</td>
				  </tr>
		 <?php }	
			
		}?>
		
      </tbody>
    </table>
 
 </div>
 </div>
   
  <script type="text/javascript">
  
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
	
    document.getElementById("btnPlaceOrder").setAttribute("disabled", "disabled"); 
    document.getElementById("import").setAttribute("disabled", "disabled"); 
	if($('[name="angk_id"]').val().length !=0){
	   document.getElementById('btnPlaceOrder').removeAttribute("disabled");
	   document.getElementById('import').removeAttribute("disabled");
	}
	
	if($('[name="angk_id"]').val().length ==0 && $('[name="prog_id"]').val().length ==0){
		document.getElementById("table_body").style.visibility = 'hidden';
	}
		
});
    
	
    var save_method; //for save method string
    var table;
 
    function add_program()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_ujian_tulis(id, id_program, id_angkatan)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/Ujiantulis/ajax_edit/')?>/" + id +"/" + id_program+ "/" + id_angkatan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
			$('[name="nip"]').val(data.id_peserta);
			$('[name="nama"]').val(data.nama);
            $('[name="nama_program"]').val(data.nama_program);
            $('[name="nama_angkatan"]').val(data.nama_angkatan);
            $('[name="score"]').val(data.posttest_score);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Ujian Tulis'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
	  });
    }
	
	function save(){
		var url;
	  
		if(document.getElementById('score').value != ""){
			if(save_method == 'add')
			{
				url = "<?php echo base_url('/UjianTulis/program_add')?>";
			}
			else
			{
				url = "<?php echo base_url('/UjianTulis/ujian_tulis_update')?>";
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
	
    function save2(id_program,angkatan_id)
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo base_url('/UjianTulis/program_add')?>";
      }
      else
      {
        url = "<?php echo base_url('/UjianTulis/ujian_tulis_update')?>";
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
					window.location =  "<?php echo site_url('/Ujiantulis/show_ujian_tulis2')?>/"+id_program+"/"+angkatan_id;
				  }
				});
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
	
	function delete_ujian_tulis(id, angkatan_id, id_program)
    {
		var url; 
		swal({
			title: "Apakah anda yakin ingin hapus?",
			text: "Data yang dihapus tidak dapat di-recover!",
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
			  title: "Terhapus!",
			  text: "Data berhasil dihapus!",
			  type: "success",
			  confirmButtonText: "OK"
			},
			function(isConfirm){
			  if (isConfirm) {
				  window.location =  "<?php echo site_url('/Ujiantulis/delete_ujian_tulis')?>/"+id+"/"+angkatan_id+"/"+id_program;
			  }
			});
		});
    }
 
  </script>
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Ujian Tulisan</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
		  
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">NIP</label>
              <div class="col-md-8">
                <input name="nip" placeholder="nip" class="form-control" type="text" disabled>
              </div>
            </div>
			
			<div class="form-group">
              <label class="control-label col-md-3">Nama</label>
              <div class="col-md-8">
                <input name="nama" placeholder="nama" class="form-control" type="text" disabled>
              </div>
            </div>
			
			<div class="form-group">
              <label class="control-label col-md-3">Program</label>
              <div class="col-md-8">
                <input name="nama_program" placeholder="nama_program" class="form-control" type="text" disabled>
              </div>
            </div>
			
			<div class="form-group">
              <label class="control-label col-md-3">Angkatan</label>
              <div class="col-md-8">
                <input name="nama_angkatan" placeholder="nama_angkatan" class="form-control" type="text" disabled>
              </div>
            </div>
			
			<div class="form-group">
              <label class="control-label col-md-3">Score</label>
              <div class="col-md-8">
                <input name="score" id="score" placeholder="score" class="form-control" type="number">
			
              </div>
            </div>
 
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save2(<?=$id_program;?>,<?=$ang_id;?>)" class="btn btn-primary btn-xs">Simpan</button>
			<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Batal</button>
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
<style>
#modal-dialog{
	width:'auto';
	height:'auto';
	'max-height':'100%'});
});
</style>

 <!-- Bootstrap modal -->
  <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="size:contain;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Template CSV</h3>
      </div>
      <div class="modal-body form">
	  
	  <table>
		<tr>
			<td><font style="font-size: smaller;">Judul kolom </font></td>
			<td>:<font style="font-size: smaller;"><b>id_peserta, nama, course_name, time_spent, posttest_score, tanggal</b></font></td>
		</tr>
		<tr>
			<td><font style="font-size: smaller;">Nama File</font></td>
			<td>:<font style="font-size: smaller;"><b>Ujian Tulis_(Nama Program)_(Nama Angkatan)_(Tanggal Ujian Lisan).csv</b></font></td>
		</tr>
		<tr>
			<td><font style="font-size: smaller;">Contoh</font></td>
			<td>:<font style="font-size: smaller;"><b>Ujian Tulis_P2M Cabang_Angkatan 11_12-02-2017.csv</b></font></td>
		</tr>
	  </table>
	  
        <form action="#" id="form" class="form-horizontal">
		<br>
		
	
		<!-- Hidden -->
			<table align="center" class="table table-bordered" style="font-size: smaller;">
				<tr align="center">
					<td> <b>id_peserta</b> </td>
					<td> <b>nama</b> </td>
					<td> <b>course_name</b> </td>
					<td> <b>time_spent</b> </td>
					<td> <b>posttest_score</b> </td>
					<td> <b>tanggal</b> </td>
				</tr>
				<tr>
					<td> 20010388 </td>
					<td> Bpk BAMBANG YULIANTO </td>
					<td> E-LEARNING ASSESSMENT MUDA 1 KP </td>
					<td> 0:54:00 </td>
					<td> 84 </td>
					<td> 10/08/2017 </td>
					
				</tr>
				<tr>
					<td> 52146 </td>
					<td> Bpk LIE EDWIN ST </td>
					<td> E-LEARNING ASSESSMENT MUDA 1 KP</td>
					<td> 0:49:00 </td>
					<td> 85 </td>
					<td> 10/08/2017 </td>
				</tr>
			</table>
        
        </form>
          </div>
      
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->