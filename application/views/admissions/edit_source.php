<?php
  $this->session->set_userdata('prev_uri', uri_string());
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $patient_id = $row->patient_id;
    $date_in = $row->date_in;
    $time_in = $row->time_in;
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
                  echo "Current Location: ".$current_location."<br/>";
                  echo "Current Service: ".$current_service;
            ?>
        </th>
      </tr>
    </table>
  </div>
</div>
<?php echo form_open('admissions/edit_source/'.$admission_id);?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <?php echo form_dropdown('source', $this->config->item('source'), $source);?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
