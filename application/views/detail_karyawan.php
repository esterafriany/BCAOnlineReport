<?php include 'display/header.php';?>
	
	<div class="container">
    <h3>Detil Data Karyawan 	</h3><br>
	<a class="btn btn-success btn-sm" href="<?php echo base_url('karyawan/') ?>"><i class="glyphicon glyphicon-chevron-left"></i> Kembali </a>
    <br><br>
	
	
    <div class="panel panel-default">
		<div class="panel-heading">DATA KARYAWAN</div>
		<div class="panel-body">
			
				<table width="100%">
					<tr>
						<td width="35%"><b>NIP</b></td>
						<td><?php echo $detil_karyawan->nip; ?></td>
					</tr>
					<tr>
						<td height="5"></td>
					</tr>
					<tr>
						<td><b>NAMA</b></td>
						<td><?php echo $detil_karyawan->nama; ?></td>
					</tr>
					<tr>
						<td height="5"></td>
					</tr>
					<tr>
						<td><b>UNIT KERJA</b></td>
						<td><?php echo $detil_karyawan->divisi; ?></td>
					</tr>
					<tr>
						<td height="5"></td>
					</tr>
					<tr>
						<td><b>PROGRAM</b></td>
						<td><?php echo $detil_karyawan->nama_program; ?></td>
					</tr>
					<tr>
						<td height="5"></td>
					</tr>
					<tr>
						<td><b>ANGKATAN</b></td>
						<td><?php echo $detil_karyawan->nama_angkatan; ?></td>
					</tr>
				</table>
		
			
		</div>
	</div>
	
		
		
		
		
 
  </div>
  
  <script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
 
<script type="text/javascript">
  
	$(document).ready( function () {
		$('#bootstrap-table').bdt();
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
 
    function delete_program(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('/program/program_delete')?>/"+id,
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
 
	$(document).ready(function() {
			$('.datatable').dataTable({
				"sPaginationType": "bs_normal"
			});	
			$('.datatable').each(function(){
				var datatable = $(this);
				// SEARCH - Add the placeholder for Search and Turn this into in-line form control
				var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
				search_input.attr('placeholder', 'Search');
				search_input.addClass('form-control input-sm');
				// LENGTH - Inline-Form control
				var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
				length_sel.addClass('form-control input-sm');
			});
		});
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
					  <label class="control-label col-md-3">Nama Program</label>
					  <div class="col-md-8">
						<input name="nama_program" placeholder="Nama Program" class="form-control" type="text">
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
   
	
    <!--  (necessary for Bootstrap's JavaScript plugins) -->	
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
	
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.bdt.min.js" type="text/javascript"></script>
  </body>
</html>