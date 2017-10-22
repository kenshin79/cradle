<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $date_in = $row->date_in;
  }
  echo form_open('admissions/edit_date_in/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Date of Admission: <?php echo form_input('date_in', $date_in, array('class'=>'datepicker'));?>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
