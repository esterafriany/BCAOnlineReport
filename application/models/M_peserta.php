<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_peserta extends CI_Model
{
	var $table = 'or_peserta';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_peserta()
	{
		$this->db->from('or_peserta');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function get_all_peserta_for_enrol()
	{
		$this->db->from('or_peserta');
		$this->db->where('angkatan_id',0);
		$query=$this->db->get();
		return $query->result();
	}
	
	public function get_peserta_by_angkatanid($id)
	{
		$this->db->select('*, or_angkatan.id as angkatan_id, or_peserta.id as peserta_id');
		$this->db->from('or_peserta');
		$this->db->join('or_angkatan', 'angkatan_id = or_angkatan.id');
		$this->db->where('angkatan_id',$id);
		$query = $this->db->get();
 
		return $query->result();
	}
 
	public function get_numrows($id)
	{
		$this->db->from($this->table);
		$this->db->where('angkatan_id',$id);
		$query = $this->db->get();
 
		return $query->num_rows();
	}
	
	public function get_numrows_peserta_nip($nip)
	{
		$this->db->from($this->table);
		$this->db->where('nip',$nip);
		$query = $this->db->get();
 
		return $query->num_rows();
	}
	
	public function get_peserta_nip($nip)
	{
		$this->db->from($this->table);
		$this->db->where('nip',$nip);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_penguji_by_nip($nip)
	{
		//$this->db->select('*, or_angkatan.id as angkatan_id, or_peserta.id as peserta_id');
		$this->db->from($this->table);
		$this->db->where('nip',$nip);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	

 
	public function get_by_kodeunik($kode_unik)
	{
		$this->db->select('*', 'or_peserta.id as `peserta_id`');
		$this->db->from($this->table);
		$this->db->where('kode_unik',$kode_unik);
		$query = $this->db->get();
 
		return $query->num_rows();
	}
	
	public function get_peserta_by_kodeunik($kode_unik)
	{
		$this->db->select('*,or_peserta.id as `peserta_id`');
		$this->db->from($this->table);
		$this->db->join('or_angkatan', 'angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'program_id = or_program.id');
		$this->db->where('kode_unik',$kode_unik);
		$query = $this->db->get();
 
		return $query->row();
	}
	
 
	public function peserta_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
 
	public function peserta_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function enrol($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
 
 
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
 
	public function random_kode_unik(){
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$result = '';
		for ($i = 0; $i < 5; $i++)
			$result .= $characters[mt_rand(0, 61)];
		
		return $result;
	}
	
	public function get_program_id($kode_unik){
		$this->db->select('program_id');
		$this->db->from($this->table);
		$this->db->join('or_angkatan', 'angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'program_id = or_program.id');
		$this->db->where('kode_unik',$kode_unik);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_kriteria_by_program_id($id){
		$this->db->from('or_penilaian_program');
		$this->db->where('program_id',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function getAll_per_Angkatan($angkatan_id)
	{
		$this->db->select('*');
		$this->db->from('or_peserta');
		$this->db->where('angkatan_id',$angkatan_id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function get_nama_angkatan($id)
	{
		$this->db->select('nama_angkatan');
		$this->db->from('or_angkatan');
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_nama_program($id)
	{
		$this->db->select('nama_program');
		$this->db->from('or_program');
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function update_peserta($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
}