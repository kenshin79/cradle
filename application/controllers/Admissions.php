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
  private $phic;
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
        $this->phic = $this->input->post('phic', TRUE);
        if(!$this->phic)
        {
          $this->phic = 0;
        }

        if($this->admissions_model->insert_new_admission($this->patient_id, $this->date_in, $this->time_in, $this->source, $this->phic, $this->initial_service, $this->current_service, $this->initial_location, $this->current_location)){
          $this->session->set_flashdata('message', "Success adding new Admission to database.");
          redirect('reports', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('message', "Error adding New Admission to database.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }

      }
      else
      {
      if(validation_errors()){
        $this->session->set_flashdata('message', validation_errors());
      }
      $data['page_title'] = "New Admission";
      $data['patient_id'] = $patient_id;
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/new_admission', $data);
      $this->load->view('templates/footer');
      }
    }
  }
  public function location_code($key)
  {
    switch ($key) {
      case '1':
        $x = "Emergency";
        break;
      case '2':
        $x = "OBAS";
        break;
      case '3':
        $x = "PAS";
        break;
      case '4':
        $x = "Ward 1";
        break;
      case '5':
        $x = "Ward 2";
        break;
      case '6':
        $x = "Ward 3";
        break;
      case '7':
        $x = "Ward 4";
        break;
      case '8':
        $x = "Ward 5 (Neuro)";
        break;
      case '9':
        $x = "Ward 5 (Rehab)";
        break;
      case '10':
        $x = "Ward 6";
        break;
      case '11':
        $x = "Ward 7";
        break;
      case '12':
        $x = "Ward 8";
        break;
      case '13':
        $x = "Ward 9";
        break;
      case '14':
        $x = "Ward 10";
        break;
      case '15':
        $x = "Ward 11";
        break;
      case '16':
        $x = "PHIC Ward";
        break;
      case '17':
        $x = "Ward 14A";
        break;
      case '18':
        $x = "Ward 14B";
        break;
      case '19':
        $x = "Ward 15";
        break;
      case '20':
        $x = "Ward 16";
        break;
      case '21':
        $x = "CI";
        break;
      case '22':
        $x = "SOJR";
        break;
      case '23':
        $x = "Hema-Onco";
        break;
      case '24':
        $x = "MICU";
        break;
      case '25':
        $x = "CENICU";
        break;
      case '26':
        $x = "SICU";
        break;
      case '27':
        $x = "Neuro ICU";
        break;
      case '28':
        $x = "NSSCU";
        break;
      case '29':
        $x = "Neonatal ICU";
        break;
      case '30':
        $x = "PICU";
        break;
      case '31':
        $x = "Burn Unit";
        break;
      case '32':
        $x = "IMU";
        break;
      default:
        $x = 1;
        break;
    }
    return $x;
  }
  public function show_active_admissions($key)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $y = $this->location_code($key);
      $data['admissions'] = $this->admissions_model->get_active_admissions($y);
      $data['page_title'] = "Active Admissions: ".$y;
      $data['key'] = $key;
      $data['census'] = "a";
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/admissions', $data);
      $this->load->view('templates/footer');
    }
  }
  public function show_inactive_admissions($key)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $y = $this->location_code($key);
      $data['admissions'] = $this->admissions_model->get_inactive_admissions($y);
      $data['page_title'] = "Discharges: ".$y;
      $data['key'] = $key;
      $data['census'] = "i";
      $this->load->view('templates/header', $data);
      $this->load->view('admissions/admissions', $data);
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
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Admission Source";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_source', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function edit_phic($admission_id, $phic)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->admissions_model->update_phic($admission_id, $phic);
      redirect($this->session->userdata('prev_uri'), 'refresh');
    }
  }
  public function edit_date_in($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('date_in', 'Date of Admission', 'required');
      if($this->form_validation->run()==TRUE){
        $date_in = $this->input->post('date_in', TRUE);
        if($this->admissions_model->update_date_in($admission_id, $date_in)){
          $this->session->set_flashdata('message', "Success updating Date of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Date of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Date of Admission";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_date_in', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function edit_time_in($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('time_in', 'Time of Admission', 'required');
      if($this->form_validation->run()==TRUE){
        $time_in = $this->input->post('time_in', TRUE);
        if($this->admissions_model->update_time_in($admission_id, $time_in)){
          $this->session->set_flashdata('message', "Success updating Time of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Time of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Time of Admission";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_time_in', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function edit_initial_location($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('initial_location', 'Initial Location', 'required');
      if($this->form_validation->run()==TRUE){
        $initial_location = $this->input->post('initial_location', TRUE);
        if($this->admissions_model->update_initial_location($admission_id, $initial_location)){
          if(!$this->transfers_model->with_transfer($admission_id)){
            $this->admissions_model->update_current_location($admission_id, $initial_location);
          }
          $this->session->set_flashdata('message', "Success updating Initial Location of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Initial Location of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Initial Location of Admission";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_initial_location', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function edit_initial_service($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $this->form_validation->set_rules('initial_service', 'Initial Service', 'required');
      if($this->form_validation->run()==TRUE){
        $initial_service = $this->input->post('initial_service', TRUE);
        if($this->admissions_model->update_initial_service($admission_id, $initial_service)){
          if(!$this->transfers_model->with_transfer($admission_id)){
            $this->admissions_model->update_current_service($admission_id, $initial_service);
          }
          $this->session->set_flashdata('message', "Success updating Initial Service of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Initial Service of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Initial Service of Admission";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_initial_service', $data);
        $this->load->view('templates/footer');
      }
    }
  }
  public function edit_disposition($admission_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    else
    {
      $disposition = $this->input->post('disposition', TRUE);
      $dispo_date = $this->input->post('dispo_date', TRUE);
      $dispo_time = $this->input->post('dispo_time', TRUE);
      if(strcmp($disposition, "Admitted")){
        $this->form_validation->set_rules('dispo_date', 'Date of Disposition', 'required|differs["0000-00-00"]');
        $this->form_validation->set_rules('dispo_time', 'Time of Disposition', 'required');
      }
      $this->form_validation->set_rules('disposition', 'Disposition', 'required');

      if($this->form_validation->run()==TRUE){
        if(!strcmp($disposition, "Admitted")){
          $dispo_date = "0000-00-00";
          $dispo_time = "00:00:00";
        }
        if(strcmp($disposition, "Admitted") && !strcmp($dispo_date, "0000-00-00")){
          $this->session->set_flashdata('message', "Disposition Date cannot be empty if no longer admitted.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        if($this->admissions_model->update_disposition($admission_id, $disposition, $dispo_date, $dispo_time)){
          $this->session->set_flashdata('message', "Success updating Diposition of Admission.");
          redirect($this->session->userdata('prev_uri'), 'refresh');
        }
        else{
          $this->session->set_flashdata('message', "Error updating Disposition of Admission/No change.");
          redirect($this->session->userdata('prev_uri'));
        }
      }
      else{
        if(validation_errors()){
          $this->session->set_flashdata('message', validation_errors());
        }
        $data['page_title'] = "Edit Disposition of Admission";
        $data['admission_id'] = $admission_id;
        $this->load->view('templates/header', $data);
        $this->load->view('admissions/patient_info_header', $data);
        $this->load->view('admissions/edit_disposition', $data);
        $this->load->view('templates/footer');
      }
    }
  }
}
