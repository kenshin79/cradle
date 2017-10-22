<div class="row">
  <div class="col">
    <h3><?php echo $page_title;?></h3>
  </div>
</div>
<?php
  $this->session->set_userdata('prev_uri', uri_string());
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
  <?php echo form_open('admissions/new_admission/'.$patient_id,'', array('patient_id'=>$patient_id)); ?>

<div class="row">
  <div class="col-1"></div>

  <div class="col">
    Date: <?php echo form_input(array('name'=>'date_in', 'id'=>'date_in', 'type'=>'text', 'class'=>'datepicker'));?><br/><br/>
    Time: <?php echo form_input(array('name'=>'time_in', 'id'=>'time_in', 'type'=>'text', 'class'=>'timepicker'));?><br/><br/>
    Location: <?php echo form_dropdown('initial_location', $this->config->item('location'), '', array('id'=>'initial_location'));?><br/><br/>
    Source: <?php echo form_dropdown('source', $this->config->item('source'), '', array('id'=>'source'));?><br/><br/>
    Service: <?php echo form_dropdown('initial_service', $this->config->item('service'), '', array('id'=>'initial_service'));?><br/><br/>
    <button class="btn btn-primary" type="submit" >Add Admission</button>
  </div>
</div>

  <?php echo form_close();?>
