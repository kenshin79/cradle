
<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $source = $row->source;
  }
  echo form_open('admissions/edit_source/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Source: <?php echo form_dropdown('source', $this->config->item('source'), $source);?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
