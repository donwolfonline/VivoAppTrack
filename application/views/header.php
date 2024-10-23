<?php  
   function activate_menu($controller) {
     $CI = get_instance();
     $last = $CI->uri->total_segments();
     $seg = $CI->uri->segment($last);
     if(is_numeric($seg)) {
       $seg = $CI->uri->segment($last-1);
     }
     if (in_array($controller, array($seg))) {
         return 'active';
     } else {
         return '';   
     } 
   }
   if(!isset($this->session->userdata['session_data'])) {
     $url=base_url().'login';
     header("location: $url");
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title><?php 
         $data = sitedata();
         $total_segments = $this->uri->total_segments(); 
         echo ucwords(str_replace('_', ' ', $this->uri->segment(1))).' | '.output($data['s_companyname']) ?></title>
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.css">
      <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/toast/toast.min.css" />
      <script src="<?= base_url(); ?>assets/plugins/toast/toast.min.js"></script>
   </head>
   <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
      <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-dark theme-navbar-primary">
         <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
         </ul>
         <input type="hidden" id="base" value="<?php echo base_url(); ?>">
         <input type="hidden" id="dateformat" value="<?php echo $data["s_date_format"]; ?>">

         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item">
               <a class="nav-link"  href="<?= base_url(); ?>login/logout">
               <i class="fas fa-sign-out-alt"></i></a>
            </li>
         </ul>
      </nav>
      <!-- /.navbar -->

      <script type="text/javascript">
    function confirmation(href_url, id) {
        $('#action').attr('action', href_url);
        $('.del_id').val(id);
        $("#myModal").modal('show');
    }
</script>




      <div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content" style="text-align: center;">
            <form id="action" method="post">
            <div class="modal-header flex-column">
            <input class="form-control del_id" type="hidden" name="del_id">                   
                <h4 class="modal-title w-100"><b>Are you sure?</b></h4>    
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
    </div>
</div>  