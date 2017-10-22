<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $initial_service = $row->initial_service;
  }
  echo form_open('admissions/edit_initial_service/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Initial Service: <?php echo form_dropdown('initial_service', $this->config->item('service'), $initial_service);?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
