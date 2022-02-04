<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Kriteria extends CI_Controller {
 
 
	 public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		$this->load->helper('url');
		$this->load->model('m_kriteria');
		$this->load->model('m_program');
		$this->load->model('m_peserta');
	}
 
	public function index($id)
	{
		$data['kriterias']=$this->m_kriteria->get_kriteria_by_programid($id);
		
		$this->load->view('list_kriteria',$data);
	}
	
	public function show_kriteria($id)
	{
		$data['kriterias'] = $this->m_kriteria->get_kriteria_by_programid($id);
		
		$data['program'] = $this->m_peserta->get_nama_program($id);
		$data['program_id'] = $id;
		$data['listPrograms'] = $this->m_program->get_all_programs();
		$this->load->view('list_kriteria',$data);
	}
	
	public function kriteria_add()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'kriteria_penilaian' => $this->input->post('kriteria_penilaian'),
				'keterangan_penilaian' => $this->input->post('keterangan'),
				'komposisi_nilai' => $this->input->post('komposisi_nilai'),
				'program_id' => $this->input->post('program_id'),
			);
		$insert = $this->m_kriteria->kriteria_add($data);
		
		//add audit trail
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = $_SERVER['QUERY_STRING'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$timestamp = time();
		date_default_timezone_set("Asia/Bangkok");
		
		$data2 = array(
			'user' => $this->session->userdata("username"),
			'type' => 'KRITERIA',
			'data_lama' => "-",
			'data_baru' => "Kriteria=".$this->input->post('kriteria_penilaian').";Keterangan=".$this->input->post('keterangan').";Komposisi=".$this->input->post('komposisi_nilai').";Program_Id=".$this->input->post('program_id'),
			'action' => "ADDED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_edit($id)
	{
		$data = $this->m_kriteria->get_by_id($id);
		echo json_encode($data);
	}
 
	public function kriteria_update()
	{
		$data_old = $this->m_kriteria->get_by_id($this->input->post('id'));
		$data = array(
			'id' => $this->input->post('id'),
			'kriteria_penilaian' => $this->input->post('kriteria_penilaian'),
			'keterangan_penilaian' => $this->input->post('keterangan'),
			'komposisi_nilai' => $this->input->post('komposisi_nilai'),
			'program_id' => $this->input->post('program_id'),
			);
		$this->m_kriteria->kriteria_update(array('id' => $this->input->post('id')), $data);
		
		//if there are updated
		if(($data_old->kriteria_penilaian != $this->input->post('kriteria_penilaian')) || ($data_old->keterangan_penilaian != $this->input->post('keterangan')) || ($data_old->komposisi_nilai != $this->input->post('komposisi_nilai')) || ($data_old->program_id != $this->input->post('program_id'))){
			//add audit trail
			$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$query = $_SERVER['QUERY_STRING'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			$timestamp = time();
			date_default_timezone_set("Asia/Bangkok");
			
			$data2 = array(
				'user' => $this->session->userdata("username"),
				'type' => 'KRITERIA',
				'data_lama' => "Kriteria=".$data_old->kriteria_penilaian.";Keterangan=".$data_old->keterangan_penilaian.";Komposisi=".$data_old->komposisi_nilai.";Program_Id=".$data_old->program_id,
				'data_baru' => "Kriteria=".$this->input->post('kriteria_penilaian').";Keterangan=".$this->input->post('keterangan').";Komposisi=".$this->input->post('komposisi_nilai').";Program_Id=".$this->input->post('program_id'),
				'action' => "UPDATED",
				'waktu' => date("Y-m-d H:i:s", $timestamp),
				'url' => $url."".$query,
				'ip_address' => $ip,
			);
			
			$insert = $this->m_program->program_trail_add($data2);
			//end add audit trail
		}
		
		echo json_encode(array("status" => TRUE));
	}
 
	public function kriteria_delete($id)
	{
		$data_old = $this->m_kriteria->get_by_id($id);
		$this->m_kriteria->delete_by_id($id);
		
		//add audit trail
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = $_SERVER['QUERY_STRING'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$timestamp = time();
		date_default_timezone_set("Asia/Bangkok");
		
		$data2 = array(
			'user' => $this->session->userdata("username"),
			'type' => 'KRITERIA',
			'data_lama' => "Kriteria=".$data_old->kriteria_penilaian.";Keterangan=".$data_old->keterangan_penilaian.";Komposisi=".$data_old->komposisi_nilai.";Program_Id=".$data_old->program_id,
			'data_baru' => "-",
			'action' => "DELETED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
 
 
 
}