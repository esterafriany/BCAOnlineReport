<?php include 'display/header.php';
$CurrentPage=$this->input->get("page");
$lastPage = ceil($Total_karyawan/10);
?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>DAFTAR KARYAWAN 	</h3>
    <br>
	<button class="btn btn-success btn-sm dropdown-toggle" onclick="tambah_karyawan()"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
    <br />

    
	<center>
	<ul class="pager">
	<?php
		foreach (range('A', 'Z') as $char) {
			if($this->input->get("page")==null)
			{
				?>
				<li><a href="karyawan/showPaged?page=1&like=<?=$char?>"><?=$char?></a></li>
			<?php
			}
			else{

				?>
			
				<li><a href="showPaged?page=<?=($CurrentPage)?>&like=<?=$char?>"><?=$char?></a></li>
			<?php
			}
		}?>
		 </ul>
	</center>
	<div class="table-responsive">
		<table class="table table-striped" id="example" cellspacing="0" width="100%" style="font-size: small;">
		  <thead>
			<tr>
				<th width="10px">No.</th>
				<th>NIP </th>
				<th>Nama</th>
				<th>Unit Kerja</th>
				<th style="width:140px;">Action</th>
			</tr>
		  </thead>
		  <tbody>
			<?php 
			if($this->input->get("page")!=null)
			{
				$i=($this->input->get("page")-1)*10+1;
			}
			else
			{
			$i = 1;
			}
			if($this->input->get("like")!=null)
			{foreach($search_karyawan as $kary){?>
				<tr>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $i++;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->nip;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->nama;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->divisi;?></td>
					<td style="padding-left: 2px; padding-right: 2px;" width="200px">
						<button class="btn btn-warning btn-xs" onclick="edit_karyawan(<?php echo $kary->id;?>)"><i class="glyphicon glyphicon-pencil"></i> </button>
						<button class="btn btn-danger btn-xs" onclick="delete_karyawan(<?php echo $kary->id;?>)"><i class="glyphicon glyphicon-trash"></i> </button>
						<a class="btn btn-warning btn-xs" href="<?php echo base_url("karyawan/show_detil_karyawan/".$kary->id); ?>"><i class="glyphicon glyphicon-search"></i> </a>
					</td>
				</tr>
				<?php
			}}
			else
			{
			foreach($karyawan as $kary){?>
				<tr>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $i++;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->nip;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->nama;?></td>
					<td style="padding-left: 2px; padding-right: 2px;"><?php echo $kary->divisi;?></td>
					<td style="padding-left: 2px; padding-right: 2px;" width="200px">
						<button class="btn btn-warning btn-xs" onclick="edit_karyawan(<?php echo $kary->id;?>)"><i class="glyphicon glyphicon-pencil"></i> </button>
						<button class="btn btn-danger btn-xs" onclick="delete_karyawan(<?php echo $kary->id;?>)"><i class="glyphicon glyphicon-trash"></i> </button>
						<a class="btn btn-warning btn-xs" href="<?php echo base_url("karyawan/show_detil_karyawan/".$kary->id); ?>"><i class="glyphicon glyphicon-search"></i> </a>
					</td>
				</tr>
			<?php }}?>
		  </tbody>
		</table>
	<center>
		<?php
		
		if($CurrentPage<0)
		{
			$CurrentPage=1;
		}
		if($this->input->get("like")!=null)
		{
			?>
				<a href="<?php echo base_url('karyawan'); ?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">Show All </a>
			<?php
		}
		else
		{
		if($this->input->get("page")!=null AND  $this->input->get("page")!=1){
			if($this->input->get("like")!=null){
				?>
				<a href="?page=1&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">&laquo; First </a>
				<?php
			}
			else
			{
			?>
			<a href="../karyawan" class="previous" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;">&laquo; First</a>
			<?php
			}
		}else{
			if($this->input->get("like")!=null){
				?>
				<a href="../karyawan/showPaged?page=1&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">&laquo; First </a>
				<?php
			}
			else{
			?>
			<a href="#" class="previous" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;">&laquo; First</a>
			<?php
			}
		}?>
		<?php
		if($this->input->get("page")!=null)
		{
			if($this->input->get("page")<=2){
				if($this->input->get("like")!=null)
				{
					?>
					<a href="../karyawan/showPaged?page=1&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">&laquo; Previous </a>
					<?php
				}
				else{
			?>
			<a href="../karyawan" class="previous" style="padding: 6px 12px;margin-left: -1px; margin-right: 3px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;">&laquo; Previous </a>
			<?php
				}
		}else{
			if($this->input->get("like")!=null)
			{
				?>
			<a href="?page=<?=($CurrentPage-1)?>&like=<?=$this->input->get("like")?>" style="padding: 6px 12px; margin-right: 3px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">&laquo; Previous </a>
			<?php
			}
			else{
			?>
			<a href="?page=<?=($CurrentPage-1)?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7; margin-right: 3px;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="previous">&laquo; Previous </a>
			<?php
			}
			}	
		}
		?>
		<?php
		if($this->input->get("page")!=$lastPage)
		{
			if($this->input->get("page")==null){
				?>
				<a href="karyawan/showPaged?page=<?=($CurrentPage+2)?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Next &raquo;</a>
				<?php
			}else{
				if($this->input->get("like")!=null)
			{
				?>
			<a href="?page=<?=($CurrentPage+1)?>&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Next &raquo; </a>
			<?php
			}
			else
			{
				?>
				<a href="?page=<?=($CurrentPage+1)?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Next &raquo;</a>
				<?php
			}
			}
		}
		if($this->input->get("page")!=null AND  $this->input->get("page")!=$lastPage){
			if($this->input->get("like")!=null)
			{
				?>
			<a href="?page=<?=($lastPage)?>&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Last &raquo;</a>
			<?php
			}
			else{
				?>
			<a href="?page=<?=($lastPage)?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Last &raquo;</a>
			<?php
			}
			
		}elseif($this->input->get("page")==null){
			if($this->input->get("like")!=null) { ?>
				<a href="karyawan/showPaged?page=<?=($lastPage)?>&like=<?=$this->input->get("like")?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Last  &raquo; </a>
			<?php } else { ?>
				<a href="karyawan/showPaged?page=<?=($lastPage)?>" style="padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background-color: #fff;border: 1px solid #ddd;border-radius: 4px;" class="next">Last  &raquo;</a>
			<?php
			}
		}
		}?>
		<br>
		<br>
		</center>
	</div> 
  </div>
 </div>
  <br/><br/><br/>
  
