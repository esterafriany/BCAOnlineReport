<?php include 'display/header.php';?>
<div class="container">

<table width="100%" border=0>
	<tr>
		<td>
			<fieldset class="col-md-6" style="width: 100%;">    	
				<legend>Penguji</legend>
				<table width="100%" >
					<tr>
						<td width="35%">NIP</td>
						<td>:&nbsp;<?php echo $penguji->nip; ?><input name="penguji_id" value="<?php echo $penguji->id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:&nbsp;<?php echo $penguji->nama; ?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:&nbsp;<?php echo $penguji->divisi; ?></td>
					</tr>
				</table>
				
			</fieldset>	
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset class="col-md-6" style="width: 100%;">    	
				<legend>Peserta</legend>
				<table width="100%" >
					<tr>
						<td width="35%">NIP</td>
						<td>:&nbsp;<?php echo $peserta->nip; ?><input  name="peserta_id" value="<?php echo $peserta->peserta_id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:&nbsp;<?php echo $peserta->nama; ?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:&nbsp;<?php echo $peserta->divisi; ?></td>
					</tr>
					<tr>
						<td>Program </td>
						<td>:&nbsp;<?php echo $peserta->nama_program; ?><input name="program_id" value="<?php echo $peserta->program_id; ?>" class="form-control" type="hidden"></td>
					</tr>
					<tr>
						<td>Angkatan </td>
						<td>:&nbsp;<?php echo $peserta->nama_angkatan; ?><input name="angkatan_id" value="<?php echo $peserta->angkatan_id; ?>" class="form-control" type="hidden"></td>
					</tr>
				</table>
			</fieldset>	
		</td>
	</tr>
</table>
 <br />
<div class="panel-body" style=" padding-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px;">
	<div class="panel panel-default" style="    padding-top: 5px; padding-bottom: 5px;  padding-left: 5px; padding-right: 5px; margin-bottom: 0px;">
		<table id="table_id" class="table table-bordered" cellspacing="0" width="100%">
		  <thead>
			<tr>
				<th><center>Kriteria</center></th>
				<th><center>Bobot</center></th>
				<th><center>Nilai</center></th>
				<th><center>Total</center></th>
			</tr>
		  </thead>
		  <tbody style="padding-bottom: 2px; padding-left: 2px; padding-top: 2px; padding-right: 2px;">
			<?php 
			$i = 1;
			foreach($detail_nilai as $nilai){?>
				 <tr>
				<td><?php echo $i++;?>. <?php echo $nilai->kriteria_penilaian;?></td>
				<td align="center"><?php echo $nilai->komposisi_nilai;?>%</td>
				<td align="center"><?php echo $nilai->nilai;?></td>
				<td align="center"><?php echo $nilai->komposisi_nilai*$nilai->nilai/100;?></td>
				 </tr>
			<?php }?>
		  </tbody>
	 
		  <tfoot>
		  <th colspan="3" style="text-align: right;">Nilai Total</th>
		  <th><center>
			<?php 
				if(count($detail_nilai) !=0){
					echo $nilai->total_nilai;
				}else{
					echo 0;
				}
			?>
		  </center>
		  </th>
		  </tfoot> 
		</table>
		</div>
</div>	
<br>
<div class="panel panel-default" style="margin-bottom: 3px;padding-left: 10px;">
	<table>
		<tr>
			<td>
				<b>Komentar:</b>
			</td>
			
		</tr>
		<tr>
			<td>
				<?php 
					if(count($detail_nilai) !=0) {
						echo $detail_nilai[0]->komentar;
					}else{
						echo "";
					}
				?>
			</td>
		</tr>
	</table>

</div>
<font style="font-size:10px;font-style: italic;">
	Disubmit pada: <?php echo $detail_nilai[0]->tanggal;?>
</font>

	<form name="form_penilaian" method="POST" action="<?php echo base_url('ujianlisan/'); ?>" class="form-horizontal">
		<table align="right">
			<tr>
				<td align="right">
			
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
						  <button type="submit" class="btn btn-success">Tutup</button>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</form>

</div>

 <style type="text/css">
	fieldset {
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
	legend
	{
		font-size:14px;
		font-weight:bold;
		margin-bottom: 0px; 
		width: 80px; 
		border: 1px solid #ddd;
		border-radius: 4px; 
		padding: 5px 5px 5px 10px; 
		background-color: #ffffff;
		color:black;
	}
  </style>
  
  
  
<script type="text/javascript">
	$(document).ready( function () {
      $('#table_id').DataTable(
	  );	  
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
<script>
wow = new WOW(
 {
 }	) 
	.init();
</script>
	
  </body>
</html>