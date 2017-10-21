<div class="row">
  <div class="col">
    <h3><?php echo $page_title; ?></h3>
  </div>
</div>
  <?php echo form_open('encounters/show_period_consults');
        $this->session->set_userdata('prev_uri', uri_string());
  ?>
