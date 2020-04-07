<script>
    var parentdata=new Array();
    var i=0;
<?php
    foreach($parentdata as $row){?>
        parentdata[i]=new Array();
        parentdata[i][0]="<?php echo $row['Email'];?>";
        parentdata[i][1]="<?php echo $row['First_Name'];?>";
        i++;
<?php }?>
    function parentEmailSelectAction(){
        var name="";
        for(i=0;i<parentdata.length;i++){
            if(parentdata[i][0]==$("#email_2").val()){
                $("#name_2").val(parentdata[i][1]);
                return;
            }
        }
    }
    function formSubmit(role){
        if($("#name_"+role).val()==""){
            alert("Please fill \"name\" field.");
            $("#name_"+role).focus();
            return;
        }
        if($("#email_"+role).val()==""){
            alert("Please fill \"email\" field.");
            $("#email_"+role).focus();
            return;
        }
        if($("#pswd_"+role).val()==""){
            alert("Please fill \"pswd\" field.");
            $("#pswd_"+role).focus();
            return;
        }
        if($("#conf_"+role).val()==""){
            alert("Please fill \"conf\" field.");
            $("#conf_"+role).focus();
            return;
        }
        if($("#pswd_"+role).val()!=$("#conf_"+role).val()){
            alert("Please fill \"password\" field.");
            $("#pswd_"+role).val('');
            $("#conf_"+role).val('');
            $("#pswd_"+role).focus();
            return;
        }
		if($("#center_"+role).val()==""){
            alert("Please fill \"location\" field.");
            $("#center_"+role).focus();
            return;
        }
        res = $.ajax({
            url: "../administrator/submituser",
            type: 'post',
            data: {
                r_role:(role%3)+1,
                r_username:$("#name_"+role).val(),
                r_email:$("#email_"+role).val(),
                r_password:$("#pswd_"+role).val(),
                r_repeatpwd:$("#conf_"+role).val(),
				center:$("#center_"+role).val()
            },
            dataType: "json",
            success: function( data ) {
                alert(data['msg']);
                if(data['error']==2){
                    $("#name_"+role).val('');
                    $("#name_"+role).focus();
                }
                if(data['error']==3){
                    $("#email_"+role).val('');
                    $("#email_"+role).focus();
                }
                //var res=JSON.parse(data);
                //alert();
            },
            error: function(e) {
                //alert(e);
            }
        });
    }
</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php if($_user_name['role']>0) echo "<font stype='font-weight:bold;'>".$_user_name['center']."</font>";else echo "All Centers";?> Add User

      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Instructors</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Parent</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Administrator</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-8">
                                        <!--select id="email_1" onchange="instructEmailSelectAction();" class="form-control select2" style="width: 100%;">
                                        <?php 
                                            /*$i=0;
                                            foreach($instructordata as $row){
                                                if(!$i){
                                                    echo "<option selected=\"selected\">{$row['Email_Address']}</option>";
                                                    $i=1;
                                                }else{
                                                    echo "<option>{$row['Email_Address']}</option>";
                                                }
                                            }*/
                                        ?>
                                        </select-->
										<input type="email" class="form-control" id="email_1" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name_1" placeholder="Name">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="pswd_1" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="conf_1" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							<input value="<?php if($_user_name['role'])echo $_user_name['center'];?>" type="<?php if($_user_name['role']==0)echo "text";else echo "hidden";?>" class="form-control" id="center_1" placeholder="location">
							</div>
							<div class="col-sm-1">
							<button type="button" onclick="formSubmit(1);" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-8">
                                        <select id="email_2" onchange="parentEmailSelectAction();" class="form-control select2" style="width: 100%;">
                                        <?php 
                                            $i=0;
                                            foreach($parentdata as $row){
                                                if(!$i){
                                                    echo "<option selected=\"selected\">{$row['Email']}</option>";
                                                    $i=1;
                                                }else{
                                                    echo "<option>{$row['Email']}</option>";
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" disabled class="form-control" id="name_2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="pswd_2" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="conf_2" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							<input value="<?php if($_user_name['role'])echo $_user_name['center'];?>" type="<?php if($_user_name['role']==0)echo "text";else echo "hidden";?>" class="form-control" id="center_2" placeholder="location">
							</div>
							<div class="col-sm-1">
							<button type="button" onclick="formSubmit(2);" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name_3" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email_3" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="pswd_3" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="conf_3" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							<input value="<?php if($_user_name['role'])echo $_user_name['center'];?>" type="<?php if($_user_name['role']==0)echo "text";else echo "hidden";?>" class="form-control" id="center_3" placeholder="location">
							</div>
							<div class="col-sm-1">
							<button type="button" onclick="formSubmit(3);" class="btn btn-info pull-right">Submit</button>
                            </div>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</div>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
    //if(instructdata.length>0)$("#name_1").val(instructdata[0][1]);
    if(parentdata.length>0)$("#name_2").val(parentdata[0][1]);
  });
</script>