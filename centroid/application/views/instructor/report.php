<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo "<font stype='font-weight:bold;'>".$_user_location."</font>";?> Report
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
        <form class="form-horizontal" method="post" action="index" id="refresh_frm">
			<input type="hidden" name="session_prev_id" id="session_prev_id"/>
			<input type="hidden" name="fixed_studentid" id="fixed_studentid"/>
			<input type="hidden" name="fixed_datex" id="fixed_datex"/>
			<input type="hidden" name="session_id" id="session_id"/>
			<input type="hidden" name="session_next_id" id="session_next_id"/>
			
		</form>
        <div class="box-footer">
		<form method="post" action="studentreport" id="frm">
			<input type="hidden" id="viewidx" value="<?php echo $viewidx;?>"/>
			<input type="hidden" id="viewdatex" value="<?php echo $viewdatex;?>"/>
			<div class="row">					
				<label for="inputEmail3" class="col-sm-1 control-label">SINCE</label>
				<div class="col-sm-2">
					<input type="text" onchange="paramchange()"  value="<?php if($fromdate=="")echo "NULL";else echo $fromdate;?>" class="form-control" autocomplate="off" name="fromdate" id="fromdate">
				</div>
					
				<label for="inputEmail3" class="col-sm-1 control-label">UNTIL</label>
				<div class="col-sm-2">
					<input type="text" onchange="paramchange()"  value="<?php if($todate=="")echo "NULL";else echo $todate;?>" class="form-control pull-right" autocomplate="off" name="todate" id="todate">
				</div>
					
				<label for="inputEmail3" class="col-sm-1 control-label">INSTRUCTOR</label>
				<div class="col-sm-2">
					<select onchange="paramchange()" class="form-control pull-right" id="instructor" name="instructor">
						<?php 
						echo "<option ".("__ALL__"==$instructor?" selected":"").">__ALL__</option>";
						foreach($userdata as $r){// value=\"{$r['email']}\"
							if($r['role']==2&&$r['center']==$_user_location)echo "<option ".($r['name']==$instructor?" selected":"").">{$r['name']}</option>";
						}?>
					</select>
				</div>
					
				<label for="inputEmail3" class="col-sm-1 control-label">STUDENT</label>
				<div class="col-sm-2">	
					<select onchange="paramchange()" class="form-control pull-right select2" name="student" id="student">
						<option <?php if($student=="")echo " selected";?> value="">___ALL</option>
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
        </form>
		</div>
      </div>
	
        <div class="box box-info">
		
            <div class="row">
                <div class="col-sm-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">SESSION REPORT</a></li>
					  <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">EXTRA REPORT</a></li>
					</ul>
				<div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box">
                        <div class="box-body">
                            <table id="example1" width="100%" class="table table-bordered table">
                                <thead>
                                    <tr>
                                        <th>DateTime&nbsp;&nbsp;&nbsp;</th>
                                        <th>Full Name</th>
										<th>Check Out-Check In</th>
                                        <th>Content</th>
										<th>SESSION</th>
										<th>HOMEWORK</th>
										<th>INTERNAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
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
											
											if($_user_role==1){
												echo "<td>{$datearr[1]}/{$datearr[2]} {$r['sign2x']}</td>";
												echo "<td>{$r['First_Name']}-{$r['Last_Name']}</td>";
												echo "<td>{$r['sign3x']}".($r['sign1x']!=""&&$r['sign3x']!=""?"-":"")."{$r['sign1x']}</td>";
											}else{
												echo "<td><a href=\"#\" onclick=\"goGPN('{$r['idx']}');\">{$datearr[1]}/{$datearr[2]} {$r['sign2x']}</a></td>";
												echo "<td><a href=\"#\" onclick=\"goGPN('{$r['idx']}');\">{$r['First_Name']}-{$r['Last_Name']}</a></td>";
												echo "<td><a href=\"#\" onclick=\"goGPN('{$r['idx']}');\">{$r['sign3x']}".($r['sign1x']!=""&&$r['sign3x']!=""?"-":"")."{$r['sign1x']}</a></td>";
											}
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
											for($i=1;$i<7;$i++){
												if($r["comment{$i}x"]!="")$s.= "<br><span class=\"label label-primary\">".$r["comment{$i}x"]."</span>";
											}
											//$s="";
											//echo "<td>{$s}</td>";
											echo "<td><a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$s}</a></td>";
											for($i=0;$i<3;$i++){
												$s="<td>";//$('#msg_session_body').val(\"{$templatedata[$r['center']][4]}\");$('#sms_session_body').val(\"{$templatedata[$r['center']][1]}\");$('#msg_homework_body').val(\"{$templatedata[$r['center']][5]}\");$('#sms_homework_body').val(\"{$templatedata[$r['center']][2]}\");
												if($i==0||($i==1&&$_user_sendable))$s.="<a href=\"#\"  data-toggle=\"modal\" data-target=\"#modal-resend-{$i}\" onclick=\"sendAction({$i},'{$r['idx']}','{$r['studentidx']}','".str_replace(" ","",$r['Center'])."','{$r['internalMail']}','{$r['sign3x']}','{$datearr[1]}/{$datearr[2]}','{$r['timex']}','{$r['sign1x']}','{$r['sign2x']}','{$r['sign3x']}','{$r['First_Name']}','{$r['Last_Name']}','{$r['quiz1x']}','{$r['quiz2x']}','{$r['quiz3x']}','{$r['quiz4x']}','{$r['quiz5x']}','{$r['quiz1xx']}','{$r['quiz2xx']}','{$r['quiz3xx']}','{$r['quiz4xx']}','{$r['quiz5xx']}','{$r['topic1x']}','{$r['topic2x']}','{$r['topic3x']}','{$r['topic4x']}','{$r['topic5x']}','{$r['topic6x']}','{$r['comment1x']}','{$r['comment2x']}','{$r['comment3x']}','{$r['comment4x']}','{$r['comment5x']}','{$r['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}','{$ixl[1]}','{$ixl[2]}','{$ixl[3]}','{$ixl[4]}','{$ixl[5]}','{$ixl[6]}');\"><span class=\"label label-{$color[$i]}\">VIEW & SEND</span></a><br>";
												$idarr=explode("##",$r["reportid{$i}"]);
												$rearr=explode("##",$r["reportreceiver{$i}"]);
												$tiarr=explode("##",$r["reporttime{$i}"]);
												//$s="<td>";//.count($idarr).",".count($rearr).",".count($tiarr)."<".$r["reporttime{$i}"]."><br>";
												for($j=0;$j<count($idarr);$j++){
													//$s.="{$idarr[$j]}";
													if($rearr[$j]!="")$s.="<a href=\"#\" type=\"button\" style=\"line-height: 1px;\"  data-toggle=\"modal\" data-target=\"#previewmondal\" onclick=\"selrow('".$idarr[$j]."','".$i."','{$r['First_Name']}-{$r['Last_Name']}','{$tiarr[$j]}','{$rearr[$j]}');\"><!--span class=\"badge bg-primary\"-->{$rearr[$j]}<!--/span--></a><br>";
												}
												$s.="</td>";
												echo $s;
											}
											echo "</tr>";
										}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
				<div class="tab-pane" id="tab_2">
                    <div class="box">
                        <div class="box-body">
                            <table id="example2" width="100%" class="table table-bordered table">
                                <thead>
                                    <tr>
                                        <th>DateTime&nbsp;&nbsp;&nbsp;</th>
                                        <th>Full Name</th>
										<th>Receiver</th>
                                        <th>Subject</th>
										<th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$row="";
										foreach($reportdata as $r){
											$row.= "<tr>";
											$row.= "<td>{$r['datex']}</td>";
											$row.= "<td>{$r['First_Name']}-{$r['Last_Name']}</td>";
											$row.= "<td>{$r['receiverx']}</td>";
											$row.= "<td>{$r['subjectx']}</td>";
											$row.= "<td>{$r['bodyx']}</td>";
											$row.= "</tr>";
										}
										echo $row;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
				</div>
				</div>
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
                        <div class="modal-header" id="preview-modal-header">
                            
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
            </div>
        </div>
    </section>
