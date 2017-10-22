<?php
  $admission_info = $this->admissions_model->get_admission_info($admission_id);
  foreach ($admission_info as $row) {
    $disposition = $row->disposition;
    $dispo_date = $row->dispo_date;
    $dispo_time = $row->dispo_time;
  }
  echo form_open('admissions/edit_disposition/'.$admission_id); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Disposition: <?php echo form_dropdown('disposition', $this->config->item('in_disposition'), $disposition);?><br/><br/>
    Disposition Date: <?php echo form_input('dispo_date', $dispo_date, array('class'=>'datepicker'));?><br/><br/>
    Disposition Time: <?php echo form_input('dispo_time', $dispo_time, array('class'=>'timepicker'));?><br/><br/>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
<?php form_close();?>
