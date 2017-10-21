<?php echo form_open('patients/index/'.$encounter) ?>
<h3><?php echo $search_title;?></h3>
<div class="form-group">

  <label for="search_term">Search:</label>
  <?php echo form_input('search_term'); ?>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
<?php
  if($encounter == 1){
    $target = 'encounters/new_consult';
  }
  elseif ($encounter == 2) {
    $target = 'encounters/new_admission';
  }
  if($search_results)
  {
    echo "<table class=\"table datatable\">";
    echo "  <thead>";
    echo "    <tr>";
    echo "      <th>Name</th>";
    echo "      <th>Case Number</th>";
    echo "      <th>Birthdate</th>";
    echo "      <th>Current Age/Sex</th>";
    echo "      <th>Address</th>";
    echo "      <th>City/Province</th>";
    echo "      <th></th>";
    echo "    </tr>";
    echo "  </thead>";
    echo "  <tbody>";
    foreach ($search_results as $row)
    {
      $age = date_diff(date_create($row->{$this->config->item('birth_date')}),date_create(date('Y-m-d')))->format('%y');
      if(strcmp($row->{$this->config->item('last_name')},$row->{$this->config->item('first_name')})){
        $full_name = $row->{$this->config->item('last_name')}.", ".$row->{$this->config->item('first_name')};
      }
      else{
        $full_name = $row->{$this->config->item('last_name')};
      }
      if(strcmp($row->{$this->config->item('first_name')}, $row->{$this->config->item('middle_name')}))
      {
        $full_name = $full_name." ".$row->{$this->config->item('middle_name')};
      }
          echo "<tr>";
          echo "<td>".$full_name."</td>";
          echo "<td>".$row->{$this->config->item('case_number')}."</td>";
          echo "<td>".$row->{$this->config->item('birth_date')}."</td>";
          echo "<td>".$age."/".$row->{$this->config->item('sex')}."</td>";
          echo "<td>".$row->{$this->config->item('address')}."</td>";
          echo "<td>".$row->{$this->config->item('city_province')}."</td>";
          echo "<td><a class=\"btn btn-primary\" href=\"".base_url().$target."/".$row->{$this->config->item('id')}."\" role=\"button\">Select</a></td>";
          echo "</tr>";
      echo form_close();
    }
    echo "  </tbody>";
    echo "</table>";
  }

 ?>
