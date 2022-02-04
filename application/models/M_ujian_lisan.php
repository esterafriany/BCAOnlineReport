<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_ujian_lisan extends CI_Model
{
	var $tableUjian = 'or_ujian_lisan';
	var $tableDetailNilaiUjian = 'or_detail_nilai_ujian_lisan';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_ujian_lisan()
	{
		$this->db->select('*, or_ujian_lisan.id as ujian_lisan_id, op1.nip as nip_peserta, op1.nama as `nama_peserta`, op2.nama as `nama_penguji`');
		$this->db->from($this->tableUjian);
		$this->db->join('or_peserta as op1', 'peserta_id = op1.id');
		$this->db->join('or_peserta as op2', 'penguji_id = op2.id');
		$this->db->join('or_angkatan', 'or_ujian_lisan.angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'or_angkatan.program_id = or_program.id');
		$query = $this->db->get();
		
		return $query->result();
	}
 
	public function get_detail_nilai_by_ujian_id($id)
	{
		$this->db->from($this->tableDetailNilaiUjian);
		$this->db->join('or_ujian_lisan as ou', 'ujian_id = ou.id');
		$this->db->join('or_penilaian_program as op2', 'penilaian_program_id = op2.id');
		$this->db->where('ujian_id',$id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function get_ujian_lisan_by_programid($id)
	{
		$this->db->select('*, or_ujian_lisan.id as ujian_lisan_id, op1.nip as nip_peserta, op1.nama as `nama_peserta`, op2.nama as `nama_penguji`, or_program.id as `program_id`');
		$this->db->from($this->tableUjian);
		$this->db->join('or_peserta as op1', 'peserta_id = op1.id');
		$this->db->join('or_peserta as op2', 'penguji_id = op2.id');
		$this->db->join('or_angkatan', 'or_angkatan.id = or_ujian_lisan.angkatan_id');
		$this->db->join('or_program', 'or_program.id = or_angkatan.program_id');
		$this->db->where('or_angkatan.program_id',$id);
		$this->db->order_by("UPPER(op1.nip)","asc");
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function get_ujian_lisan_by_programid2($idprogram, $idangkatan)
	{
		$this->db->select('*, or_ujian_lisan.id as ujian_lisan_id, op1.nip as nip_peserta, op1.nama as `nama_peserta`, op2.nama as `nama_penguji`');
		$this->db->from('or_ujian_lisan');
		$this->db->join('or_peserta as op1', 'peserta_id = op1.id');
		$this->db->join('or_peserta as op2', 'penguji_id = op2.id');
		$this->db->join('or_angkatan', 'or_ujian_lisan.angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'or_angkatan.program_id = or_program.id');
		$this->db->where('or_ujian_lisan.angkatan_id',$idangkatan);
		$this->db->order_by("UPPER(op1.nip)","asc");
		
		$query = $this->db->get();
		
		return $query->result();
	}
		
	public function get_penguji_by_ujian_id($id)
	{
		$this->db->from('or_ujian_lisan');
		$this->db->join('or_peserta', 'penguji_id = or_peserta.id');
		$this->db->where('or_ujian_lisan.id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_ujian_lisan_by_id($id)
	{
		$this->db->from('or_ujian_lisan');
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_peserta_by_ujian_id($id_ujian)
	{
		$this->db->from('or_ujian_lisan');
		$this->db->join('or_peserta', 'peserta_id = or_peserta.id');
		$this->db->join('or_angkatan', 'or_ujian_lisan.angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'program_id = or_program.id');
		$this->db->where('or_ujian_lisan.id',$id_ujian);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_penguji_by_peserta($peserta_id, $angkatan_id, $penguji)
	{
		$this->db->from('or_ujian_lisan');
		
		$array = array('penguji' => $penguji, 'peserta_id' => $peserta_id, 'angkatan_id' => $angkatan_id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function get_data_ujian_lisan($peserta_id, $angkatan_id)
	{
		$this->db->from('or_ujian_lisan');
		
		$array = array('peserta_id' => $peserta_id, 'angkatan_id' => $angkatan_id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function get_data_ujian_lisan_rows($peserta_id, $angkatan_id)
	{
		$this->db->from('or_ujian_lisan');
		
		$array = array('peserta_id' => $peserta_id, 'angkatan_id' => $angkatan_id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->num_rows();
	}
	
	
	
	public function getpeserta_by_kode_unik($kode_unik)
	{
		$this->db->select('id');
		
		$this->db->from('or_peserta');
		$array = array('kode_unik' => $kode_unik);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function getangkatan_by_kode_unik($kode_unik)
	{
		$this->db->select('angkatan_id');
		
		$this->db->from('or_peserta');
		$array = array('kode_unik' => $kode_unik);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function program_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
 
	public function program_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
 
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	public function delete_detail_by_id($id)
	{
		$this->db->where('ujian_id', $id);
		$this->db->delete('or_detail_nilai_ujian_lisan');
	}
	
	public function delete_ujian_lisan_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('or_ujian_lisan');
	}
 
	public function getAll($angkatan_id)
	{
		if($angkatan_id <> 0){
			$this->db->select('*,  CAST((penguji_1 + penguji_2+penguji_3)/3 AS DECIMAL(8,2)) as `nilai_ujian_lisan`  FROM ( SELECT peserta_id, nip, nama, divisi, MAX(IF(penguji = "Penguji 1", total_nilai, 0)) AS penguji_1,MAX(IF(penguji = "Penguji 2", total_nilai, 0)) AS penguji_2,MAX(IF(penguji = "Penguji 3", total_nilai, 0)) AS penguji_3 ');
			$this->db->from('or_ujian_lisan oul');
			$this->db->join('or_peserta op', 'op.id = oul.peserta_id');
			$this->db->where('oul.angkatan_id',$angkatan_id);
			$this->db->group_by('peserta_id ) as `_tb`');
			
			$query = $this->db->get();
			
		}else{
			$this->db->select('*, CAST((penguji_1 + penguji_2+penguji_3)/3 AS DECIMAL(8,2)) as `nilai_ujian_lisan`  FROM ( SELECT peserta_id, nip, nama, divisi, MAX(IF(penguji = "Penguji 1", total_nilai, 0)) AS penguji_1,MAX(IF(penguji = "Penguji 2", total_nilai, 0)) AS penguji_2,MAX(IF(penguji = "Penguji 3", total_nilai, 0)) AS penguji_3 ');
			$this->db->from('or_ujian_lisan oul');
			$this->db->join('or_peserta op', 'op.id = oul.peserta_id');
			$this->db->group_by('peserta_id ) as `_tb`');
			
			$query = $this->db->get();
		}
		
		return $query->result();
	}
	
	public function getAll_dua_penguji($angkatan_id)
	{
		if($angkatan_id <> 0){
			
			
			$this->db->select('*,  CAST((penguji_1 + penguji_2)/2 AS DECIMAL(8,2)) as `nilai_ujian_lisan`  FROM ( SELECT peserta_id, nip, nama, divisi, MAX(IF(penguji = "Penguji 1", total_nilai, 0)) AS penguji_1,MAX(IF(penguji = "Penguji 2", total_nilai, 0)) AS penguji_2 ');
			$this->db->from('or_ujian_lisan oul');
			$this->db->join('or_peserta op', 'op.id = oul.peserta_id');
			$this->db->where('oul.angkatan_id',$angkatan_id);
			$this->db->group_by('peserta_id ) as `_tb`');
			
			$query = $this->db->get();
			
		}else{
			$this->db->select('*, CAST((penguji_1 + penguji_2)/2 AS DECIMAL(8,2)) as `nilai_ujian_lisan`  FROM ( SELECT peserta_id, nip, nama, divisi, MAX(IF(penguji = "Penguji 1", total_nilai, 0)) AS penguji_1,MAX(IF(penguji = "Penguji 2", total_nilai, 0)) AS penguji_2');
			$this->db->from('or_ujian_lisan oul');
			$this->db->join('or_peserta op', 'op.id = oul.peserta_id');
			$this->db->group_by('peserta_id ) as `_tb`');
			
			$query = $this->db->get();
		}
		
		return $query->result();
	}
	
	public function cek_penguji($peserta_id, $penguji_id, $tanggal)
	{
		$this->db->select('*');
		$this->db->from('or_ujian_lisan');
		$array = array('peserta_id' => $peserta_id, 'penguji_id' => $penguji_id, 'DATE(tanggal) ' => $tanggal);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->num_rows();
	}
	
	public function get_jumlah_penguji_by_program_id($id)
	{
		$this->db->select('jumlah_penguji');
		$this->db->from('or_program');
		$array = array('id' => $id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->rows();
	}
 
	public function get_idpenguji($nip)
	{
		$this->db->select('id');
		$this->db->from('or_peserta');
		$array = array('nip' => $nip);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_indeks_penguji($id)
	{
		$this->db->select('penguji');
		$this->db->from('or_ujian_lisan');
		$array = array('id' => $id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_jumlah_penguji($program_id)
	{
		$this->db->select('jumlah_penguji');
		$this->db->from('or_program');
		$array = array('id' => $program_id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_all_jadwal()
	{
		$this->db->select('id, vp.nama_program, vp.nama_angkatan,vp.angkatan_id, tanggal, keterangan');
		$this->db->from('or_jadwal_ujian_lisan oj');
		$this->db->join('v_program_angkatan vp', 'oj.angkatan_id = vp.angkatan_id');
		
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function get_jadwal_ujian_lisan($angkatan_id)
	{
		$this->db->select('*');
		$this->db->from('or_jadwal_ujian_lisan');
		$array = array('angkatan_id' => $angkatan_id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_jadwal_by_program($id_program)
	{
		$this->db->select('id, vp.nama_program, vp.nama_angkatan,vp.angkatan_id, tanggal, keterangan');
		$this->db->from('or_jadwal_ujian_lisan oj');
		$this->db->join('v_program_angkatan vp', 'oj.angkatan_id = vp.angkatan_id');
		$array = array('vp.program_id' => $id_program);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->result();
		
	}
	
	public function jadwal_update($where, $data)
	{
		$this->db->update('or_jadwal_ujian_lisan', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function get_jadwal()
	{
		$this->db->select('*');
		$this->db->from('or_jadwal_ujian_lisan');
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function res_jadwal($where, $data)
	{
		$this->db->update('or_jadwal_ujian_lisan', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function ujian_lisan_update($where, $data){
		$this->db->update('or_ujian_lisan', $data, $where);
		return $this->db->affected_rows();
	}
	
 
}