</div>
<?php foreach($templatedata as $r)if($r['typex']!=7){?>
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
            <input type="hidden" id="reporting_internalMail"/>
			<!--input type="hidden" id="msg_session_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==4){echo $templatedata[$i]['textx'];break;}?>"/>
            <input type="hidden" id="sms_session_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==1){echo $templatedata[$i]['textx'];break;}?>"/>
			<input type="hidden" id="msg_homework_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==5){echo $templatedata[$i]['textx'];break;}?>"/>
            <input type="hidden" id="sms_homework_body" value="<?php //for($i=0;$i<count($templatedata);$i++)if($templatedata[$i]['typex']==2){echo $templatedata[$i]['textx'];break;}?>"/>
            -->
        </div>
        <div class="modal-body" id="session_message_body">
            <p>Sorry, There is no data.&hellip;</p>
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
            <p>Sorry, There is no data.&hellip;</p>
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
<div class="modal modal-info fade" id="modal-resend-2">
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
        <div class="modal-body" id="internal_message_body">
            <p>Sorry, There is no data.&hellip;</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CLOSE</button>
            <div id="internal_sending_btn"><button type="button"  name="sendingBtn" class="btn btn-outline" onclick="sendingProcess(3);">RESEND</button></div>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo ASSET_PATH;?>pages/constants.js"></script>
<script src="<?php echo ASSET_PATH;?>pages/instructor/report.js"></script>