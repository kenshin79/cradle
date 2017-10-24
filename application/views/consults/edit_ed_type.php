<?php
$this->load->model('emergency_consults_model');
$ed_type_info = $this->emergency_consults_model->get_ed_type($consult_id);
foreach ($ed_type_info as $row)
{
  $ed_type = $row->ed_type;
}
echo form_open('consults/edit_ed_type/'.$consult_id);
?>
<div class="row">
  <div class="col-1"></div>
    <div class="col">
      <?php echo form_dropdown('ed_type', $this->config->item('ed_type'), $ed_type);?>
      <button class="btn btn-primary" type="submit">Save</button>
    </div>
  </div>
</div>
<?php form_close();?>
