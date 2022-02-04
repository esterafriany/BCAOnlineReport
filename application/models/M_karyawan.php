<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_karyawan extends CI_Model
{
	var $table = 'or_peserta';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	public function get_all_karyawan()
	{
		$this->db->from('or_peserta');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function get_user()
	{
		$this->db->from('or_user');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_role()
	{
		$this->db->from('or_user_role');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_limited_karyawan($start)
	{
		$end=10;
		$this->db->select('*');
		$this->db->from('or_peserta');
		$this->db->limit(10,$start);
		$query=$this->db->get();
		return $query->result();
	}
	public function get_limited_karyawan_by_like($like,$start)
	{
		$end=10;
		$this->db->select('*');
		$this->db->from('or_peserta');
		$this->db->like('nama', $like, 'after');
		$this->db->limit(10,$start);
		$query=$this->db->get();
		return $query->result();
	}
	public function search_karyawan_by_like($like)
	{
		$end=10;
		$this->db->select('*');
		$this->db->from('or_peserta');
		$this->db->like('nama', $like, 'after');
		$query=$this->db->get();
		return $query->result();
	}
	public function get_count_karyawan()
	{
		$this->db->count('*');
		$this->db->from('or_peserta');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function getdetail_by_id($id)
	{
		$this->db->select('*,or_peserta.id as `peserta_id`, or_angkatan.id as `angkatan_id`, or_program.id as `prg_id`');
		$this->db->from($this->table);
		$this->db->join('or_angkatan', 'angkatan_id = or_angkatan.id');
		$this->db->join('or_program', 'program_id = or_program.id');
		$this->db->where('or_peserta.id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
		
	///////////////////////
 

	public function program_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function user_add($data)
	{
		$this->db->insert('or_user', $data);
		return $this->db->insert_id();
	}
 
	public function get_by_id($id)
	{
		$this->db->from('or_user');
		$this->db->where('id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function user_update($where, $data)
	{
		$this->db->update('or_user', $data, $where);
		return $this->db->affected_rows();
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
	
	public function _user_delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('or_user');
	}
 
 
}