<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
			if(!$this->ion_auth->logged_in()){
				$this->session->set_userdata('old_url', uri_string());
				redirect('auth');
			}
			else{
				$data['page_title'] = "Home";
				$this->load->view('templates/header', $data);
				$this->load->view('templates/footer');
			}

	}
}
