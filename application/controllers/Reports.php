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

  public function daily_area()
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
        $this->form_validation->set_rules('location', 'Location', 'required');
        if($this->form_validation->run()==TRUE)
        {
          $date_start = $this->input->post('date_start', TRUE);
          $date_end = $this->input->post('date_end', TRUE);
          $location = $this->input->post('location', TRUE);
          $data['date_start'] = $date_start;
          $data['date_end'] = $date_end;
          $data['location'] = $location;
          $data['page_title'] = "Daily Area Census";
          $data['target'] = "reports/daily_area";
          $this->load->view('templates/header', $data);
          $this->load->view('templates/period_reports_header', $data);
          $this->load->view('reports/location_selector');
          $this->load->view('templates/select_period_dates');
          $this->load->view('reports/per_area_daily_census', $data);
          $this->load->view('templates/footer');
        }
        else
        {
          if(validation_errors()){
            $this->session->set_flashdata('message', validation_errors());
          }
          $data['page_title'] = "Daily Area Census";
          $data['target'] = "reports/daily_area";
          $this->load->view('templates/header', $data);
          $this->load->view('templates/period_reports_header', $data);
          $this->load->view('reports/location_selector');
          $this->load->view('templates/select_period_dates');
          $this->load->view('templates/footer');
        }
    }
  }

  public function daily_hospital()
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
          $data['date_start'] = $date_start;
          $data['date_end'] = $date_end;
          $data['page_title'] = "Daily Hospital Census";
          $data['target'] = "reports/daily_hospital";
          $this->load->view('templates/header', $data);
          $this->load->view('templates/period_reports_header', $data);
          $this->load->view('templates/select_period_dates');
          $this->load->view('reports/hospital_daily_census', $data);
          $this->load->view('templates/footer');
        }
        else
        {
          if(validation_errors()){
            $this->session->set_flashdata('message', validation_errors());
          }
          $data['page_title'] = "Daily Area Census";
          $data['target'] = "reports/daily_hospital";
          $this->load->view('templates/header', $data);
          $this->load->view('templates/period_reports_header', $data);
          $this->load->view('templates/select_period_dates');
          $this->load->view('templates/footer');
        }
    }
  }
}
