<script>var alertmsg="<?php if(isset($confirm_msg))echo $confirm_msg;?>";</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php //echo "<font stype='font-weight:bold;'>".$_user_name['center']."</font>";?> Report
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-default">
        <!--div class="box-header with-border">
          <h3 class="box-title">Select2</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div-->
        <!-- /.box-header -->
        
        <div class="box-footer">
    		<form method="post" action="index" id="frm" autocomplate="off">
    		<input type="hidden" id="viewidx" value="<?php echo $viewidx;?>"/>
    		<input type="hidden" id="viewdatex" value="<?php echo $viewdatex;?>"/>
            <div class="row">					
				<label for="inputEmail3" class="col-sm-1 control-label">SINCE</label>
				<div class="col-sm-2">
					<input type="text" onchange="paramchange()" value="<?php if($fromdate=="")echo "NULL";else echo $fromdate;?>" class="form-control" autocomplate="off" name="fromdate" id="fromdate"/>
				</div>
					
				<label for="inputEmail3" class="col-sm-1 control-label">UNTIL</label>
				<div class="col-sm-2">
					<input type="email" onchange="paramchange()" value="<?php if($todate=="")echo "NULL";else echo $todate;?>" class="form-control pull-right" autocomplate="off" name="todate" id="todate"/>
				</div>
					
				
					
				<label for="inputEmail3" class="col-sm-1 control-label">STUDENT</label>
				<div class="col-sm-2">	
					<select onchange="paramchange()" class="form-control pull-right select2" name="student" id="student" <?php if(count($student)<2)echo "disable";?>>
						<?php if(count($studentdata)>1){?><option <?php if($student=="")echo " selected";?> value="">_ALL_</option><?php }?>
						<?php foreach($studentdata as $r){
								echo "<option  ".($student==$r['s_Id']?" selected":"")." value=\"{$r['s_Id']}\">{$r['First_Name']}-{$r['Last_Name']}</option>";
						}?>
					</select>
					<!--button type="button" data-toggle="modal" class="btn btn-block btn-primary " data-target="#modal-success">SEND TODAY'S SESSION REPORT</button-->
				</div>
			</div>
				<!--div class="col-sm-3">
					<div class="input-group">
						<label for="inputEmail3" class="col-sm-1 control-label">KIND</label>
						<div class="input-group-addon">
							<i class="fa fa-arrows-alt"></i>
						</div>
						<select onchange="typechange()" class="form-control pull-right" id="typesel">
							<option value="0">SEND TODAY'S SESSION REPORT MAIL</option>
							<option value="3">SEND TODAY'S SESSION REPORT SMS</option>
							<option value="1">SEND HOMEWORK TO STUDENT MAIL</option>
							<option value="4">SEND HOMEWORK TO STUDENT SMS</option>
							<option value="2">SEND INTERNAL EMAIL TO CENTER MAIL</option>
							<!--option>COMMENTS BY INSTRUCTOR TEMPLATE</option>
						</select>
						<button type="button" data-toggle="modal" class="btn btn-block btn-primary " data-target="#modal-success">SEND TODAY'S SESSION REPORT</button>
					</div>
				</div-->
			</div>
        </form>
		</div>
	
        <div class="box box-info">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="example1" width="90%" class="table table-bordered table">
                                <thead>
                                    <tr>
                                        <th>DateTime&nbsp;&nbsp;&nbsp;</th>
                                        <th>Full Name</th>
										<th>Check Out-Check In</th>
                                        <th>Content</th>
										<th>SESSION</th>
										<th>HOMEWORK</th>
										<!--th>INTERNAL</th-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php /*
                                        $color=explode(",","primary,success,info");
										$quiz=explode(",","...");
										$colorSys=explode(",","primary,success,info");
										foreach($sessiondata as $r){$datearr=explode("-",$r['datex']);
											echo "<tr>";
											for($i=1;$i<7;$i++){
											    $arr=explode("@",$r["topic{$i}x"]);
											    $descrip[$i]="";
											    if(count($arr)>1){
											        $descrip[$i]="{$arr[1]}";
											        if($arr[0]=="PK#"&&isset($ixldata[$arr[1]]))$descrip[$i]=$ixldata[$arr[1]];
											    }
											    $ixl[$i]="";
											    if(count($arr)>1){
											        $ixl[$i]="{$arr[1]}";
											        if($arr[0]=="PK#"&&isset($ixlurldata[$arr[1]]))$ixl[$i]=$ixlurldata[$arr[1]];
											    }
											}
											echo "<td><a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$datearr[1]}/{$datearr[2]} {$r['sign2x']}</a></td>";
											echo "<td><a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$r['First_Name']}-{$r['Last_Name']}</a></td>";
											echo "<td><a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$r['sign1x']}".($r['sign1x']!=""&&$r['sign3x']!=""?"-":"")."{$r['sign3x']}</a></td>";
											$s="";
											//for($i=1;$i<6;$i++)
											//	if($r["quiz{$i}x"]==1)echo "<span class=\"badge bg-red\">{$quiz[$i]}</span>";
											for($i=1;$i<7;$i++){
												if($r["topic{$i}x"]!=""){
													$arr=explode("@",$r["topic{$i}x"]);
													$s.= "<span class=\"badge bg-yellow\">{$arr[0]}</span>";
													$s.= "<span class=\"badge bg-green\">{$arr[1]}</span>";
													$s.= "<span class=\"badge bg-red\">{$arr[2]}</span>";
												}
											}
											$kk=0;
											for($i=1;$i<7;$i++){//
												if($r["comment{$i}x"]!=""){
												    //if($kk>0)$s.=",";$kk=1;
												    $s.= "<br><span class=\"label label-primary\">".$r["comment{$i}x"]."</span>";}
											}
											//$s="";
											echo "<td><a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$s}</a></td>";
											for($i=0;$i<2;$i++){
												$s="<td>";//$('#msg_session_body').val(\"{$templatedata[$r['center']][4]}\");$('#sms_session_body').val(\"{$templatedata[$r['center']][1]}\");$('#msg_homework_body').val(\"{$templatedata[$r['center']][5]}\");$('#sms_homework_body').val(\"{$templatedata[$r['center']][2]}\");
												if($i==0||($i==1&&$_user_sendable))$s.="<a href=\"#\"  data-toggle=\"modal\" data-target=\"#modal-resend-{$i}\" onclick=\"sendAction({$i},'{$r['idx']}','{$r['studentidx']}','".str_replace(" ","",$r['Center'])."','{$r['iname']}','{$r['sign3x']}','{$r['pFirst_Name']}','{$r['pemail']}','{$r['pphone']}','{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}','{$ixl[1]}','{$ixl[2]}','{$ixl[3]}','{$ixl[4]}','{$ixl[5]}','{$ixl[6]}');\"><span class=\"label label-".($i==0?"primary":"success")."\">VIEW & SEND</span></a><br>";
												
												/*
												$idarr=explode("##",$r["reportid{$i}"]);
												$rearr=explode("##",$r["reportreceiver{$i}"]);
												$tiarr=explode("##",$r["reporttime{$i}"]);//.$r["reportid{$i}"].",".$r["reportreceiver{$i}"];
												for($j=0;$j<count($idarr);$j++){//class=\"btn btn-block btn-{$color[$i]} \"
													if($rearr[$j]!="")$s.="<a href=\"#\" type=\"button\" style=\"line-height: 1px;\"  data-toggle=\"modal\" data-target=\"#previewmondal\" onclick=\"selrow('".$idarr[$j]."','".$i."','{$r['First_Name']}-{$r['Last_Name']}','{$tiarr[$j]}','{$rearr[$j]}');\"><!--span class=\"badge bg-primary\"-->{$rearr[$j]}<!--/span--></a><br>";
												}
												/** /
												$twicearr=explode("@@",$r["reporttwice{$i}"]);
												for($j=0;$j<count($twicearr);$j++){
												    $temparr=explode("##",$twicearr[$j]);
												    if(count($temparr)<3)continue;
												    $idd=$temparr[0];$ree=$temparr[1];$tii=$temparr[2];
												    $s.="<a href=\"#\" type=\"button\" style=\"line-height: 1px;\"  data-toggle=\"modal\" data-target=\"#previewmondal\" onclick=\"selrow('".$idd."','".$i."','{$r['First_Name']}-{$r['Last_Name']}','{$tii}','{$ree}');\"><!--span class=\"badge bg-primary\"-->{$ree}<!--/span--></a><br>";
												}
												$s.="</td>";
												echo $s;
											}
											echo "</tr>";
										}*/
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
                
            </div>
            
        </div>
        <?php foreach($templatedata as $r){?>
		<div class="modal modal-primary fade" id="msg_session_body_<?php echo str_replace(" ","",$r['center'])."_".$r['typex'];?>"><?php echo str_replace('</prev>','',str_replace('<pre>','',$r['textx']));?></div>
		<?php }?>
        <div class="modal modal-primary fade" id="modal-resend-0">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">TODAY'S SESSION REPORT</h4>
                    <input type="hidden" id="instructor_name" value=""/>
                    <input type="hidden" id="reporting_name"/>
                    <input type="hidden" id="reporting_mail"/>
                    <input type="hidden" id="reporting_pnum"/>
                    <input type="hidden" id="reporting_fname"/>
                    <input type="hidden" id="reporting_sessionid"/>
                    <input type="hidden" id="reporting_stdid"/>
                    <input type="hidden" id="reporting_checkoutname"/>
                    <input type="hidden" id="reporting_center"/>
					<!--input type="hidden" id="msg_session_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==4){echo $templatedata[$i]['textx'];break;}?>"/>
                    <input type="hidden" id="sms_session_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==1){echo $templatedata[$i]['textx'];break;}?>"/>
					<input type="hidden" id="msg_homework_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==5){echo $templatedata[$i]['textx'];break;}?>"/>
                    <input type="hidden" id="sms_homework_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==2){echo $templatedata[$i]['textx'];break;}?>"/>
                    -->
                </div>
                <div class="modal-body" id="session_message_body">
                    <p>Please save courrent data.&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
                    <div id="session_sending_btn"><button type="button" name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(1);">RESEND</button></div>
                </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal modal-success fade" id="modal-resend-1">
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
                    <div id="homework_sending_btn"><button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(2);">RESEND</button></div>
                </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        
        <div class="modal modal fade" id="previewcontent">
					 <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header" id="modal-header-page">
                            <h1>Game Plan Dialog</h1>
                        </div>
                        <div class="modal-body" id="previewcontentpanel">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" style="border: 1px solid #ef4343;background: #c1222200;color: #770e0e;" data-dismiss="modal">CLOSE</button>
                        </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
				</div>
        <div class="modal modal-info fade" id="previewmondal">
					 <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header" id="modal-header-message">
                            
                        </div>
                        <div class="modal-body" id="previewpanel">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
                        </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
				</div>
    </section>