<style>
.previous {
    background-color: #f1f1f1;
    color: black;
}

.next {
    background-color: #4CAF50;
    color: white;
}

.round {
    border-radius: 50%;
	background-color: #58cee3;
}
</style>
 
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
 
 
    function tambah_karyawan()
    {
      save_method = 'addkaryawan';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form_karyawan').modal('show'); // show bootstrap modal
      
      $('.modal-title').text('Tambah Peserta'); // Set Title to Bootstrap modal title
    }
 
    function edit_karyawan(id)
    {
      save_method = 'updatekaryawan';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/Karyawan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="nip"]').val(data.nip);
            $('[name="nama"]').val(data.nama);
            $('[name="divisi"]').val(data.divisi);
            $('[name="angkatan_id"]').val(data.angkatan_id);
			
 
 
            $('#modal_form_karyawan').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Data Karyawan '); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
	  });
    }
	
	function save_karyawan()
    {
      var url;
		if(document.getElementById('nip').value != "" && document.getElementById('nama').value != "" && document.getElementById('divisi').value != ""){
			if(save_method == 'addkaryawan')
			{
				url = "<?php echo site_url('/Karyawan/karyawan_add')?>";
			}
			else{
				url = "<?php echo site_url('/Karyawan/karyawan_update')?>";
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
 
    function delete_karyawan(id)
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
				url : "<?php echo site_url('/Peserta/karyawan_delete')?>/"+id,
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
                <input name="nama" id="nama" placeholder="Nama" class="form-control" type="text">
              </div>	  
            </div>
	    <div class="form-group">
	      <label class="control-label col-md-3">Unit Kerja</label>
              <div class="col-md-8">
                <input name="divisi" id="divisi" placeholder="Divisi" class="form-control" type="text">
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
	
<?php include 'display/footer2.php';?>
   
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>