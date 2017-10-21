<?php
echo "<div class=\"row\">";
echo "<div  class=\"col-1\"></div>";
echo "<div class=\"col\">";
echo "<h3>".$page_title."</h3>";
echo "</div>";
echo "</div>";
$this->load->model('emergency_consults_model');
$current_disposition = $this->emergency_consults_model->get_disposition($consult_id);
foreach ($current_disposition as $row)
{
  $dispo_now = $row->disposition;
}
echo form_open('consults/edit_consult_disposition/'.$consult_id);
?>

<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <label>Disposition</label>
    <?php echo form_dropdown('disposition', $this->config->item('ed_disposition'), $dispo_now);?>
  </div>
  <div class="col">
    <label>Date</label>
    <?php echo form_input('dispo_date', '', array('class'=>'datepicker', 'id'=>'dispo_date'));?>
  </div>
  <div class="col">
    <label>Time</label>
    <?php echo form_input('dispo_time', '', array('class'=>'timepicker', 'id'=>'dispo_time'));?>
  </div>
  <div class="col">
    <button class="btn btn-primary" type="submit">Save</button>
  </div>
</div>
