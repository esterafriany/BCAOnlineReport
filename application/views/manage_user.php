<?php include 'display/header.php';?>
<div class="container">
	<div class="panel panel-default" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
    <h3>MANAGE USER</h3>
	<br/>
    <button class="btn btn-success btn-sm" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
    <br/>
    <br />
	<br/>
	
	<div class="vertical-align-middle">
	<table width="100%" cellspacing="0" width="70%" align="center">
        <tr>
			<td>
			
			<?php if(isset($msg) && $msg != "NULL") { ?>
				<div class="alert alert-warning" role="alert"><?php echo $msg; ?></div>
			<?php } ?>
			
				<table class="table table-striped table-hover" id="example" cellspacing="0" width="100%">
				  <thead>
					<tr>
						<th width="10px">No.</th>
						<th>Username</th>
						<th>Keterangan </th>
						<th style="width:120px;">Action</th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					$i = 1;
					foreach($users as $user){
						if($user->id != 0){
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $user->username;?></td>
								<td><?php echo $user->nama;?></td>
								<td>
									<button class="btn btn-warning btn-xs" onclick="edit_user(<?php echo $user->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger btn-xs" onclick="delete_user(<?php echo $user->id;?>)"><i class="glyphicon glyphicon-trash"></i></button>
								</td>
							</tr>
						<?php
						}
						?>
					<?php }?>
				  </tbody>
				</table>
			</td>
        </tr>
    </table>
	</div>
	
	</div>
  </div>
  <br/><br/><br/>
 
 <script type="text/javascript">
  
	$(document).ready(function () {
		//Place this plugin snippet into another file in your applicationb
		(function ($) {
			$.toggleShowPassword = function (options) {
				var settings = $.extend({
					field: "#password",
					control: "#toggle_show_password",
				}, options);

				var control = $(settings.control);
				var field = $(settings.field)

				control.bind('click', function () {
					if (control.is(':checked')) {
						field.attr('type', 'text');
					} else {
						field.attr('type', 'password');
					}
				})
			};
		}(jQuery));

		//Here how to call above plugin from everywhere in your application document body
		$.toggleShowPassword({
			field: '#pass1',
			control: '#test2',
		});
		
		//Here how to call above plugin from everywhere in your application document body
		$.toggleShowPassword({
			field: '#pass2',
			control: '#test3',
		});
		
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
		
		$(function() { 
		  $("#role").on("change",function() { 
			$("#role_name").val($("#role option:selected" ).text()); 
		  }); 
		});
		
		$("select.country").change(function(){
        var selectedCountry = $(".country option:selected").val();
        $("#role_name").val(selectedCountry); 
		//alert("You have selected the country - " + selectedCountry);
    });
		
	});
	
	function add_user()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah User '); // Set Title to Bootstrap modal title
    }
	
	function edit_user(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/karyawan/ajax_edit_user/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="username"]').val(data.username);
			$('[name="role_name"]').val(data.nama);
			
			$('#role').val(data.role).attr("selected", "selected");
			
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Data User'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal('Error get data from ajax');
        }
	  });
    }
	
	function delete_user(id)
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
				url : "<?php echo site_url('/karyawan/user_delete')?>/"+id,
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
	
	function save()
    {
      var url;
	  
		if(document.getElementById('username').value != "" && document.getElementById('pass1').value != "" && document.getElementById('role_name').value != ""){
			if(save_method == 'add') {
				url = "<?php echo site_url('/karyawan/user_add')?>";
			}else{
				url = "<?php echo site_url('/karyawan/user_update')?>";
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
	
	
	
	function checkPass()
	{
		//Store the password field objects into variables ...
		var pass1 = document.getElementById('pass1');
		var pass2 = document.getElementById('pass2');
		//Store the Confimation Message Object ...
		var message = document.getElementById('confirmMessage');
		//Set the colors we will be using ...
		var goodColor = "#fafafa";
		var badColor = "#ff6666";
		//Compare the values in the password field 
		//and the confirmation field
		if(pass1.value == pass2.value){
			//The passwords match. 
			//Set the color to the good color and inform
			//the user that they have entered the correct password 
			pass2.style.backgroundColor = goodColor;
			message.style.color = goodColor;
			//message.innerHTML = "Passwords Match!"
		}else{
			//The passwords do not match.
			//Set the color to the bad color and
			//notify the user.
			pass2.style.backgroundColor = badColor;
			message.style.color = badColor;
			message.innerHTML = "Passwords Do Not Match!"
		}
	}
	
	
	
</script>

<!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">User</h3>
      </div>
      <div class="modal-body form">
        <form method="POST" action="<?php echo base_url('karyawan/user_add'); ?>"  id="form" class="form-horizontal"/>
          <input type="hidden" value="" name="id"/>
		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Username</label>
              <div class="col-md-8">
                <input name="username" id="username" placeholder="Username" class="form-control" type="text" required/>
              </div>
            </div>
          </div>
		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Password</label>
              <div class="col-md-8">
                <input name="pass1" id="pass1" placeholder="Password" class="form-control" type="password" required/>
				<input id="test2" type="checkbox" />Show password
              </div>
            </div>
          </div>
		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Confirm Passw</label>
              <div class="col-md-8">
                <input name="pass2" id="pass2" placeholder="Confirm Password" class="form-control" type="password" onkeyup="checkPass(); return false;" required/>
				<input id="test3" type="checkbox">Show password</input><br>
				<span id="confirmMessage" class="confirmMessage"></span>
              </div>
            </div>
          </div>
		  		  
		  <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Role </label>
              <div class="col-md-8">
				<select class="form-control" id="role" name="role" required>
					<option value="">Pilih Role</option>
					<?php foreach($roles as $role) { ?>
						<option value="<?php echo $role->role_id;?>"><?php echo $role->role_name;?></option>
					<?php } ?>
				</select>
				
				<input type="hidden" value="" name="role_name" id="role_name"/>
                
              </div>
            </div>
          </div>
        
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-xs" >Simpan</button>
            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Batal</button>
			</form>
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