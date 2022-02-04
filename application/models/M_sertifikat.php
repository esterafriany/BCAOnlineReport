<?php
 
class M_sertifikat extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }
	
	public function get_ujian_sertifikat_by_programid($idprogram)
	{
		$query = $this->db->query("Select _tb.peserta_id 
									, _tb.nip_peserta 
									, _tb.angkatan_id 
									, oa.program_id
									, _tb.nama 
									, _tb.divisi 
									, jumlah_penguji
									, jumlah_nilai_lisan
									, jumlah_nilai
									, posttest_score as nilai_tulis
									, CAST((_tb.nilai_lisan) AS DECIMAL(12,2)) as nilai_lisan
									, CAST(((((jumlah_nilai_lisan/jumlah_penguji*80)/100)+((posttest_score*20)/100))) AS DECIMAL(12,2)) as nilai_akhir
								FROM 
								(
									SELECT peserta_id 
										, ops.nip as nip_peserta
										, oul.angkatan_id
										, nama , divisi 
										, opr.jumlah_penguji as jumlah_penguji
										, COUNT(*) as jumlah_nilai 
										, AVG(total_nilai) as nilai_lisan 
										, SUM(total_nilai) as jumlah_nilai_lisan 
										, ot.posttest_score 
										FROM or_ujian_lisan oul Join or_peserta ops on ops.id = oul.peserta_id 
										Left Join or_ujian_tulis ot on ot.id_peserta = oul.nip_peserta 
										Join or_angkatan oa on oa.id = oul.angkatan_id
										Join or_program opr on oa.program_id = opr.id
										Group By peserta_id, angkatan_id, nip_peserta, angkatan_id, nama, divisi 

									UNION

									SELECT peserta_id 
										, id_peserta as nip_peserta 
										, oul.angkatan_id 
										, ops.nama 
										, divisi
										, opr.jumlah_penguji as jumlah_penguji
										, COUNT(*) as jumlah_nilai
										, AVG(total_nilai) as nilai_lisan 
										, SUM(total_nilai) as jumlah_nilai_lisan 
										, ot.posttest_score 
										FROM or_ujian_tulis ot Join or_peserta ops on ops.nip = ot.id_peserta 
										Left join or_ujian_lisan oul on oul.nip_peserta = ot.id_peserta 
										Join or_angkatan oa on oa.id = oul.angkatan_id
										Join or_program opr on oa.program_id = opr.id
										Group by peserta_id,angkatan_id, nip_peserta, angkatan_id, nama, divisi 
								) _tb
								join or_angkatan oa on oa.id = _tb.angkatan_id
								Where oa.program_id =".$idprogram."
								order by _tb.nip_peserta ");

		$result = $query->result();
		
        return $result;
	}
	
	public function get_ujian_sertifikat_by_programid2($idprogram, $angkatan_id)
	{
		$query = $this->db->query("Select _tb.peserta_id
									, _tb.nip_peserta 
									, _tb.angkatan_id 
									, oa.program_id
									, _tb.nama 
									, _tb.divisi 
									, jumlah_penguji
									, jumlah_nilai
									, jumlah_nilai_lisan
									, posttest_score as nilai_tulis
									, CAST((_tb.nilai_lisan) AS DECIMAL(12,2)) as nilai_lisan
									, CAST(((((jumlah_nilai_lisan/jumlah_penguji*80)/100)+((posttest_score*20)/100))) AS DECIMAL(12,2)) as nilai_akhir
								FROM 
								(
									SELECT peserta_id 
										, ops.nip as nip_peserta 
										, oul.angkatan_id 
										, nama , divisi 
										, opr.jumlah_penguji
										, COUNT(*) as jumlah_nilai 
										, AVG(total_nilai) as nilai_lisan 
										, SUM(total_nilai) as jumlah_nilai_lisan 
										, ot.posttest_score 
										FROM or_ujian_lisan oul Join or_peserta ops on ops.id = oul.peserta_id 
										Left Join or_ujian_tulis ot on ot.id_peserta = oul.nip_peserta 
										Join or_angkatan oa on oa.id = oul.angkatan_id
										Join or_program opr on oa.program_id = opr.id
										Group By peserta_id, angkatan_id, nip_peserta, angkatan_id, nama, divisi 

									UNION

									SELECT peserta_id 
										, id_peserta as nip_peserta 
										, oul.angkatan_id 
										, ops.nama 
										, divisi
										, opr.jumlah_penguji
										, COUNT(*) as jumlah_nilai
										, AVG(total_nilai) as nilai_lisan 
										, SUM(total_nilai) as jumlah_nilai_lisan 
										, ot.posttest_score 
										FROM or_ujian_tulis ot Join or_peserta ops on ops.nip = ot.id_peserta 
										Left join or_ujian_lisan oul on oul.nip_peserta = ot.id_peserta 
										Join or_angkatan oa on oa.id = oul.angkatan_id
										Join or_program opr on oa.program_id = opr.id
										Group by peserta_id,angkatan_id, nip_peserta, angkatan_id, nama, divisi 
								) _tb
								join or_angkatan oa on oa.id = _tb.angkatan_id
								where oa.program_id =".$idprogram." and _tb.angkatan_id = ".$angkatan_id."
								order by _tb.nip_peserta ");

		$result = $query->result();
		
        return $result;
	}

	public function get_sertifikat_by_nip($nip,$idprogram, $angkatan_id)
	{
		$query = $this->db->query("Select 
					(
						Select CAST((AVG(nilai_akhir)) AS DECIMAL(12,2)) as nilai_rata_rata
						FROM
						(
							Select  CAST(((((jumlah_nilai_lisan/ope.jumlah_penguji*80)/100)+((posttest_score*20)/100))) AS DECIMAL(12,2)) as nilai_akhir
							FROM 
							(
								SELECT peserta_id, nip_peserta, oul.angkatan_id, nama, divisi, AVG(total_nilai) as nilai_lisan , SUM(total_nilai) as jumlah_nilai_lisan
								FROM or_ujian_lisan oul 
								left  join or_peserta ops on ops.id = oul.peserta_id 
								GROUP BY peserta_id,angkatan_id, nip_peserta, angkatan_id, nama, divisi 
							) _tb1
						join or_angkatan oa on oa.id = _tb1.angkatan_id
						left join or_ujian_tulis ut on ut.id_peserta = _tb1.nip_peserta
						join or_program ope on ope.id = oa.program_id
						where oa.program_id =".$idprogram." and _tb1.angkatan_id = ".$angkatan_id."
						) _tb2
					) as nilai_rata,
						_tb.peserta_id 
						, _tb.nip_peserta 
						, _tb.angkatan_id 
						, oa.program_id
						, nama_program
						, nama_program_lengkap
						, nama_angkatan
						, _tb.nama 
						, _tb.divisi 
						, posttest_score as nilai_tulis
						, CAST((_tb.jumlah_nilai_lisan/ope.jumlah_penguji) AS DECIMAL(12,2)) as nilai_lisan
						, CAST(((((_tb.jumlah_nilai_lisan/ope.jumlah_penguji*80)/100)+((posttest_score*20)/100))) AS DECIMAL(12,2)) as nilai_akhir
					FROM 
					(
						SELECT peserta_id 
						, nip_peserta 
						, oul.angkatan_id 
						, nama 
						, divisi 
						, AVG(total_nilai) as nilai_lisan 
						, SUM(total_nilai) as jumlah_nilai_lisan
						, ot.posttest_score 
						FROM or_ujian_lisan oul 
						Join or_peserta ops on ops.id = oul.peserta_id 
						Left Join or_ujian_tulis ot on ot.id_peserta = oul.nip_peserta 
						Group By peserta_id, angkatan_id, nip_peserta, angkatan_id, nama, divisi
						
						Union
						
						SELECT peserta_id 
						, id_peserta as nip_peserta 
						, ot.angkatan_id 
						, ops.nama , divisi
						, AVG(total_nilai) as nilai_lisan 
						, SUM(total_nilai) as jumlah_nilai_lisan
						, ot.posttest_score 
						FROM or_ujian_tulis ot 
						Join or_peserta ops on ops.nip = ot.id_peserta 
						left join or_ujian_lisan oul on oul.nip_peserta = ot.id_peserta 
						Group by peserta_id,angkatan_id, nip_peserta, angkatan_id, nama, divisi
					) _tb
					join or_angkatan oa on oa.id = _tb.angkatan_id
					join or_program ope on ope.id = oa.program_id
					Where _tb.nip_peserta =".$nip);

		$result = $query->row();
		
        return $result;
	}

}
/*END OF FILE*/