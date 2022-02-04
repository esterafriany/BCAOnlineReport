<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>DAFTAR ANGKATAN </h3>
	<h4>Program : <?php if (isset($angkatan[0])) {echo $angkatan[0]->nama_program;}  ?></h4>
	<br>
	<table>
		
		<tr>
			<td>
				<div class="dropdown">
				<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-warning btn-sm" data-target="#">
					<?php if(!empty($program)){echo $program->nama_program;}else{ echo "Pilih Program";} ?> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
					<?php foreach($listPrograms as $program) { 
						if($program->id !=0){
						?>
							<li><a href="<?php echo base_url("angkatan/show_angkatan/".$program->id); ?>"><?php echo $program->nama_program; ?></a></li>
						<?php							
						}
					?>
					<?php } ?>
				</ul>
				</div>
			</td>
			<td><button class="btn btn-success btn-sm" onclick="add_angkatan(<?php echo $program_id; ?>)"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
			</td>
		</tr>
	</table>
	<br>
	<div class="alert alert-warning" role="alert" style="padding-top: 10px; padding-left: 10px;  padding-right: 10px;   padding-bottom: 10px; margin-bottom: 15px;"><center>Klik nama angkatan untuk mengelola peserta.</center></div>
	
	<table id="example" cellspacing="0" width="100%" style="font-size: small;">
		<thead>
			<tr>
				<th>Nama Angkatan</th>
			</tr>
		  </thead>
		<tbody>
			<tr><td height="3px"></td></tr>
			<ul class="list-group">
				<?php foreach($angkatan as $ang) {
				
				if($ang->angkatan_id != 0){
				?>
					<tr>
					<td>
						
						<li class="list-group-item">
							<a href="<?php echo base_url("peserta/show_peserta/".$ang->angkatan_id."/".$program_id); ?>"><?php echo $ang->nama_angkatan; ?></a>
							<span class="badge">
							<button class="btn btn-default btn-xs" onclick="edit_angkatan(<?php echo $ang->angkatan_id;?>)" style="padding-top: 5px;border-bottom-width: 0px;"><i class="glyphicon glyphicon-pencil"></i></button>&nbsp;&nbsp;&nbsp;
							<button class="btn btn-default btn-xs" onclick="delete_angkatan(<?php echo $ang->angkatan_id;?>)" style="padding-top: 5px;border-bottom-width: 0px;"><i class="glyphicon glyphicon-trash"></i></button>
							</span>
						</li>
					</td>
				</tr>
				<?php
				}
				?>		
				
				<?php } ?>
			</ul>
		</tbody>
	</table>
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
	});
	
    var save_method; //for save method string
    var table;
 
 
    function add_angkatan($id)
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('[name="program_id"]').val($id);
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_angkatan(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/angkatan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="nama_angkatan"]').val(data.nama_angkatan);
            $('[name="program_id"]').val(data.program_id);
			
 
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Angkatan'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
	  });
    }
 
 
    function save()
    {
		if(document.getElementById('nama_angkatan').value != ""){
			if(save_method == 'add')
			{
				url = "<?php echo site_url('/angkatan/angkatan_add')?>";
			}
			else{
				url = "<?php echo site_url('/angkatan/angkatan_update')?>";
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
 
    function delete_angkatan(id)
    {
		swal({
			title: "Apakah anda yakin ingin hapus?",
			text: "Data akan dihapus tidak dapat di-recover!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			  $.ajax({
				url : "<?php echo site_url('/angkatan/angkatan_delete')?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal({
					  title: "Terhapus!",
					  text: "Data berhasil dihapus!",
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
					swal("Oops..","Data gagal dihapus.","error");
				}
			});
		});
    }
 

  </script>
	</div>
</div>
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Tambah Angkatan</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
	  <input type="hidden" value="" name="program_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nama Angkatan</label>
              <div class="col-md-8">
                <input name="nama_angkatan" id="nama_angkatan" placeholder="Nama Angkatan" class="form-control" type="text">
              </div>
	    </div>
 
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-xs">Simpan</button>
            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancel</button>
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