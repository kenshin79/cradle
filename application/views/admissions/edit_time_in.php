<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $time_in = $row->time_in;
  }
  echo form_open('admissions/edit_time_in/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Time of Admission: <?php echo form_input('time_in', $time_in, array('class'=>'timepicker'));?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