</div>
<script src="<?php echo ASSET_PATH;?>pages/constants.js"></script>
<!--<script src="<?php echo ASSET_PATH;?>pages/parent/report.js"></script>-->
<script>
$(document).ready(function(){
        $('.select2').select2();
        if(alertmsg!=''){
            alert(alertmsg);
            location.href="../login/forget";
        }
        var cols=[];
        var i,j,visible,sortable,searchable;
        var _cols=(new String("date,name,check,content,session,homework")).split(",");
        var _ords=[true,true,true,false,false,false,false];
        for(i=0;i<_cols.length;i++){
            visible=true;
            searchable=true;
            cols.push({ "mData": _cols[i],'visible':visible,'bSearchable':_ords[i],'bSortable':_ords[i]  });
        }
        var tblDef1={
            "ajax": {
                url:'../parentx/getreportdata',
                data:function(d){
                    //alert($("#example1").DataTable().page.info().page);
                    
                    //d=$("#example1").DataTable().page.info();
                    d.page=$("#example1").DataTable().page.info().page;
                    d.start=$("#example1").DataTable().page.info().start;
                    d.fromdate=$("#fromdate").val();
                    d.todate=$("#todate").val();
                	d.instructor=$("#instructor").val();
                	d.student=$("#student").val();
                	d.typesel=$("#typesel").val();
                	
                },
                dataSrc:"data",
                "type" : "POST"
            },
            "processing": true,
            "serverSide": true,
            'lengthChange': true,
            bJQueryUI: true,
            aaSorting: [[0, 'desc']],
            aoColumns: cols,
            dom: 'lBfrtip'
        };
        datatable1=$('#example1').DataTable(tblDef1);
        
        $('#fromdate').datepicker({
          autoclose: true,format: 'yyyy-mm-dd' 
        });
    	$('#todate').datepicker({
          autoclose: true,format: 'yyyy-mm-dd' 
        });
        $("body").attr("class","skin-blue sidebar-mini sidebar-collapse");
    });
