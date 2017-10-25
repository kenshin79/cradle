<?php
  $patient_info = $this->mpi_model->get_patient($patient_id);
  foreach ($patient_info as $row)
  {

    $last_name = $row->{$this->config->item('last_name')};
    $first_name = $row->{$this->config->item('first_name')};
    $middle_name = $row->{$this->config->item('middle_name')};
    $sex = $row->{$this->config->item('sex')};
    $case_number = $row->{$this->config->item('case_number')};
    $birth_date = $row->{$this->config->item('birth_date')};
    $address = $row->{$this->config->item('address')};
    $city_province = $row->{$this->config->item('city_province')};
  }
  $age = date_diff(date_create($birth_date), date_create(date('Y-m-d')))->y;

 ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <h3>New Emergency</h3>
  </div>
</div>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <table class="table">
      <tr>
        <th><?php echo $last_name.", ".$first_name." ".$middle_name." ".$age."/".$sex;?><br/>
            Birth Date: <?php echo $birth_date;?><br/>
            Case Number: <?php echo $case_number;?><br/>
            Address: <?php echo $address;?><br/>
        </th>
      </tr>
    </table>
<?php echo form_open('consults/new_consult/'.$patient_id,'', array('patient_id'=>$patient_id)); ?>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    Date: <?php echo form_input(array('name'=>'date_in', 'id'=>'date_in', 'type'=>'text', 'class'=>'datepicker'));?><br/><br/>
    Time: <?php echo form_input(array('name'=>'time_in', 'id'=>'time_in', 'type'=>'text', 'class'=>'timepicker'));?><br/><br/>
    Type: <?php echo form_dropdown('ed_type', $this->config->item('ed_type'));?><br/><br/>
    <button class="btn btn-primary" type="submit" >Add Consult</button>
  </div>
</div>


  <?php echo form_close();?>
