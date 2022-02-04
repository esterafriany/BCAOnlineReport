<?php
 
class M_ujian_tulis extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }
 
    function get_addressbook() {     
        $query = $this->db->get('or_ujian_tulis');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
 
    public function insert_csv($data) {
		$this->db->insert('or_ujian_tulis', $data);
		
		
		$last_id = $this->db->insert_id();
		return $last_id;
    }
	
	public function get_ujian_tulis_by_programid($id)
	{
		$query = $this->db->query("select ut.id
					, id_peserta
					, ops.nama
					, ut.angkatan_id
					, oa.nama_angkatan
					, opr.id as id_program
					, opr.nama_program
					, posttest_score
					From or_ujian_tulis ut
					join or_peserta ops on ops.nip = ut.id_peserta
					join or_angkatan oa on oa.id = ut.angkatan_id
					join or_program opr on opr.id = oa.program_id
					where opr.id = ".$id);

		$result = $query->result();
		
        return $result;
	}
	
	public function get_ujian_tulis_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('or_ujian_tulis');
		$array = array('id' => $id);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function get_ujian_lisan_by_programid2($idprogram, $idangkatan)
	{
		$query = $this->db->query("select ut.id
					, id_peserta
					, ops.nama
					, ut.angkatan_id
					, oa.nama_angkatan
					, opr.id as id_program
					, opr.nama_program
					, posttest_score
					From or_ujian_tulis ut
					join or_peserta ops on ops.nip = ut.id_peserta
					join or_angkatan oa on oa.id = ut.angkatan_id
					join or_program opr on opr.id = oa.program_id
					where opr.id = ".$idprogram." and ut.angkatan_id = ".$idangkatan);

		$result = $query->result();
		
        return $result;
	}
	
	public function get_ujian_tulis_by_peserta_angkatanid($idpeserta, $idangkatan)
	{
		//$query = $this->db->query("select * from or_ujian_tulis ut where id_peserta = ".$idpeserta." and angkatan_id = ".$idangkatan);
		
		$this->db->select('*');
		$this->db->from('or_ujian_tulis');
		$array = array('id_peserta' => $idpeserta,'angkatan_id' => $idangkatan);
		$this->db->where($array); 
		$query = $this->db->get();
 
		return $query->row();
	}
	
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('or_ujian_tulis');
	}
	
	
	public function get_by_id($id, $idprogram, $idangkatan)
	{
		$query = $this->db->query("select ut.id
					, id_peserta
					, ops.nama
					, ut.angkatan_id
					, oa.nama_angkatan
					, opr.id as id_program
					, opr.nama_program
					, posttest_score
					, time_spent
					, ut.tanggal
					From or_ujian_tulis ut
					join or_peserta ops on ops.nip = ut.id_peserta
					join or_angkatan oa on oa.id = ut.angkatan_id
					join or_program opr on opr.id = oa.program_id
					where opr.id = ".$idprogram." and ut.angkatan_id = ".$idangkatan." and ut.id = ".$id);
		
        return $query->row();
	}
	
	public function ujian_tulis_update($where, $data)
	{
		$this->db->update('or_ujian_tulis', $data, $where);
		return $this->db->affected_rows();
	}
	
}
/*END OF FILE*/