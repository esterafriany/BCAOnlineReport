<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_kriteria extends CI_Model
{
	var $table = 'or_penilaian_program';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_programs()
	{
		$this->db->from('or_penilaian_program');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function get_kriteria_by_programid($id)
	{
		$this->db->from('or_penilaian_program');
		//$this->db->from($this->table);
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
		$this->db->from('or_penilaian_program');
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
 
	public function kriteria_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
 
	public function kriteria_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
 
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
 
 
}