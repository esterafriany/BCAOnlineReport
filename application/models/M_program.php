<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_program extends CI_Model
{
	var $table = 'or_program';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_programs()
	{
		$this->db->from('or_program');
		$query=$this->db->get();
		return $query->result();
	}
	
	function get_all_program($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from or_program where nama_program like '%$st%' limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	function get_books_count($st = NULL){
        if ($st == "NIL") $st = "";
        $sql = "select * from or_program where nama_program like '%$st%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
 
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_nama_program_by_id($id)
	{
		$this->db->select('nama_program');
		$this->db->from($this->table);
		$this->db->where('id',$id);
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
	
	public function delete_angkatan_by_programid($id)
	{
		$this->db->where('program_id', $id);
		$this->db->delete('or_angkatan');
	}
 
	public function delete_kriteria_by_programid($id)
	{
		$this->db->where('program_id', $id);
		$this->db->delete('or_penilaian_program');
	}
	
	public function get_angkatan_by_program_id($id)
	{
		$this->db->select('*');
		$this->db->from('or_angkatan');
		$this->db->where('program_id',$id);
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function get_peserta_by_angkatan_id($id)
	{
		$this->db->select('*');
		$this->db->from('or_peserta');
		$this->db->where('angkatan_id',$id);
		$query = $this->db->get();
 
		return $query->result();
	}
	
	public function peserta_update($where, $data)
	{
		$this->db->update('or_peserta', $data, $where);
		return $this->db->affected_rows();
	}
 
	//audit trail
	public function program_trail_add($data)
	{
		$this->db->insert('or_audit_trail', $data);
		return $this->db->insert_id();
	}
 
}