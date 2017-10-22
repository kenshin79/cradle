<?php
  $this->session->set_userdata('prev_uri', uri_string());
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
  $patient_info = $this->mpi_model->get_patient($patient_id);
  foreach ($patient_info as $row)
  {

    $last_name = $row->{$this->config->item('last_name')};
    $first_name = $row->{$this->config->item('first_name')};
    $middle_name = $row->{$this->config->item('middle_name')};
    $sex = $row->{$this->config->item('sex')};
    $birth_date = $row->{$this->config->item('birth_date')};
    $case_number = $row->{$this->config->item('case_number')};
  }
  $age = date_diff(date_create($birth_date), date_create($date_in))->y;
  $days = date_diff(date_create(date('Y-m-d H:i:s')), date_create($date_in." ".$time_in))->d;
?>

<div class="row">
<div class="col-1"></div>
<div class="col">
  <h3><?php echo $page_title; ?></h3>
</div>
</div>
<div class="row">
<div class="col-1"></div>
<div class="col">
  <table class="table">
    <tr>
      <th><?php echo $last_name.", ".$first_name." ".$middle_name." ".$age."/".$sex."<br/>";
                echo "Case no: ".$case_number."<br/>";
                echo "Date of Admission: ".$date_in."<br/>";
                echo "Time of Admission: ".$time_in."<br/>";
                echo "No. of Days Admitted: ".$days."<br/>";
                echo "Current Location: ".$current_location."<br/>";
                echo "Current Service: ".$current_service."<br/>";                
                echo "Initial Location: ".$initial_location."<br/>";
                echo "Initial Service: ".$initial_service."<br/>";
          ?>
      </th>
    </tr>
  </table>
