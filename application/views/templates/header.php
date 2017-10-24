<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title;?> - CRADLE</title>
    <meta name="author" content="Homer Uy Co, M.D.">
    <meta name="description" content="Computerized Registry of Admissions and Discharges">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jquery-ui/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jquery-ui/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jquery-ui/jquery.timepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datatables.min.css">
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/popper.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/jquery-ui/jquery.timepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
    <script>
        $( function() {
          $( ".datepicker" ).datepicker({
            dateFormat:"yy-mm-dd"
          });
          $('.timepicker').timepicker({ timeFormat: 'H:mm:ss'});
          $(".datatable").DataTable({});

          });

    </script>
  </head>
  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo base_url()."welcome";?>">CRADLE <span class="badge badge-pill badge-primary">User: <?php echo $this->session->identity; ?></span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url()."reports"; ?>"><span>Home</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle btn" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Census
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="<?php echo base_url()."consults/show_active_consults";?>">Active Emergency Consults</a>
                <a class="dropdown-item" href="<?php echo base_url()."admissions/show_admissions";?>">Admissions List</a>
                <a class="dropdown-item" href="<?php echo base_url()."consults/select_period_consults";?>">Period Emergency Consults</a>

              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle btn" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                New
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="<?php echo base_url()."patients/index/1";?>">New Emergency Consult</a>
                <a class="dropdown-item" href="<?php echo base_url()."patients/index/2";?>">New Admission</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="btn
              <?php
                if(!$this->ion_auth->is_admin())
                {
                  echo "disabled";
                }
              ?>
              " href="<?php echo base_url()."auth/list_users";?>">List Users</a>
            </li>
            <li class="nav-item">
              <a class="btn" href="<?php echo base_url()."auth/change_password";?>">Change Password</a>
            </li>
            <li class="nav-item">
              <a class="btn" href="<?php echo base_url()."auth/logout";?>">Log Out</a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="row">
        <div class="form-group row">
            <?php
              if($this->session->flashdata('message'))
              {
                echo "<div id='infoMessage'class='alert alert-primary' >".$this->session->flashdata('message')."</div>";
              }
            ?>
        </div>
      </div>
    </div>
