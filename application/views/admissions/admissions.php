<h3>Admissions</h3>
<table class="table datatable">
  <thead>
    <tr>
      <th>No.</th>
      <th>Admission</th>
      <th>Date/Time</th>
      <th>Transfers</th>
      <th>Disposition</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $this->session->set_userdata('prev_uri', uri_string());
      $count = 1;
      foreach ($admissions as $row) {
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
        $transfers = $this->transfers_model->get_transfers($row->id);
        echo "<tr>";
        echo "<td>".$count."</td>";
        echo "<td>".$last_name.", ".$first_name." ".$middle_name;
        echo " ".$age."/".$sex."<br />";
        echo "Case no: ".$case_number."<br />";
        echo "Source: <a href=\"".base_url()."admissions/edit_source/".$row->id."\">".$row->source."</a><br/>";
        echo "PHIC: <a href=\"".base_url()."admissions/edit_phic/".$row->id."/".$row->phic."\">";
        if($row->phic)
        {
            echo "YES";
        }
        else
        {
            echo "NO";

        }
        echo "</a><br/>";
        echo "Current Location: ".$row->current_location."<br/>";
        echo "Current Service: ".$row->current_service."<br/>";
        if($this->transfers_model->with_transfer($row->id)){
          echo "Initial Location: ".$row->initial_location."<br/>";
        }
        else{
          echo "Initial Location: <a href=\"".base_url()."admissions/edit_initial_location/".$row->id."\">".$row->initial_location."</a><br/>";
        }
        if($this->transfers_model->with_transfer($row->id)){
          echo "Initial Service: ".$row->initial_service."<br/>";
        }
        else{
          echo "Initial Service: <a href=\"".base_url()."admissions/edit_initial_service/".$row->id."\">".$row->initial_service."</a><br/>";
        }
        echo "</td>";
        echo "<td>Date<br/><a href=\"".base_url()."admissions/edit_date_in/".$row->id."\">".$row->date_in."</a><br />";
        echo "Time<br/><a href=\"".base_url()."admissions/edit_time_in/".$row->id."\">".$row->time_in."</a><br/>";
        echo $days." days</td>";
        echo "<td>Transfers:<br/>";
        if($transfers){
            $item = 1;
            foreach ($transfers as $t) {
              if($item == count($transfers))
              {
                echo "<a href=\"".base_url()."transfers/edit_transfer/".$t->id."/".$row->id."\" >[".$t->date_transfer."] ".$t->target_location.", ".$t->target_service."</a><br/>";
              }
              else
              {
                echo "[".$t->date_transfer."] ".$t->target_location.", ".$t->target_service."<br/>";
              }
              $item++;
            }
        }
        else
        {
              echo "None.<br/>";
        }

            echo "<a class=\"btn btn-primary\" href=\"".base_url()."transfers/add_transfer/".$row->id."\" >Add Transfer</a>";
            echo "</td>";
            echo "<td><a href=\"".base_url()."admissions/edit_disposition/".$row->id."\">".$row->disposition."</a><br/>";
            if(strcmp($row->disposition, "Admitted")){
              echo "Date<br/>".$row->dispo_date."<br/>";
              echo "Time<br/>".$row->dispo_time;
            }
            echo "</td></tr>";
        $count++;
        }
     ?>
  </tbody>
</table>
