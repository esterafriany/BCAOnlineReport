 <?php
 
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
 
 ?>
 <table border="1" width="100%">
		<thead>
			<td colspan="8">
				<center><h2>Daftar Nilai Gabungan</h2></center>
			</td>
		</thead>
		<tr>
			<th width="10px">No.</th>
			<th>NIP</th>
			<th>Nama</th>
			<th>Divisi/Unit Kerja</th>
			<th>Nilai Tulis</th>
			<th>Nilai Lisan</th>
			<th>Nilai Akhir</th>
			<th>Lulus/Tidak Lulus</th>
		</tr>
      
 
      <tbody>
           <?php 
			$i = 1;
			foreach($list_report as $report){ ?>
				<tr>
					<td><?php echo $i++;?></td>
					<td><?php echo $report->nip_peserta;?></td>
					<td><?php echo $report->nama;?></td>
					<td><?php echo $report->divisi;?></td>
					<td><?php if($report->nilai_tulis != ""){echo $report->nilai_tulis; }else{echo "-";} ?></td>
					<td>
					
					<?php 
					if($report->nilai_lisan != "") {
						if($report->jumlah_penguji <> $report->jumlah_nilai){
							echo round($report->jumlah_nilai_lisan / $report->jumlah_penguji,2); 
						}else{
							echo $report->nilai_lisan; 
						}
						
					}else{
						echo "-";
					} ?>
					
					<?php if($report->jumlah_penguji <> $report->jumlah_nilai){ ?>
						<a type="button" data-container="body" data-toggle="popover" data-placement="right" data-content="Semua penguji belum memberi nilai !">
						  <i class="glyphicon glyphicon-info-sign" style="color: red;"></i>
						</a>
					<?php } ?>
					
					</td>
					<td>
					<?php 
					if($report->nilai_akhir != ""){
						echo $report->nilai_akhir; 
					}else{
						echo "-";
				} ?>
					</td>
					<td><?php if($report->nilai_akhir >= 70){echo "Lulus";}else{echo "Tidak Lulus";} ?></td>
		
				</tr>
		<?php }	
		?>
      </tbody>
 
 </table>
 
 