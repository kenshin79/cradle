<?php

  $patient_info = $this->mpi_model->get_patient($patient_id);
  foreach ($patient_info as $pow) {
    $last_name = $pow->{$this->config->item('last_name')};
    $first_name = $pow->{$this->config->item('first_name')};
    $middle_name = $pow->{$this->config->item('middle_name')};
    $case_number = $pow->{$this->config->item('case_number')};
    $sex = $pow->{$this->config->item('sex')};
    $birth_date = $pow->{$this->config->item('birth_date')};
    $address = $pow->{$this->config->item('address')};
    $city_province = $pow->{$this->config->item('city_province')};
  }
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $patient_id = $row->patient_id;
    $date_in = $row->date_in;
    $time_in = $row->time_in;
    $initial_location = $row->initial_location;
    $initial_service = $row->initial_service;
    $current_location = $row->current_location;
    $current_service = $row->current_service;
    $source = $row->source;
  }
 ?>
