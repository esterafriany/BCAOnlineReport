<?php include 'display/header.php';?>
<div class="container">	
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
	<h3>DAFTAR PROGRAM 	</h3>
	<br/>
    <button class="btn btn-success btn-sm" onclick="add_program()"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
    <br/>
    <br/>
	
    <div class="alert alert-warning" role="alert" style="padding-top: 10px; padding-left: 10px;  padding-right: 10px;   padding-bottom: 10px; margin-bottom: 15px;"><center>Klik nama program untuk mengelola angkatan.</center>
	</div>
	
	<table class="table table-striped table-hover" id="example" cellspacing="0" width="100%" style="font-size: small;">
      <thead>
        <tr>
			<th style="padding-left: 2px; padding-right: 2px;" width="50px">No.</th>
			<th style="padding-left: 2px; padding-right: 2px;">Nama Program</th>
			<th style="padding-left: 2px; padding-right: 2px;">Jumlah Penguji</th>
			<th style="width:120px;">Action</th>
        </tr>
      </thead>
      <tbody>
		<?php 
		$i = 1;
		foreach($books as $book){
			if($book->id != 0){
			?>
			<tr>
				<td style="padding-left: 2px; padding-right: 2px;"><?php echo $i++;?></td>
				<td style="padding-left: 2px; padding-right: 2px;"><a href="<?php echo base_url("angkatan/show_angkatan/".$book->id); ?>"><?php echo $book->nama_program;?></a></td>
				<td style="padding-left: 2px; padding-right: 2px;"><?php echo $book->jumlah_penguji;?></td>
				<td style="padding-left: 2px; padding-right: 2px;">
					<button class="btn btn-warning btn-xs" onclick="edit_program(<?php echo $book->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
					<button class="btn btn-danger btn-xs" onclick="delete_program(<?php echo $book->id;?>)"><i class="glyphicon glyphicon-trash"></i></button>
					<a class="btn btn-warning btn-xs" href="<?php echo base_url("kriteria/show_kriteria/".$book->id); ?>"><font size="1">Kriteria</font></a>
				</td>
			</tr>
			<?php
			}
			?>
		<?php }?>
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
 
 
    function add_program()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Program '); // Set Title to Bootstrap modal title
    }
 
    function edit_program(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/program/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="nama_program"]').val(data.nama_program);
            $('[name="program_name"]').val(data.nama_program_lengkap);
			$('[name="jumlah_penguji"]').val(data.jumlah_penguji);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Program'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal('Error get data from ajax');
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
				swal('Error get data from ajax');
			}
		});
	}
 
    function save(){
		var url;
		
		if(document.getElementById('nama_program').value != "" && document.getElementById('jumlah_penguji').value != "" && document.getElementById('program_name').value != ""){
		
			if(save_method == 'add') {
				  url = "<?php echo site_url('/program/program_add')?>";
			}else{
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
 
    function delete_program(id){
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
				url : "<?php echo site_url('/program/program_delete')?>/"+id,
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
	
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
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
        <h3 class="modal-title">Program</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Program</label>
              <div class="col-md-8">
                <input name="nama_program" id="nama_program" placeholder="Program" class="form-control" type="text">
              </div>
            </div>
          </div>
		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nama Program</label>
              <div class="col-md-8">
                <input name="program_name" id="program_name" placeholder="Nama Program (akan ditampilkan di sertifikat)" class="form-control" type="text">
              </div>
            </div>
          </div>
		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Jumlah Penguji</label>
              <div class="col-md-8">
                <input name="jumlah_penguji" id="jumlah_penguji" placeholder="Jumlah Penguji" onkeypress="return isNumberKey(event)" class="form-control" type="text">
              </div>
            </div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-xs">Simpan</button>
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