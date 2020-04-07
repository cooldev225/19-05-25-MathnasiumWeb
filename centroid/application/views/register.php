<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Math Lecture</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/select2/dist/css/select2.min.css">

  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo ASSET_PATH;?>plugins/iCheck/all.css">
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
  <script>
  var baseurl="<?php echo BASE_PATH;?>";
function formSubmit(){
        if($("#r_username").val()==""){
            alert("Please fill \"name\" field.");
            $("#r_username").focus();
            return;
        }
        if($("#r_email").val()==""){
            alert("Please fill \"email\" field.");
            $("#r_email").focus();
            return;
        }
        if($("#r_password").val()==""){
            alert("Please fill \"pswd\" field.");
            $("#r_password").focus();
            return;
        }
        if($("#r_repeatpwd").val()==""){
            alert("Please fill \"conf\" field.");
            $("#r_repeatpwd").focus();
            return;
        }
        if($("#r_password").val()!=$("#r_repeatpwd").val()){
            alert("Please fill \"password\" field.");
            $("#r_password").val('');
            $("#r_repeatpwd").val('');
            $("#r_password").focus();
            return;
        }
        res = $.ajax({
            url: baseurl+"/administrator/submituser",
            type: 'post',
            data: {
                r_role:$("#r_role").val(),
                r_username:$("#r_username").val(),
                r_email:$("#r_email").val(),
                r_password:$("#r_password").val(),
                r_repeatpwd:$("#r_repeatpwd").val()
            },
            dataType: "json",
            success: function( data ) {
                if(data['error']==2){
                    $("#r_username").val('');
                    $("#r_username").focus();
                }
                if(data['error']==3){
                    $("#r_email").val('');
                    $("#r_email").focus();
                }else if(data['error']==0){
					alert('Please waiting for administrator accept you.');
					
				}
            },
            error: function(e) {
                //alert(e);
            }
        });
		
		
    }
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2();
		
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%' /* optional */
		});
		
	  });
	   
</script>
  <script src="<?php echo ASSET_PATH;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/raphael/raphael.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/morris.js/morris.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
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
  <script src="<?php echo ASSET_PATH;?>dist/js/adminlte.min.js"></script>
  <script src="<?php echo ASSET_PATH;?>dist/js/pages/dashboard.js"></script>
  <script src="<?php echo ASSET_PATH;?>dist/js/demo.js"></script>
</head>



<body class="hold-transition login-page">
    <div class="register-box">
        <div class="login-logo">
          <a href="<?php echo BASE_PATH;?>"><img src="<?php echo IMAGE_PATH;?>logo.png" style="width: 215px;"></a>
        </div>
       <?php
			$rolearr=explode(",","null,Administrator,Instructor,Parent");
		  ?> 
	  <div class="register-box-body">
          <p class="register-box-msg">Register a new <?php echo $rolearr[$role];?></p>
		  
          <form action="<?php echo BASE_PATH?>/administrator/submituser" method="post">
				<input type="hidden" id="r_role" name="r_role" value="<?php echo $role;?>"/>
			  <div class="form-group has-feedback">
				<input type="text" name="r_username" id="r_username" class="form-control" placeholder="Full name">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			  </div>
			  <div class="form-group has-feedback">
				<input type="email" name="r_email" id="r_email" class="form-control" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<?php //if($role==3){?>
				  <!--select class="form-control select2" name="r_email" id="r_email">
                      <?php //for($i=0;$i<count($parentdata);$i++)echo "<option>{$parentdata[$i]['Email']}</option>";?>
                  </select>
				  <?php //}else{?>
				  <input type="text" class="form-control" name="r_email" id="r_email"-->
				  <?php //}?>
			  </div>
			  <div class="form-group has-feedback">
				<input type="password" name="r_password" id="r_password" class="form-control" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			  </div>
			  <div class="form-group has-feedback">
				<input type="password" name="r_repeatpwd" id="r_repeatpwd" class="form-control" placeholder="Retype password">
				<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
			  </div>
			  
              <div class="row">
				<div class="col-xs-8">
				  <div class="checkbox icheck">
					<label>
					  <input type="checkbox"> I agree to the <a href="#">terms</a>
					</label>
				  </div>
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
				  <button type="button" onclick="formSubmit();" class="btn btn-primary btn-block btn-flat">Register</button>
				</div>
				<!-- /.col -->
			  </div>
			</form>
				
				<!--div class="social-auth-links text-center">
				  <p>- OR -</p>
				  <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
					Facebook</a>
				  <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
					Google+</a>
				</div-->
				
			<a href="#" onclick="location.href=baseurl+'/login';" class="text-center">I already have a membership</a>
		</div>		
          
    </div>


</body>
</html>
