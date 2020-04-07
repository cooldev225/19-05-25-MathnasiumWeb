<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php 
	if(!isset($sessiondata['studentx'])) echo "Math Lecture";
	else if($sessiondata['studentx']!="")echo $this->view['sessiondata']['studentx'];
	else echo "Math Lecture";?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/select2/dist/css/select2.min.css">

  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/morris.js/morris.css">
  <!--link rel="stylesheet" href="<?php //echo ASSET_PATH;?>bower_components/jvectormap/jquery-jvectormap.css"-->
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <style>
      .icheckbox_flat-green, .iradio_flat-green, .iradio_flat-red {
        margin-top: 8px;
        padding-top: 30px;
        //background: url(<?php echo ASSET_PATH;?>plugins/iCheck/flat/red.png) no-repeat;
        margin-right: 8px;
      }
      .form-control {
        font-size: 17px;
      }
  </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <script src="<?php echo ASSET_PATH;?>bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/raphael/raphael.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/morris.js/morris.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!--script src="<?php //echo ASSET_PATH;?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="<?php //echo ASSET_PATH;?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script-->
  <script src="<?php echo ASSET_PATH;?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/moment/min/moment.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/fastclick/lib/fastclick.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/iCheck/icheck.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>dist/js/adminlte.min.js"></script>
  <!--script src="<?php echo ASSET_PATH;?>dist/js/pages/dashboard.js"></script-->
  <script src="<?php echo ASSET_PATH;?>dist/js/demo.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include $header;?>
    <?php include $sidebar;?>
    <?php include $content;?>
    <?php include $footer;?>
</div>


</body>
</html>
