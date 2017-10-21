<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Log In - CRADLE</title>
    <meta name="author" content="Homer Uy Co, M.D.">
    <meta name="description" content="Computerized Registry of Admissions and Discharges">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <style>
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #eee;
    }

    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin .checkbox {
      font-weight: normal;
    }
    .form-signin .form-control {
      position: relative;
      height: auto;
      -webkit-box-sizing: border-box;
              box-sizing: border-box;
      padding: 10px;
      font-size: 16px;
    }
    .form-signin .form-control:focus {
      z-index: 2;
    }
    .form-signin input[type="email"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    </style>
  </head>
  <body>
    <div class="container">
        <?php echo form_open("auth/login", array('class'=>'form-signin'));?>
        <div class="form-group row">
            <h2 class="form-signin-heading"><?php echo lang('login_heading');?></h2>
        </div>
        <div class="form-group row">
            <?php
              if($message)
              {
                echo "<div id='infoMessage'class='alert alert-primary' >".$message."</div>";
              }
            ?>
        </div>
        <div class="form-group row">
            <label for="identity" class="label">Email address</label>
              <?php //echo lang('login_identity_label', 'identity');?>
              <?php echo form_input($identity);?>

            <label for="password" class="label">Password</label>
              <?php //echo lang('login_password_label', 'password');?>
              <?php echo form_input($password);?>

            <div class="checkbox">
              <label>
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                <?php echo lang('login_remember_label', 'remember');?>
              </label>
          </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php //echo form_submit('submit', lang('login_submit_btn')); ?>Sign In</button>
            <?php echo form_close();?>

          <label><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></label>
        </div>
    </div>


    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  </body>
</html>
