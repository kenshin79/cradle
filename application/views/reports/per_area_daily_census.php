<br/>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <h3><?php echo $page_title;?> <span><?php echo $location." (".$date_start." to ".$date_end.")";?></span></h3>
  </div>
</div>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
<table class="table table-sm">
  <tr>
    <th>Date</th>
    <th>+Beg Bal</th>
    <th>+Adm</th>
    <th>+Trans-in</th>
    <th>-Disch</th>
    <th>-T-out</th>
    <th>+Adm/Disch</th>
    <th>Census</th>
    <th>Inpatient Service Days</th>
  </tr>
<?php
$start = $date_start;
$end = $date_end;
$total_patient_days = 0;

while (strtotime($start) <= strtotime($end))
{
  $beg_adm = $this->admissions_model->count_day_active_admissions($start, $location);
  $beg_adm_trans = 0;
  foreach ($beg_adm as $row) {
    if($this->transfers_model->with_trans_out($row->id, $start, $location)){
      $beg_adm_trans++;
    }
  }
  $beg_trans = $this->transfers_model->count_day_active_transfers($start, $location);
  $beg_trans_trans = 0;
  foreach ($beg_trans as $row) {
    if($this->transfers_model->trans_with_trans_out($row->admission_id, $row->date_transfer, $start, $location)){
      $beg_trans_trans++;
    }
  }
  $beg_bal = count($beg_adm) + count($beg_trans) - ($beg_adm_trans + $beg_trans_trans);
  $day_admissions = $this->admissions_model->count_day_admissions($start, $location);

  $day_trans_in = $this->transfers_model->count_day_transfers_in($start, $location);
  $trans_in_and_out = 0;
  foreach ($day_trans_in as $row)
  {
    if($to = $this->transfers_model->same_day_trans_in_and_out($row->admission_id, $start, $location))
    {
      $trans_in_and_out++;

    }
  }
  $trans_in_and_dispo = 0;
  foreach($day_trans_in as $row){
    if($td = $this->transfers_model->same_day_trans_in_and_dispo($row->admission_id, $start, $location)){
      $trans_in_and_dispo++;
    }
  }
    $day_transfers_in = count($day_trans_in);

    $day_dispo = $this->admissions_model->count_day_dispo($start, $location);
    $day_transfers_out = $this->transfers_model->count_day_transfers_out($start, $location);

    $adm_dis = $this->admissions_model->count_day_admit_and_dispo($start, $location);
    $adm_tout = $this->admissions_model->count_day_admit_and_trans_out($start, $location);

    $same_day_in_and_out = $adm_dis + $adm_tout + $trans_in_and_out + $trans_in_and_dispo;
    $end_bal = $beg_bal + $day_admissions + $day_transfers_in - $day_dispo - $day_transfers_out;
    $service_days = $end_bal + $same_day_in_and_out;
    echo "<tr>";
    echo "<td>".$start."</td>";
    echo "<td>".$beg_bal."</td>";
    echo "<td>".$day_admissions."</td>";
    echo "<td>".$day_transfers_in."</td>";
    echo "<td>".$day_dispo."</td>";
    echo "<td>".$day_transfers_out."</td>";
    echo "<td>".$same_day_in_and_out."</td>";
    echo "<td>".$end_bal."</td>";
    echo "<td>".$service_days."</td>";
    $start = date ("Y-m-d", strtotime("+1 days", strtotime($start)));
    $total_patient_days = $total_patient_days + $service_days;
    echo "</tr>";
}

?>
  <tfoot>
    <tr>
      <th colspan="7"></th>
      <th>Total Inpatient Service days</th><th><?php echo $total_patient_days;?></th>
    </tr>
  </tfoot>
</table>
  </div>
  <div class="col-1"></div>
</div>
<?php

echo count($day_trans_in);
 ?>
