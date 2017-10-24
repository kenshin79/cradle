<h3>Active Emergency Consults</h3>
<table class="table datatable">
  <thead>
    <tr>
      <th>No.</th>
      <th>Patient</th>
      <th>Type</th>
      <th>Date of Consult</th>
      <th>Time of Consult</th>
      <th>Days</th>
      <th>Disposition</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $this->session->set_userdata('prev_uri', uri_string());
      $count = 1;
      foreach ($active_consults as $row) {
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
        $days = date_diff(date_create(date('Y-m-d H:i:s')), date_create($row->date_in." ".$row->time_in))->d;
        echo "<tr>";
        echo "<td>".$count."</td>";
        echo "<td>".$last_name.", ".$first_name." ".$middle_name;
        echo " ".$age."/".$sex."<br/>";
        echo "Case number: ".$case_number."</td>";
        echo "<td><a href=\"".base_url()."consults/edit_ed_type/".$row->id."\">".$row->ed_type."</a></td>";
        echo "<td><a class=\"\" href=\"".base_url()."consults/edit_consult_date_in/".$row->id."\">".$row->date_in."</a></td>";
        echo "<td><a class=\"\" href=\"".base_url()."consults/edit_consult_time_in/".$row->id."\">".$row->time_in."</a></td>";
        echo "<td>".$days."</td>";
        echo "<td><a class=\"\" href=\"".base_url()."consults/edit_consult_disposition/".$row->id."/".$row->disposition."\">".$row->disposition."</a></td>";
        echo "</tr>";
        $count++;
      }
     ?>
  </tbody>
</table>
