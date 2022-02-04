<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class UjianLisan extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->helper('url');
		$this->load->model('m_ujian_lisan');
		$this->load->model('m_program');
		$this->load->model('m_angkatan');
		
	}
 
	public function index(){
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid2('bbbb', 'aaaa');// $this->m_ujian_lisan->get_all_ujian_lisan2();
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = null;
		$data['initial'] = "TRUE";
		$this->load->view('list_ujian_lisan', $data);
	}
	
	public function jadwal()
	{
		$data['listjadwal'] = $this->m_ujian_lisan->get_all_jadwal();
		
		$data['listPrograms'] = $this->m_program->get_all_programs();
		$this->load->view('list_jadwal',$data);
	}
	
	public function show_jadwal($id_program)
	{
		$data['listjadwal'] = $this->m_ujian_lisan->get_jadwal_by_program($id_program);
		$data['listPrograms'] = $this->m_program->get_all_programs();
		$data['program'] = $this->m_program->get_nama_program_by_id($id_program); 

		$this->load->view('list_jadwal',$data);
	}	
	
	public function ajax_edit_jadwal($angkatan_id)
	{
		$data = $this->m_ujian_lisan->get_jadwal_ujian_lisan($angkatan_id);
		echo json_encode($data);
	}
	

	public function jadwal_update()
	{
		$data_old = $this->m_ujian_lisan->get_jadwal_ujian_lisan($this->input->post('prg_id'));
		
		$data = array(
				'id' => $this->input->post('id'),
				'angkatan_id' => $this->input->post('prg_id'),
				'tanggal' => $this->input->post('selected_date'),
				'keterangan' => $this->input->post('keterangan'),

			);
		$this->m_ujian_lisan->jadwal_update(array('id' => $this->input->post('id')), $data);
		
		//if there are updated
		if($data_old->angkatan_id != $this->input->post('prg_id') || $data_old->tanggal != $this->input->post('selected_date') || $data_old->keterangan != $this->input->post('keterangan')){
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
				'type' => 'JADWAL UJIAN LISAN',
				'data_lama' => "Angkatan_Id=".$data_old->angkatan_id.";Tanggal=".$data_old->tanggal.";Keterangan=".$data_old->keterangan,
				'data_baru' => "Angkatan_Id=".$this->input->post('prg_id').";Tanggal=".$this->input->post('selected_date').";Keterangan=".$this->input->post('keterangan'),
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
		
	public function show_ujian_lisan($id_program)
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid($id_program);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program);
		$data['initial'] = "FALSE";
		$this->load->view('list_ujian_lisan',$data);
	}
	
	public function show_ujian_lisan2($id_program, $id_angkatan)
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid2($id_program, $id_angkatan);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program; 
		$data['ang_id'] = $id_angkatan;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program); 
		$data['angkatan'] = $this->m_angkatan->get_nama_angkatan_by_id($id_angkatan);
		$data['initial'] = "FALSE";
		$data['jumlah_penguji'] = $this->m_ujian_lisan->get_jumlah_penguji($id_program);
		
		

		$this->load->view('list_ujian_lisan',$data);
	}
	
	public function show_detail($id)
	{
		$data['detail_nilai'] = $this->m_ujian_lisan->get_detail_nilai_by_ujian_id($id);
		$data['penguji'] = $this->m_ujian_lisan->get_penguji_by_ujian_id($id);
		$data['peserta'] = $this->m_ujian_lisan->get_peserta_by_ujian_id($id);
		$this->load->view('detail_ujian_lisan',$data);
	}
	
	public function submit_nilai()
	{
		$this->load->view('masuk_penguji');
	}
 
	//export ke dalam format excel
	public function export_excel($angkatan_id, $jumlah_penguji){
		
		if($jumlah_penguji == 3){
			$data = array( 'title' => 'Data Hasil Ujian Lisan Tanggal '.date("Y-m-d"),
							'buku' => $this->m_ujian_lisan->getAll($angkatan_id));
			$data['jumlah_penguji'] = $jumlah_penguji;
			$this->load->view('vw_laporan_excel',$data);
		}else if($jumlah_penguji == 2){
			$data = array( 'title' => 'Data Hasil Ujian Lisan Tanggal '.date("Y-m-d"),
							'buku' => $this->m_ujian_lisan->getAll_dua_penguji($angkatan_id));
			$data['jumlah_penguji'] = $jumlah_penguji;
			$this->load->view('vw_laporan_excel',$data);
		}else{
			echo "<script>alert('Tidak dapat download ujian lisan. Jumlah penguji masih salah.')</script>";
			$data['ujian_lisan'] = $this->m_ujian_lisan->get_all_ujian_lisan();
			
			$data['listprograms'] = $this->m_program->get_all_programs();
			$data['listAngkatan'] = null;
			$this->load->view('list_ujian_lisan',$data);
		}
	   
	}
	
	public function reset_jadwal()
	{
		$data_jadwal = $this->m_ujian_lisan->get_jadwal();
		
		foreach($data_jadwal as $jadwal){
			$data = array(
				'id' => $jadwal->id,
				'angkatan_id' => $jadwal->angkatan_id,
				'tanggal' => '0000-00-00',
				'keterangan' => $jadwal->keterangan,
			);
			$this->m_ujian_lisan->res_jadwal(array('id' => $jadwal->id), $data);
		}
		echo json_encode(array("status" => TRUE));
		
		
	}
	
	public function delete_ujian_lisan($id, $id_program,$peserta_id, $penguji_id, $angkatan_id){
		$indeks_penguji = $this->m_ujian_lisan->get_indeks_penguji($id);
		$explode = explode(" ", $indeks_penguji->penguji);
		$j_penguji = $this->m_ujian_lisan->get_jumlah_penguji($id_program);
			
			$data_old = $this->m_ujian_lisan->get_ujian_lisan_by_id($id);
			//delete detail ujian lisan
			$this->m_ujian_lisan->delete_detail_by_id($id);
			//delete ujian lisan
			$this->m_ujian_lisan->delete_ujian_lisan_by_id($id);
			
			
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
				'id' => $this->input->post('id'),
				'user' => $this->session->userdata("username"),
				'type' => 'UJIAN LISAN',
				'data_lama' => "Nip_Peserta=".$data_old->nip_peserta.";Angkatan_Id=".$data_old->angkatan_id.";Penguji_Id=".$data_old->penguji_id.";Tanggal=".$data_old->tanggal.";Total_Nilai=".$data_old->total_nilai.";Komentar=".$data_old->komentar,
				'data_baru' => "-",
				'action' => "DELETED",
				'waktu' => date("Y-m-d H:i:s", $timestamp),
				'url' => $url."".$query,
				'ip_address' => $ip,
			);
			
			$insert = $this->m_program->program_trail_add($data2);
			//end add audit trail
			
			//update indeks penguji
			$sisa_nilai = $this->m_ujian_lisan->get_data_ujian_lisan($peserta_id, $angkatan_id);
			$sisa_nilai_rows = $this->m_ujian_lisan->get_data_ujian_lisan_rows($peserta_id, $angkatan_id);
			
			for ($i = 0; $i < $sisa_nilai_rows; $i++) {
				$num = "".$i+1;
				$data = array(
					'id' => $sisa_nilai[$i]->id,
					'penguji' => "Penguji ".$num,
				);
				$this->m_ujian_lisan->ujian_lisan_update(array('id' => $sisa_nilai[$i]->id), $data);
			}
		echo json_encode(array("status" => TRUE));
	}
	
	
	
	
}