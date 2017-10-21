<?php
  $patient_info = $this->mpi_model->get_patient($patient_id);
  foreach ($patient_info as $row)
  {

    $last_name = $row->{$this->config->item('last_name')};
    $first_name = $row->{$this->config->item('first_name')};
    $middle_name = $row->{$this->config->item('middle_name')};
    $sex = $row->{$this->config->item('sex')};
    $case_number = $row->{$this->config->item('case_number')};
    $birth_date = $row->{$this->config->item('birth_date')};
    $address = $row->{$this->config->item('address')};
    $city_province = $row->{$this->config->item('city_province')};
  }
  $age = date_diff(date_create($birth_date), date_create(date('Y-m-d')))->y;
 ?>
  <?php echo form_open('consults/new_consult/'.$patient_id,'', array('patient_id'=>$patient_id)); ?>

<div class="row">

  <div class="col">
    <h3>New Emergency</h3>
  </div>
  <div class="col">
    <label for="date_in">Date</label>
    <?php echo form_input(array('name'=>'date_in', 'id'=>'date_in', 'type'=>'text', 'class'=>'datepicker'));?>
  </div>
  <div class="col">
    <label for="time_in" >Time</label>
    <?php echo form_input(array('name'=>'time_in', 'id'=>'time_in', 'type'=>'text', 'class'=>'timepicker'));?>
  </div>
  <div class="col">
    <button class="btn btn-primary" type="submit" >Add Consult</button>
  </div>
</div>


  <?php echo form_close();?>
<table class="table">
  <tr>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Birth date</th>
    <th>Current Age/Sex</th>
  </tr>
  <tr>
    <td><?php echo $last_name;?></td>
    <td><?php echo $first_name;?></td>
    <td><?php echo $middle_name;?></td>
    <td><?php echo $birth_date;?></td>
    <td><?php echo $age."/".$sex;?></td>
  </tr>
  <tr>
    <td colspan="2">Case Number:<?php echo $case_number;?></td>
    <td colspan="3">Address: <?php echo $address;?></td>
  </tr>
  <tr>
    <td colspan="5">City/Province: <?php echo $city_province;?></td>
  </tr>
</table>
