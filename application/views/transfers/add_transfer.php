<div class="row">
  <div class="col">
    <h3><?php echo $page_title;?></h3>
  </div>
</div>
<?php
foreach ($patient_info as $pow)
{
  $patient_id = $pow->{$this->config->item('id')};
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
  foreach ($admission_info as $row)
  {
    $admission_id = $row->id;
    $current_location = $row->current_location;
    $current_service = $row->current_service;
  }
 ?>

<table class="table">
  <tr>
    <th colspan="2"><?php echo $last_name.", ".$first_name." ".$middle_name." ".$age."/".$sex;?></th>
  </tr>
  <tr>
    <th colspan="2">Case No. <?php echo $case_number;?></th>
  </tr>
</table>
<?php echo form_open('transfers/add_transfer/'.$admission_id."/".$patient_id,'', array('current_location'=>$current_location, 'current_service'=>$current_service))?>
<div class="row">
  <div class="col-1">
  </div>
  <div class="col-3">
    <p>Location: <?php echo $current_location;?></p>
  </div>
  <div class="col-4">
    <p>Destination Location: <?php echo form_dropdown('target_location', $this->config->item('location'), $current_location)?></p>
  </div>
  <div class="col-3">
    Date: <?php echo form_input('date_transfer','',array('class'=>'datepicker', 'id'=>'date_transfer'));?>
  </div>
</div>

<div class="row">
    <div class="col-1">
    </div>
    <div class="col-3">
      <p>Current Service: <?php echo $current_service;?></p>
    </div>
    <div class="col-4">
      <p>Destination Service: <?php echo form_dropdown('target_service', $this->config->item('service'), $current_service)?></p>
    </div>
    <div class="col-3">
      Time: <?php echo form_input('time_transfer','',array('class'=>'timepicker', 'id'=>'time_transfer'));?>
    </div>
</div>
<div class="row">
  <div class="col-1">
  </div>
  <div class="col">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
<?php form_close();?>
