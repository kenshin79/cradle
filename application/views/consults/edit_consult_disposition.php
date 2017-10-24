<?php
$this->load->model('emergency_consults_model');
$consult = $this->emergency_consults_model->get_consult($consult_id);
foreach ($consult as $row)
{
  $dispo_date = $row->dispo_date;
  $dispo_time = $row->dispo_time;
  $dispo_now = $row->disposition;
}
echo form_open('consults/edit_consult_disposition/'.$consult_id);
?>

<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Disposition:
    <?php echo form_dropdown('disposition', $this->config->item('ed_disposition'), $dispo_now);?><br/><br/>
    Date of Disposition:
    <?php echo form_input('dispo_date', $dispo_date, array('class'=>'datepicker', 'id'=>'dispo_date'));?><br/><br/>
    Time of Disposition:
    <?php echo form_input('dispo_time', $dispo_time, array('class'=>'timepicker', 'id'=>'dispo_time'));?><br/><br/>
    <button class="btn btn-primary" type="submit">Save</button>
  </div>
</div>
<?php form_close();?>
