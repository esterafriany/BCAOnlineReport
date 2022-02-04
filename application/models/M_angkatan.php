<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_angkatan extends CI_Model
{
	var $table = 'or_angkatan';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_angkatan()
	{
		$this->db->from('or_angkatan');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function get_angkatan_by_programid($id)
	{
		$this->db->select('*, or_angkatan.id as `angkatan_id`');
		$this->db->from($this->table);
		$this->db->join('or_program', 'program_id = or_program.id');
		$this->db->where('program_id',$id);
		$query = $this->db->get();
 
		return $query->result();
	}
	
 
	public function get_numrows($id)
	{
		$this->db->from($this->table);
		$this->db->where('program_id',$id);
		$query = $this->db->get();
 
		return $query->num_rows();
	}
 
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_nama_angkatan_by_id($id)
	{
		$this->db->select('nama_angkatan');
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
 
	public function angkatan_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
 
	public function angkatan_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
 
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		
		$data = array(
			'angkatan_id' => 0,
		);
		
		$where = array('angkatan_id' => $id);
		
		$this->db->update('or_peserta', $data, $where);
		return $this->db->affected_rows();
		
	}
	
	public function peserta_update($where, $data)
	{
		$this->db->update('or_peserta', $data, $where);
		return $this->db->affected_rows();
	}
 
	
	
 
}