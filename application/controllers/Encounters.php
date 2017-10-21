<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encounters extends CI_Controller {

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
    $this->load->model('emergency_consults_model');
    $this->load->model('admissions_model');
    $this->load->model('transfers_model');
  }

  public function new_consult($patient_id)
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
        $this->disposition = "Active";

        if($this->emergency_consults_model->insert_new_consult($this->patient_id, $this->date_in, $this->time_in, $this->disposition)){
          $this->session->set_flashdata('message', "Success adding new Emergency Consult to database.");
          redirect('welcome', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('message', "Error adding New Emergency Consult to database.");
          redirect('welcome', 'refresh');
        }

      }
      else{
        $this->session->set_flashdata('message', validation_errors());
        $data['page_title'] = "New Consult";
        $data['patient_id'] = $patient_id;
        $this->load->view('templates/header', $data);
        $this->load->view('encounters/new_consult', $data);
        $this->load->view('templates/footer');
      }

    }
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
      $this->load->view('encounters/new_admission', $data);
      $this->load->view('templates/footer');
      }
    }
  }

  public function show_active_consults()
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $data['active_consults'] = $this->emergency_consults_model->get_active_consults();
      $data['page_title'] = "Active Emergency Consults";
      $this->load->view('templates/header', $data);
      $this->load->view('encounters/active_consults', $data);
      $this->load->view('templates/footer');
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
      $this->load->view('encounters/admissions', $data);
      $this->load->view('templates/footer');
    }
  }
  public function show_period_consults()
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
        $this->form_validation->set_rules('date_start', 'Start Date', 'required');
        $this->form_validation->set_rules('date_end', 'End Date', 'required');
        if($this->form_validation->run()==TRUE)
        {
          $date_start = $this->input->post('date_start', TRUE);
          $date_end = $this->input->post('date_end', TRUE);
          $data['period_consults'] = $this->emergency_consults_model->get_period_consults($date_start, $date_end);
          $data['page_title'] = "Period Emergency Consults (from ".$date_start." to ".$date_end.")";
          $this->load->view('templates/header', $data);
          $this->load->view('encounters/list_period_consults', $data);
          $this->load->view('templates/footer');
        }
        else
        {
          if(validation_errors())
          {
            $this->session->set_flashdata('message', validation_errors());
          }
          $data['page_title'] = "Select Consult Period Dates";
          $this->load->view('templates/header', $data);
          $this->load->view('encounters/period_consults_header', $data);
          $this->load->view('templates/select_period_dates');
          $this->load->view('templates/footer');
        }
      }
  }
  public function edit_consult_date_in($consult_id)
  {
      if (!$this->ion_auth->logged_in())
      {
        // redirect them to the login page
        redirect('auth/login', 'refresh');
      }
      else
      {

      $this->form_validation->set_rules('date_in', 'Date of Consult', 'required');
      if($this->form_validation->run()==TRUE)
      {
        $this->date_in = $this->input->post('date_in', TRUE);
        if($this->emergency_consults_model->edit_date_in($consult_id, $this->date_in))
        {
          $this->session->set_flashdata('message', "Successfully updated Date of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
          redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Date of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        $data['page_title'] = "Edit Date of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('encounters/edit_consult_date_in', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function edit_consult_time_in($consult_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {

      $this->form_validation->set_rules('time_in', 'Time of Consult', 'required');
      if($this->form_validation->run()==TRUE)
      {
        $this->time_in = $this->input->post('time_in', TRUE);
        if($this->emergency_consults_model->edit_time_in($consult_id, $this->time_in))
        {
          $this->session->set_flashdata('message', "Successfully updated Time of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
            redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Time of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
            redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        $data['page_title'] = "Edit Time of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('encounters/edit_consult_time_in', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function edit_consult_disposition($consult_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('disposition', 'Disposition', 'required');

      if($this->form_validation->run()==TRUE)
      {
        $this->disposition = $this->input->post('disposition', TRUE);
        $this->dispo_date = $this->input->post('dispo_date', TRUE);
        $this->dispo_time = $this->input->post('dispo_time', TRUE);

        if($this->emergency_consults_model->edit_disposition($consult_id, $this->disposition, $this->dispo_date, $this->dispo_time))
        {
          $this->session->set_flashdata('message', "Successfully updated Disposition of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
            redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Disposition of Emergency Consult.");
          //redirect('encounters/show_active_consults', 'refresh');
            redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        $data['page_title'] = "Edit Disposition of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('encounters/edit_consult_disposition', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function select_period_consults()
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $data['page_title'] = "Select Consult Period Dates";
      $this->load->view('templates/header', $data);
      $this->load->view('encounters/period_consults_header', $data);
      $this->load->view('templates/select_period_dates');
      $this->load->view('templates/footer');      # code...
    }

  }
}
