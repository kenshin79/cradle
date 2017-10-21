<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('mpi_model');
  }

  public function index($encounter)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {

      if($encounter == 1)
      {
        $data['search_title'] = "New Emergency Consult";
      }
      else
      {
        $data['search_title'] = "New Admission";
      }
      $data['encounter'] = $encounter;
      $this->form_validation->set_rules('search_term', 'Search Term', 'required|min_length[3]');
      if($this->form_validation->run() == FALSE)
      {
        $this->session->set_flashdata('message', validation_errors());
        $data['page_title'] = "Search Patient";
        $data['search_results'] = "";
        $this->load->view('templates/header', $data);
        $this->load->view('mpi/search_patient', $data);
        $this->load->view('templates/footer');
      }
      else
      {

        $term = $this->input->post('search_term', TRUE);
        $data['search_results'] = $this->mpi_model->search_mpi($term);
        $data['page_title'] = "Search Patient";
        $this->load->view('templates/header', $data);
        $this->load->view('mpi/search_patient', $data);
        $this->load->view('templates/footer');
      }

    }
  }

}
