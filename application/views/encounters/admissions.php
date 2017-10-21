<h3>Admissions</h3>
<table class="table datatable">
  <thead>
    <tr>
      <th>No.</th>
      <th>Patient</th>
      <th>Date/Time</th>
      <th>Service</th>
      <th>Location</th>
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
        $transfers = $this->transfers_model->get_transfers($row->id);
        echo "<tr>";
        echo "<td>".$count."</td>";
        echo "<td>".$last_name.", ".$first_name." ".$middle_name;
        echo " ".$age."/".$sex."<br />";
        echo "Case no.:".$case_number."<br />";
        echo "Source:<a href=\"\">".$row->source."</a></td>";
        echo "<td>Date<br/><a href=\"\">".$row->date_in."</a><br />";
        echo "Time<br/><a href=\"\">".$row->time_in."</a></td>";
        echo "<td>Initial<br/><a href=\"\">".$row->initial_service."</a><br />";
        echo "Current<br/>".$row->current_service."</td>";
        echo "<td>Initial<br/><a href=\"\">".$row->initial_location."</a><br/>";
        echo "Current<br/>".$row->current_location."<br/>";
        echo "<a class=\"btn btn-primary\" href=\"".base_url()."transfers/add_transfer/".$row->id."/".$row->patient_id."\" >Add Transfer</a></td>";
        echo "<td><a href=\"\">".$row->disposition."</a><br/>";
        echo "Date<br/>".$row->dispo_date."<br/>";
        echo "Time<br/>".$row->dispo_time."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td colspan=\"5\">Location transfers: ";
        $move = 1;
        $number_transfers = count($transfers);
        foreach ($transfers as $t) {
          if(strcmp($t->source_location, $t->target_location)){
            echo "(".$move.") [".$t->date_transfer."] ".$t->target_location." - ";
            $move++;
          }
        }
        $move = 1;
        echo "<br/>Service transfers: ";
        foreach ($transfers as $t) {
          if(strcmp($t->source_service, $t->target_service)){
            echo "(".$move.") [".$t->date_transfer."] ".$t->source_service."-->".$t->target_service." ";
          }
        }
          echo "</td>";
          echo "</tr>";
          $count++;
        }

     ?>
  </tbody>
</table>
