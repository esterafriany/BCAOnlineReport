<?php 
 
class Admin extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('security');
	
		if($this->session->userdata('login') != "login"){
			redirect(base_url("login"));
		}
		
	}
 
	function index(){
		
		$this->load->view('home_admin');
		
	}
}