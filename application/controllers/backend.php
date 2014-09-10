<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class backend extends CI_Controller {

  function __construct() {
    parent::__construct();
  }

  function index() {
    if($this->session->userdata('logged_in'))  {
      $session_data = $this->session->userdata('logged_in');

      $this->load->model('Model_takken','Takken');

      $DB['Kapoenen']
      $DB['Welpen']
      $DB['JongGivers']
      $DB['Givers']
      $DB['Jins']
      $DB['Leiding']
      
      $this->load->view('components/admin_header');
      $this->load->view('components/navbar_admin');
      $this->load->view('admin/takken');
      $this->load->view('components/footer');
    } else {
      //If no session, redirect to login page
      redirect('Admin', 'refresh');
	  }
  }
  
  function logout() {
    $this->session->unset_userdata('logged_in');
    session_destroy();
    redirect('Admin', 'refresh');
  }

}