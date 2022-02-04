<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AuditTrail extends CI_Controller {
 
	 public function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('login') != "login"){
			redirect(base_url("welcome/login_admin"));
		}
		
		$this->load->helper('url');
		$this->load->model('m_audit_trail');
		$this->load->helper('form');
        $this->load->database();
	}
 
	public function index()
	{
		$data['audits']=$this->m_audit_trail->get_all_audit_trail();
		$this->load->view('list_audit_trail',$data);
	}

}