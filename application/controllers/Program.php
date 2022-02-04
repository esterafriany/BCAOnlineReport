<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Program extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->helper('url');
		$this->load->model('m_program');
		$this->load->helper('form');
        $this->load->database();
	}
 
	public function index() {
		$data['books']=$this->m_program->get_all_programs();
		$this->load->view('list_program',$data);
	}
	
	public function test() {
		$this->load->view('test_paging');
	}
	
	public function index2() {
        //pagination settings
        $config['base_url'] = base_url('Program/index');
        $config['total_rows'] = $this->db->count_all('tbl_books');
        $config['per_page'] = "10";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
		$config['display_pages'] = FALSE;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>' . "\n";
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>' . "\n";
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>' . "\n";
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>' . "\n";
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // get books list
		$data['books'] = $this->m_program->get_all_program($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
        
        // load view
        $this->load->view('list_program',$data);
    }
	
		
	function search() {
        //get search string
        $search = ($this->input->post("book_name"))? $this->input->post("book_name") : "NIL";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        //pagination settings
        $config = array();
        $config['base_url'] = base_url("Program/search/$search");
        $config['total_rows'] = $this->m_program->get_books_count($search);
        $config['per_page'] = "10";
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
		$config['display_pages'] = FALSE;
		
        //integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>' . "\n";
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>' . "\n";
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>' . "\n";
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>' . "\n";
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        //get books list
        $data['books'] = $this->m_program->get_all_program($config['per_page'], $data['page'], $search);
        $data['pagination'] = $this->pagination->create_links();

        //load view
        $this->load->view('list_program',$data);
    }
		
	public function program_add(){
		$data = array(
			'id' => $this->input->post('id'),
			'nama_program' => $this->input->post('nama_program'),
			'nama_program_lengkap' => $this->input->post('program_name'),
			'jumlah_penguji' => $this->input->post('jumlah_penguji'),
			);
		$insert = $this->m_program->program_add($data);
		
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
			'type' => 'PROGRAM',
			'data_lama' => "-",
			'data_baru' => "Nama_Program=".$this->input->post('nama_program').";Nama_Program_Lengkap=".$this->input->post('program_name').";Jumlah_Penguji=".$this->input->post('jumlah_penguji'),
			'action' => "ADDED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_edit($id) {
		$data = $this->m_program->get_by_id($id);
		echo json_encode($data);
	}
 
	public function program_update() {
		$data_old = $this->m_program->get_by_id($this->input->post('id'));
		
		//if there are updated
		if(($data_old->nama_program != $this->input->post('nama_program')) || ($data_old->nama_program_lengkap != $this->input->post('program_name')) || ($data_old->jumlah_penguji!=$this->input->post('jumlah_penguji'))){
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
				'type' => 'PROGRAM',
				'data_lama' => "Nama_Program=".$data_old->nama_program.";Nama_Program_Lengkap=".$data_old->nama_program_lengkap.";Jumlah_Penguji=".$data_old->jumlah_penguji,
				'data_baru' => "Nama_Program=".$this->input->post('nama_program').";Nama_Program_Lengkap=".$this->input->post('program_name').";Jumlah_Penguji=".$this->input->post('jumlah_penguji'),
				'action' => "UPDATED",
				'waktu' => date("Y-m-d H:i:s", $timestamp),
				'url' => $url."".$query,
				'ip_address' => $ip,
			);
			
			$insert = $this->m_program->program_trail_add($data2);
			//end add audit trail
		}
		
		$data = array(
			'id' => $this->input->post('id'),
			'nama_program' => $this->input->post('nama_program'),
			'nama_program_lengkap' => $this->input->post('program_name'),
			'jumlah_penguji' => $this->input->post('jumlah_penguji'),
		);
		
		$this->m_program->program_update(array('id' => $this->input->post('id')), $data);
		
		echo json_encode(array("status" => TRUE));
	}
 
	public function program_delete($id){
		$data_old = $this->m_program->get_by_id($id);
		//delete program
		$this->m_program->delete_by_id($id);
		
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
			'type' => 'PROGRAM',
			'data_lama' => "Nama_Program=".$data_old->nama_program.";Nama_Program_Lengkap=".$data_old->nama_program_lengkap.";Jumlah_Penguji=".$data_old->jumlah_penguji,
			'data_baru' => "-",
			'action' => "DELETED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
				
		//delete kriteria 
		$this->m_program->delete_kriteria_by_programid($id);
		
		//reset angkatan peserta
		$angkatan_id = $this->m_program->get_angkatan_by_program_id($id); 
		
		foreach($angkatan_id as $angkatan){
			$peserta_by_angkatan_id = $this->m_program->get_peserta_by_angkatan_id($angkatan->id); 
			
			foreach($peserta_by_angkatan_id as $peserta){
				$data2 = array(
					'id' => $peserta->id,
					'angkatan_id' => 0,
				);
				$this->m_program->peserta_update(array('id' => $peserta->id), $data2);
			}
		}
		
		//delete angkatan
		$this->m_program->delete_angkatan_by_programid($id);
		
		echo json_encode(array("status" => TRUE));
	}
}