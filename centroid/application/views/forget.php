<style>
    .code-input{
            width: 30px;
        height: 30px;
        font-size: 30px;
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Math Lecture | Forgot</title>
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
                  <input type="hidden" class="form-control" value="<?php if(!isset($status))$status=0;echo $status;?>" name="status" id="status"/>
                  <input type="email" class="form-control" value="<?php if($status>0&&isset($email))echo $email;?>" <?php if($status>0)echo " readonly";?> placeholder="Your Email" name="email" id="email" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                  <?php if($status==0)echo "<br><br>";
                  else if($status){echo"Please check your email box and then type your code.";?>
                  
                      <input type="input" id="code1" name="code1" class="code-input"/>-
                      <input type="input" id="code2" name="code2" class="code-input"/>-
                      <input type="input" id="code3" name="code3" class="code-input"/>-
                      <input type="input" id="code4" name="code4" class="code-input"/>-
                      <input type="input" id="code5" name="code5" class="code-input"/><a href="#" onclick="eyeclick();">
                          
              </div>
              <div class="form-group has-feedback"><span class="fa fa-eye form-control-label" id="peye"></span></a>
                      <input type="password" class="form-control" placeholder="New create password" name="password" id="password" required>
                      
              </div>
              <div class="form-group has-feedback">
                  
                      <input type="password" class="form-control" placeholder="Confirm password" name="cpassword" id="cpassword" required>
                <?php }?>
              </div>
                  
              <div class="form-group">
                  <div class="col-xs-6">
                      <a href="index" onclick=""><lavbel>go back</label></a>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" onclick="submitAction(<?php echo $status;?>);" class="btn btn-primary btn-block btn-flat"><?php if($status==0)echo "Next";else echo "Submit";?></button>
                  </div>
                  <input type="text" style="height;0px;opacity: 0;"/>
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
    function eyeclick(){
        //alert($("#peye").attr('class'));
        if($("#peye").attr('class')=="fa fa-eye form-control-label"){
            $("#peye").attr('class',"fa fa-eye-slash form-control-label");
            $("#password").attr('type',"text");
            $("#cpassword").attr('type',"text");
        }else{
            $("#peye").attr('class',"fa fa-eye form-control-label");
            $("#password").attr('type',"password");
            $("#cpassword").attr('type',"password");
        } 
    }
    function submitAction(f){
        if($('#email').val()==""){
            alert('Please type your email.');
            $('#email').focus();
            return;
        }
        if($("#password").val()!=$("#cpassword").val()){
            $("#password").val('');
            $("#cpassword").val('');
            $("#password").focus();
            return;
        }
        $("#loginfrm").submit();
    }
    $(function () {
        $("#code1").focus();
        $("#password").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(e.keyCode==13){
                if($("#password").val()!='')$("#cpassword").focus();
            }
        });
        $("#cpassword").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(e.keyCode==13){
                if($("#cpassword").val()!='')submitAction(1);
            }
        });
        $("#code1").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(isNaN($("#code1").val())){
                $("#code1").val('');
                $("#code1").focus();
            }else{
                $("#code2").val('');
                $("#code2").focus();
            }
        });
        $("#code2").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(isNaN($("#code2").val())){
                $("#code2").val('');
                $("#code2").focus();
            }else{
                $("#code3").val('');
                $("#code3").focus();
            }
        });
        $("#code3").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(isNaN($("#code3").val())){
                $("#code3").val('');
                $("#code3").focus();
            }else{
                $("#code4").val('');
                $("#code4").focus();
            }
        });
        $("#code4").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(isNaN($("#code4").val())){
                $("#code4").val('');
                $("#code4").focus();
            }else{
                $("#code5").val('');
                $("#code5").focus();
            }
        });
        $("#code5").on('keyup',function(e){//alert(isNaN($("#code1").val()));
            if(isNaN($("#code5").val())){
                $("#code5").val('');
                $("#code5").focus();
            }else{
                $("#password").val('');
                $("#password").focus();
            }
        });
    });
    </script>
    </body>
</html>
