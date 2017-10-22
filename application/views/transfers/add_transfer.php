<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $current_location = $row->current_location;
    $current_service = $row->current_service;
  }
 ?>

<?php echo form_open('transfers/add_transfer/'.$admission_id,'', array('current_location'=>$current_location, 'current_service'=>$current_service))?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Destination Location: <?php echo form_dropdown('target_location', $this->config->item('location'), $current_location)?><br/><br/>
    Destination Service: <?php echo form_dropdown('target_service', $this->config->item('service'), $current_service)?><br/><br/>
    Date of Transfer: <?php echo form_input('date_transfer','',array('class'=>'datepicker', 'id'=>'date_transfer'));?><br/><br/>
    Time of Transfer: <?php echo form_input('time_transfer','',array('class'=>'timepicker', 'id'=>'time_transfer'));?><br/><br/>
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
<?php form_close();?>
