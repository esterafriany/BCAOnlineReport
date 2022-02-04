<?php include 'display/header.php';?>
<div class="container">
<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>DAFTAR NILAI UJIAN LISAN 	</h3>
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
					<?php foreach($listprograms as $program) { 
					if($program->id !=0){
						?>
							<li><a href="<?php echo base_url("UjianLisan/show_ujian_lisan/".$program->id); ?>"><?php echo $program->nama_program; ?></a></li>
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
						foreach($listAngkatan as $angkatan) { ?>
							<li><a href="<?php echo base_url("UjianLisan/show_ujian_lisan2/".$id_program."/".$angkatan->angkatan_id); ?>"><?php echo $angkatan->nama_angkatan; ?></a></li>
						<?php 
						}
						} ?>
					</ul>
				</div>
				<input type="hidden" name="angk_id" id="angk_id" value="<?php if(!empty($ang_id)){ echo $ang_id; } ?>">
			</td>
			<?php if(empty($ang_id)){ $ang_id = 0; } ?>
			<?php 
				if(!empty($jumlah_penguji)){ 
					$jlh_penguji = $jumlah_penguji->jumlah_penguji; 
				}else{
					$jlh_penguji = 0;
				}
			?>
			<td>
				<a class="btn btn-success btn-sm" id="btnPlaceOrder" name="btnPlaceOrder" href="<?php echo base_url('UjianLisan/export_excel/'.$ang_id.'/'.$jlh_penguji) ?>"><i class="glyphicon glyphicon-download"></i> Unduh Ke Excel</a>
			</td>
			
		</tr>
	</table>

    <br />
    <table id="example" class="table table-striped table-hover" cellspacing="0" width="100%" style="font-size: 14;">
      <thead>
        <tr>
			<th width="10px">No.</th>
			<th>Nama</th>
			<th>Penguji</th>
			<th>Waktu Submit</th>
			<th style="width:110px;">Action</th>
        </tr>
      </thead>
      <tbody id="table_body">
		<?php 
		$i = 1;
			foreach($ujian_lisan as $lisan){?>
		     <tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $lisan->nama_peserta;?></td>
			<td><?php echo $lisan->nama_penguji;?></td>
			<td><?php echo  date("d M Y", strtotime($lisan->tanggal));?> | <?php echo  date("H:i", strtotime($lisan->tanggal));?></td>
		
			<td width="150px">
				<a class="btn btn-warning btn-xs" href="<?php echo base_url("UjianLisan/show_detail/".$lisan->ujian_lisan_id); ?>"><i class="glyphicon glyphicon-search"></i> </a>
				
				<?php if($this->session->userdata("role")==3){ ?>
					<a class="btn btn-danger btn-xs" onclick="delete_ujian_lisan(<?php echo $lisan->ujian_lisan_id; ?>,<?php echo $id_program; ?>,<?php echo $lisan->peserta_id; ?>,<?php echo $lisan->penguji_id; ?>,<?php echo $ang_id; ?>)">
					<i class="glyphicon glyphicon-remove"></i>Reset
				</a>
				<?php } ?>
				
			</td>
		      </tr>
		     <?php 
			}
		 ?>
    </table>
      </tbody>
	 
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
		
		if($('[name="angk_id"]').val().length !=0){
		   document.getElementById('btnPlaceOrder').removeAttribute("disabled");
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
 
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Book'); // Set title to Bootstrap modal title
 
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
 
    function save(){
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
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding / update data');
            }
        });
    }
 
    function delete_ujian_lisan(id, id_program, peserta_id, penguji_id, id_angkatan){
		swal({
			title: "Apakah anda yakin ingin reset nilai?",
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
				url : "<?php echo site_url('/UjianLisan/delete_ujian_lisan')?>/"+id+"/"+id_program+"/"+peserta_id+"/"+penguji_id+"/"+id_angkatan,
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
        <h3 class="modal-title">Program</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nama_Program</label>
              <div class="col-md-9">
                <input name="nama_program" placeholder="Nama_Program" class="form-control" type="text">
              </div>
            </div>
 
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
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