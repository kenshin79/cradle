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

  public function add_transfer($admission_id, $patient_id)
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
            redirect('transfers/add_transfer/'.$admission_id."/".$patient_id);

        }
        else{
            $success_transfer = $this->transfers_model->insert_new_transfer($admission_id, $target_location, $current_location, $target_service, $current_service, $date_transfer, $time_transfer);
            $success_admission = $this->admissions_model->update_admission_transfer($admission_id, $target_location, $target_service);
            if($success_transfer && $success_admission){
              $this->session->set_flashdata('message', "Success recording transfer.");
              redirect('transfers/add_transfer/'.$admission_id."/".$patient_id, 'refresh');
            }
        }
      }
      else{
        if(validation_errors()){
            $this->session->set_flashdata('message', validation_errors());
        }

        $data['admission_info']= $this->admissions_model->get_admission_info($admission_id);
        $data['patient_info'] = $this->mpi_model->get_patient($patient_id);
        $data['page_title'] = "Add Transfer";
        $this->load->view('templates/header', $data);
        $this->load->view('transfers/add_transfer', $data);
        $this->load->view('templates/footer');
      }
    }


  }

}