function previewcontentpanel(datex,timex,sign1,sign2,sign3,fname,tname,
                            quiz1x,quiz2x,quiz3x,quiz4x,quiz5x,quiz1xx,quiz2xx,quiz3xx,quiz4xx,quiz5xx,
                            topic1,topic2,topic3,topic4,topic5,topic6,comment1,comment2,comment3,comment4,comment5,comment6,
                            descrip1,descrip2,descrip3,descrip4,descrip5,descrip6){
    //$("#modal-header-page").val("<h1>Game Plan Dialog</h1>");
    var space="&nbsp;&nbsp;&nbsp;";
    if(quiz1x=='')quiz1x=0;if(quiz2x=='')quiz2x=0;if(quiz3x=='')quiz3x=0;if(quiz4x=='')quiz4x=0;if(quiz5x=='')quiz5x=0;
    var answer=(new String("NO,YES")).split(",");
    var html=
        "<font style=\"font-weight:bold;font-size:17px;\">"+sign1+"/<font style=\"color:red;\">"+fname+"-"+tname+space+datex+space+timex+"</font></font><br>"+
        space+_QUIZ[1]+space+"<font style=\"color:red;\">"+answer[quiz1x]+"</font><br>"+
        space+_QUIZ[2]+space+"<font style=\"color:red;\">"+answer[quiz2x]+(quiz2x==1&&quiz1xx!=""?",&nbsp;"+quiz1xx:"")+"</font><br>"+
        space+_QUIZ[3]+space+"<font style=\"color:red;\">"+answer[quiz3x]+(quiz3x==1&&quiz2xx!=""?",&nbsp;"+quiz2xx:"")+"</font><br>"+
        space+_QUIZ[4]+space+"<font style=\"color:red;\">"+answer[quiz4x]+(quiz4x==1?",&nbsp;"+quiz3xx+"~"+quiz4xx+",&nbsp;"+quiz5xx:"")+"</font><br>"+
        "<font style=\"font-size: 10px;color: #3db173;\">=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=</font><br>";
    var arr=topic1.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip1+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    arr=topic2.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip2+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    arr=topic3.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip3+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    arr=topic4.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip4+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    arr=topic5.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip5+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    arr=topic6.split("@");if(arr.length==3)
    html+=space+arr[0]+":&nbsp;"+descrip6+(arr[2]!=""?", page:&nbsp;"+arr[2]:"")+"<br>";
    if(comment1!="")
    html+=space+comment1+"<br>";
    if(comment2!="")
    html+=space+comment2+"<br>";
    if(comment3!="")
    html+=space+comment3+"<br>";
    if(comment4!="")
    html+=space+comment4+"<br>";
    if(comment5!="")
    html+=space+comment5+"<br>";
    if(comment6!="")
    html+=space+comment6+"<br>";
    html+="<font style=\"font-size: 10px;color: #3db173;\">=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=+-*/^%=</font><br>"+
        space+"<font style=\"font-weight:bold;font-size:17px;color:red;\">"+sign2+"</font><br>"+
        space+_QUIZ[5]+space+"<font style=\"color:red;\">"+answer[quiz5x]+"</font><br>"+
        "<font style=\"font-weight:bold;font-size:17px;\">"+sign3+"</font>";
    $("#previewcontentpanel").html(html);
}
function paramchange(){
    datatable1.ajax.reload();
    return;
	var fromdate=$("#fromdate").val();
	var todate=$("#todate").val();
	var instructor=$("#instructor").val();
	var student=$("#student").val();
	var typesel=$("#typesel").val();
	$("#frm").submit();
}
function selrow(idx,cr,std,time,to){//alert(idx+","+datex);
var color=(new String("primary,success,info")).split(",");//alert(color[cr]);
		    $("#previewmondal").attr('class','modal modal-'+color[cr]+' fade');
	var res = $.ajax({
		url: "getMessageData",
		type: 'post',
		data: {
			idx:idx
		},
		dataType: "json",
		success: function( data ) {
		    
			if(data['msg']=="")data['msg']="Tere is no message.";
			var html=//"<div class=\"small-box bg-primary\">"+
						//"<div class=\"inner\">"+
						"  <h3>"+std+"</h3>"+
						"  <p>SESSION REPORT TO "+to+" ON "+time+"</p>";
					//	"</div>"+
					//	"<div class=\"icon\">"+
					//	"  <i class=\"ion ion-email\"></i>"+
					//	"</div>"+
					//	"<div id=\"preview\">"+
					//	"</div>"+
						//"<a href=\"#\" class=\"small-box-footer\">"+
						//"  More info <i class=\"fa fa-arrow-circle-right\"></i>"+
						//"</a>"+
					//  "</div>";//alert(cr+","+color[cr]);
			
			$("#previewpanel").html(data['msg']);
			$("#modal-header-message").html(html);
		},
		error: function(e) {
			//alert(e['msg']);
		}
	});
}

