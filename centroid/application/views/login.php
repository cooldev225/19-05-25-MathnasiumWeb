
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
          <p class="login-box-msg">Sign in to start your session</p>

          <form action="<?php echo BASE_PATH?>/login/signin" method="post" id="loginfrm">
              <div class="form-group has-feedback">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                  <div class="col-xs-6"><input type="hidden" id="role" name="role"/>
                  <div class="checkbox icheck">
                      <!--
                      <label>
                      <input type="checkbox"> Remember Me
                      </label><br><br><br><br>
                      -->
                      <a href="<?php echo URL_PATH;?>login/forget" onclick="">I forgot my password</a>
                      <br><a href="<?php echo URL_PATH;?>login/forget" onclick="">Create new password</a>
                  </div>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" onclick="submitAction(0);" style="margin-top: 14px;" class="btn btn-primary btn-block btn-flat">Login</button>
                    <!--
                    <button type="button" onclick="submitAction(2);" class="btn btn-primary btn-block btn-flat">INSTRUCTOR</button>
                    <button type="button" onclick="submitAction(3);" class="btn btn-primary btn-block btn-flat">PARENT</button>
                    <button type="button" onclick="submitAction(1);" class="btn btn-primary btn-block btn-flat">ADMINISTRATOR</button>
                    -->
                  </div>
              </div>
              
              <!--div class="social-auth-links text-center">
                  <p>- SELECT USER -</p>
                  <select class="form-control" name="role" id="role">
                      <option value="2">INSTRUCTOR</option>
                      <option value="3">PARENT</option>
                      <option value="1">ADMINISTRATOR</option>
                  </select>
              </div-->
          </form>
        
        <!-- <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
            Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
            Google+</a>
        </div> -->
        <!-- /.social-auth-links -->

          <!--br>
          <a href="#" onclick="location.href='home/adduser/'+$('#role').val();" class="text-center">Register a new membership</a>
		-->
        </div>
    </div>

    <script src="<?php echo ASSET_PATH;?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo ASSET_PATH;?>plugins/iCheck/icheck.min.js"></script>
    <script>
    $("#email").on('keyup',function(event){
        if(event.keyCode==13){
            //alert();
            if($("#email").val()!="")$("#password").focus();
        }
    });
    $("#password").on('keyup',function(event){
        if(event.keyCode==13){
            //alert();
            if($("#email").val()==""){$("#email").focus();return;}
            if($("#password").val()!="")submitAction(0);
        }
    });
    function submitAction(r){
        $("#role").val(r);
        $("#loginfrm").submit();
    }
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>
    </body>
</html>
