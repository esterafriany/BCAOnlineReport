<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class UjianLisan_penguji extends CI_Controller {
 
	 public function __construct()
	{
		parent::__construct();
				
		$this->load->helper('url');
		$this->load->model('m_ujian_lisan');
		$this->load->model('m_program');
		$this->load->model('m_angkatan');
		$this->load->model('m_kriteria');
		$this->load->model('m_peserta');
	}
 
	public function ajax_edit($id)
	{
		$data = $this->m_kriteria->get_by_id($id);
		echo json_encode($data);
	}
 
	public function index()
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_all_ujian_lisan();
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = null;
		$this->load->view('list_ujian_lisan',$data);
	}
	
	public function show_ujian_lisan($id_program)
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid($id_program);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		
		$this->load->view('list_ujian_lisan',$data);
	}
	
	public function show_ujian_lisan2($id_program, $id_angkatan)
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid2($id_program, $id_angkatan);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		
		$this->load->view('list_ujian_lisan',$data);
	}
	
	public function show_detail($id)
	{
		$data['detail_nilai'] = $this->m_ujian_lisan->get_detail_nilai_by_ujian_id($id);
		$data['penguji'] = $this->m_ujian_lisan->get_penguji_by_ujian_id($id);
		$data['peserta'] = $this->m_ujian_lisan->get_peserta_by_ujian_id($id);
		$this->load->view('detail_ujian_lisan',$data);
	}
	
	public function submit_nilai(){
		$id_penguji = $this->input->post('penguji_id');
		$id_peserta = $this->input->post('peserta_id');
		$nip_penguji = $this->input->post('nip_penguji');
		$jumlah_penguji = $this->m_ujian_lisan->get_jumlah_penguji_by_program_id($this->input->post('program_id'));
		
		//get number of kriteria
		$prog_id = $this->input->post('program_id');
		$num_kriteria = $this->m_kriteria->get_numrows($prog_id);
		
		$data_kriteria = array(
			'kriteria_id' => $this->input->post('kriteria_id'),
			'total_nilai' => $this->input->post('total_nilai'),
			'total_nilai2' => $this->input->post('nilai'),
			'komposisi_nilai' => $this->input->post('komposisi_nilai')
		);
		
		$status_nilai = "true";
		$t_nilai = 0;
		$nilai_per_kriteria = 0;
		
		for($i = 0; $i < $num_kriteria; $i++)
		{
			if($data_kriteria['total_nilai2'][$i] ==""){
				$status_nilai = "false";
				//break;
			}
			
			$nilai_per_kriteria = ($data_kriteria['total_nilai2'][$i] * $data_kriteria['komposisi_nilai'][$i])/100;
			
			$t_nilai = $t_nilai + $nilai_per_kriteria;
		}
		//echo $t_nilai;

		for($cek_penguji = 1; cek_penguji <= $jumlah_penguji; $cek_penguji++){
			
		}
		
		//cek penguji 1
		$p1 = $this->m_ujian_lisan->get_penguji_by_peserta($this->input->post('peserta_id'),$this->input->post('angkatan_id'),'Penguji 1');
		//cek penguji 2
		$p2 = $this->m_ujian_lisan->get_penguji_by_peserta($this->input->post('peserta_id'),$this->input->post('angkatan_id'),'Penguji 2');
		//cek penguji 3
		$p3 = $this->m_ujian_lisan->get_penguji_by_peserta($this->input->post('peserta_id'),$this->input->post('angkatan_id'),'Penguji 3');
		
		
		if(empty($p1)){
			$penguji = 'Penguji 1';
		}else if(empty($p2)){
			$penguji = 'Penguji 2';
		}else if(empty($p3)){
			$penguji = 'Penguji 3';
		}
		//time setting
		$timestamp = time();
		date_default_timezone_set("Asia/Bangkok");
		
		/*/insert table or_ujian_lisan
		$this->db->insert('or_ujian_lisan',
			array(
				'id' => '',
				'peserta_id' => $this->input->post('peserta_id'),
				'nip_peserta' => $this->input->post('nip_peserta'),
				'angkatan_id' => $this->input->post('angkatan_id'),
				'penguji_id' => $this->input->post('penguji_id'),
				'penguji' => $penguji,
				'tanggal' => date("Y-m-d H:i:s", $timestamp),
				'total_nilai' => $t_nilai,
				'komentar' => $this->input->post('komentar'),
				'status_ujian' => 1
			)
		);*/
				
		$this->db->query("INSERT INTO or_ujian_lisan (peserta_id, nip_peserta, angkatan_id, penguji_id, penguji, tanggal, total_nilai, komentar, status_ujian)
			SELECT * FROM (SELECT ".$this->input->post('peserta_id').",".$this->input->post('nip_peserta').",".$this->input->post('angkatan_id').",".$this->input->post('penguji_id').",'".$penguji."','".date("Y-m-d H:i:s", $timestamp)."',".$t_nilai.",'".$this->input->post('komentar')."',1) AS tmp
			WHERE NOT EXISTS (
				SELECT * FROM or_ujian_lisan WHERE nip_peserta = ".$this->input->post('nip_peserta')." and angkatan_id = ".$this->input->post('angkatan_id')." and penguji_id = ".$this->input->post('penguji_id')."
			) LIMIT 1; ");
		
		$inserted_id = $this->db->insert_id();
		
		for($i = 0; $i < $num_kriteria; $i++){
			$this->db->insert('or_detail_nilai_ujian_lisan',
				array(
				'id' => '',
				'ujian_id' => $inserted_id,
				'penilaian_program_id' => $data_kriteria['kriteria_id'][$i],
				'nilai' => $data_kriteria['total_nilai2'][$i],
				//'nilai' => $this->input->post('total_nilai'.$i),
				)
			);
		}

		//load rekapitulasi
		$data['detail_nilai'] = $this->m_ujian_lisan->get_detail_nilai_by_ujian_id($inserted_id);
		$data['penguji'] = $this->m_ujian_lisan->get_penguji_by_ujian_id($inserted_id);
		$data['peserta'] = $this->m_ujian_lisan->get_peserta_by_ujian_id($inserted_id);
		$data['result'] = "Nilai berhasil disubmit. Proses Penilaian sudah selesai.";
		
		$this->load->view('rekap_nilai',$data);
	}
	
}