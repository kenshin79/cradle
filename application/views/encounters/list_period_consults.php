<div class="row">
  <div class="col">
    <h3><?php echo $page_title; ?></h3>
  </div>
</div>
<?php

  if($period_consults)
  {
    $this->session->set_userdata('prev_uri', uri_string());
    echo "<table class=\"table datatable\">";
    echo "  <thead>";
    echo "    <tr>";
    echo "      <th>No.</th>";
    echo "      <th>Patient</th>";
    echo "      <th>Case Number</th>";
    echo "      <th>Date of Consult</th>";
    echo "      <th>Time of Consult</th>";
    echo "      <th>Disposition</th>";
    echo "      <th>Date of Dispo</th>";
    echo "      <th>Time of Dispo</th>";
    echo "    </tr>";
    echo "  </thead>";
    echo "  <tbody>";
    $count = 1;
    foreach ($period_consults as $row) {
      $patient_info = $this->mpi_model->get_patient($row->patient_id);
      foreach ($patient_info as $pow)
      {

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
      echo "<tr>";
      echo "<td>".$count."</td>";
      echo "<td>".$last_name.", ".$first_name." ".$middle_name;
      echo " ".$age."/".$sex."</td>";
      echo "<td>".$case_number."</td>";
      echo "<td><a class=\"\" href=\"".base_url()."encounters/edit_consult_date_in/".$row->id."\">".$row->date_in."</a></td>";
      echo "<td><a class=\"\" href=\"".base_url()."encounters/edit_consult_time_in/".$row->id."\">".$row->time_in."</a></td>";
      echo "<td><a class=\"\" href=\"".base_url()."encounters/edit_consult_disposition/".$row->id."/".$row->disposition."\">".$row->disposition."</a></td>";
      echo "<td>".$row->dispo_date."</td>";
      echo "<td>".$row->dispo_time."</td>";
      echo "</tr>";
      $count++;
    }
    echo "</tbody>";
    echo "</table>";
  }
  else {
    echo "<h2>No consults retrieved.</h2>";
  }

 ?>
