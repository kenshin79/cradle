<div class="row">
  <div class="col-4">
    <label>From</label>
    <?php echo form_input('date_start','',array('class'=>'datepicker'));?>
  </div>
  <div class="col-4">
    <label>To</label>
    <?php echo form_input('date_end','',array('class'=>'datepicker'));?>
  </div>
  <div class="col-4">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
  <?php echo form_close(); ?>
</div>
