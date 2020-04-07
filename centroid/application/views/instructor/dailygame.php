<script>
    var init_radio=new Array();i=1;
<?php 
    for($i=1;$i<6;$i++){?>
    init_radio[i]="<?php echo $sessiondata['quiz'.$i.'x'];?>";
    i++;
<?php }?>

</script>
<style>.box {margin-bottom:0px;}</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo "<font stype='font-weight:bold;'>".$_user_location."</font>";?> Daily Game Plan
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <form class="form-horizontal" method="post" action="index" id="refresh_frm">
                <input type="hidden" name="session_prev_id" id="session_prev_id" value="<?php echo $sessionprevid;?>"/>
				<input type="hidden" name="fixed_studentid" id="fixed_studentid"/>
				<input type="hidden" name="fixed_datex" id="fixed_datex"/>
                <input type="hidden" name="session_id" id="session_id" value="<?php echo $sessionid;?>"/>
                <input type="hidden" name="session_next_id" id="session_next_id" value="<?php echo $sessionnextid;?>"/>
                
            </form>
            <div class="modal modal-primary fade" id="modal-success">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">TODAY'S SESSION REPORT</h4>
                        <input type="hidden" id="instructor_name" value="<?php if(isset($sessiondata['instructorx']))echo $sessiondata['instructorx']?>"/>
                        <input type="hidden" id="reporting_name"/>
                        <input type="hidden" id="reporting_mail"/>
                        <input type="hidden" id="reporting_pnum"/>
						
						<input type="hidden" id="internal_email" value="<?php echo $internal_email;?>"/>
                        <input type="hidden" id="msg_session_body" value="<?php for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==4){echo $templatedata[$i]['textx'];break;}?>"/>
                        <input type="hidden" id="sms_session_body" value="<?php for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==1){echo $templatedata[$i]['textx'];break;}?>"/>
						<input type="hidden" id="msg_homework_body" value="<?php for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==5){echo $templatedata[$i]['textx'];break;}?>"/>
                        <input type="hidden" id="sms_homework_body" value="<?php for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==2){echo $templatedata[$i]['textx'];break;}?>"/>
						<input type="hidden" id="msg_internal_body" value="<?php for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==6){echo $templatedata[$i]['textx'];break;}?>"/>
                    </div>
                    <div class="modal-body" id="session_message_body">
                        <p>Please save courrent data.&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
                        <div id="session_sending_btn"><button type="button" name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(1);">SEND</button></div>
                    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal modal-info fade" id="modal-center">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">INTERAL MAIL</h4>
						<?php
						$html="<select onchange=\"\" class=\"form-control select2\" style=\"width:400px;\" name=\"dropimtemp\" id=\"dropimtemp\">";
							foreach($templatedata as $r){
								if($r['typex']==7)$html.="<option>{$r['textx']}</option>";
							}
						$html.="</select>";
						$html.="<button type=\"button\" onclick=\"dropimtempadd();\" class=\"btn btn-outline pull-left\">add</button>";
						$html.="<button type=\"button\" onclick=\"dropimtempdelete();\" class=\"btn btn-outline pull-left\">delete</button>";
						echo $html;
					?>
                    </div>
                    <div class="modal-body" id="center_message_body">
                        <p>Please save courrent data.&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
                        <div id="center_sending_btn"><button type="button" name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(3);">SEND</button></div>
                    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal modal-success fade" id="modal-homework">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">HOMEWORK</h4>
						
                    </div>
					
                    <div class="modal-body" id="homework_message_body">
                        <p>Please save courrent data.&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
                        <div id="homework_sending_btn"><button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(2);">SEND</button></div>
                    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <form class="form-horizontal" method="post" id="save_frm">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" onclick="$('#session_id').val($('#session_prev_id').val());$('#refresh_frm').submit();" class="btn btn-info pull-left" <?php if($sessionprevid<0)echo "disabled";?>><i class="fa fa-angle-double-left"></i> PREVIOUS </button>
                        </div>
                        <div class="col-sm-4">
                            <p class="text-aqua" style="width:100px; margin:auto;">SESSON <?php echo $currentsessionnum;//echo $sessionnumber;?></p>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" onclick="$('#session_id').val($('#session_next_id').val());$('#refresh_frm').submit();" class="btn btn-info pull-right" <?php if($sessionid<0&&$sessionnextid<0)echo "disabled";?>> NEXT <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Part1</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button-->
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Student Name<font style="color:red;">*</font></label>
                            <div class="col-sm-2">
                                <select id="part1_stdname" onchange="stdChangeAction();" class="form-control select2" style="width: 100%;">
                                <?php 
									$fff=0;$tt=0;
                                    foreach($studentdata as $row){
                                        if($fff==0&&$sessiondata['studentidx']==""){
											echo "<option selected=\"selected\"></option>";
											$fff=1;//$tt++;
										}
										
											if($sessiondata['studentidx']==$row['s_Id']){
												echo "<option selected=\"selected\">{$row['First_Name']}-{$row['Last_Name']}-{$row['s_Id']}";
												echo "</option>";//$tt++;
											}else{
												echo "<option>{$row['First_Name']}-{$row['Last_Name']}-{$row['s_Id']}";
												echo "</option>";$tt++;
											}
                                    }
                                ?>
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Date<font style="color:red;">*</font></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control pull-right" id="part1_date" value="<?php echo $sessiondata['datex'];?>">
							</div>
							<div class="col-sm-1">
                            	<button type="button" onclick="dateChangeAction();" class="btn btn-info pull-left" <?php if(!isset($sessiondata['studentidx']))echo "disabled";else if($sessiondata['studentidx']=='')echo "disabled";?>>New</button>
							</div>
                            <label class="col-sm-1 control-label">Time<font style="color:red;">*</font></label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control timepicker" style="    min-width: 88px;" id="part1_time" value="<?php echo $sessiondata['timex'];?>"><?php /*date_default_timezone_set('Africa/Lagos'); echo date("H:i a");*/?>
                            </div>
                        </div>
                        <div class="form-group" id="quiz1">
                            <label class="col-sm-4 control-label">DID YOU CHECK-IN / SCAN IN BAR CODE?<font style="color:red;">*</font></label>
                            <div class="col-sm-2" style="width: 140px;">
                                <label><?php //echo "<".$sessiondata['quiz1x'].",".$sessiondata['quiz2x'].",".$sessiondata['quiz3x'].",".$sessiondata['quiz4x'].",".$sessiondata['quiz5x'].">";?>
                                    YES<input type="radio" id="quiz1x1" name="r3" class="flat-red" <?php if($sessiondata['quiz1x']=="1")echo "value=\"on\" checked";else "value=\"off\"";?>>
                                </label>
                                <label>
                                    NO<input type="radio" id="quiz1x2" name="r3" class="flat-red" <?php if($sessiondata['quiz1x']=="0")echo "value=\"on\" checked";else "value=\"off\"";?>>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="quiz2">
                            <label class="col-sm-4 control-label">DO YOU NEED HELP FOR ANY UPCOMING TEST/QUIZ IN SCHOOL?<font style="color:red;">*</font></label>
                            <div class="col-sm-2" style="width: 140px;">
                                <label>
                                    YES<input type="radio" id="quiz2x1" name="r31" class="flat-red" <?php if($sessiondata['quiz2x']=="1")echo "value=\"on\" checked";else "value=\"off\"";?>>
                                </label>
                                <label>
                                    NO<input type="radio" id="quiz2x2" name="r31" class="flat-red" <?php if($sessiondata['quiz2x']=="0")echo "value=\"on\" checked";else "value=\"off\"";?>>
                                </label>
                            </div>
                            <label id="quiz2lab" class="col-sm-3 control-label" style=" <?php if(!$sessiondata['quiz2x'])echo "opacity:0.1;";?>">SCHOOL TEST/QUIZ TOPIC NAMES<font style="color:red;">*</font></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="quiz2txt" placeholder="TOPIC NAMES..." value="<?php echo $sessiondata['quiz1xx'];?>" style=" <?php if(!$sessiondata['quiz2x'])echo "opacity:0.1;";?>">
                            </div>
                        </div>
                        <div class="form-group" id="quiz3">
                            <label class="col-sm-4 control-label">DO YOU NEED HELP WITH ANY CURRENT SCHOOL TOPIC?<font style="color:red;">*</font></label>
                            <div class="col-sm-2" style="width: 140px;">
                                <label>
                                    YES<input type="radio" id="quiz3x1" name="r32" class="flat-red" <?php if($sessiondata['quiz3x']=="1")echo "checked";?>>
                                </label>
                                <label>
                                    NO<input type="radio" id="quiz3x2" name="r32" class="flat-red" <?php if($sessiondata['quiz3x']=="0")echo "checked";?>>
                                </label>
                            </div>
                            <label id="quiz3lab" class="col-sm-3 control-label" style=" <?php if(!$sessiondata['quiz3x'])echo "opacity:0.1;";?>">CURRENT SCHOOL TOPIC NAMES<font style="color:red;">*</font></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="quiz3txt" placeholder="TOPIC NAMES..."  value="<?php echo $sessiondata['quiz2xx'];?>" style=" <?php if(!$sessiondata['quiz3x'])echo "opacity:0.1;";?>">
                            </div>
                        </div>
                        <div class="form-group" id="quiz4">
                            <label class="col-sm-4 control-label">DID YOU BRING ANY HOMEWORK TO GET EXTRA HELP?<font style="color:red;">*</font></label>
                            <div class="col-sm-2" style="width: 140px;">
                                <label>
                                    YES<input type="radio" id="quiz4x1" name="r33" class="flat-red" <?php if($sessiondata['quiz4x']=="1")echo "checked";?>>
                                </label>
                                <label>
                                    NO<input type="radio" id="quiz4x2" name="r33" class="flat-red" <?php if($sessiondata['quiz4x']=="0")echo "checked";?>>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="quiz4lab1" class="col-sm-3 control-label" style=" <?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>">HOMEWORK START TIME<font style="color:red;">*</font></label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control timepicker" id="part1_starttime"  style=" min-width: 88px; <?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>"  value="<?php echo $sessiondata['quiz3xx'];?>"/>
                            </div>
                            <label id="quiz4lab2" class="col-sm-2 control-label" style="width: 140px;" style=" <?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>">END TIME<font style="color:red;">*</font></label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control timepicker" id="part1_endtime" style=" min-width: 88px;<?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>"  value="<?php echo $sessiondata['quiz4xx'];?>" />
                            </div>
                            <label id="quiz4lab3" class="col-sm-2 control-label" style=" <?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>">HOMEWORK TOPIC NAME<font style="color:red;">*</font></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="quiz4txt" style=" <?php if(!$sessiondata['quiz4x'])echo "opacity:0.1;";?>"  value="<?php echo $sessiondata['quiz5xx'];?>"  placeholder="TOPIC NAMES...">  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CHECK-IN INSTRUCTOR NAME<font style="color:red;">*</font></label>
                            <div class="col-sm-1" style="width: 140px;">
                                <input type="text" class="form-control" id="part1_sign" placeholder="SIGN IN"  value="<?php echo $sessiondata['sign1x'];?>" >  
                            </div>
							<div class="col-sm-1" style="width: 140px;">
								<button type="button" class="btn btn-block btn-info" onclick="save_data(1);" >SAVE</button>
							</div>
						</div>
                    </div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Part2</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button-->
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php for($i=0;$i<6;$i++){
                            $topic_arr=explode("@",$sessiondata['topic'.($i+1).'x']);    
                            if(count($topic_arr)<3)$topic_arr=array("","","");
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">WORKING ON TOPIC NUMBER(<?php echo $i+1;?>)<?php if(!$i)echo "<font style=\"color:red;\">*</font>";?></label>
                            <div class="col-sm-2">
                                <select id="part2_topic<?php echo $i+1;?>" class="form-control" style="width: 100%;">
                                    <?php 
                                        foreach($topickinddata as $row){
                                            if($topic_arr[0]=="")$topic_arr[0]=$row['kindx'];
                                            if($topic_arr[0]==$row['kindx']){
                                                echo "<option selected=\"selected\">{$row['kindx']}</option>";
                                            }else{
                                                echo "<option>{$row['kindx']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-1" style="width: 140px;">
                                <input type="text" onblur="part2_digit_blur_Action('<?php echo $i+1;?>')" class="form-control" id="part2_digit<?php echo $i+1;?>" value="<?php echo $topic_arr[1];?>" >   <!--data-inputmask="'mask': ['9999']" data-mask--> 
                            </div>
                            <label class="col-sm-2 control-label">COMPLETED PAGENUMBERS #</label>
                            <div class="col-sm-3">
                            <input type="text" onblur="part2_page_blur_Action('<?php echo $i+1;?>')" class="form-control" id="part2_page<?php echo $i+1;?>" value="<?php echo $topic_arr[2];?>">    
                            </div>
                        </div>
                        <?php }?>
                        <?php for($i=0;$i<6;$i++){?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php if(!$i)echo "COMMENTS BY INSTRUCTOR<font style=\"color:red;\">*</font>";?></label>
                            <div class="col-sm-8">
                                <select onchange="save_data(1);" id="comment<?php echo $i+1;?>" class="form-control select2" style="width: 100%;">
                                <?php 
                                    echo "<option></option>";
                                    foreach($templatedata as $row)if($row['typex']==0){
                                        //if($sessiondata['comment'.($i+1).'x']=="")$sessiondata['comment'.($i+1).'x']=$row['textx'];
                                        if($sessiondata['comment'.($i+1).'x']==$row['textx']){
                                            echo "<option selected=\"selected\">{$row['textx']}</option>";
                                        }else{
                                            echo "<option>{$row['textx']}</option>";
                                        }
                                    }
                                ?>
								</select>
							</div>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Part3</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button-->
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <div class="form-group">
                            <label class="col-sm-2 control-label">CHECK-OUT TIME<font style="color:red;">*</font></label>
                            <div class="col-sm-1">
								<input type="text" class="form-control timepicker" style="min-width: 88px;" id="part3_checktime" value="<?php echo $sessiondata['sign2x'];?>"/>
                            </div>
                            <label class="col-sm-7 control-label">REMINDER GIVEN TO STUDENT TO WAIT IN LOBBY & NOT TO GO OUTSIDE TILL YOU SEE YOUR GUARDIAN?<font style="color:red;">*</font></label>
                            <div class="col-sm-2">
                                <label>
                                    YES<input type="radio" id="quiz5x1" name="r34" class="flat-red" <?php if($sessiondata['quiz5x']=="1")echo "value=\"on\" checked";//else "value=\"off\"";?>>
                                </label>
                                <label>
                                    NO<input type="radio" id="quiz5x2" name="r34" class="flat-red" <?php if($sessiondata['quiz5x']=="0")echo "value=\"on\" checked";//else "value=\"off\"";?>>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CHECK-OUT INSTRUCTOR NAME<font style="color:red;">*</font></label>
                            <div class="col-sm-2">
                            <input type="text" class="form-control timepicker" id="part3_sign"  placeholder="SIGN OUT" value="<?php echo $sessiondata['sign3x'];?>"/>
                            </div>
							<div class="col-sm-1" style="width: 140px;">
								<button type="button" class="btn btn-block btn-info" onclick="save_data(2);" >SAVE</button>
							</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <button type="button" onclick="sendSessionReportsAction();" data-toggle="modal" class="btn btn-block btn-primary " data-target="#modal-success">SEND TODAY'S SESSION REPORT</button>
                            </div>
                            <div class="col-sm-3">
                                <?php if($_user_sendable){?><button type="button" class="btn btn-block btn-success " onclick="sendHomeworkAction();" data-toggle="modal" data-target="#modal-homework">SEND HOMEWORK TO STUDENT</button><?php }?>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-block btn-info " onclick="sendCenterAction();" data-toggle="modal" data-target="#modal-center">SEND INTERNAL EMAIL TO CENTER</button>
                            </div>
							
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" onclick="$('#session_id').val($('#session_prev_id').val());$('#refresh_frm').submit();" class="btn btn-info pull-left" <?php if($sessionprevid<0)echo "disabled";?>><i class="fa fa-angle-double-left"></i> PREVIOUS  </button>
                        </div>
                        <div class="col-sm-4">
                            <p class="text-aqua" style="width:100px; margin:auto;">SESSON <?php echo $currentsessionnum;?></p>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" onclick="$('#session_id').val($('#session_next_id').val());$('#refresh_frm').submit();" class="btn btn-info pull-right" <?php if($sessionid<0&&$sessionnextid<0)echo "disabled";?>> NEXT <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
    </section>
</div>
<div id="ghostskin" style="    
    position: absolute;
    width: 449px;
    height: 60px;
    left: 924px;
    top: 313px;
    z-index: -10;
    background-color: white;
    opacity: 0.8;"></div>
<script src="<?php echo ASSET_PATH;?>pages/constants.js"></script>
<!--<script src="<?php echo ASSET_PATH;?>pages/instructor/dailygame.js"></script>-->
<script>
    
    function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
    //Date picker
    $('#part1_date').datepicker({
      autoclose: true,
      timePicker: true,
      format: 'yyyy-mm-dd' 
    });//.datepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    /*
    $('#part1_time').timepicker();
    $('#part1_starttime').timepicker();
    $('#part1_endtime').timepicker();
    $('#part3_checktime').timepicker({
      autoclose: true,
      format: 'h:mm A' 
    });
    */
    $('#part1_time').on('click',function(){
        if($('#part1_time').val()==''){
            $('#part1_time').val(formatAMPM(new Date()));
        }
    });
    $('#part3_checktime').on('click',function(){
        if($('#part3_checktime').val()==''){
            $('#part3_checktime').val(formatAMPM(new Date()));
        }
    });
    $('#part1_starttime').on('click',function(){
        if($('#part1_starttime').val()==''){
            $('#part1_starttime').val(formatAMPM(new Date()));
        }
    });
    $('#part1_endtime').on('click',function(){
        if($('#part1_endtime').val()==''){
            $('#part1_endtime').val(formatAMPM(new Date()));
        }
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    $('[data-mask]').inputmask();

    $('#quiz1x1').on('ifChecked', function(event){
        $('#quiz1x1').val('on');
        $('#quiz1x2').val('off');
    });
    $('#quiz1x2').on('ifChecked', function(event){
        $('#quiz1x1').val('off');
        $('#quiz1x2').val('on');
    });
	$('#quiz2x1').on('ifChecked', function(event){
        $("#quiz2lab").css("opacity","1");
        $("#quiz2txt").css("opacity","1");
        $('#quiz2x1').val('on');
        $('#quiz2x2').val('off');
    });
    $('#quiz2x2').on('ifChecked', function(event){
        $("#quiz2lab").css("opacity","0.1");
        $("#quiz2txt").css("opacity","0.1");
        $('#quiz2x1').val('off');
        $('#quiz2x2').val('on');
    });
    $('#quiz3x1').on('ifChecked', function(event){
        $("#quiz3lab").css("opacity","1");
        $("#quiz3txt").css("opacity","1");
        $('#quiz3x1').val('on');
        $('#quiz3x2').val('off');
    });
    $('#quiz3x2').on('ifChecked', function(event){
        $("#quiz3lab").css("opacity","0.1");
        $("#quiz3txt").css("opacity","0.1");
        $('#quiz3x1').val('off');
        $('#quiz3x2').val('on');
    });
    $('#quiz4x1').on('ifChecked', function(event){
        $("#quiz4lab1").css("opacity","1");
        $("#part1_starttime").css("opacity","1");
        $("#quiz4lab2").css("opacity","1");
        $("#part1_endtime").css("opacity","1");
        $("#quiz4lab3").css("opacity","1");
        $("#quiz4txt").css("opacity","1");
        $('#quiz4x1').val('on');
        $('#quiz4x2').val('off');
    });
    $('#quiz4x2').on('ifChecked', function(event){
        $("#quiz4lab1").css("opacity","0.1");
        $("#part1_starttime").css("opacity","0.1");
        $("#quiz4lab2").css("opacity","0.1");
        $("#part1_endtime").css("opacity","0.1");
        $("#quiz4lab3").css("opacity","0.1");
        $("#quiz4txt").css("opacity","0.1");
        $('#quiz4x1').val('off');
        $('#quiz4x2').val('on');
    });
	$('#quiz5x1').on('ifChecked', function(event){
        $('#quiz5x1').val('on');
        $('#quiz5x2').val('off');
    });
    $('#quiz5x2').on('ifChecked', function(event){
        $('#quiz5x1').val('off');
        $('#quiz5x2').val('on');
    });
    for(var i=1;i<6;i++){
        if(init_radio[i]=="1"){
            $("#quiz"+i+"x1").val('on');
			$("#quiz"+i+"x2").val('off');
        }else if(init_radio[i]=="0"){
            $("#quiz"+i+"x1").val('off');
			$("#quiz"+i+"x2").val('on');
        }	
    }
	
    for(var i=1;i<6;i++){
		$("#comment"+i).select2({
		  tags: true
		});
	}
	
	$("#dropimtemp").select2({
		  tags: true
		});
	
    /*$("#part1_stdname").on('change',function(){
        if(isValiable(1))$("#part1_stdname").focus();
    });
    
    $("#part1_time").on('change',function(){
        //if(isValiable(1))$("#quiz2x1").focus();
    });
    $("#quiz2txt").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(1))$("#quiz3txt").focus();
    });   
    $("#quiz3txt").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(1))$("#part1_starttime").focus();
    });
    $("#part1_starttime").on('click',function(e){
        //if(isValiable(1))$("#quiz4txt").focus();
    });
    $("#part1_endtime").on('click',function(e){
        //if(isValiable(1))$("#quiz4txt").focus();
    });
    $("#quiz4txt").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(1))$("#part1_sign").focus();
    });
    $("#part1_sign").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(1))e.keyCode=9;
    });
    $("#part3_checktime").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(2))$("#part3_sign").focus();
    });
    $("#part3_sign").on('keyup',function(e){
        if(e.keyCode==13)if(isValiable(2))e.keyCode=9;
    });*/
  });
  
    var current_focus_obj=0;
	function part2_page_blur_Action(i){
		//alert(i+","+current_focus_obj);
		if(current_focus_obj!=i){
			if($("#part2_digit"+i).val()!='')save_data(1);
			current_focus_obj=i;
		}
	}
	var current_digit_focus_obj=0;
	function part2_digit_blur_Action(i){
		if(current_digit_focus_obj!=i){
			if($("#part2_page"+i).val()!='')save_data(1);
			current_digit_focus_obj=i;
		}
	}

  function isValiable(f){
        if($("#part1_stdname").val()==null||$("#part1_stdname").val()==""){
            $("#part1_stdname").focus();
			alert("Please select a student field.");
            return false;
        }
        if($("#part1_date").val()==''){
            $("#part1_date").focus();
			alert("Please fill a date field.");
            return false;
        }
        if($("#part1_time").val()==''){
            $("#part1_time").focus();
			alert("Please fill a time field.");
            return false;
        }
        if($("#quiz1x1").val()=="on"&&$("#quiz1x2").val()=="on"){
            $("#quiz1x1").focus();
			alert(_QUIZ[1]);
            return false;
        }
		if($("#quiz1x1").val()=="off"){
            $("#quiz1x1").focus();
			alert("MUST SELECT YES TO SAVE IN BAR CODE FIELD.");
            return false;
        }
		if($("#quiz2x1").val()=="on"&&$('#quiz2x2').val()=="on"){
            $("#quiz2x1").focus();
			alert(_QUIZ[2]);
            return false;
        }
		if($("#quiz2x2").val()=="off"&&$("#quiz2txt").val()==""){
            $("#quiz2txt").focus();
			alert("PLEASE FILL A SCHOOL TEST/QUIZ TOPIC NAMES FIELD.");
            return false;
        }
		if($("#quiz3x1").val()=="on"&&$('#quiz3x2').val()=="on"){
            $("#quiz3x1").focus();
			alert(quiz[3]);
            return false;
        }
		if($("#quiz3x2").val()=="off"&&$("#quiz3txt").val()==""){
            $("#quiz3txt").focus();
			alert("PLEASE FILL A CURRENT SCHOOL TOPIC NAMES FIELD.");
            return false;
        }
		if($("#quiz4x1").val()=="on"&&$('#quiz4x2').val()=="on"){
            $("#quiz4x1").focus();
			alert(_QUIZ[4]);
            return false;
        }
		if($("#quiz4x2").val()=="off"&&$("#part1_starttime").val()==""){
            $("#part1_starttime").focus();
			alert("PLEASE FILL A HOMEWORK START TIME FIELD.");
            return false;
        }
		if($("#quiz4x2").val()=="off"&&$("#part1_endtime").val()==""){
            $("#part1_endtime").focus();
			alert("PLEASE FILL A HOMEWORK END TIME FIELD.");
            return false;
        }
		if($("#quiz4x2").val()=="off"&&$("#quiz4txt").val()==""){
            $("#quiz3txt").focus();
			alert("PLEASE FILL A HOMEWORK TOPIC NAME FIELD.");
            return false;
        }
        if($("#part1_sign").val()==""){
            $("#part1_sign").focus();
			alert("PLEASE CHECK-IN INSTRUCTOR INITIAL FIELD.");
            return false;
        }
        if(f==1)return true;
        var i=1;
        for(;i<7;i++){
            if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")break;
        }
        if(i==7){
            $("#part2_digit1").focus();
			alert("PLEASE FILL WORKING ON TOPIC FIELDS.");
            return false;
        }
        for(i=1;i<7;i++){
            if($("#comment"+i).val()!="")break;
        }
        if(i==7){
            $("#commet1").focus();
			alert("PLEASE FILL COMMENT FIELDS.");
            return false;
        }
        if($("#part3_checktime").val()==""){
            $("#part3_checktime").focus();
			alert("PLEASE FILL CHECK-OUT TIME FIELD.");
            return;
        }
		if($("#quiz5x1").val()=="on"&&$('#quiz5x2').val()=="on"){
            $("#quiz5x1").focus();
			alert(_QUIZ[5]);
            return false;
        }
		if($('#quiz5x1').val()=='off'){
			alert('SAVE not possible because Reminder not given to Student to select YES');
			return;
		}
		if($("#part3_sign").val()==""){
            $("#part3_sign").focus();
			alert("PLEASE CHECK-OUT INSTRUCTOR INITIAL FIELD.");
            return;
        }
        return true;
    }
  function goStudentAction(id,st,dt){
	  //alert(st+','+dt);
	  //$("#fixed_studentid").val(strname[2]);
	  $("#session_id").val(id);
	  $("#refresh_frm").submit();
  }
  function save_data(f){
        if(!isValiable(f)){
            //alert("Please fill all fields.");
            return;
        }//alert($('#quiz5x1').val());
		
        var topic=new Array();
        for(var i=1;i<7;i++){
            if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
                topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
            else 
                topic[i]="";
        }
        if($('#quiz2x1').val()=="off")$('#quiz2txt').val('');
        if($('#quiz3x1').val()=="off")$('#quiz3txt').val('');
        if($('#quiz4x1').val()=="off")$('#part1_starttime').val('');
        if($('#quiz4x1').val()=="off")$('#part1_endtime').val('');
        if($('#quiz4x1').val()=="off")$('#quiz4txt').val('');
        var stdarr=$("#part1_stdname").val().split("-");
		if(stdarr.length<3){
			alert("Please fill the student name field.");
			$("#part1_stdname").focus();
			return;
        }
		
		res = $.ajax({
            url: "../instructor/submitsession",
            type: 'post',
            data: {
                studentx:stdarr[0],
                studentidx:stdarr[2],
                datex:$("#part1_date").val(),
                timex:$("#part1_time").val(),
                quiz1x:$('#quiz1x1').val()=="on"&&$('#quiz1x2').val()=="on"?"":$('#quiz1x1').val()=="off"?0:1,
                quiz2x:$('#quiz2x1').val()=="on"&&$('#quiz2x2').val()=="on"?"":$('#quiz2x1').val()=="off"?0:1,
                quiz3x:$('#quiz3x1').val()=="on"&&$('#quiz3x2').val()=="on"?"":$('#quiz3x1').val()=="off"?0:1,
                quiz4x:$('#quiz4x1').val()=="on"&&$('#quiz4x2').val()=="on"?"":$('#quiz4x1').val()=="off"?0:1,
                quiz5x:$('#quiz5x1').val()=="on"&&$('#quiz5x2').val()=="on"?"":$('#quiz5x1').val()=="off"?0:1,
                quiz1xx:$('#quiz2txt').val(),
                quiz2xx:$('#quiz3txt').val(),
                quiz3xx:$('#part1_starttime').val(),
                quiz4xx:$('#part1_endtime').val(),
                quiz5xx:$('#quiz4txt').val(),
                topic1x:topic[1],
                topic2x:topic[2],
                topic3x:topic[3],
                topic4x:topic[4],
                topic5x:topic[5],
                topic6x:topic[6],
                comment1x:$("#comment1").val(),
                comment2x:$("#comment2").val(),
                comment3x:$("#comment3").val(),
                comment4x:$("#comment4").val(),
                comment5x:$("#comment5").val(),
                sign1x:$("#part1_sign").val(),
                sign2x:$("#part3_checktime").val(),
                sign3x:$("#part3_sign").val(),
                sessionid:$("#session_id").val()
            },
            dataType: "json",
            success: function( $data ) {
                if($data['error']==0){
					//alert($("#session_id").val()+","+$data['sessionid']);
                    if($("#session_id").val()!=$data['sessionid']){
						$("#session_id").val($data['sessionid']);
						$("#refresh_frm").submit();
					}//else alert("Saved your operation correctly!");
                }else{
                    //alert($data['msg']);
                }
            },
            error: function(e) {
                //alert(e);
            }
        });
    }
	var date_chg_flag=0;
  //$("#part1_date").on('change',function(){
  function dateChangeAction(){
	if($("#part1_stdname").val()!=''){
		var strname=$("#part1_stdname").val().split("-");
		if($("#session_id").val()>-1){
			$("#fixed_studentid").val(strname[2]);
			$("#fixed_datex").val($("#part1_date").val());
			$("#session_id").val(-1);
			$("#refresh_frm").submit();
			/*date_chg_flag=1;
			$("#part1_stdname").val(strname);
			alert(date_chg_flag);
			date_chg_flag=0;*/
		}
	}
  };
  function stdChangeAction(){
		if(date_chg_flag>0)return;
		
		var stdarr=$("#part1_stdname").val().split("-");
		$("#fixed_studentid").val(stdarr[2]);
		$("#fixed_datex").val($("#part1_date").val());
		$("#session_id").val(-1);
		//alert($("#internal_email").val());
		$("#refresh_frm").submit();
		return;
					
					
        var stdarr=$("#part1_stdname").val().split("-");
		document.getElementsByTagName("TITLE")[0].text=stdarr[0]+"-MATH";
        res = $.ajax({
            url: "../instructor/getSessionIdByStdId",
            type: 'post',
            data: {
                studentx:stdarr[0],
                studentidx:stdarr[2],
                datex:$("#part1_date").val()
            },
            dataType: "json",
            success: function( data ) {
                if(data['error']==0){
                    //if(data['sessionid']!=$("#session_id").val()){
                        $("#session_id").val(data['sessionid']);
                        
                    //}
                }else{
					$("#fixed_studentid").val(stdarr[2]);
					$("#fixed_datex").val($("#part1_date").val());
					$("#session_id").val(-1);
				}
				
				$("#refresh_frm").submit();
            },
            error: function(e) {
                //alert(e);
            }
        });
  }
  
  function sendSessionReportsAction(){
	var stdarr=$("#part1_stdname").val().split("-");
	if($('#part1_sign').val()==''){
	    alert('Please fill CHECK-IN fields.');
	    $("#session_sending_btn").html('');
		return;
	}
	if($('#part3_sign').val()==''){
	    alert('Please fill CHECK-OUT fields.');
	    $("#session_sending_btn").html('');
		return;
	}
	if(stdarr.length<2){
		$("#session_sending_btn").html('');
		return;
	}
	$("#session_sending_btn").html('<button type="button" name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(1);">SEND</button>');
    
    var topic=new Array();
    for(var i=1;i<7;i++){
        if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
            topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
        else 
            topic[i]="";
    }
	res = $.ajax({
        url: "../instructor/getParentByStdId",
        type: 'post',
        data: {
            studentx:stdarr[0],
            studentidx:stdarr[2],
            topic1x:topic[1],
            topic2x:topic[2],
            topic3x:topic[3],
            topic4x:topic[4],
            topic5x:topic[5],
            topic6x:topic[6],
            datex:$("#part1_date").val()
        },
        dataType: "json",
        success: function( data ) {
            var body="";
            if(data['name']==''){
                body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#session_sending_btn").html('');
            }else if(data['mail']==''){
                body="There is no the email of guardian "+data['name']+".";$("#session_sending_btn").html('');
            }else{
                var part1="&nbsp;&nbsp;&nbsp;"+stdarr[0]+" answered the following:<br>";
                part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[1]+"&nbsp;&nbsp;"+($("#quiz1x1").val()=="on"?"YES":"NO")+"<br>";
				part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[2]+"&nbsp;&nbsp;"+($("#quiz2x1").val()=="on"?"YES(\""+$("#quiz2txt").val()+"\")":"NO")+"<br>";
				part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[3]+"&nbsp;&nbsp;"+($("#quiz3x1").val()=="on"?"YES(\""+$("#quiz3txt").val()+"\")":"NO")+"<br>";
				part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[4]+"&nbsp;&nbsp;"+($("#quiz4x1").val()=="on"?"YES(\""+$("#quiz4txt").val()+"\","+$("#part1_starttime").val()+"-"+$("#part1_endtime").val()+")":"NO")+"<br>";
				part1+="&nbsp;&nbsp;&nbsp;Instructor Sign:&nbsp;&nbsp;"+$("#part1_sign").val()+"<br>";
                
                var part2="";
				var descar=data['description'].split("##");//alert(descar);
                var j=0,ss;
				for(var i=1;i<7;i++)
                    if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!=""){
						if(descar.length>j)ss=descar[j++];
						else ss="";
                        part2+="&nbsp;&nbsp;&nbsp;"+$("#part2_topic"+i).val()+$("#part2_digit"+i).val()+":"+ss+"<br>&nbsp;&nbsp;&nbsp;pages are \""+$("#part2_page"+i).val().replace(/,_/g,"").replace(/_/,"")+"\".<br>";
					}
				if(part2!="")
					part2="&nbsp;&nbsp;&nbsp;"+stdarr[0]+" had worked on the following topics and page numbers:<br>"+part2;
				for(var i=1;i<6;i++)
                    if($("#comment"+i).val()!="")
                        part2+="&nbsp;&nbsp;&nbsp;"+$("#comment"+i).val()+"<br>";
                
                var part3="";
                part3+="&nbsp;&nbsp;&nbsp;Check-out time: &nbsp;&nbsp;"+$("#part3_checktime").val()+"<br>";
                part3+="&nbsp;&nbsp;&nbsp;"+_QUIZ[5]+"&nbsp;&nbsp;"+($("#quiz5x1").val()=="on"?"YES":"NO")+"<br>";
				part3+="&nbsp;&nbsp;&nbsp;Instructor Sign: &nbsp;&nbsp;"+$("#part3_sign").val();
                
				var fixed_body="Part1:<br>"+part1+
                        "<br>Part2:<br>"+part2+
                        "<br>Part3:<br>"+part3;
				var body=$("#msg_session_body").val();
				body=body.replace(/_PARENTNAME_/g,data['name']);
				body=body.replace(/_STUDENTNAME_/g,stdarr[0]);
				body=body.replace(/\n_FIXEDBODY_\n/g,fixed_body);
				body=body.replace(/_FIXEDBODY_\n/g,fixed_body);
				body=body.replace(/\n_FIXEDBODY_/g,fixed_body);
				body=body.replace(/_FIXEDBODY_/g,fixed_body);
				body=body.replace(/_CHECKOUTNAME_/g,$("#part3_sign").val());
            }
			$("#session_message_body").html(body);
			$("#reporting_name").val(data['name']);
			$("#reporting_mail").val(data['mail']);
			$("#reporting_pnum").val(data['pnum']);
        },
        error: function(e) {
            //alert(e);
        }
    }); 
  }
  
 function sendHomeworkAction(){
        var stdarr=$("#part1_stdname").val().split("-");
        if($('#part1_sign').val()==''){
    	    alert('Please fill CHECK-IN fields.');
    	    $("#homework_sending_btn").html('');
    		return;
    	}
    	if($('#part3_sign').val()==''){
    	    alert('Please fill CHECK-OUT fields.');
    	    $("#homework_sending_btn").html('');
    		return;
    	}
		if(stdarr.length<2){
			$("#homework_sending_btn").html('');
			return;
		}
		var topic=new Array();
        for(var i=1;i<7;i++){
            if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
                topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
            else 
                topic[i]="";
        }
        res = $.ajax({
            url: "../instructor/getParentByStdId",
            type: 'post',
            data: {
                studentx:stdarr[0],
                studentidx:stdarr[2],
                topic1x:topic[1],
                topic2x:topic[2],
                topic3x:topic[3],
                topic4x:topic[4],
                topic5x:topic[5],
                topic6x:topic[6],
                datex:$("#part1_date").val()
            },
            dataType: "json",
            success: function( data ) {
                var body="";
                if(data['name']==''){
                    body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#homework_sending_btn").html('');
                }else if(data['mail']==''){
                    body="There is no the email of guardian "+data['name']+".";$("#homework_sending_btn").html('');
                }else{
                    if(data['url']==""){
                        $("#homework_sending_btn").html('');
                    }
                    var body=$("#msg_homework_body").val();
					body=body.replace(/_PARENTNAME_/g,data['name']);
					body=body.replace(/_STUDENTNAME_/g,stdarr[0]);
					body=body.replace(/_FIXEDBODY_/g,data['url'].replace(/##/g,"<br>"));
					body=body.replace(/_CHECKOUTNAME_/g,$("#part3_sign").val());  
				}
				$("#homework_message_body").html(body);
                    $("#reporting_name").val(data['name']);
                    $("#reporting_mail").val(data['mail']);
                    $("#reporting_pnum").val(data['pnum']);
            },
            error: function(e) {
                //alert(e);
            }
        });  
 }
 function sendCenterAction(){
     if($('#part1_sign').val()==''){
	    alert('Please fill CHECK-IN fields.');
	    $("#center_sending_btn").html('');
		return;
	}
	if($('#part3_sign').val()==''){
	    alert('Please fill CHECK-OUT fields.');
	    $("#center_sending_btn").html('');
		return;
	}
    $("#center_sending_btn").html('<button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(3);">SEND</button>');
    var stdarr=$("#part1_stdname").val().split("-");
    var topic=new Array();
    for(var i=1;i<7;i++){
        if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
            topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
        else 
            topic[i]="";
    }
    res = $.ajax({
        url: "../instructor/getParentByStdId",
        type: 'post',
        data: {
            studentx:stdarr[0],
            studentidx:stdarr[2],
            topic1x:topic[1],
            topic2x:topic[2],
            topic3x:topic[3],
            topic4x:topic[4],
            topic5x:topic[5],
            topic6x:topic[6],
            datex:$("#part1_date").val()
        },
        dataType: "json",
        success: function( data ) {
            var body="";
            if(data['name']==''){
                body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#center_sending_btn").html('');
            }else if(data['mail']==''){
                body="There is no the email of guardian "+stdarr[0]+"needs the following:<br>";$("#center_sending_btn").html('');
            }else{
				var fixed_body="";
                var body=$("#msg_internal_body").val();
				body=body.replace(/_PARENTNAME_/g,data['name']);
				body=body.replace(/_STUDENTNAME_/g,stdarr[0]);
				//body=body.replace(/_FIXEDBODY_/g,fixed_body);
				body=body.replace(/_CHECKOUTNAME_/g,$("#part3_sign").val());  

            }
			$("#center_message_body").html(body);
        },
        error: function(e) {
            //alert(e);
        }
    });  
}
function dropimtempadd(){
	var html=$("#center_message_body").html();
	html=html.replace($("#dropimtemp").val()+"<br>","");  
	html=html.replace(/_FIXEDBODY_/g,$("#dropimtemp").val()+"<br>_FIXEDBODY_");  
	var res = $.ajax({
		url: "../instructor/saveIMTemp",
		type: 'post',
		data: {
			body:$("#dropimtemp").val(),
			type:7
		},
		dataType: "json",
		success: function( data ) {
			
		},
		error: function(e) {
			//alert(e);
		}
	});
	$("#center_message_body").html(html);
}
function dropimtempdelete(){
	var html=$("#center_message_body").html();
	html=html.replace($("#dropimtemp").val()+"<br>","");  
	$("#center_message_body").html(html);
}
 function sendingProcess(f){
    var mail='';
	var name='';
    var subj='';
    var smsbody="";
	var sdata=$("#part1_stdname").val().split("-");
var body="";
    if(f<3){
        name=$("#reporting_name").val().split("#");
        mail=$("#reporting_mail").val().split("#");
        pnum=$("#reporting_pnum").val().split("#");

        if(f==1){
            $("#session_sending_btn").html('');
            subj="TODAY'S MATHNASIUM SESSION REPORT";
            smsbody=$("#sms_session_body").val();
			body=$("#session_message_body").html();
        }else if(f==2){
            $("#homework_sending_btn").html('');
            subj="ADDITIONAL ONLINE MATH PRACTICE";
            smsbody=$("#sms_homework_body").val();
			body=$("#homework_message_body").html();
        }
		
        for(var i=0;i<mail.length;i++){//alert(mail[i]);
			res = $.ajax({
                url: "../instructor/sendingEmail",
                type: 'post',
                data: {
                    mail:mail[i],
                    subj:subj,
					student:sdata[2],
					sessionid:$("#session_id").val(),
					type:f-1,
                    body:body.replace($("#reporting_name").val(),name[i])
                },
                dataType: "json",
                success: function( data ) {
					
				},
                error: function(e) {
                    
                }
            });

			smsbody=smsbody.replace(/_PARENTNAME_/g,name[i]);
			smsbody=smsbody.replace(/_STUDENTNAME_/g,sdata[0]);
			smsbody=smsbody.replace(/_CHECKOUTNAME_/g,$("#part3_sign").val());
            res = $.ajax({
                url: "../instructor/sendingSmsMessage",
                type: 'post',
                data: {
                    pnum:pnum[i],
					student:sdata[2],
					subj:subj,
					type:f+2,
					sessionid:$("#session_id").val(),
                    body:smsbody
                },
                dataType: "json",
                success: function( data ) {
                    
                },
                error: function(e) {
                    
                }
            });
        }
    }else{
        $("#center_sending_btn").html('');
		var body=$("#center_message_body").html().replace("_FIXEDBODY_<br>","").replace(/_FIXEDBODY_/g,"");
        res = $.ajax({
            url: "../instructor/sendingEmail",
            type: 'post',
            data: {
                mail:$("#internal_email").val(),
                subj:"INTERNAL EMAIL",
				type:2,
				student:sdata[2],
				sessionid:$("#session_id").val(),
                body:body
            },
            dataType: "json",
            success: function( data ) {
                
			},
            error: function(e) {
                
            }
        });
    }
 }
 
 /*
 function sendSessionReportsAction1(){
    $("#session_sending_btn").html('<button type="button" name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(1);">SEND</button>');
    var stdarr=$("#part1_stdname").val().split("-");
    var topic=new Array();
    for(var i=1;i<7;i++){
        if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
            topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
        else 
            topic[i]="";
    }
    res = $.ajax({
        url: "getParentByStdId",
        type: 'post',
        data: {
            studentx:stdarr[0],
            studentidx:stdarr[2],
            topic1x:topic[1],
            topic2x:topic[2],
            topic3x:topic[3],
            topic4x:topic[4],
            topic5x:topic[5],
            topic6x:topic[6],
            datex:$("#part1_date").val()
        },
        dataType: "json",
        success: function( data ) {
            var body="";
            if(data['name']==''){
                body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#session_sending_btn").html('');
            }else if(data['mail']==''){
                body="There is no the email of guardian "+data['name']+".";$("#session_sending_btn").html('');
            }else{
                var part1="";
                if($("#quiz1x1").val()=="on")part1+="&nbsp;&nbsp;&nbsp;He answered he scan in barcode.<br>";
                if($("#quiz2x1").val()=="on")part1+="&nbsp;&nbsp;&nbsp;He was beseech help for upcoming test/quiz \""+$("#quiz2txt").val()+"\" in school.<br>";
                if($("#quiz3x1").val()=="on")part1+="&nbsp;&nbsp;&nbsp;He was beseech help with current school topic \""+$("#quiz3txt").val()+"\" in school.<br>";
                if($("#quiz4x1").val()=="on")part1+="&nbsp;&nbsp;&nbsp;He brought homework \""+$("#quiz4txt").val()+"\"("+$("#part1_starttime").val()+"-"+$("#part1_endtime").val()+") to get extra help.<br>";
                part1+="&nbsp;&nbsp;&nbsp;sign:"+$("#part1_sign").val()+"<br>";
                
                var part2="";
                for(var i=1;i<7;i++)
                    if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
                        part2+="&nbsp;&nbsp;&nbsp;He had worked on topic "+$("#part2_topic"+i).val()+"&nbsp;"+$("#part2_digit"+i).val()+" and completed pages are \""+$("#part2_page"+i).val().replace(/,_/g,"").replace(/_/,"")+"\".<br>";
                for(var i=1;i<6;i++)
                    if($("#comment"+i).val()!="")
                        part2+="&nbsp;&nbsp;&nbsp;"+$("#comment"+i).val()+"<br>";
                
                var part3="";
                part3+="&nbsp;&nbsp;&nbsp;chech-out time: "+$("#part3_checktime").val()+"<br>";
                if($("#quiz5x1").val()=="on")part3+="&nbsp;&nbsp;&nbsp;I remindered given to student to mail in lobby & not to go outside till you see your guardian.<br>";
                part3+="&nbsp;&nbsp;&nbsp;sign: "+$("#part3_sign").val();
                body=   
                        "I hope you are doing well. I wanted to give you an update on "+stdarr[0]+"'s today's session.<br>Please see below the details of today's session as recorded by our Instructors:"+
                        "<br>------------------------------------------------------------------------------------------------------------------------------"+
                        "Part1:<br>"+part1+
                        "<br>Part2:<br>"+part2+
                        "<br>Part3:<br>"+part3+
                        "------------------------------------------------------------------------------------------------------------------------------<br>"+
                        "Please let me know if you have any question or concern. You can also schedule a meeting using our app. If you prefer to do the meeting over phone, please enter a comment to call you for the meeting at the specified time."+
                        "<br>"+
                        "<br>Thank you,"+
                        "<br>"+$("#part3_sign").val()+
                        "<br>Executive Director.";

                
            }
			$("#session_message_body").html("<p> Hello "+data['name']+"&hellip;</p>"+body);
			$("#reporting_name").val(data['name']);
			$("#reporting_mail").val(data['mail']);
			$("#reporting_pnum").val(data['pnum']);
        },
        error: function(e) {
            //alert(e);
        }
    });  
  }
 function sendHomeworkAction1(){
        $("#homework_sending_btn").html('<button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(2);">SEND</button>');
        //alert($("#part1_stdname").val()+','+$("#quiz1X1").val()+','+$('#quiz2x1').val());
        var stdarr=$("#part1_stdname").val().split("-");
        var topic=new Array();
        for(var i=1;i<7;i++){
            if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
                topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
            else 
                topic[i]="";
        }
        res = $.ajax({
            url: "getParentByStdId",
            type: 'post',
            data: {
                studentx:stdarr[0],
                studentidx:stdarr[2],
                topic1x:topic[1],
                topic2x:topic[2],
                topic3x:topic[3],
                topic4x:topic[4],
                topic5x:topic[5],
                topic6x:topic[6],
                datex:$("#part1_date").val()
            },
            dataType: "json",
            success: function( data ) {
                var body="";
                if(data['name']==''){
                    body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#homework_sending_btn").html('');
                }else if(data['mail']==''){
                    body="There is no the email of guardian "+data['name']+".";$("#homework_sending_btn").html('');
                }else{
                    body=   "I hope you are doing well. "+stdarr[0]+"' had been working on some Mathnasium topics here at center and we think he can do some extra practice at home online of the same topic.<br>"+
                            "Please note that we do not recommend students to do any home work since it creates stress and anxiety at home because parents need to get involved. If the student is resisting to the homework using the attached link, please stop giving the homework.<br>"+
                            "Also the link will allow you to do 20 questions since we have not purchased license for you. We will buy the license in bulk as a school  so that we can mentor the progress as well and parents are not involved. We will take all such burden from you and you have confidence on us.<br>"+
                            "Please let us know if you want us to buy the license and we will charge $5 a month for this huge extra service. Please see the homework URL link below:"+
                            "<br>------------------------------------------------------------------------------------------------------------------------------"+
                            "<br>"+data['url'].replace(/##/g,"<br>")+
                            "<br>------------------------------------------------------------------------------------------------------------------------------<br>"+
                            "Please let me know if you have any question or concern. You can also schedule a meeting using our app. If you prefer to do the meeting over phone, please enter a comment to call you for the meeting at the specified time."+
                            "<br>"+
                            "<br>Thank you,"+
                            "<br>"+$("#part3_sign").val()+
                            "<br>Executive Director.";
                }
				$("#homework_message_body").html("<p> Hello "+data['name']+"&hellip;</p>"+body);
                    $("#reporting_name").val(data['name']);
                    $("#reporting_mail").val(data['mail']);
                    $("#reporting_pnum").val(data['pnum']);
            },
            error: function(e) {
                //alert(e);
            }
        });  
 }
 function sendCenterAction(){
    $("#center_sending_btn").html('<button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(3);">SEND</button>');
    var stdarr=$("#part1_stdname").val().split("-");
    var topic=new Array();
    for(var i=1;i<7;i++){
        if($("#part2_topic"+i).val()!=""&&$("#part2_digit"+i).val()!=""&&$("#part2_page"+i).val()!="")
            topic[i]=$("#part2_topic"+i).val()+"@"+$("#part2_digit"+i).val()+"@"+$("#part2_page"+i).val();
        else 
            topic[i]="";
    }
    res = $.ajax({
        url: "getParentByStdId",
        type: 'post',
        data: {
            studentx:stdarr[0],
            studentidx:stdarr[2],
            topic1x:topic[1],
            topic2x:topic[2],
            topic3x:topic[3],
            topic4x:topic[4],
            topic5x:topic[5],
            topic6x:topic[6],
            datex:$("#part1_date").val()
        },
        dataType: "json",
        success: function( data ) {
            var body="";
            if(data['name']==''){
                body="There is no the guardian of "+$("#part1_stdname").val()+".";$("#center_sending_btn").html('');
            }else if(data['mail']==''){
                body="There is no the email of guardian "+stdarr[0]+"needs the following:<br>";$("#center_sending_btn").html('');
            }else{
                body="<p> Hello AED / Instructors<br><br>"+stdarr[0]+"</p><br>"+
                        "Print More Math Topics (PK/FO/WOB/ENR etc)<br>"+
                        "Print POST Assessment<br>"+
                        "Re-Grade and Enter POST Assessment<br>"+
                        "Print PRE Assesment<br>"+
                        "Re-Grade and enter PRE Assessment<br>"+
                        "Chart / Learning Plan / Tabs missing - make sure binder is completely Built<br>"+
                        "Other: Type custom texts here<br><br>"+
                        "If you have any question, please text me<br>"+
                        "<br>Thank you,<br>"+
                        "<br>"+$("#part3_sign").val();

            }
			$("#center_message_body").html(body);
        },
        error: function(e) {
            //alert(e);
        }
    });  
}
 */
</script>