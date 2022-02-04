<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
		$this->load->helper('url');
	}
	
	public function login_admin()
	{
		if($this->session->userdata('login') != "login"){
			$this->load->view('login_admin');
		}else{
			$this->load->view('home_admin');
		}
	}
	
	public function penguji()
	{
		$this->load->view('masuk_penguji');
	}
	
	public function home()
	{
		 redirect('welcome/penguji');
	}
	
	function mulai_penilaian(){
		
		$this->load->model('m_peserta');
		$this->load->model('m_ujian_lisan');
		$nip = $this->input->post('nip');
		$kode_unik = $this->input->post('kode_unik');
		
		//get angkatan by kodeunik peserta
		$angkatan = $this->m_peserta->get_peserta_by_kodeunik($kode_unik);
		$tgl = null;
		if(!empty($angkatan)){
			//getjadwal by angkatan
			$tgl = $this->m_ujian_lisan->get_jadwal_ujian_lisan($angkatan->angkatan_id);
		}
		
		//cek apakah ada ujian lisan program di tanggal hari ini
		if(!empty($tgl) && $tgl->tanggal != date("Y-m-d")){
			//jika tidak ada
			$data['error4'] = TRUE;
			$this->load->view('masuk_penguji',$data);
		}else{
			//jika ada
			//cek penguji 3
			$p_id = $this->m_ujian_lisan->getpeserta_by_kode_unik($kode_unik);
			$ang_id = $this->m_ujian_lisan->getangkatan_by_kode_unik($kode_unik);
			
			//cek jika dia peserta : ang_id <> 0
			if(!empty($ang_id) && $ang_id->angkatan_id <> 0){
				if(!empty($p_id) && !empty($ang_id)){
					$p3 = $this->m_ujian_lisan->get_penguji_by_peserta($p_id->id,$ang_id->angkatan_id,'Penguji 3');
				}
				
				if(!empty($p3))
				{
					//penguji sudah ada 3
					$data['error'] = TRUE;
					$this->load->view('masuk_penguji',$data);
				}else{
					//validasi kode unik
					if($nip != '' || $kode_unik)
					{
						//cek apakah penguji sudah pernah menguji peserta yang sama di tanggal yang sama
						//cek peserta, penguji, tanggal
						$id_penguji = $this->m_ujian_lisan->get_idpenguji($nip);
						
						if(!empty($id_penguji)){
							$jumlah_penguji = $this->m_ujian_lisan->cek_penguji($p_id->id, $id_penguji->id, date("Y-m-d"));
						}else{
							$jumlah_penguji = null;
						}
						
						
						if($jumlah_penguji == 0){
							$penguji = $this->m_peserta->get_numrows_peserta_nip($nip);
						   
							$data = $this->m_peserta->get_by_kodeunik($kode_unik);
							   
							if ($data == 1 && $penguji == 1)
							{
								$datas['penguji'] = $this->m_peserta->get_penguji_by_nip($nip);
								$datas['peserta'] = $this->m_peserta->get_peserta_by_kodeunik($kode_unik);
								
								$program_id = $this->m_peserta->get_program_id($kode_unik);
								$datas['kriterias'] = $this->m_peserta->get_kriteria_by_program_id($datas['peserta']->program_id);
								$datas['kode_unik'] = $this->input->post('kode_unik');
								
								 
								$this->load->view('form_penilaian', $datas);
							}
							else if ($data <> 1)
							{
									//show message information
									echo '<script>alert("Data tidak ada. Cek kode unik atau NIP Penguji yang benar.");</script>';
									$this->load->view('masuk_penguji');
							}
							else if ($penguji <> 1)
							{
									//show message information
									$datas['error5'] = TRUE;
									$this->load->view('masuk_penguji',$datas);
							}
						}else{
							//penguji sudah ada 3
							$data['error3'] = TRUE;
							$this->load->view('masuk_penguji',$data);
						}
							
					}else{
							echo '<script>alert("Masukkan Kode Unik Peserta atau NIP Anda!");</script>';
							$this->load->view('masuk_penguji');
					}
				}
			}else{
				
				$data['error2'] = TRUE;
				$this->load->view('masuk_penguji',$data);
			}
		}
	}
	
}