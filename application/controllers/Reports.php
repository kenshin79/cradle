<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

  public function __construct()
	{
		parent::__construct();
    $this->load->model('mpi_model');
    $this->load->model('emergency_consults_model');
    $this->load->model('admissions_model');
    $this->load->model('transfers_model');

  }

  public function index()
  {
    $data['page_title'] = "Home - CRADLE";
    $this->load->view('templates/header', $data);
    $this->load->view('reports/home', $data);
    $this->load->view('templates/footer');
  }

}
