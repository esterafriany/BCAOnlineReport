<?php include 'display/header.php';?>
<div class="container">
	<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>Daftar Kriteria Program: <?php if(!empty($program)){ echo $program->nama_program;} ?> </h3>
	<br>
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
							<li><a href="<?php echo base_url("kriteria/show_kriteria/".$program->id); ?>"><?php echo $program->nama_program; ?></a></li>
						<?php							
						}
					} ?>
				</ul>
				</div>
			</td>
			<td><button class="btn btn-success btn-sm" onclick="add_kriteria(<?php echo $program_id; ?>)"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
			</td>
		</tr>
	</table>
    <br>
	
    <table id="bootstrap-table" class="table table-hover table-striped " cellspacing="0" width="100%">
      <thead>
        <tr>
			<th width="10px">#</th>
			<th>Nama Kriteria</th>
			<th>Bobot Nilai</th>
			<th style="width:75px;">Action</th>
        </tr>
      </thead>
      <tbody>
	<?php 
	$i = 1;
	foreach($kriterias as $kriteria){?>
	     <tr>
		 <td><?php echo $i++;?></td>
		 <td><?php echo $kriteria->kriteria_penilaian; ?></td>
		 <td><?php echo $kriteria->komposisi_nilai; ?>%</td>
			<td>
				<button class="btn btn-warning btn-xs" onclick="edit_kriteria(<?php echo $kriteria->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
				<button class="btn btn-danger btn-xs" onclick="delete_kriteria(<?php echo $kriteria->id;?>)"><i class="glyphicon glyphicon-trash"></i></button>
			</td>
	      </tr>
	<?php }?>
      </tbody>
    </table><br><br>
 
  </div>
 </div>
<script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
 
<script type="text/javascript">
  
	$(document).ready( function () {
		$('#bootstrap-table').bdt();
	});
  
    var save_method; //for save method string
    var table;
 
 
    function add_kriteria($id)
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('[name="program_id"]').val($id);
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_kriteria(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/kriteria/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="kriteria_penilaian"]').val(data.kriteria_penilaian);
            $('[name="keterangan"]').val(data.keterangan_penilaian);
            $('[name="komposisi_nilai"]').val(data.komposisi_nilai);
            $('[name="program_id"]').val(data.program_id);
			
 
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Kriteria'); // Set title to Bootstrap modal title
 
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
      
		if(document.getElementById('komposisi_nilai').value != "" && document.getElementById('keterangan').value != "" && document.getElementById('kriteria_penilaian').value != ""){
		if(save_method == 'add')
		{
			url = "<?php echo site_url('/kriteria/kriteria_add')?>";
		}else{
			url = "<?php echo site_url('/kriteria/kriteria_update')?>";
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
 
    function delete_kriteria(id)
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
				url : "<?php echo site_url('/kriteria/kriteria_delete')?>/"+id,
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
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Tambah Kriteria</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
	  <input type="hidden" value="" name="program_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-4">Kriteria Penilaian</label>
              <div class="col-md-7">
                <input name="kriteria_penilaian" id="kriteria_penilaian" placeholder="Kriteria Penilaian" class="form-control" type="text">
              </div>
			</div>
			<div class="form-group">
              <label class="control-label col-md-4">Keterangan</label>
              <div class="col-md-7">
                <textarea name="keterangan" id="keterangan" placeholder="Keterangan Penilaian" class="form-control" rows="4"></textarea>
              </div>
			</div>
	    <div class="form-group">
	      <label class="control-label col-md-4">Komposisi Nilai</label>
              <div class="col-md-5">
                <input name="komposisi_nilai" id="komposisi_nilai" placeholder="Komposisi Nilai" class="form-control" type="number">
              </div>
			  <div class="col-md-2">
                <label class="control-label col-md-4"> %</label>
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
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.bdt.js" type="text/javascript"></script>
	<script>
	wow = new WOW(
	 {
	
		}	) 
		.init();
	</script>
	
  </body>
</html>