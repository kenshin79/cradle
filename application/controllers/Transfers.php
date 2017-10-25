<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers extends CI_Controller {

  private $id;
  private $admission_id;
  private $date_transfer;
  private $time_transfer;
  private $source_location;
  private $target_location;
  private $source_service;
  private $target_service;

  public function __construct()
	{
		parent::__construct();
    $this->load->model('mpi_model');
    $this->load->model('emergency_consults_model');
    $this->load->model('admissions_model');
    $this->load->model('transfers_model');
  }

  public function add_transfer($admission_id)
  {

    $this->form_validation->set_rules('target_location','Destination Location', 'required');
    $this->form_validation->set_rules('target_service', 'Destination Service', 'required');
    $this->form_validation->set_rules('date_transfer', 'Date of Transfer', 'required');
    $this->form_validation->set_rules('time_transfer', 'Time of Transfer', 'required');

    if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

    else
    {
      if($this->form_validation->run()==TRUE)
      {
        $target_location = $this->input->post('target_location', TRUE);
        $target_service = $this->input->post('target_service', TRUE);
        $date_transfer = $this->input->post('date_transfer', TRUE);
        $time_transfer = $this->input->post('time_transfer', TRUE);
        $current_location = $this->input->post('current_location', TRUE);
        $current_service = $this->input->post('current_service', TRUE);

        if(strcmp($target_location, $current_location)==0 && strcmp($target_service, $current_service)==0)
        {
            $this->session->set_flashdata('message', "No transfer occurred, both location and service unchanged.");
            redirect($this->session->userdata('prev_uri'), 'refresh');

        }
        else{
            $success_transfer = $this->transfers_model->insert_new_transfer($admission_id, $target_location, $current_location, $target_service, $current_service, $date_transfer, $time_transfer);
            $success_admission = $this->admissions_model->update_admission_transfer($admission_id, $target_location, $target_service);
            if($success_transfer && $success_admission){
              $this->session->set_flashdata('message', "Success recording transfer.");
              redirect($this->session->userdata('prev_uri'), 'refresh');
            }
        }
      }
      else{
        if(validation_errors()){
            $this->session->set_flashdata('message', validation_errors());
        }
        $data['admission_id'] = $admission_id;
        $data['page_title'] = "Add Transfer";
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('transfers/add_transfer', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function edit_transfer($transfer_id, $admission_id)
  {
    if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
    else
    {
      $this->form_validation->set_rules('date_transfer', "Date of Transfer", 'required');
      $this->form_validation->set_rules('time_transfer', "Time of Transfer", 'required');
      $this->form_validation->set_rules('target_location', "Target Location", 'required');
      $this->form_validation->set_rules('target_service', "Target Service", 'required');


      if($this->form_validation->run() == TRUE)
      {
        $date_transfer = $this->input->post('date_transfer', TRUE);
        $time_transfer = $this->input->post('time_transfer', TRUE);
        $target_location = $this->input->post('target_location', TRUE);
        $target_service = $this->input->post('target_service', TRUE);
        $current_location = $this->input->post('current_location', TRUE);
        $current_service = $this->input->post('current_service', TRUE);
        $old_date = $this->input->post('old_date', TRUE);
        $old_time = $this->input->post('old_time', TRUE);
        if(!strcmp($current_location, $target_location) && !strcmp($current_service, $target_service) && !strcmp($old_date, $date_transfer) && !strcmp($old_time, $time_transfer))
        {
          $this->session->set_flashdata('message', "Error no changes have been made to transfer.");
          redirect($this->session->userdata('prev_uri', 'refresh'));
        }
        else{
          if(strcmp($current_location, $target_location) || strcmp($current_service, $target_service)){
            $update = $this->admissions_model->update_admission_transfer($admission_id, $target_location, $target_service);
          }
          else{
            $update = 1;
          }
          if($this->transfers_model->update_transfer($transfer_id, $date_transfer, $time_transfer, $target_location, $target_service) && $update){
            $this->session->set_flashdata('message', "Success updating Transfer.");
            redirect($this->session->userdata('prev_uri'), 'refresh');
          }
          else
          {
            $this->session->set_flashdata('message', "Error updating transfer/No changes.");
            redirect($this->session->userdata('prev_uri'), 'refresh');
          }
        }


      }
      if(validation_errors()){
        $this->session->set_flashdata('message', validation_errors());
      }
      $data['page_title'] = "Edit Transfer";
      $data['transfer_id'] = $transfer_id;
      $data['admission_id'] = $admission_id;
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/patient_info_header', $data);
      $this->load->view('transfers/edit_transfer', $data);
      $this->load->view('templates/footer');
    }
  }
  public function delete_transfer($transfer_id){
    if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
    if(!$this->ion_auth->is_admin()){
      $this->session->set_flashdata('message', "You need to be admin to delete a Transfer. Please refer to your admin.");
      redirect('auth/logout', 'refresh');
    }
    $transfer_info = $this->transfers_model->get_transfer_info($transfer_id);
    foreach ($transfer_info as $row) {
      $admission_id = $row->admission_id;
      $source_location = $row->source_location;
      $source_service = $row->source_service;
    }
    $update_admission = $this->admissions_model->update_admission_transfer($admission_id, $source_location, $source_service);
    $delete = $this->transfers_model->delete_transfer($transfer_id);
    if($delete)
    {
      $this->session->set_flashdata('message', "Successfully deleted a Transfer.");
      redirect('welcome', 'refresh');
    }
    else {
      $this->session->set_flashdata('message', "Error deleting Transfer.");
      redirect($this->session->userdata('prev_uri'), 'refresh');
    }

  }

}
