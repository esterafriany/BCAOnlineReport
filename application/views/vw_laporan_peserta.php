 <?php
 
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
 
 ?>
 <table border="1" width="100%">
 
      <thead>
		<td colspan="4">
			<center><h2>Daftar Kode Unik Peserta</h2></center>
		</td>
	  </thead>
	   <tr>

		  <th>NIP</th>
		  <th>Nama</th>
		  <th>Divisi</th>
		  <th>Kode Unik</th>

	   </tr>
      
 
      <tbody>
           <?php $i=1; foreach($peserta as $peserta) { ?>
           <tr>
                <td><?php echo $peserta->nip; ?></td>
				<td><?php echo $peserta->nama; ?></td>
				<td><?php echo $peserta->divisi; ?></td>
				<td><?php echo $peserta->kode_unik; ?></td>
           </tr>
           <?php $i++; } ?>
      </tbody>
 
 </table>
 