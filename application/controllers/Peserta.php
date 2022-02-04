<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Peserta extends CI_Controller {
 
 
	 public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		$this->load->helper('url');
		$this->load->model('m_peserta');
		$this->load->model('m_angkatan');
		$this->load->model('m_karyawan');
		$this->load->model('m_program');
		$this->load->library('csvimport');
		
		$this->load->helper(array('form', 'url')); 
		$this->load->helper("file");
		$this->load->helper('download');
	}
 
	public function index($id)
	{
		$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($id);
		$this->load->view('list_peserta',$data);
	}
	
	public function index2() { 
        $this->load->view('upload_form', array('error' => ' ' )); 
    } 
	
	public function download($fileName){
		if ($fileName) {
			$file = realpath('./uploads')."\\".$fileName ;   
			if (file_exists ( $file )) {
				/*save download
				// get file content
				//$data = file_get_contents ( $file );
				//force download
				//force_download ( $fileName, $data );
				//end save download */
				
				redirect(base_url('uploads/'.$fileName));
			} else {
				// Redirect to base url
				//redirect ( base_url () );
			}
		}
	}
	
	public function delete_file($fileName, $id) { 
		$file = realpath('./uploads')."\\".$fileName ;   
		unlink($file);
		$data = array(
			'id' => $id,
			'file_lampiran' => "",
		);
		$this->m_peserta->peserta_update(array('id' => $id), $data);
		$data['message'] = 'File berhasil dihapus';
		echo json_encode($data);
	}
	
	public function do_upload() {
		$nip = $this->input->post('nip');
		$id = $this->input->post('id_p');
		$config['upload_path']   	= './uploads/'; 
		$config['allowed_types'] 	= 'pdf'; 
		$config['max_size']      	= 100; 
		$config['max_width']     	= 1024;
		$config['max_height']		= 768;  
		$config['file_name'] 		= $nip;
		$config['overwrite'] 		= TRUE;
		$this->load->library('upload', $config);
		$karyawan = $this->m_karyawan->getdetail_by_id($id);
		
		$data['message'] = 'File yang diupload harus pdf!';
		
		if (!$this->upload->do_upload('lampiran')) {
			$status = FALSE;
		} else {
			$status = TRUE;
		}

		if($status == TRUE){
			$data = array(
				'id' => $id,
				'file_lampiran' => "".$nip.".".$config['allowed_types'],
			);
			$this->m_peserta->peserta_update(array('id' => $id), $data);
			$data['message'] = 'File berhasil diupload';
		}
		
		redirect('Peserta/show_peserta/'.$karyawan->angkatan_id.'/'.$karyawan->prg_id);
		
	
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
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_edit($id)
	{
		$data = $this->m_peserta->get_by_id($id);
		echo json_encode($data);
	}
 
	public function karyawan_update()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama'),
				'divisi' => $this->input->post('divisi'),
				'angkatan_id' => $this->input->post('angkatan_id'),
			);
		$this->m_peserta->peserta_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
 
	public function karyawan_delete($id)
	{
		$data_old = $this->m_peserta->get_by_id($id);
		$this->m_peserta->delete_by_id($id);
		
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
			'user' => $this->session->userdata("nama"),
			'type' => 'KARYAWAN',
			'data_lama' => "NIP=".$data_old->nip.";Nama=".$data_old->nama.";Unit_Kerja=".$data_old->divisi.";Angkatan_Id=".$data_old->angkatan_id,
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
 
	public function ajax_enrol()
	{
		$data = $this->m_peserta->get_all_peserta_for_enrol();
		echo json_encode($data);
	}
	
	public function enrol_karyawan($id, $angkatan_id)
	{
		$data = array(
				'id' => $id,
				'angkatan_id' => $angkatan_id,
			);
		$this->m_peserta->peserta_update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function unenrol_peserta($id, $ang_id_display){
		$karyawan = $this->m_karyawan->getdetail_by_id($id);
		
		$data = array(
				'id' => $id,
				'angkatan_id' => 0,
			);
		$this->m_peserta->peserta_update(array('id' => $id), $data);
		
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
			'user' => $this->session->userdata("nama"),
			'type' => 'PESERTA',
			'data_lama' => "NIP=".$karyawan->nip.";Angkatan_Id=".$karyawan->angkatan_id.";Kode_Unik=".$karyawan->kode_unik,
			'data_baru' => "-",
			'action' => "UNENROLLED",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail
		
		redirect('Peserta/show_peserta/'.$ang_id_display.'/'.$karyawan->prg_id);
	}
	
	public function generate_kode_unik($angkatan_id)
	{
		$data_peserta = $this->m_peserta->get_peserta_by_angkatanid($angkatan_id);
		
		foreach($data_peserta as $peserta){
			$kode_unik = $this->m_peserta->random_kode_unik();
			$data = array(
				'id' => $peserta->peserta_id,
				'nip' => $peserta->nip,
				'nama' => $peserta->nama,
				'divisi' => $peserta->divisi,
				'kode_unik' => $kode_unik,
				'angkatan_id' => $peserta->angkatan_id,
			);
			$this->m_peserta->peserta_update(array('id' => $peserta->peserta_id), $data);
		}
		echo json_encode(array("status" => TRUE));
	}
	
	public function generate_kode_unik_peserta($id)
	{
		$data_peserta = $this->m_peserta->get_by_id($id);
		$kode_unik = $this->m_peserta->random_kode_unik();
		
		$data = array(
			'id' => $data_peserta->id,
			'nip' => $data_peserta->nip,
			'nama' => $data_peserta->nama,
			'divisi' => $data_peserta->divisi,
			'kode_unik' => $kode_unik,
			'angkatan_id' => $data_peserta->angkatan_id,
		);
		
		$this->m_peserta->peserta_update(array('id' => $data_peserta->id), $data);
		
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
			'user' => $this->session->userdata("nama"),
			'type' => 'PESERTA',
			'data_lama' => "NIP=".$data_peserta->nip.";Angkatan_Id=".$data_peserta->angkatan_id.";Kode_Unik=".$data_peserta->kode_unik,
			'data_baru' => "NIP=".$data_peserta->nip.";Angkatan_Id=".$data_peserta->angkatan_id.";Kode_Unik=".$kode_unik,
			'action' => "UPDATED KODE UNIK",
			'waktu' => date("Y-m-d H:i:s", $timestamp),
			'url' => $url."".$query,
			'ip_address' => $ip,
		);
		
		$insert = $this->m_program->program_trail_add($data2);
		//end add audit trail		
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function random(){
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$result = '';
		for ($i = 0; $i < 5; $i++)
			$result .= $characters[mt_rand(0, 61)];
	}
	
	public function enrol()
	{
		if(!empty($_POST['ang_id'])) {
			$ang = array(
				'angkatan_id' => $this->input->post('ang_id'),
			);
			
			$data = array();
			$enrol = $this->input->post('enrol');
			if(!empty($enrol)){
				foreach($this->input->post('enrol') as $enrol) 
				{
				   $data[] = array('enrol_karyawan' => $enrol);
				   $this->m_peserta->enrol(array('id' => $enrol), $ang);
				}
				
				$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($this->input->post('ang_id'));
				$data['angkatan_id'] = $this->input->post('ang_id'); 
				$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($this->input->post('prg_id'));
				$data['prog_id'] = $this->input->post('prg_id');
				
				$data['angkatan'] = $this->m_peserta->get_nama_angkatan($this->input->post('ang_id'));
				$data['program'] = $this->m_peserta->get_nama_program($this->input->post('prg_id'));
				
				$this->load->view('list_peserta',$data);
			}else{
				echo "<script>";
				echo "alert('Tidak ada peserta yang dipilih.');";
				echo "</script>";
				
				$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($this->input->post('ang_id'));
				$data['angkatan_id'] = $this->input->post('ang_id'); 
				$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($this->input->post('prg_id'));
				$data['prog_id'] = $this->input->post('prg_id');
				
				$data['angkatan'] = $this->m_peserta->get_nama_angkatan($this->input->post('ang_id'));
				$data['program'] = $this->m_peserta->get_nama_program($this->input->post('prg_id'));
				
				$this->load->view('list_peserta',$data);
			}
		}else{
			echo "<script>";
			echo "alert('Tidak ada peserta yang dipilih.');";
			echo "</script>";
		}
	}
	
	public function enrol2($angkatan_id, $program_id)
	{
		$data = array();
		$enrol = $this->input->post('enrol');
		
		$data_peserta = $this->input->post('data'); 

		foreach($data_peserta as $enrol) 
		{
		   $data[] = array('enrol_karyawan' => $enrol);
		   $this->m_peserta->enrol(array('id' => $enrol), $angkatan_id);
		}

		$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($angkatan_id);
		$data['angkatan_id'] = $angkatan_id; 
		$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($program_id);
		$data['prog_id'] = $program_id;
		
		$data['angkatan'] = $this->m_peserta->get_nama_angkatan($angkatan_id);
		$data['program'] = $this->m_peserta->get_nama_program($program_id);
		
		$this->load->view('list_peserta',$data);
		echo json_encode(array("status" => TRUE));
	}
	
	//export ke dalam format excel
	public function export_excel($angkatan_id){
	   $data = array( 'title' => 'Daftar Kode Unik Peserta '.date("Y-m-d"),
			'peserta' => $this->m_peserta->getAll_per_Angkatan($angkatan_id));

	   $this->load->view('vw_laporan_peserta',$data);
	}
	
	function importcsv() {
		$angkatan_id = $this->input->post('angk_id');
		$program_id = $this->input->post('prg_id');
		
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = "csv";
        $config['max_size'] = '1000';
		$config['encrypt_name']  = TRUE;
 
        $this->load->library('upload', $config);
		$this->upload->initialize($config);
        // If upload failed, display error
		$img = "btnPlaceOrder";
        if (!$this->upload->do_upload($img)) {
            $data['error'] = $this->upload->display_errors();
			$data['message'] = "File yang diupload tidak valid!";
			
			$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($angkatan_id);
			$data['angkatan_id'] = $angkatan_id;
			$data['angkatan'] = $this->m_peserta->get_nama_angkatan($angkatan_id);
			$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($program_id);
			$data['prog_id'] = $program_id;
			$data['program'] = $this->m_peserta->get_nama_program($program_id);
					
            $this->load->view('list_peserta', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
			
			//checking filename
			$filename = pathinfo($_FILES['btnPlaceOrder']['name'], PATHINFO_FILENAME);
		
			if ($this->csvimport->get_array($file_path)) {
				$csv_array = $this->csvimport->get_array($file_path);

					foreach ($csv_array as $row) {
						if (array_key_exists('nip', $row)) {
							$data_old = $this->m_peserta->get_peserta_nip($row['nip']);
							$insert_data = array(
								'nip'=>$row['nip'],
								'angkatan_id' => $angkatan_id,
							);
							$this->m_peserta->update_peserta(array('nip' => $row['nip']), $insert_data);
							
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
								'user' => $this->session->userdata("nama"),
								'type' => 'PESERTA',
								'data_lama' => "NIP=".$row['nip'].";Angkatan_Id=".$data_old->angkatan_id.";Kode_Unik=".$data_old->kode_unik,
								'data_baru' => "NIP=".$row['nip'].";Angkatan_Id=".$angkatan_id.";Kode_Unik=".$data_old->kode_unik,
								'action' => "ENROLLED",
								'waktu' => date("Y-m-d H:i:s", $timestamp),
								'url' => $url."".$query,
								'ip_address' => $ip,
							);
							if($data_old->angkatan_id != $angkatan_id){
								$insert = $this->m_program->program_trail_add($data2);
							}
							//end add audit trail
							
							$data['message'] = "Data peserta berhasil di import!";
						}else{
							$data['message'] = "File yang diupload tidak valid!";
						}
					}
			
				$data['peserta'] = $this->m_peserta->get_peserta_by_angkatanid($angkatan_id);
				$data['angkatan_id'] = $angkatan_id;
				$data['angkatan'] = $this->m_peserta->get_nama_angkatan($angkatan_id);
				$data['listAngkatan'] = $this->m_angkatan->get_angkatan_by_programid($program_id);
				$data['prog_id'] = $program_id;
				$data['program'] = $this->m_peserta->get_nama_program($program_id);
				
				$this->load->view('list_peserta',$data);
				
			} else {
				$data['error'] = "Error occured";
				$this->load->view('list_peserta', $data);
			}
        }
		
    } 
 
}

