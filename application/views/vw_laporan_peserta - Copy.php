 <?php
 
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
 
 ?>

 
<?php $i=1; foreach($peserta as $peserta) { ?>
<table border="1" width="100%">
	<thead>
		<td>
			<center><h2>Kode Unik Peserta</h2></center>
		</td>
	  </thead>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td>NIP</td>
						<td align="left"><b><?php echo $peserta->nip; ?></b></td>
					</tr>
					
					<tr>
						<td>Nama</td>
						<td><b><?php echo $peserta->nama; ?></b></td>
					</tr>
					
					<tr>
						<td>Unit Kerja/Divisi</td>
						<td><b><?php echo $peserta->divisi; ?></b></td>
					</tr>
					
					<tr>
						<td>Kode Unik</td>
						<td><b><?php echo $peserta->kode_unik; ?></b></td>
					</tr>
				</table>
			</td>
		</tr>
</table>

<?php $i++; } ?>