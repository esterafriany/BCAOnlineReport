<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Sertifikat extends CI_Controller {
 
 
	 public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->helper('url');
		$this->load->model('m_program');
		$this->load->model('m_angkatan');
		$this->load->model('m_ujian_lisan');
		$this->load->model('m_sertifikat');
		$this->load->model('m_ujian_tulis');
		
		$this->load->helper(array('form', 'url'));
	}
 
	public function index()
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_all_ujian_lisan();
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = null;
		$this->load->view('list_sertifikat',$data);
	}
	
	//export ke dalam format excel
	public function export_excel($id_program, $id_angkatan){
	   $data = array( 'title' => 'Daftar_Nilai_Gabungan '.date("Y-m-d"),
			'list_report' => $this->m_sertifikat->get_ujian_sertifikat_by_programid2($id_program, $id_angkatan));
			
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program; 
		$data['ang_id'] = $id_angkatan;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program); 
		$data['angkatan'] = $this->m_angkatan->get_nama_angkatan_by_id($id_angkatan);
		
		$data['jumlah_penguji'] = $this->m_ujian_lisan->get_jumlah_penguji($id_program);
			
	   $this->load->view('vw_laporan_sertifikat',$data);
	}
	
	
	public function show_report($id_program)
	{
		$data['list_report'] = $this->m_sertifikat->get_ujian_sertifikat_by_programid($id_program);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program);
		
		$this->load->view('list_sertifikat',$data);
	}
	
	public function show_report2($id_program, $id_angkatan)
	{
		$data['list_report'] = $this->m_sertifikat->get_ujian_sertifikat_by_programid2($id_program, $id_angkatan);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program; 
		$data['ang_id'] = $id_angkatan;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program); 
		$data['angkatan'] = $this->m_angkatan->get_nama_angkatan_by_id($id_angkatan);
		
		$data['jumlah_penguji'] = $this->m_ujian_lisan->get_jumlah_penguji($id_program);
		
		$this->load->view('list_sertifikat',$data);
	}
	
	public function get_sertifikat($nip, $program_id, $angkatan_id){
		$data = $this->m_sertifikat->get_sertifikat_by_nip($nip, $program_id, $angkatan_id);
		
		echo json_encode($data);
	}
	
	public function print_sertifikat($nip, $program_id, $angkatan_id)
	{
		$data['list_sertifikat'] = $this->m_sertifikat->get_sertifikat_by_nip($nip, $program_id, $angkatan_id);
		
		$this->load->view('detail_sertifikat',$data);
	}
	
}