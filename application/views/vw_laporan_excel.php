 <?php
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0"); 
 ?>

 <input type="button" id="btnExport" value=" Export Table data into Excel " />
 <div id="dvData">
 
 <?php if($jumlah_penguji == 2){ ?>
	<table border="1" width="100%">
      <thead>
           <tr>
              <th>NIP</th>
			  <th>Nama</th>
			  <th>Divisi</th>
			  <th>Penguji 1</th>
			  <th>Penguji 2</th>
			  <th>Nilai Ujian Lisan</th>
           </tr>
      </thead>
      <tbody>
           <?php $i=1; foreach($buku as $buku) { ?>
           <tr>
                <td><?php echo $buku->nip; ?></td>
				<td><?php echo $buku->nama; ?></td>
				<td><?php echo $buku->divisi; ?></td>
				<td><?php echo $buku->penguji_1; ?></td>
				<td><?php echo $buku->penguji_2; ?></td>
				<td><?php echo $buku->nilai_ujian_lisan; ?></td>
           </tr>
           <?php $i++; } ?>
      </tbody>
	</table>
 <?php }else if($jumlah_penguji == 3){ ?>
	
 
    <table>
		<tr>
		  <th>NIP</th>
		  <th>Nama</th>
		  <th>Divisi</th>
		  <th>Penguji 1</th>
		  <th>Penguji 2</th>
		  <th>Penguji 3</th>
		  <th>Nilai Ujian Lisan</th>
	   </tr>
        <?php $i=1; foreach($buku as $buku) { ?>
           <tr>
                <td><?php echo $buku->nip; ?></td>
				<td><?php echo $buku->nama; ?></td>
				<td><?php echo $buku->divisi; ?></td>
				<td><?php echo $buku->penguji_1; ?></td>
				<td><?php echo $buku->penguji_2; ?></td>
				<td><?php echo $buku->penguji_3; ?></td>
				<td><?php echo $buku->nilai_ujian_lisan; ?></td>
           </tr>
           <?php $i++; } ?>
    </table>
 <?php } ?>
</div>

<style type="text/css">
body {
    font-size: 12pt;
    font-family: Calibri;
    padding : 10px;
}
table {
    border: 1px solid black;
}
th {
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
td {
    border: 1px solid black;
    padding: 5px;
}
input {
    font-size: 12pt;
    font-family: Calibri;
}
</style>

 <script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
 <script type="text/javascript">
  $(document).ready( function () {
    $("#btnExport").click(function (e) {
    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});
});
</script>
	
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
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.bdt.min.js" type="text/javascript"></script>
  </body>
</html>