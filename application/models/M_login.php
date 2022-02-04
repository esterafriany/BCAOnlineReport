<?php 
 
class M_login extends CI_Model{	
	function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}	
	
	function get_data_user($where){		
		return $this->db->get_where('or_user',$where)->result();
	}
	
	function password_update($where, $data)
	{
		$this->db->update('or_user', $data, $where);
		return $this->db->affected_rows();
	}
}