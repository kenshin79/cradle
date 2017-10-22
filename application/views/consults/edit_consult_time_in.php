<?php
$this->load->model('emergency_consults_model');
$current_time_in = $this->emergency_consults_model->get_time_in($consult_id);
foreach ($current_time_in as $row)
{
  $time_in_value = $row->time_in;
}
echo form_open('consults/edit_consult_time_in/'.$consult_id);
?>
<div class="row">
  <div class="col-1"></div>
    <div class="col">
      <?php echo form_input('time_in', $time_in_value, array('type'=>'text', 'id'=>'time_in', 'class'=>"timepicker"));?>
      <button class="btn btn-primary" type="submit">Save</button>
    </div>
  </div>
</div>
<?php form_close();?>
