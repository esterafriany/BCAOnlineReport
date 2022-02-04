<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>JADWAL UJIAN LISAN </h3>
	<table>
		<tr>
			<td>
				<div class="dropdown">
				<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-warning btn-sm" data-target="#">
					<?php if(!empty($program)){echo $program->nama_program;}else{ echo "Pilih Program";} ?>  <span class="caret"></span>
				</a>
				<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
					<?php foreach($listPrograms as $program) {
						if($program->id !=0){
							?>
							<li><a href="<?php echo base_url("ujianlisan/show_jadwal/".$program->id); ?>"><?php echo $program->nama_program; ?></a></li>
							<?php							
						}
					} ?>
				</ul>
				</div>
			</td>
			
		</tr>
	</table>
    <br>
	
    <table id="example" class="table table-hover table-striped " cellspacing="0" width="100%">
      <thead>
        <tr>
			<th width="30px">No.</th>
			<th>Program</th>
			<th>Angkatan</th>
			<th>Tanggal</th>
			<th width="140">Ubah Jadwal</th>
        </tr>
      </thead>
      <tbody>
	<?php 
	$i = 1;
	foreach($listjadwal as $jadwal){ 
	if($jadwal->id != 0){
	?>
	     <tr>
		 <td><?php echo $i++;?></td>
		 <td><?php echo $jadwal->nama_program; ?></td>
		 <td><?php echo $jadwal->nama_angkatan; ?></td>
		 <td><?php echo $jadwal->tanggal; ?></td>
			<td>
				<center><button class="btn btn-warning btn-xs" onclick="edit_jadwal('<?php echo $jadwal->angkatan_id; ?>', '<?php echo $jadwal->nama_program; ?>' , '<?php echo $jadwal->nama_angkatan; ?>', '<?php echo $jadwal->id; ?>')"><i class="glyphicon glyphicon-pencil"></i></button></center>
			</td>
	      </tr>
	<?php }
	}?>
      </tbody>
 
    </table>
	<br>
  </div>
 </div>
 
<script type="text/javascript">
	 $(function() {
		$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
	});
	
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
 
    function edit_jadwal(id_angkatan, nama_program, nama_angkatan, id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/ujianlisan/ajax_edit_jadwal/')?>/" + id_angkatan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="prg_id"]').val(id_angkatan);
            $('[name="id"]').val(data.id);
			$('[id="datepicker"]').val(data.tanggal);
            $('[name="keterangan"]').val(data.keterangan);
			
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Jadwal '+ nama_program + ' ' + nama_angkatan ); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Data Error');
        }
	  });
    }
 
 
    function save()
    {
		
		if(document.getElementById('datepicker').value != ""){
			url = "<?php echo site_url('/ujianlisan/jadwal_update')?>";
	 
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
					  text: "Data sukses diubah!",
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
	
	function reset_jadwal()
    {
		swal({
			title: "Apakah anda yakin ingin reset jadwal?",
			text: "Jadwal akan diubah menjadi 0000-00-00!",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			closeOnConfirm: false
		},
		function () {
			// ajax delete data from database
			  $.ajax({
				url : "<?php echo site_url('/ujianlisan/reset_jadwal')?>",
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal({
					  title: "Sukses!",
					  text: "Jadwal berhasil di-reset!",
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
					swal("Oops..","Data gagal di-reset.","error");
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
        <h3 class="modal-title">Ubah Jadwal</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
			<input type="hidden" value="" name="prg_id" id="prg_id" />
			<input type="hidden" value="" name="id" id="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-4">Tanggal Ujian  </label>
              <div class="col-md-6">
                <input name="selected_date" id="datepicker" Placeholder="Pilih Tanggal Ujian" class="form-control" type="text" required>
              </div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4">Keterangan </label>
              <div class="col-md-6">
                <input name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control" type="text">
              </div>
            </div>
			
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-xs">Simpan</button>
            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Kembali</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
	

<?php include 'display/footer2.php';?>
	<!-- date -->
	<!--load jquery-->
	
	<!--load jquery ui js file-->
	<script src="<?php echo base_url(); ?>assets/jqueryui/jquery-ui.js"></script>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	
  </body>
</html>