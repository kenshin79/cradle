<?php
  $this->session->set_userdata('prev_uri', uri_string());
  $consults = $this->emergency_consults_model->get_consult($consult_id);
  foreach ($consults as $row) {
    $patient_id = $row->patient_id;
    $date_in = $row->date_in;
    $time_in = $row->time_in;
    $disposition = $row->disposition;
    $dispo_date = $row->dispo_date;
    $dispo_time = $row->dispo_time;
  }
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
$age = date_diff(date_create($birth_date), date_create(date('Y-m-d')))->y;

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
      <th><?php echo $last_name.", ".$first_name." ".$middle_name." ".$age."/".$sex."<br/>";?>
        Case number: <?php echo $case_number."<br/>";?>
        Date of Consult: <?php echo $date_in."<br/>";?>
        Time of Consult: <?php echo $time_in."<br/>";?>
        Disposition: <?php echo $disposition."<br/>";?>
        <?php
          if(strcmp($disposition, 'Active')){
            echo "Date of Disposition: ".$dispo_date."<br/>";
            echo "Time of Disposition: ".$dispo_time."<br/>";
          }
         ?>
      </th>
    </tr>
  </table>
</div>
</div>
