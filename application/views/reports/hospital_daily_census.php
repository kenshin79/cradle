<br/>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <h3><?php echo $page_title;?> <span><?php echo "(".$date_start." to ".$date_end.")";?></span></h3>
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
    <th>-Disch</th>
    <th>+Adm/Disch</th>
    <th>Census</th>
    <th>Inpatient Service Days</th>
  </tr>
<?php
$start = $date_start;
$end = $date_end;
$total_patient_days = 0;
while (strtotime($start) <= strtotime($end)) {
  $beg_adm = $this->admissions_model->count_day_active_hospital_admissions($start);
  $day_admissions = $this->admissions_model->count_day_hospital_admissions($start);
  $day_dispo = $this->admissions_model->count_day_hospital_dispo($start);
  $adm_dis = $this->admissions_model->count_day_hospital_admission_discharges($start);
  $end_bal = $beg_adm + $day_admissions - $day_dispo;
  $service_days = $end_bal + $adm_dis;
    echo "<tr>";
    echo "<td>".$start."</td>";
    echo "<td>".$beg_adm."</td>";
    echo "<td>".$day_admissions."</td>";
    echo "<td>".$day_dispo."</td>";
    echo "<td>".$adm_dis."</td>";
    echo "<td>".$end_bal."</td>";
    echo "<td>".$service_days."</td>";
    $start = date ("Y-m-d", strtotime("+1 days", strtotime($start)));
    $total_patient_days = $total_patient_days + $service_days;
    echo "</tr>";
}

?>
  <tfoot>
    <tr>
      <th colspan="5"></th>
      <th>Total Inpatient Service Days</th>
      <th><?php echo $total_patient_days;?></th>
    </tr>
  </tfoot>
</table>
  </div>
  <div class="col-1"></div>
</div>
