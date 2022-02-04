<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Karyawan extends CI_Controller {
 
 
	 public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->helper('url');
		$this->load->model('m_karyawan');
		$this->load->model('m_peserta');
		$this->load->model('m_program');
	}
 
	public function index()
	{
		$data['karyawan']=$this->m_karyawan->get_limited_karyawan(0);
		// $data['karyawan']=$this->m_karyawan->get_limited_karyawan_by_like('A',0);
		$query = $this->db->query('SELECT * FROM or_peserta');
		
		//$data['karyawan']=$this->m_karyawan->get_limited_karyawan_by_like($this->input->get('like'),$start);
		
		$data['Total_karyawan']=$query->num_rows();
		$this->load->view('list_karyawan',$data);
	}

	function ganti_password(){
		$this->load->view('change_password');
	}
	
	function manage_user(){
		$data['users'] = $this->m_karyawan->get_user();
		$data['roles'] = $this->m_karyawan->get_role();
		$this->load->view('manage_user', $data);
	}
	
	public function user_add()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('pass1')),
				'nama' => $this->input->post('role_name'),
				'role' => $this->input->post('role'),
		);
			
		$insert = $this->m_karyawan->user_add($data);
		
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
			'type' => 'USER',
			'data_lama' => "-",
			'data_baru' => "Username=".$this->input->post('username').";Password=".$this->input->post('password').";Nama=".$this->input->post('role_name').";Role=".$this->input->post('role'),
			'action' => "ADDED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_edit_user($id)
	{
		$data = $this->m_karyawan->get_by_id($id);
		echo json_encode($data);
	}
	
	public function user_update()
	{
		$data_old = $this->m_karyawan->get_by_id($this->input->post('id'));
		$data = array(
			'id' => $this->input->post('id'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('pass1')),
			'nama' => $this->input->post('role_name'),
			'role' => $this->input->post('role'),
		);
		
		$this->m_karyawan->user_update(array('id' => $this->input->post('id')), $data);
		
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
			'type' => 'USER',
			'data_lama' => "Username=".$data_old->username.";Password=".$data_old->password.";Nama=".$data_old->nama.";Role=".$data_old->role,
			'data_baru' => "Username=".$this->input->post('username').";Password=".$this->input->post('password').";Nama=".$this->input->post('role_name').";Role=".$this->input->post('role'),
			'action' => "UPDATED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function user_delete($id)
	{
		$data_old = $this->m_karyawan->get_by_id($id);
		$this->m_karyawan->_user_delete_by_id($id);
		
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
			'type' => 'USER',
			'data_lama' => "Username=".$data_old->username.";Password=".$data_old->password.";Nama=".$data_old->nama.";Role=".$data_old->role,
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
	
	public function showPaged()
	{
		if($this->input->get('like')!=null)
		{
			$temp=$this->input->get('like');
			$data['search_karyawan']=$this->m_karyawan->search_karyawan_by_like($temp);
			$query = $this->db->query('SELECT * FROM or_peserta WHERE nama LIKE "'.$temp.'%"');
		}
		else
		{
			$query = $this->db->query('SELECT * FROM or_peserta');
		}
		$data['Total_karyawan']=$query->num_rows();
		$start=($this->input->get('page')-1)*10;
		if($start<0){$start=0;}
		if($this->input->get('like')!=null)
		{
			$data['karyawan']=$this->m_karyawan->get_limited_karyawan_by_like($this->input->get('like'),$start);
		}
		else{
		$data['karyawan']=$this->m_karyawan->get_limited_karyawan($start);
		}
		$this->load->view('list_karyawan',$data);
	}
	
	
	public function ajax_edit($id)
	{
		$data = $this->m_peserta->get_by_id($id);
		echo json_encode($data);
	}
	
	public function show_peserta($id,$program_id)
	{
		$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($id);
		$data['angkatan_id'] = $id;
		$data['angkatan'] = $this->m_peserta->get_nama_angkatan($id);
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($program_id);
		$data['prog_id'] = $program_id;
		$data['program'] = $this->m_peserta->get_nama_program($program_id);
		
		$this->load->view('list_peserta',$data);
	}
	
	public function karyawan_add()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama'),
				'divisi' => $this->input->post('divisi'),
				'angkatan_id' => $this->input->post('angkatan_id'),
			);
		$insert = $this->m_peserta->peserta_add($data);
		
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
			'type' => 'KARYAWAN',
			'data_lama' => "-",
			'data_baru' => "NIP=".$this->input->post('nip').";Nama=".$this->input->post('nama').";Unit_Kerja=".$this->input->post('divisi').";Angkatan_Id=".$this->input->post('angkatan_id'),
			'action' => "ADDED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function karyawan_update()
	{
		$data_old = $this->m_peserta->get_by_id($this->input->post('id'));
		$data = array(
				'id' => $this->input->post('id'),
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama'),
				'divisi' => $this->input->post('divisi'),
				'angkatan_id' => $this->input->post('angkatan_id'),
			);
		$this->m_peserta->peserta_update(array('id' => $this->input->post('id')), $data);
		
		//if there are updated
		if(($data_old->nip != $this->input->post('nip')) || ($data_old->nama != $this->input->post('nama')) || ($data_old->divisi != $this->input->post('divisi')) || ($data_old->angkatan_id != $this->input->post('angkatan_id'))){
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
				'type' => 'KARYAWAN',
				'data_lama' => "NIP=".$data_old->nip.";Nama=".$data_old->nama.";Unit_Kerja=".$data_old->divisi.";Angkatan_Id=".$data_old->angkatan_id,
				'data_baru' => "NIP=".$this->input->post('nip').";Nama=".$this->input->post('nama').";Unit_Kerja=".$this->input->post('divisi').";Angkatan_Id=".$this->input->post('angkatan_id'),
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

	
	public function show_detil_karyawan($id)
	{
		$data['detil_karyawan'] = $this->m_karyawan->getdetail_by_id($id);
		
		$this->load->view('detail_karyawan',$data);
	}
}

