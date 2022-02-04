<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_audit_trail extends CI_Model
{
	var $table = 'or_audit_trail';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_audit_trail()
	{
		$this->db->from('or_audit_trail');
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
 
 
}