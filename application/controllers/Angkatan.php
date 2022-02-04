<?php 
 
class Angkatan extends CI_Controller {
 
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->model('m_angkatan');
		$this->load->model('m_program');
	}

	public function index($id)
	{
		$data['angkatan'] = $this->m_angkatan->get_angkatan_by_programid($id);
		$data['listPrograms'] = $this->m_program->get_all_programs();
		$this->load->view('list_angkatan',$data);
	}
	
	public function show_angkatan($id)
	{
		$data['angkatan'] = $this->m_angkatan->get_angkatan_by_programid($id);
 		$data['program_id'] = $id;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id); 
		$data['listPrograms'] = $this->m_program->get_all_programs();
		$this->load->view('list_angkatan',$data);
	}
	
	public function angkatan_add()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'nama_angkatan' => $this->input->post('nama_angkatan'),
				'program_id' => $this->input->post('program_id'),
			);
		$insert = $this->m_angkatan->angkatan_add($data);
		
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
			'type' => 'ANGKATAN',
			'data_lama' => "-",
			'data_baru' => "Nama_Angkatan=".$this->input->post('nama_angkatan').";Program_Id=".$this->input->post('program_id'),
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
		$data = $this->m_angkatan->get_by_id($id);
		echo json_encode($data);
	}
 
	public function angkatan_update()
	{
		$data_old = $this->m_angkatan->get_by_id($this->input->post('id'));
		$data = array(
				'id' => $this->input->post('id'),
				'nama_angkatan' => $this->input->post('nama_angkatan'),
				'program_id' => $this->input->post('program_id'),
			);
		$this->m_angkatan->angkatan_update(array('id' => $this->input->post('id')), $data);
		
		//if there are updated
		if(($data_old->nama_angkatan != $this->input->post('nama_angkatan')) || ($data_old->program_id != $this->input->post('program_id'))){
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
				'type' => 'ANGKATAN',
				'data_lama' => "Nama_Angkatan=".$data_old->nama_angkatan.";Program_Id=".$data_old->program_id,
				'data_baru' => "Nama_Angkatan=".$this->input->post('nama_angkatan').";Program_Id=".$this->input->post('program_id'),
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
 
	public function angkatan_delete($id)
	{
		$data_old = $this->m_angkatan->get_by_id($id);
		$this->m_angkatan->delete_by_id($id);
		
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
			'type' => 'ANGKATAN',
			'data_lama' => "Nama_Angkatan=".$data_old->nama_angkatan.";Program_Id=".$data_old->program_id,
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