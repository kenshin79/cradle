<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <table class="table">
      <tr>
        <td colspan="3"><h4>ACTIVE ED Consults (<?php echo $this->emergency_consults_model->count_all_active_consults();?>)</h4><br/></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."consults/show_active_consults/1";?>">ADULT (<?php echo $this->emergency_consults_model->count_active_consults("Adult");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."consults/show_active_consults/2";?>">PEDIATRIC (<?php echo $this->emergency_consults_model->count_active_consults("Pediatric");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."consults/show_active_consults/3";?>">OBSTETRIC (<?php echo $this->emergency_consults_model->count_active_consults("Obstetric");?>)</a></td>
      </tr>
    </table>
  </div>
  <div class="col-1"></div>
</div>
<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <table class="table">
      <tr>
        <td colspan="5"><h4>ACTIVE Admissions (<?php echo $this->admissions_model->count_all_active_admissions();?>)</h4></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/1";?>">Emergency Room (<?php echo $this->admissions_model->count_active_admissions("Emergency");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/3";?>">PAS (<?php echo $this->admissions_model->count_active_admissions("PAS");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/2";?>">OBAS (<?php echo $this->admissions_model->count_active_admissions("OBAS");?>)</a></td><td></td><td?</td>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/4";?>">Ward 1 (<?php echo $this->admissions_model->count_active_admissions("Ward 1");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/5";?>">Ward 2 (<?php echo $this->admissions_model->count_active_admissions("Ward 2");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/6";?>">Ward 3 (<?php echo $this->admissions_model->count_active_admissions("Ward 3");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/7";?>">Ward 4 (<?php echo $this->admissions_model->count_active_admissions("Ward 4");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/8";?>">Ward 5(N) (<?php echo $this->admissions_model->count_active_admissions("Ward 5 (Neuro)");?>)</a></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/9";?>">Ward 5(R) (<?php echo $this->admissions_model->count_active_admissions("Ward 5 (Rehab)");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/10";?>">Ward 6 (<?php echo $this->admissions_model->count_active_admissions("Ward 6");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/11";?>">Ward 7 (<?php echo $this->admissions_model->count_active_admissions("Ward 7");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/12";?>">Ward 8 (<?php echo $this->admissions_model->count_active_admissions("Ward 8");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/13";?>">Ward 9 (<?php echo $this->admissions_model->count_active_admissions("Ward 9");?>)</a></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/14";?>">Ward 10 (<?php echo $this->admissions_model->count_active_admissions("Ward 10");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/15";?>">Ward 11 (<?php echo $this->admissions_model->count_active_admissions("Ward 11");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/16";?>">PHIC Ward (<?php echo $this->admissions_model->count_active_admissions("PHIC Ward");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/17";?>">Ward 14A (<?php echo $this->admissions_model->count_active_admissions("Ward 14A");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/18";?>">Ward 14B (<?php echo $this->admissions_model->count_active_admissions("Ward 14B");?>)</a></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/19";?>">Ward 15 (<?php echo $this->admissions_model->count_active_admissions("Ward 15");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/20";?>">Ward 16 (<?php echo $this->admissions_model->count_active_admissions("Ward 16");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/21";?>">Cancer Institute (<?php echo $this->admissions_model->count_active_admissions("CI");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/22";?>">SOJR (<?php echo $this->admissions_model->count_active_admissions("SOJR");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/23";?>">Hema-Onco (<?php echo $this->admissions_model->count_active_admissions("Hema-Onco");?>)</a></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/24";?>">Medical ICU (<?php echo $this->admissions_model->count_active_admissions("MICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/25";?>">CENICU (<?php echo $this->admissions_model->count_active_admissions("CENICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/30";?>">Pediatric ICU (<?php echo $this->admissions_model->count_active_admissions("PICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/26";?>">Surgical ICU (<?php echo $this->admissions_model->count_active_admissions("SICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/31";?>">Burn Unit (<?php echo $this->admissions_model->count_active_admissions("Burn Unit");?>)</a></td>
      </tr>
      <tr>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/29";?>">Neonatal ICU (<?php echo $this->admissions_model->count_active_admissions("NICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/27";?>">Neuro ICU (<?php echo $this->admissions_model->count_active_admissions("Neuro ICU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/28";?>">NSSCU (<?php echo $this->admissions_model->count_active_admissions("NSSCU");?>)</a></td>
        <td><a class="btn btn-light" href="<?php echo base_url()."admissions/show_active_admissions/32";?>">IMU (<?php echo $this->admissions_model->count_active_admissions("IMU");?>)</a></td><td></td>
      </tr>
    </table>
  </div>
  <div class="col-1"></div>
</div>
