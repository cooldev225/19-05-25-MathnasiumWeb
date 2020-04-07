
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Math Lecture | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH;?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/iCheck/square/blue.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
          <a href="<?php echo BASE_PATH;?>"><img src="<?php echo IMAGE_PATH;?>logo.png" style="width: 215px;"></a>
        </div>
      
        <?php if($error != 0){?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?php echo $message;?>
          </div>
        <?php }?>
        
      <div class="login-box-body">
          <p class="login-box-msg"></p>

          <form action="<?php echo BASE_PATH?>/login/forgetin" method="post" id="loginfrm">
              <div class="form-group has-feedback">
                  <input type="email" class="form-control" placeholder="Your Email" name="email" id="email" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              
              <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="New create password" name="password" id="password" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              
              <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="Your First Name" name="username" id="username" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              
              <div class="form-group has-feedback">
                  <select class="form-control" name="role" id="role">
                      <option value="2">INSTRUCTOR</option>
                      <option value="3">PARENT</option>
                      <option value="1">ADMINISTRATOR</option>
                  </select>
              </div>
              
              <div class="form-group has-feedback">
                  Please choose your center.
                  <select class="form-control" name="center" id="center">
                      <?php
                        foreach(explode("###",$centerdata) as $center){
                            echo "<option>{$center}</option>";
                        }
                      ?>
                  </select>
              </div>
              <div class="row">
                  <div class="col-xs-6">
                      <a href="index" onclick="">go back</a>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" onclick="submitAction();" class="btn btn-primary btn-block btn-flat">submit</button>
                  </div>
              </div>
          </form>
        </div>
    </div>

    <script src="<?php echo ASSET_PATH;?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo ASSET_PATH;?>plugins/iCheck/icheck.min.js"></script>
    <script>
    function submitAction(){
        if($('#email').val()==""){
            alert('Please type your email.');
            $('#email').focus();
            return;
        }
        if($('#password').val()==""){
            alert('Please type your password.');
            $('#password').focus();
            return;
        }
        if($('#username').val()==""){
            alert('Please type your username.');
            $('#username').focus();
            return;
        }
        $("#loginfrm").submit();
    }
$(function () {

});
    </script>
    </body>
</html>
