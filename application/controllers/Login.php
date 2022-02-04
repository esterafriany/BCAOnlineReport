<?php 
 
class Login extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('m_login');
		$this->load->helper('url');
		$this->load->model('m_peserta');
		$this->load->model('m_ujian_lisan');
		$this->load->model('m_program');
	}
 
	function index(){
		$this->load->view('login_admin');
	}
 
	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
			
		$cek = $this->m_login->cek_login("or_user",$where)->num_rows();
		$user_data = $this->m_login->cek_login("or_user",$where)->result();
		if($cek > 0){
			$data_session = array(
				'nama' => $user_data[0]->nama,
				'username' => $user_data[0]->username,
				'role' => $user_data[0]->role,
				'login' => "login"
				);
	
			$this->session->set_userdata($data_session);
			
			redirect(base_url("admin"));
		}else{
			$data['error'] = TRUE;
			$this->load->view('login_admin', $data);
		}
	}
 
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('welcome/login_admin'));
	}
	
	function submit_password(){
		$where = array(
			'username' => $this->session->userdata("username")
		);
		
		$cek = $this->m_login->cek_login("or_user",$where)->num_rows();
		$user_data = $this->m_login->cek_login("or_user",$where)->result();	
		
		$data['msg']= "NULL";
		if($cek > 0 && ($user_data[0]->password == md5($this->input->post('password_lama')))){
			if($this->input->post('password_baru') == $this->input->post('confirm_password')){
				//submit perubahan
				
				$data = array(
					'password' => md5($this->input->post('password_baru')),
				);
				
				$this->m_login->password_update($where, $data);
				
				//if there are updated
				if($this->input->post('password_lama') != $this->input->post('password_baru')){
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
						'type' => 'PASSWORD',
						'data_lama' => "Password=".$this->input->post('password_lama'),
						'data_baru' => "Password=".$this->input->post('password_baru'),
						'action' => "UPDATED",
						'waktu' => date("Y-m-d H:i:s", $timestamp),
						'url' => $url."".$query,
						'ip_address' => $ip,
					);
					
					$insert = $this->m_program->program_trail_add($data2);
					//end add audit trail
				}
								
				$data['msg'] = "Password berhasil diubah !";
			}else{
				$data['msg'] = "Confirm password masih salah !";
			}
		}else{
			$data['msg'] = "Password yang dimasukkan masih salah !";
		}
		
		$this->load->view('change_password', $data);
	}
	
}















