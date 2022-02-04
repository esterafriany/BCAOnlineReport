<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class UjianTulis extends CI_Controller {
 
 
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
		$this->load->model('m_ujian_tulis');
		$this->load->library('csvimport');
		
		 $this->load->helper(array('form', 'url'));
	}
 
	public function index()
	{
		$data['ujian_lisan'] = $this->m_ujian_lisan->get_all_ujian_lisan();
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = null;
		$this->load->view('list_ujian_tulis',$data);
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
		$data = array(
				'id' => $this->input->post('id'),
				'angkatan_id' => $this->input->post('prg_id'),
				'tanggal' => $this->input->post('selected_date'),
				'keterangan' => $this->input->post('keterangan'),

			);
		$this->m_ujian_lisan->jadwal_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	
	public function show_ujian_tulis($id_program)
	{
		$data['ujian_tulis'] = $this->m_ujian_tulis->get_ujian_tulis_by_programid($id_program);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program);
		
		$this->load->view('list_ujian_tulis',$data);
	}
	
	public function show_ujian_tulis2($id_program, $id_angkatan)
	{
		$data['ujian_tulis'] = $this->m_ujian_tulis->get_ujian_lisan_by_programid2($id_program, $id_angkatan);
		$data['listprograms'] = $this->m_program->get_all_programs();
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($id_program);
		$data['id_program'] = $id_program; 
		$data['ang_id'] = $id_angkatan;
		$data['program'] =  $this->m_program->get_nama_program_by_id($id_program); 
		$data['angkatan'] = $this->m_angkatan->get_nama_angkatan_by_id($id_angkatan);
		$data['jumlah_penguji'] = $this->m_ujian_lisan->get_jumlah_penguji($id_program);
		
		$this->load->view('list_ujian_tulis',$data);
	}
	
	function importcsv(){
		$angkatan_id = $this->input->post('angk_id');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
		$config['encrypt_name']  = TRUE;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
 
        // If upload failed, display error
		$img = "btnPlaceOrder";
        if (!$this->upload->do_upload($img)) {
            $data['error'] = $this->upload->display_errors();
			$data['message'] = "File yang diupload tidak valid!";
			
			redirect ('UjianTulis/show_ujian_tulis2/'.$this->input->post('prg_id').'/'.$this->input->post('angk_id'));
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
			
			//checking filename
			$filename = pathinfo($_FILES['btnPlaceOrder']['name'], PATHINFO_FILENAME);
			$explode = explode("_", $filename); 
			
			if (preg_match('/_/',$filename)){
				
				if($explode[1] == $this->input->post('nama_prog') && $explode[2] == $this->input->post('nama_angk')){
					if ($this->csvimport->get_array($file_path)) {
						$csv_array = $this->csvimport->get_array($file_path);

						//print_r(array_values($csv_array));
						$i = 0;
						foreach ($csv_array as $row) {
							if (array_key_exists('id_peserta', $row) && array_key_exists('nama', $row) && array_key_exists('course_name', $row) && array_key_exists('time_spent', $row) && array_key_exists('posttest_score', $row) && array_key_exists('tanggal', $row)) {
								$insert_data = array(
									'id_peserta'=>$row['id_peserta'],
									'angkatan_id'=>$angkatan_id,
									'course_name'=>$row['course_name'],
									'time_spent'=>$row['time_spent'],
									'posttest_score'=>str_replace(",",".",$row['posttest_score']),
									'tanggal'=>$row['tanggal'],
								);
								
								//cek jika id_peserta dan angkatan_id sudah ada di database.
								$data_ujian_tulis = $this->m_ujian_tulis->get_ujian_tulis_by_peserta_angkatanid($row['id_peserta'],$angkatan_id);
																
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
									'type' => 'UJIAN TULIS',
									'data_lama' => "-",
									'data_baru' => "NIP=".$row['id_peserta'].";Angkatan_ID=".$angkatan_id.";Time_Spent=".$row['time_spent'].";Posttest_Score=".$row['posttest_score'].";Tanggal=".$row['tanggal'],
									'action' => "ADDED",
									'waktu' => date("Y-m-d H:i:s", $timestamp),
									'url' => $url."".$query,
									'ip_address' => $ip,
								);
							
								
								if(empty($data_ujian_tulis->id_peserta) ){
									$last_id = $this->m_ujian_tulis->insert_csv($insert_data);
									$insert = $this->m_program->program_trail_add($data2);
								}
								//end add audit trail
								
							}else{
								$data['message'] = "File yang diupload tidak valid!";
							}
						}
						
						if($i==0){
							$data['message'] = "Data peserta berhasil di import!";
						}else{
							$data['message'] = "Data peserta berhasil di import! ".$i." data gagal diupload.";
						}
						$this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
						redirect ('UjianTulis/show_ujian_tulis2/'.$this->input->post('prg_id').'/'.$this->input->post('angk_id'));
					} else {
						redirect ('UjianTulis/show_ujian_tulis2/'.$this->input->post('prg_id').'/'.$this->input->post('angk_id'));
					}
					
				}else{
					redirect ('UjianTulis/show_ujian_tulis2/'.$this->input->post('prg_id').'/'.$this->input->post('angk_id'));
				}
			}else{
				$data['message'] = "File yang diupload tidak valid!";
				$data['ujian_lisan'] = $this->m_ujian_lisan->get_ujian_lisan_by_programid2($this->input->post('prg_id'), $this->input->post('angk_id'));
				$data['listprograms'] = $this->m_program->get_all_programs();
				$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($this->input->post('prg_id'));
				$data['id_program'] = $this->input->post('prg_id'); 
				$data['ang_id'] =  $this->input->post('angk_id');
				$data['program'] =  $this->m_program->get_nama_program_by_id($this->input->post('prg_id')); 
				$data['angkatan'] = $this->m_angkatan->get_nama_angkatan_by_id( $this->input->post('angk_id'));
				$data['message'] = "Penamaan File tidak sesuai format!";
				$data['jumlah_penguji'] = $this->m_ujian_lisan->get_jumlah_penguji($this->input->post('prg_id'));
				
				$this->load->view('list_ujian_tulis',$data);
			}
        }
    }
	
	function delete_ujian_tulis($id, $id_angkatan, $id_program){
		$data_old = $this->m_ujian_tulis->get_by_id($id, $id_program, $id_angkatan);
		$this->m_ujian_tulis->delete_by_id($id);
		
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
			'type' => 'UJIAN TULIS',
			'data_lama' => "NIP=".$data_old->id.";Angkatan_ID=".$data_old->angkatan_id.";Time_Spent=".$data_old->time_spent.";Posttest_Score=".$data_old->posttest_score.";Tanggal=".$data_old->tanggal,
			'data_baru' => "-",
			'action' => "DELETED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		redirect ('UjianTulis/show_ujian_tulis2/'.$id_program.'/'.$id_angkatan);
	}
	
	public function ajax_edit($id, $idprogram, $idangkatan)
	{
		$data = $this->m_ujian_tulis->get_by_id($id, $idprogram, $idangkatan);
		echo json_encode($data);
	}
	
	public function ujian_tulis_update(){
		$data_old = $this->m_ujian_tulis->get_ujian_tulis_by_id($this->input->post('id'));
		$data = array(
				'id' => $this->input->post('id'),
				'posttest_score' => $this->input->post('score'),
			);
		$this->m_ujian_tulis->ujian_tulis_update(array('id' => $this->input->post('id')), $data);
		
		if($data_old->posttest_score != $this->input->post('score')){
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
				'type' => 'UJIAN TULIS',
				'data_lama' => "NIP=".$data_old->id.";Angkatan_ID=".$data_old->angkatan_id.";Time_Spent=".$data_old->time_spent.";Posttest_Score=".$data_old->posttest_score.";Tanggal=".$data_old->tanggal,
				'data_baru' => "NIP=".$data_old->id.";Angkatan_ID=".$data_old->angkatan_id.";Time_Spent=".$data_old->time_spent.";Posttest_Score=".$this->input->post('score').";Tanggal=".$data_old->tanggal,
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
}