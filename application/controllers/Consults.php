<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consults extends CI_Controller {

  private $patient_id;
  private $date_in;
  private $time_in;
  private $disposition;
  private $dispo_date;
  private $dispo_time;

  public function __construct()
	{
		parent::__construct();
    $this->load->model('mpi_model');
    $this->load->model('emergency_consults_model');

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
        $this->load->view('consults/new_consult', $data);
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
      $this->load->view('consults/active_consults', $data);
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
          $this->load->view('consults/list_period_consults', $data);
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
          $this->load->view('consults/period_consults_header', $data);
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
          redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Date of Emergency Consult/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        $data['page_title'] = "Edit Date of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('consults/patient_info_header', $data);
        $this->load->view('consults/edit_consult_date_in', $data);
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
            redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Time of Emergency Consult/No change.");
            redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        $data['page_title'] = "Edit Time of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('consults/patient_info_header', $data);
        $this->load->view('consults/edit_consult_time_in', $data);
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
      $this->disposition = $this->input->post('disposition', TRUE);
      $this->dispo_date = $this->input->post('dispo_date', TRUE);
      $this->dispo_time = $this->input->post('dispo_time', TRUE);
      $this->form_validation->set_rules('disposition', 'Disposition', 'required');
      if(strcmp($this->disposition, "Active")){
        $this->form_validation->set_rules('dispo_date', 'Date of Disposition', 'required');
        $this->form_validation->set_rules('dispo_time', 'Time of Disposition', 'required');
      }
      if($this->form_validation->run()==TRUE)
      {
        if(!strcmp($this->disposition, "Active")){
          $this->dispo_date = "0000-00-00";
          $this->dispo_time = "00:00:00";
        }
        if(strcmp($this->disposition, "Active") && !strcmp($this->dispo_date, "0000-00-00")){
          $this->session->set_flashdata('message', "Disposition Date cannot be empty if no longer active.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }

        if($this->emergency_consults_model->edit_disposition($consult_id, $this->disposition, $this->dispo_date, $this->dispo_time))
        {
          $this->session->set_flashdata('message', "Successfully updated Disposition of Emergency Consult.");
            redirect($this->session->userdata('prev_uri'));
        }
        else
        {
          $this->session->set_flashdata('message', "Error updating Disposition of Emergency Consult/No change.");
            redirect($this->session->userdata('prev_uri'));
        }
      }
      else
      {
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Disposition of Consult";
        $data['consult_id'] = $consult_id;
        $this->load->view('templates/header', $data);
        $this->load->view('consults/patient_info_header', $data);
        $this->load->view('consults/edit_consult_disposition', $data);
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
      $this->load->view('consults/period_consults_header', $data);
      $this->load->view('templates/select_period_dates');
      $this->load->view('templates/footer');      # code...
    }

  }
}