function sendAction(f,idx,stdid,center,iname,checkoutname,myname,mymail,mynum,datex,timex,sign1,sign2,sign3,fname,tname,
                    quiz1x,quiz2x,quiz3x,quiz4x,quiz5x,quiz1xx,quiz2xx,quiz3xx,quiz4xx,quiz5xx,
                    topic1,topic2,topic3,topic4,topic5,topic6,comment1,comment2,comment3,comment4,comment5,comment6,
                    descrip1,descrip2,descrip3,descrip4,descrip5,descrip6,
                    ixl1,ixl2,ixl3,ixl4,ixl5,ixl6){
res = $.ajax({
    url: "../instructor/getParentByStdId",
    type: 'post',
    data: {
        studentx:fname,
        studentidx:stdid,
        topic1x:topic1,
        topic2x:topic2,
        topic3x:topic3,
        topic4x:topic4,
        topic5x:topic5,
        topic6x:topic6,
        datex:timex
    },
    dataType: "json",
    success: function( data ) {
    var body="";
            if(data['name']==''){
                body="There is no the guardian of "+fname+".";
                $("#session_sending_btn").html('');
                $("#homework_sending_btn").html('');
                return;
            }else if(data['mail']==''){
                body="There is no the email of guardian "+data['name']+".";
                $("#session_sending_btn").html('');
                $("#homework_sending_btn").html('');
                return;
            }
if(f==0){
    var part1="&nbsp;&nbsp;&nbsp;"+fname+" answered the following:<br>";
    part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[1]+"&nbsp;&nbsp;"+(quiz1x==1?"YES":"NO")+"<br>";
	part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[2]+"&nbsp;&nbsp;"+(quiz2x==1?"YES(\""+quiz1xx+"\")":"NO")+"<br>";
	part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[3]+"&nbsp;&nbsp;"+(quiz3x==1?"YES(\""+quiz2xx+"\")":"NO")+"<br>";
	part1+="&nbsp;&nbsp;&nbsp;"+_QUIZ[4]+"&nbsp;&nbsp;"+(quiz4x==1?"YES(\""+quiz3xx+"\","+quiz4xx+"-"+quiz5xx+")":"NO")+"<br>";
	part1+="&nbsp;&nbsp;&nbsp;Instructor Sign:&nbsp;&nbsp;"+sign1;
    var part2="",arr;
arr=topic1.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip1+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
arr=topic2.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip2+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
arr=topic3.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip3+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
arr=topic4.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip4+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
arr=topic5.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip5+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
arr=topic6.split("@");if(arr.length==3)
    part2+="&nbsp;&nbsp;&nbsp;"+arr[0]+arr[1]+":"+descrip6+"<br>&nbsp;&nbsp;&nbsp;pages are \""+arr[2]+"\".<br>";
if(part2!="")
	part2="&nbsp;&nbsp;&nbsp;"+fname+" had worked on the following topics and page numbers:<br>"+part2;
if(comment1!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment1+"<br>";
if(comment2!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment2+"<br>";
if(comment3!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment3+"<br>";
if(comment4!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment4+"<br>";
if(comment5!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment5+"<br>";
if(comment6!="")
    part2+="&nbsp;&nbsp;&nbsp;"+comment6+"<br>";
    var part3="";
    part3+="&nbsp;&nbsp;&nbsp;chech-out time: &nbsp;&nbsp;"+sign2+"<br>";
    part3+="&nbsp;&nbsp;&nbsp;"+_QUIZ[5]+"&nbsp;&nbsp;"+(quiz5x==1?"YES":"NO")+"<br>";
	part3+="&nbsp;&nbsp;&nbsp;Instructor Sign: &nbsp;&nbsp;"+sign3;
	var fixed_body="Part1:<br>"+part1+
        "<br>Part2:<br>"+part2+
        "Part3:<br>"+part3;//alert($("#msg_session_body_"+center+"_4").html()+","+"#msg_session_body_"+center+"_4");
	var body=$("#msg_session_body_"+center+"_4").html();
	body=body.replace(/_PARENTNAME_/g,data['name']);//myname);
	body=body.replace(/_STUDENTNAME_/g,fname);
	body=body.replace(/_FIXEDBODY_/g,fixed_body);
	body=body.replace(/_CHECKOUTNAME_/g,sign3);
	$("#session_message_body").html(body);
	$("#session_sending_btn").html("<button type=\"button\" name=\"sendingBtn\" class=\"btn btn-outline\" onclick=\"sendingProcess(1);\">RESEND</button></div>");
}else{
    var body=$("#msg_session_body_"+center+"_5").html();
	body=body.replace(/_PARENTNAME_/g,data['name']);
	body=body.replace(/_STUDENTNAME_/g,fname);
	//var ixl=ixl1;	ixl+=(ixl!=""&&ixl2!=""?"##":"")+ixl2;	ixl+=(ixl!=""&&ixl3!=""?"##":"")+ixl3;	ixl+=(ixl!=""&&ixl4!=""?"##":"")+ixl4;	ixl+=(ixl!=""&&ixl5!=""?"##":"")+ixl5;	ixl+=(ixl!=""&&ixl6!=""?"##":"")+ixl6;
	body=body.replace(/_FIXEDBODY_/g,data['url'].replace(/##/g,"<br>"));//ixl.replace(/##/g,"<br>"));
	body=body.replace(/_CHECKOUTNAME_/g,sign3);  
    $("#homework_message_body").html(body);
    if(data['url']!='')$("#homework_sending_btn").html("<button type=\"button\"  name=\"sendingBtn\" class=\"btn btn-outline\" onclick=\"sendingProcess(2);\">RESEND</button>");
    else $("#homework_sending_btn").html("");
    
}
    $("#reporting_fname").val(fname);
    $("#reporting_stdid").val(stdid);
    $("#instructor_name").val(iname);
    $("#reporting_name").val(data['name']);
    $("#reporting_mail").val(data['mail']);
    $("#reporting_pnum").val(data['pnum']);
    $("#reporting_sessionid").val(idx);
    $("#reporting_center").val(center);
    $("#reporting_checkoutname").val(checkoutname);
}});
}
 function sendingProcess(f){
    var subj='';
    var smsbody="";
    var body="";
    var name,mail,pnum;
    if(f<3){
        name=$("#reporting_name").val().split("#");
        mail=$("#reporting_mail").val().split("#");
        pnum=$("#reporting_pnum").val().split("#");
        if(f==1){
            $("#session_sending_btn").html('');
            subj="TODAY'S MATHNASIUM SESSION REPORT";
            smsbody=$("#msg_session_body_"+$("#reporting_center").val()+"_1").html();
			body=$("#session_message_body").html();
        }else if(f==2){
            $("#homework_sending_btn").html('');
            subj="ADDITIONAL ONLINE MATH PRACTICE";
            smsbody=$("#msg_session_body_"+$("#reporting_center").val()+"_2").html();
			body=$("#homework_message_body").html();
        }
        for(var i=0;i<mail.length;i++){
    		res = $.ajax({
                url: "../instructor/sendingEmail",
                type: 'post',
                data: {
                    instructor:$("#instructor_name").val(),
                    center:$("#reporting_center").val(),
                    mail:mail[i],
                    subj:subj,
    				student:$("#reporting_stdid").val(),
    				sessionid:$("#reporting_sessionid").val(),
    				type:f-1,
                    body:body.replace($("#reporting_name").val(),name[i]).replace($("#reporting_name").val(),name[i]).replace($("#reporting_name").val(),name[i])
                },
                dataType: "json",
                success: function( data ) {
    				
    			},
                error: function(e) {
                    
                }
            });
    
    		smsbody=smsbody.replace(/_PARENTNAME_/g,name[i]);
    		smsbody=smsbody.replace(/_STUDENTNAME_/g,$("#reporting_fname").val());
    		smsbody=smsbody.replace(/_CHECKOUTNAME_/g,$("#reporting_checkoutname").val());
            res = $.ajax({
                url: "../instructor/sendingSmsMessage",
                type: 'post',
                data: {
                    instructor:$("#instructor_name").val(),
                    center:$("#reporting_center").val(),
                    pnum:pnum[i],
    				student:$("#reporting_stdid").val(),
    				subj:subj,
    				type:f+2,
    				sessionid:$("#reporting_sessionid").val(),
                    body:smsbody
                },
                dataType: "json",
                success: function( data ) {
                    paramchange();
                },
                error: function(e) {
                    paramchange();
                }
            });
        }
    }
 }

</script>