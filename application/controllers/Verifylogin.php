<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('user','',TRUE);
    $this->load->helper('string');
		$this->load->library('email');
  }

  function index() {
    // This method will have the credentials validation
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
	
    if($this->form_validation->run() == FALSE) {
      // Field validation failed.  User redirected to login page
      $this->load->view('admin/login');
    } else {
      // Go to private area
      redirect('backend', 'refresh');
    }
    
  }
  
  function check_database($password) {
    // Field validation succeeded.  Validate against database
    $username = $this->input->post('username');
    
    //query the database
    $result = $this->user->login($username, $password);
    
    if($result) {
      $sess_array = array();

      foreach($result as $row) {
        $sess_array = array(
          'id'       => $row->id,
          'username' => $row->username,
          'Admin'    => $row->Admin_role,
          'Tak'      => $row->Tak,
					'Theme'    => $row->Theme,
					'Email'    => $row->Mail,
        );

        $this->session->set_userdata('logged_in', $sess_array);
				
				$this->load->model('Model_log', 'Log');
				$this->Log->logged_in();
      }
      return TRUE;
    } else {
      $this->form_validation->set_message('check_database', 'Foutief wachtwoord of gebruikersnaam');
      return false;
    }
  }
	
	function reset() {
		$Output = $this->user->reset_pass();
		
		if(count($Output) == 1) {
      // Write to database
      $New['New'] = random_string('alnum', 16);
      $this->user->insert_new($New);

			// Email 
      $mail = $this->load->view('email/reset', $New , TRUE);

      // Mail voor bevestiging
      $this->email->from('contact@st-joris-turnhout.be', 'Contact st-joris turnhout');
      $this->email->to($this->input->post('recovery')); 
      $this->email->subject('Reset wachtwoord - Sint Joris Turnhout');
      $this->email->message($mail);
      $this->email->set_mailtype("html");  
      $this->email->send();
        
      $this->email->clear();
			
			// Output view
			$this->load->view('alerts/reset_success');
		} else {
			// Output view
			$this->load->view('alerts/reset_failed');
		}
	}
}
