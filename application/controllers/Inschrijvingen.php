<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Inschrijvingen extends CI_Controller {

		// Constructer
		public $Error_heading = array();
		public $Error_message = array();
		public $Session       = array();

    function __construct(){
			parent::__construct();
			// Load model
			$this->load->dbutil();
			$this->load->library(array('Email','dompdf_gen'));
			$this->load->helper(array('Email'));
			$this->load->model('Model_inschrijvingen','Inschrijving');

			// Variables
			$this->Error_heading = "No Permission";
			$this->Error_message = "Hebt heb geen rechten om deze handeling uit te voeren";
			$this->Session = $this->session->userdata('logged_in');
    }
		// End constructor

		// Client side
		public function Ontbijt_beschrijving() {
			$Data = array(
				'Title'  => 'Inschrijvingen ontbijt',
				'Active' => '10',
			);

			$this->load->view('components/header', $Data);
			$this->load->view('components/navbar', $Data);
			$this->load->view('client/ontbijt_beschrijving');
			$this->load->view('components/footer');
		}

		public function Ontbijt_inschrijving() {
			$Data['Title']  = "Inschrijving ontbijt";
			$Data['Active'] = "4";

			// Variable is not array because it is one item.
			$DB['Datums']   = $this->Inschrijving->Get_dates();

			$this->load->view('components/header', $Data);
			$this->load->view('components/navbar', $Data);
			$this->load->view('client/ontbijt_inschrijving', $DB);
			$this->load->view('components/footer');
		}

		// Administrators side
		public function Admin_ontbijt() {
			$Data = array(
				'Title'  => 'Admin inschrijvingen ontbijt',
				'Active' => '4',
			);

			if($this->Session) {
				if($this->Session['Admin'] == 1) {
					// Database values
					$DB = array(
						'Ontbijt_datums' => $this->Inschrijving->Get_Dates_Full(),
						'Inschrijvingen' => $this->Inschrijving->Inschrijvingen_All(),
						'Datums' 				 => $this->Inschrijving->Get_dates(),
					);

					$this->load->view('components/admin_header', $Data);
					$this->load->view('components/navbar_admin', $Data);
					$this->load->view('admin/inschrijvingen_ontbijt', $DB);
					$this->load->view('components/footer');
				} else {

				}
			} else {
				redirect('Admin', 'Refresh');
			}
		}

		// Database handlings
		public function Insert_inschrijving() {
			if($this->Session) {
				$this->Inschrijving->InsertDB();
				redirect('Inschrijvingen/Admin_ontbijt');
			} else {
				// Write to database
				$this->Inschrijving->InsertDB();

				// Variables User => Mail
				$Input = array(
					'Naam'     => $this->input->post('Naam'),
					'Voornaam' => $this->input->post('Voornaam'),
					'Email'    => $this->input->post('Email'),
					'Personen' => $this->input->post('Personen'),
				);

				// View voor email
				$mail_ontbijt = $this->load->view('email/ontbijt_inschrijving', $Input , TRUE);

				// Mail voor bevestiging
				$this->email->from('contact@st-joris-turnhout.be', 'Contact st-joris turnhout');
        $this->email->to($this->input->post('Email'));
        $this->email->subject('Bevestiging inschrijving ontbijt');
        $this->email->message($mail_ontbijt);
        $this->email->set_mailtype("html");
        $this->email->send();

        $this->email->clear();

				// Redirect
				redirect('Ontbijt_beschrijving');
			}
		}

		public function Ontbijt_Start() {
			if($this->Session) {
				if($this->Session['Admin'] == 1) {
					$this->Inschrijving->Start_inschrijving_ontbijt();
					redirect('Inschrijvingen/Admin_ontbijt');
				} else {
					$Data = array(
						'Heading' => $this->Error_heading,
						'Message' => $this->Error_message,
					);

					$this->load->view('errors/html/alert', $Data);
				}
			} else {
				// If no session, redirect to login
				redirect('Admin', 'Refresh');
			}
		}

		public function Ontbijt_Stop() {
			if($this->Session) {
				if($this->Session['Admin'] == 1) {
					$Data['Query'] = $this->Inschrijving->Download_month();

					$this->Inschrijving->Stop_inschrijving_ontbijt();

					// Make and download PDF
					$this->load->view('pdf/ontbijt', $Data);
					$html = $this->output->get_output();

					$this->dompdf->load_html($html);
					$this->dompdf->render();
					$this->dompdf->stream("inschrijvingen.pdf");

					redirect('Inschrijvingen/Admin_ontbijt');
				} else {
					$Data = array(
						'Heading' => $this->Error_heading,
						'Message' => $this->Error_message,
					);

					$this->load->view('errors/html/alert', $Data);
				}
			} else {
				// If no session, redirect to login
				redirect('Admin', 'Refresh');
			}
		}

		public function Download_ontbijt() {
			$Data['Query'] = $this->Inschrijving->Download();

        	$this->load->view('pdf/ontbijt', $Data);
        	$html = $this->output->get_output();

        	// Convert to PDF
        	$this->dompdf->load_html($html);
        	$this->dompdf->render();
        	$this->dompdf->stream("Onbijt_inschrijvingen.pdf");
		}

		public function Delete_inschrijving() {
			if($this->Session) {
				if($this->Session['Admin'] == 1) {
					$this->Inschrijving->DeleteDB();
					redirect('Admin_ontbijt');
				} else {
					$Data = array(
						'Heading' => $this->Error_heading,
						'Message' => $this->Error_message,
					);

					$this->load->view('errors/html/alert', $Data);
				}
			} else {
				// If no session, redirect to login
				redirect('Admin', 'Refresh');
			}
		}
	}
