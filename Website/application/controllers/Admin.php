<?php defined('BASEPATH') OR exit('No direct script access allowed');

  /**
	 * @author: Tim Joosten
	 * @license: Closed source
	 * @copyright: Tim Joosten
	 * @since: 2015
	 * @package: Scouts website (http://www.st-joris-turnhout.be)
	 */

	class Admin extends CI_Controller {
		function __construct() {
    		parent::__construct();
        $this->load->helper(array('form'));
  		}

  		public function index() {
  			if($this->session->userdata('logged_in')) {
  				redirect('backend','refresh');
  			} else {
    			$this->load->view('admin/login');
  			}
  		}
	}