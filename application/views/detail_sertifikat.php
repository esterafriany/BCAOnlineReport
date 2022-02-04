
<?php include 'display/header.php';?>

<div class="container">


<a class="btn btn-danger btn-xs" id="btnSertifikat" href="<?php echo base_url('sertifikat/show_report2/'.$list_sertifikat->program_id.'/'.$list_sertifikat->angkatan_id)?>">
	<i class="glyphicon glyphicon-print"></i> Kembali Ke Daftar Sertifikat
</a>

<div id="content" hidden>
	<img src="<?php echo base_url()?>assets/images/border.jpg" style="position: absolute;width: 100%;height:auto; left:0px; top:0px; z-index:-1;">
	<br><br>
	<table align="center" width="80%">
		<tr align="center">
			<td><h1 name="nama_program" class="fontsforweb_fontid_57985" style="font-size: x-large;" id="nama_program" ><?=$list_sertifikat->nama_program_lengkap?></h1> <h4 id="nama_angkatan" class="fontsforweb_fontid_57985" style="font-size: x-large;" ><?=$list_sertifikat->nama_angkatan?></h4></td>
		</tr>
		<tr align="center">
			<td><br>
				<h1 id="nama_peserta" class="fontsforweb_fontid_57985" style="font-size: 25px;"><?=$list_sertifikat->nama?></h1>
				<h4 id="nip_peserta" class="font">NIP : <?=$list_sertifikat->nip_peserta?></h4>
			</td>
		</tr>
		<tr align="center">
			<td><br>
				<h4 id="divisi" class="font">Unit Kerja : <?=$list_sertifikat->divisi?></h4>
			</td>
		</tr>
		<tr align="center">
			<td><br>
				<table width="80%" style="border-collapse: collapse; border: 1px solid #ddd; font-size:12px;"id="table">
					<tr>
						<td align="center" width="5%" style="border-bottom: 1px solid #ddd;border-radius: 30px;">No. </td>
						<td style="border-bottom: 1px solid #ddd;">Jenis Ujian </td>
						<td align="center" style="border-bottom: 1px solid #ddd;">Nilai</td>
					</tr>
					<tr>
						<td align="center">1</td>
						<td>Ujian Tertulis</td>
						<td id="nilai_tulis" align="center"><?=$list_sertifikat->nilai_tulis?></td>
					</tr>
					<tr>
						<td align="center" style="border-bottom: 1px solid #ddd;">2</td>
						<td style="border-bottom: 1px solid #ddd;">Ujian Lisan</td>
						<td id="nilai_lisan" align="center" style="border-bottom: 1px solid #ddd;"><?=$list_sertifikat->nilai_lisan?></td>
					</tr>
					<tr>
						<td colspan="2">Nilai Rata-rata Kelas</td>
						<td id="nilai_rata_rata" align="center"><?=$list_sertifikat->nilai_rata?></td>
					</tr>
					<tr>
						<td colspan="2" style="border-bottom: 1px solid #ddd;">Nilai Akhir : Ujian Tertulis (20%) + Ujian Lisan (80%)</td>
						<td id="nilai_akhir" align="center" style="border-bottom: 1px solid #ddd;"><?=$list_sertifikat->nilai_akhir?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr align="center"><br>
			<td style="font-size:12px;"><br>Jakarta, <?php echo date("d F Y") ?> </td>
		</tr>
	</table>
	<br><br>
	<table align="center">
		<tr align="center">
			<td width="20%" style="font-size:12px;">
				Kepala Divisi
				<br><br><br><br>
				(Lena Setiawati)
			</td>
			<td width="60%">
			</td>
			<td width="20%" style="font-size:12px;">
				Kepala Biro
				<br><br><br><br>
				(L. Melly Gunawan)
			</td>
		</tr>
	</table> 
</div>
</div>

  
<script type="text/javascript">
	$(document).ready( function () {
		//var printer = new Printer($("#content").html() );
		//OOP FTW
		
		Popup($('#content').html());
	});
  

	function Printer($c){
		var h = $c;
		return {
			print: function(){
				var d = $("<div>").html(h).appendTo("html");
				$("body").hide();
				window.print();
				d.remove();
				$("body").show();
			},
			setContent: function($c){
				h = $c;
			}
		};
	}

	function Popup(data) {
		var myWindow = window.open('', 'my div', 'height=400,width=600');
		myWindow.document.write('<html><head><title>my div</title>');
		myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />');
		myWindow.document.write('<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" media="all"/>');
		myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/font.css"/>');
		myWindow.document.write('<style type="text/css">.font {font-family: "AlexBrushRegular";}</style>');
		myWindow.document.write('</head><body >');
		myWindow.document.write(data);
		myWindow.document.write('</body></html>');
		myWindow.document.close(); // necessary for IE >= 10
		
		myWindow.onload=function(){ // necessary if the div contain images
			myWindow.focus(); // necessary for IE >= 10
			myWindow.print();
			myWindow.close();
		};
	}
</script>
  

	
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
	<script src="<?php echo base_url(); ?>assets/js_paging/jquery.bdt.js" type="text/javascript"></script>
  </body>
</html>