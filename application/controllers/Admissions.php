<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admissions extends CI_Controller {

  private $patient_id;
  private $date_in;
  private $time_in;
  private $disposition;
  private $dispo_date;
  private $dispo_time;
  private $source;
  private $initial_service;
  private $current_service;
  private $inital_location;
  private $current_location;

  public function __construct()
	{
		parent::__construct();
    $this->load->model('mpi_model');
    $this->load->model('admissions_model');
    $this->load->model('transfers_model');
  }

  public function new_admission($patient_id)
  {
    if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
    else
    {
      $this->form_validation->set_rules('date_in', 'Date of Consult', 'required');
      $this->form_validation->set_rules('time_in', 'Time of Consult', 'required');
      if($this->form_validation->run()==TRUE)
      {
        $this->date_in = $this->input->post('date_in', TRUE);
        $this->time_in = $this->input->post('time_in', TRUE);
        $this->patient_id = $this->input->post('patient_id', TRUE);
        $this->initial_location = $this->input->post('initial_location', TRUE);
        $this->current_location = $this->input->post('initial_location', TRUE);
        $this->initial_service = $this->input->post('initial_service', TRUE);
        $this->current_service = $this->input->post('initial_service', TRUE);
        $this->source = $this->input->post('source', TRUE);

        if($this->admissions_model->insert_new_admission($this->patient_id, $this->date_in, $this->time_in, $this->source, $this->initial_service, $this->current_service, $this->initial_location, $this->current_location)){
          $this->session->set_flashdata('message', "Success adding new Admission to database.");
          redirect('welcome', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('message', "Error adding New Admission to database.");
          redirect('welcome', 'refresh');
        }

      }
      else
      {

      $this->session->set_flashdata('message', validation_errors());
      $data['page_title'] = "New Admission";
      $data['patient_id'] = $patient_id;
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/new_admission', $data);
      $this->load->view('templates/footer');
      }
    }
  }

  public function show_admissions()
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $data['admissions'] = $this->admissions_model->get_admissions();
      $data['page_title'] = "Admissions";
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/admissions', $data);
      $this->load->view('templates/footer');
    }
  }
  public function edit_source($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('source', 'Source of Admission', 'required');
      if($this->form_validation->run()==TRUE){
        $source = $this->input->post('source', TRUE);
        if($this->admissions_model->update_source($admission_id, $source)){
          $this->session->set_flashdata('message', "Success updating Source of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Source of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        $data['page_title'] = "Edit Admission Source";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/edit_source', $data);
        $this->load->view('templates/footer');
      }
    }
  }


}
