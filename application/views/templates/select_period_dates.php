<div class="row">
  <div class="col-1"></div>
  <div class="col">
    <br/>
    From: <?php echo form_input('date_start','',array('class'=>'datepicker'));?>
    To: <?php echo form_input('date_end','',array('class'=>'datepicker'));?>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php echo form_close(); ?>
  </div>
</div>
