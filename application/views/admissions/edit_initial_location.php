<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $initial_location = $row->initial_location;
  }
  echo form_open('admissions/edit_initial_location/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Initial Location: <?php echo form_dropdown('initial_location', $this->config->item('location'), $initial_location);?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
