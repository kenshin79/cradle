<?php
  $transfer_info = $this->transfers_model->get_transfer_info($transfer_id);
  foreach ($transfer_info as $row) {
    $date_transfer = $row->date_transfer;
    $time_transfer = $row->time_transfer;
    $target_location = $row->target_location;
    $target_service = $row->target_service;
  }
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $current_location = $row->current_location;
    $current_service = $row->current_service;
  }
 ?>

<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <?php echo form_open('transfers/edit_transfer/'.$transfer_id.'/'.$admission_id,'', array('current_location'=>$current_location, 'current_service'=>$current_service, 'old_date'=>$date_transfer, 'old_time'=>$time_transfer));?>
    Date of Transfer: <?php echo form_input('date_transfer',$date_transfer, array('class'=>'datepicker'));?><br/><br/>
    Time of Transfer: <?php echo form_input('time_transfer', $time_transfer, array('class'=>'timepicker'));?><br/><br/>
    Target Location: <?php echo form_dropdown('target_location', $this->config->item('location'), $target_location);?><br/><br/>
    Target Service: <?php echo form_dropdown('target_service', $this->config->item('service'), $target_service);?><br/><br/>
    <button type="submit" class="btn btn-primary">Save</button>
    <?php
      if($this->ion_auth->is_admin())
      {
        echo "<a class=\"btn btn-warning\" href=\"".base_url()."transfers/delete_transfer/".$transfer_id."\" >Delete ?</a>";
      }
     ?>
    <?php echo form_close();?>
  </div>
