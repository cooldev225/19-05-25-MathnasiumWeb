<script>
  function calcOverhed(c,sn,ev,tv,q){
      var ch;      //    ch=q.charAt(i);
      q=q.replace(/Enrolled/gi,ev).replace(/Total/gi,tv).replace(/Sending/gi,sn);
      q=q.replace(/T/gi,tv).replace(/E/gi,ev).replace(/S/gi,sn);
      $('#'+c+'_overhead').html(Math.round(eval(q)));
  }
</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php if($_user_name['role']>0) echo "<font stype='font-weight:bold;'>".$_user_name['center']."</font>";else echo "All Centers";?>  Control Panel
      </h1>
      <form action="controlpanel" id="refreshfrm" method="post">
		<input type="hidden" name="selcenter" id="selcenter" value=""/>
		<input type="hidden" name="active_tab" id="active_tab" value="1"/>
		</form>
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php if($_user_name['role']<2){?>
			  <li <?php if($active_tab==1)echo " class=\"active\"";?>><a href="#tab_1" data-toggle="tab" aria-expanded="false">SMPT</a></li>
			  <li <?php if($active_tab==2)echo " class=\"active\"";?>><a href="#tab_2" data-toggle="tab" aria-expanded="false">SMS</a></li>
			  <li <?php if($active_tab==3)echo " class=\"active\"";?>><a href="#tab_3" data-toggle="tab" aria-expanded="false">PASSWORD</a></li>
			  <li <?php if($active_tab==5)echo " class=\"active\"";?>><a href="#tab_5" data-toggle="tab" aria-expanded="false">IP ADDRESS</a></li>
			  <?php if($_user_name['role']==0){?>
			  <li <?php if($active_tab==4)echo " class=\"active\"";?>><a href="#tab_4" data-toggle="tab" aria-expanded="false">SUPER</a></li>
			  <?php }}else{?>
			  <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false">PASSWORD</a></li>
			  <?php }?>
			</ul>
            <div class="tab-content"><?php if($_user_name['role']<2){?>
                <div class="tab-pane <?php if($active_tab==1)echo " active";?>" id="tab_1">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
							
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Center</label>
                                    <div class="col-sm-8"><?php //echo $smtpdata[0]['center'];?>
                                        <select  id="smtp_center" onchange="refresh(1)" <?php if($_user_name['role']>0)echo "disabled";?> class="form-control select2" style="width: 100%;">
                                        <?php 
											foreach(explode("###",$centerdata) as $r){
												$f=0;
												if(count($smtpdata))if($smtpdata[0]['center']==$r){
													echo "<option selected=\"selected\">{$r}</option>";
													$f=1;
												}
												if($f==0&&$_user_name['role']==0)echo "<option>{$r}</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">center email</label>

                                    <div class="col-sm-8">
                                        <input type="mail" value="<?php if(count($smtpdata))echo $smtpdata[0]['from_'];else echo "";?>" class="form-control" id="smtp_from" placeholder="center email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Host</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php if(count($smtpdata))echo $smtpdata[0]['smtp_host'];else echo "ssl://smtp.gmail.com";?>" class="form-control" id="smtp_host" placeholder="Host">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Port</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php if(count($smtpdata))echo $smtpdata[0]['smtp_port'];else echo "465";?>" class="form-control" id="smtp_port" placeholder="port">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">username</label>

                                    <div class="col-sm-8">
                                        <input type="mail" value="<?php if(count($smtpdata))echo $smtpdata[0]['smtp_user'];else echo "";?>" class="form-control" id="smtp_user" placeholder="username">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">password</label>

                                    <div class="col-sm-8">
                                        <input type="password" value="<?php if(count($smtpdata))echo $smtpdata[0]['smtp_pass'];else echo "";?>" class="form-control" id="smtp_pass" placeholder="password">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							
							</div>
							<div class="col-sm-1">
							<button type="button" onclick="smtpSubmit(1);" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane <?php if($active_tab==2)echo " active";?>" id="tab_2">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
								<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Center</label>
                                    <div class="col-sm-8">
                                        <select id="sms_center" onchange="refresh(2);" <?php if($_user_name['role']>0)echo "disabled";?> class="form-control select2" style="width: 100%;">
                                        <?php 
                                            foreach(explode("###",$centerdata) as $r){
												$f=0;
												if(count($smtpdata))if($smtpdata[0]['center']==$r){
													echo "<option selected=\"selected\">{$r}</option>";
													$f=1;
												}
												if($f==0&&$_user_name['role']==0)echo "<option>{$r}</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php if(count($smtpdata))echo $smtpdata[0]['sms_number'];else echo "";?>" class="form-control" id="sms_number" placeholder="Phone Number">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">SID</label>

                                    <div class="col-sm-8">
                                        <input type="mail" value="<?php if(count($smtpdata))echo $smtpdata[0]['sms_sid'];else echo "";?>" class="form-control" id="sms_sid" placeholder="sms sid">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">token</label>

                                    <div class="col-sm-8">
                                        <input type="text" value="<?php if(count($smtpdata))echo $smtpdata[0]['sms_token'];else echo "";?>" class="form-control" id="sms_token" placeholder="sms token">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							<input type="hidden" id="sms_flag" value="<?php echo $smtpdata[0]['sms_flag']; ?>"/>
							<button type="button" onclick="smsFlag();" class="btn btn-info pull-right"><?php if($smtpdata[0]['sms_flag']==0)echo "Enable";else echo "Disable"; ?></button>
                            </div>
                            <div class="col-sm-1">
							<button type="button" onclick="smtpSubmit(2);" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane <?php if($active_tab==5)echo " active";?>" id="tab_5">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
								<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Center</label>
                                    <div class="col-sm-8">
                                        <select id="ip_center" onchange="refresh(3);" <?php if($_user_name['role']>0)echo "disabled";?> class="form-control select2" style="width: 100%;">
                                        <?php 
                                            foreach(explode("###",$centerdata) as $r){
												if($selcenter==$r){
													echo "<option selected=\"selected\">{$r}</option>";
												}else if($_user_name['role']==0)echo "<option>{$r}</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">IP Address:</label>
                                    <div class="col-sm-3">
                                        <input type="text" style="width:0px;height:0px;"/>
                                        <input style="margin-top: -20px;" type="text" value="" onkeyup="ipkeyup(event);" class="form-control" id="ip_add" placeholder="255.255.255.255"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="button" id="ipbtn" onclick="ipadd(0);" class="btn btn-info pull-right" value="Add IP Address"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-8">
                                    <table width="100%" class="table table-bordered table">
                                        <thead>
                                            <tr>
                                                <th>IP Adress</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <?php
                                                $color=explode(",","#a9a9a9,#337ab7");
                                                foreach($ipdata as $r){
                                                    $rr= "<tr>";
                                                    $rr.= "<td>{$r['ip']}</td>";
                                                    $rr.= "<td><button onclick=\"ipdel('{$r['ip']}');\" type=\"button\" class=\"btn bg-maroon btn-xs\">delete</button></td>";
                                                    $rr.= "</tr>";
                                                    echo $rr;
                                                }
                                            ?>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							
                            </div>
                            <div class="col-sm-1">
							
                            </div>
							</div>
                        </form>
                    </div>
                </div>
                <?php if($_user_name['role']==0){?>
                <div class="tab-pane <?php if($active_tab==4)echo " active";?>" id="tab_4">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
								
                                <div class="form-group">
                                    <table id="example1" width="90%" class="table table-bordered table">
                                        <thead>
                                            <tr>
                                                <th>Center&nbsp;</th>
                                                <th>UserActive/LA/Instructor/Parent</th>
        										<th>HOMEWORK</th>
                                                <th>Enrolled/Total</th>
        										<th></th>
        										<th>Overhead</th>
                                            </tr>
                                        </thead>
                                            <?php
                                                $color=explode(",","#a9a9a9,#337ab7");
                                                foreach(explode("###",$centerdata) as $r){
                                                    $rr= "<tr>";
                                                    $rr.= "<td>{$r}</td>";
                                                    $r=str_replace(' ','',$r);
                                                    $rr.= "<td>";
                                                        $rr.="<a href='#' onclick=\"activeAction('{$r}',0)\" style=\"color:{$color[$superdata[$r]['active0']]};\">".($superdata[$r]['active0']==0?"enable":"disable")."</a>";
                                                        $rr.="&nbsp;/<a href='#' onclick=\"activeAction('{$r}',1)\" style=\"color:{$color[$superdata[$r]['active1']]};\">".($superdata[$r]['active1']==0?"enable":"disable")."</a>";
                                                        $rr.="&nbsp;/<a href='#' onclick=\"activeAction('{$r}',2)\" style=\"color:{$color[$superdata[$r]['active2']]};\">".($superdata[$r]['active2']==0?"enable":"disable")."</a>";
                                                        $rr.="&nbsp;/<a href='#' onclick=\"activeAction('{$r}',3)\" style=\"color:{$color[$superdata[$r]['active3']]};\">".($superdata[$r]['active3']==0?"enable":"disable")."</a>";
                                                        $rr.="</td>";
                                                    $rr.= "<td><a href='#' onclick=\"activeAction('{$r}',4)\" style=\"color:{$color[$superdata[$r]['sending']]};\">".($superdata[$r]['sending']==0?"enable":"disable")."</a></td>";
                                                    $rr.= "<td>{$superdata[$r]['enrolled1']}/{$superdata[$r]['enrolled']}</td>";
                                                    $rr.= "<td><input onkeyup=\"overheadSave(event,'{$r}',{$superdata[$r]['sending']},{$superdata[$r]['enrolled1']},{$superdata[$r]['enrolled']});\" id=\"{$r}_equation\" value='{$superdata[$r]['overhead']}' style=\"width:150px;\"/></td>";
                                                    $rr.= "<td><div id=\"{$r}_overhead\"><script>calcOverhed('{$r}',{$superdata[$r]['sending']},{$superdata[$r]['enrolled1']},{$superdata[$r]['enrolled']},'{$superdata[$r]['overhead']}');</script></div></td>";
                                                    $rr.= "</tr>";
                                                    echo $rr;
                                                }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
			<?php }}?>
				<div class="tab-pane <?php if($_user_name['role']>1||($_user_name['role']<2&&$active_tab==3)) echo " active";?>" id="tab_3">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
								<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Previous Password</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control" value="<?php echo $logined_user['password'];?>" id="real_prev_pass">
										<input type="hidden" class="form-control" value="<?php echo $logined_user['name'];?>" id="username_">
										<input type="hidden" class="form-control" value="<?php echo $logined_user['email'];?>" id="email_">
										<input type="hidden" class="form-control" value="<?php echo $logined_user['role'];?>" id="role_">
										<input type="hidden" class="form-control" value="<?php echo $logined_user['center'];?>" id="center_">
										<input type="password" class="form-control" id="prev_pass">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="new_pass">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="conf_pass">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							
							</div>
							<div class="col-sm-1">
							<button type="button" onclick="pswdSubmit();" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
				</div>
            </div>
        </div>
        
    </section>
</div>

<script>
function ipkeyup(e){
    if(e.keyCode==13&&$('#ip_add').val()!=""){
        //$("#ipbtn").focus();
        //e.keyCode=9;
        ipadd(0);
        
    }
}    
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
	  tags: true
	});
  });
  function smsFlag(){
      $('#sms_flag').val(1-$('#sms_flag').val());
      smtpSubmit(2);
      $("#active_tab").val(2);
      refresh(2);
  }
  function smtpSubmit(f){var center=$("#smtp_center").val();if(f==2)center=$("#sms_center").val();
	  if($("#smtp_user")==""){alert("Please fill a smtp user field.");return;}
	  if($("#smtp_pass")==""){alert("Please fill a smtp password field.");return;}
	  var res = $.ajax({
		url: "smtpsave",
		type: 'post',
		data: {
			flag:f,
			host:$("#smtp_host").val(),
			port:$("#smtp_port").val(),
			user:$("#smtp_user").val(),
			frome:$("#smtp_from").val(),
			pass:$("#smtp_pass").val(),
			center:center,
			number:$("#sms_number").val(),
			sid:$("#sms_sid").val(),
			token:$("#sms_token").val(),
			sflag:$("#sms_flag").val()
		},
		dataType: "json",
		success: function( data ) {
			alert("success!");
		},
		error: function(e) {
			//alert(e);
		}
	});
	
	
  }
  function refresh(f){
	  if(f==1){
		  $('#selcenter').val($('#smtp_center').val());
		  $("#active_tab").val(1);
	  }else if(f==2){
		  $('#selcenter').val($('#sms_center').val());
		  $("#active_tab").val(2);
	  }else if(f==3){
	     $('#selcenter').val($('#ip_center').val());
	     $("#active_tab").val(5);
	  }else if(f==4){
	     $('#selcenter').val($('#smtp_center').val());
	     $("#active_tab").val(4);
	  }
	  $('#refreshfrm').submit();
  }
  function pswdSubmit(){
	  if($('#conf_pass').val()!=$('#new_pass').val()){
		  alert("Please type data correctly.");
		  $('#new_pass').val('');
		  $('#conf_pass').val('');
		  $('#new_pass').focus();
		  return;
	  }
	  var res = $.ajax({
		url: "../login/changepass",
		type: 'post',
		data: {
			name:$('#username_').val(),
			email:$("#email_").val(),
			newpass:$("#new_pass").val(),
			prevpass:$("#prev_pass").val(),
			pass:$("#real_prev_pass").val(),
			role:$("#role_").val(),
			center:$("#center_").val()
		},
		dataType: "json",
		success: function( data ) {
			if(data==2){
				alert("Please type previous password correctly.");
				$("#prev_pass").val('');
				$("#prev_pass").focus();
			}else if(data==3){
				alert("Please type new password again. The Password is duplicated");
				$("#prev_pass").val('');
				$("#prev_pass").focus();
			}else alert("success!");
		},
		error: function(e) {
			//alert(e);
		}
	});
  }
  function activeAction(c,f){
    var res = $.ajax({
		url: "activesave",
		type: 'post',
		data: {
			center:c,
			flag:f
		},
		dataType: "json",
		success: function( data ) {
			refresh(4);
		},
		error: function(e) {
			refresh(4);
		}
	});
  }
  
  function ipadd(f){
     var res = $.ajax({
		url: "setipaddress",
		type: 'post',
		data: {
			center:$('#ip_center').val(),
			ip:$('#ip_add').val(),
			flag:f
		},
		dataType: "json",
		success: function( data ) {
			refresh(3);
		},
		error: function(e) {
			refresh(3);
		}
	}); 
  }
  
  function ipdel(ip){
     var res = $.ajax({
		url: "setipaddress",
		type: 'post',
		data: {
			center:$('#ip_center').val(),
			ip:ip,
			flag:1
		},
		dataType: "json",
		success: function( data ) {
			refresh(3);
		},
		error: function(e) {
			refresh(3);
		}
	}); 
  }
  
  
  function overheadSave(e,c,sn,ev,tv){
      if(e.keyCode!=13)return;
      var v=$('#'+c+'_equation').val();
      var res = $.ajax({
		url: "activesave",
		type: 'post',
		data: {
			center:c,
			flag:5,
			value:v
		},
		dataType: "json",
		success: function( data ) {
			
		},
		error: function(e) {
			
		}
	});
    calcOverhed(c,sn,ev,tv,v);
  }
</script>