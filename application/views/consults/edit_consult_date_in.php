<?php
$this->load->model('emergency_consults_model');
$current_date_in = $this->emergency_consults_model->get_date_in($consult_id);
foreach ($current_date_in as $row)
{
  $date_in_value = $row->date_in;
}
echo form_open('consults/edit_consult_date_in/'.$consult_id);
?>
<div class="row">
  <div class="col-1">
  </div>
  <div class="col">
    <?php echo form_input('date_in', $date_in_value, array('type'=>'text', 'id'=>'date_in', 'class'=>"datepicker"));?>
    <button class="btn btn-primary" type="submit">Save</button>
  </div>
</div>
<?php form_close();?>
