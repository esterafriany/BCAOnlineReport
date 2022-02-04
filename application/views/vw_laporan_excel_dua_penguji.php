 <?php
 header("Content-type: application/vnd-ms-excel; charset=utf-8");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
 ?>
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