<script>
    function userAction(id,role,tab){
        //alert(id+','+role);
        res = $.ajax({
            url: "setuser",
            type: 'post',
            data: {
                role:role,
                id:id
            },
            dataType: "json",
            success: function( data ) {
                
            },
            error: function(e) {
                
            }
        });
        location.href="viewuser?tab="+tab;
    }
</script>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php //if($_user_name['role']>0) echo "<font stype='font-weight:bold;'>".$_user_name['center']."</font>";else echo "";?> View Users
 
      </h1>
      
    </section>

    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li<?php if($tab==1)echo " class=\"active\"";?>><a href="#tab_1" data-toggle="tab" aria-expanded="false">Instructors</a></li>
              <li<?php if($tab==2)echo " class=\"active\"";?>><a href="#tab_2" data-toggle="tab" aria-expanded="false">Parent</a></li>
              <li<?php if($tab==3)echo " class=\"active\"";?>><a href="#tab_3" data-toggle="tab" aria-expanded="true">Administrator</a></li>
              <li<?php if($tab==5)echo " class=\"active\"";?>><a href="#tab_5" data-toggle="tab" aria-expanded="true">Removed User</a></li>
              <!--<li<?php if($tab==4)echo " class=\"active\"";?>><a href="#tab_4" data-toggle="tab" aria-expanded="true">Location</a></li>-->
            </ul>
            <div class="tab-content">
                <div class="tab-pane<?php if($tab==1)echo " active";?>" id="tab_1">
                    <div class="box">
                        <div class="box-body">
                            <table width="100%">
                                <tr><td width="*" align="right">
                                  <select id="locationemail_ins" onchange="chglocationcenter(1);" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    foreach($instructordata as $c){
                                        echo "<option value=\"{$c['email']}\">{$c['name']} - {$c['email']}</option>";
                                    }
                                  ?>
                                  </select>
                                  <select id="locationcenter_ins" onchange="chglocationcenter(1);" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    $selcenter="";
                                    foreach(explode("###",$centerpermission) as $c){
                                        if($_now_user['center']!=$c){
                                            if($selcenter=="")$selcenter=$c;
                                            echo "<option>{$c}</option>";
                                        }
                                    }
                                  ?>    
                                  </select>
                                </td><td width="40px">
                                    <?php 
                                        $f=0;
                                        if(count($instructordata)>0){
                                        if(!isset($addedlocation[$instructordata[0]['email']]))
                                        $addedlocation[$instructordata[0]['email']]="";
                                        foreach(explode(',',$addedlocation[$instructordata[0]['email']]) as $a){
                                            if($a==$selcenter){$f=1;break;}
                                        }
                                        }
                                        if($f==0){?>
                                    <button type="button" id="addlocationinsbtn" onclick="addLocationIns();" class="btn btn-info pull-left"><i class="fa fa-angle-double-left"></i>Add</button>
                                    <?php }else{?>
                                    <button type="button" id="addlocationinsbtn" onclick="addLocationIns();" class="btn btn-danger pull-left">Delete<i class="fa fa-angle-double-right"></i></button>
                                    <?php }?>
                                </td>
                            </table>
                            <table id="example1" width="100%" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Email</th>
                                        <th>IP</th>
                                        <th>Name</th>
                                        <th>ADDED LOCATION</th>
                                        <th>State</th>
										<th>Register Date</th>
                                        <th>Action</th>
                                        <th>visited_count</th>
                                        <th>last_visited_time</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									foreach($instructordata as $row){
									    if(!isset($addedlocation[$row['email']]))$addedlocation[$row['email']]="";
									    //if(strpos($addedlocation[$row['email']],$row['center'])==false&&$row['center']!=$_user_name['center'])$addedlocation[$row['email']].=($addedlocation[$row['email']]==""?"":",").$row['center'];
									    if($row['center']!=$_user_name['center']){
									        $f=0;
									        foreach(explode(",",$addedlocation[$row['email']]) as $rr)if($rr==$row['center']){$f=1;break;}
									        if($f==0)$addedlocation[$row['email']]=$row['center'].($addedlocation[$row['email']]==""?"":",").$addedlocation[$row['email']];
								        }
									    //$addedlocation[$row['email']]=str_replace($row['center'],"<font style=\"font-weight:bold;color:red;\">{$row['center']}</font>",$addedlocation[$row['email']]);
									    $ss="";
									    foreach(explode(",",$addedlocation[$row['email']]) as $rr){
									        $ss.=($ss==""?"":",");
									        if($rr==$row['center'])$rr="<font style=\"font-weight:bold;color:red;\">{$rr}</font>";
									        $ss.=$rr;
									    }
									    $addedlocation[$row['email']]=$ss;
										echo "<tr>";
										echo "<td></td>";
										echo "<td>{$row['email']}</td>";
										echo "<td><input type='checkbox' onclick=\"iplockAction('{$row['id']}');\" " .($row['ip_lock']==1?"checked":""). "/></td>";
										echo "<td>{$row['name']}</td>";
										echo "<td>".(isset($addedlocation[$row['email']])?$addedlocation[$row['email']]:"")."</td>";
                                        echo "<td>{$state[$row['state']]}</td>";
										echo "<td>{$row['reg_date']}</td>";
                                        echo "<td>";
                                        if($row['state']==0||$row['state']==2){
                                            echo "<button onclick=\"userAction('{$row['id']}',1,1);\" type=\"button\" class=\"btn bg-success btn-xs\">{$state[1]}</button>";
                                        }else if($row['state']==1){
                                            echo "<button onclick=\"userAction('{$row['id']}',2,1);\" type=\"button\" class=\"btn bg-orange btn-xs\">{$state[2]}</button>";
                                        }
										echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"userAction('{$row['id']}',3,1);\" type=\"button\" class=\"btn bg-maroon btn-xs\">delete</button></td>";
										echo "<td>{$row['visited_count']}</td>";
										echo "<td>{$row['last_visited_time']}</td>";
										echo "<td>{$row['id']}</td>";
										echo "</tr>";
									}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane<?php if($tab==2)echo " active";?>" id="tab_2">
                    <div class="box">
                        <div class="box-body">
                            <table id="example2" width="100%" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Email</th>
                                        <th>IP</th>
                                        <th>Name</th>
                                        <th>Location</th>
										<th>State</th>
                                        <th>Register Date</th>
                                        <th>Action</th>
                                        <th>visited_count</th>
                                        <th>last_visited_time</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									foreach($parentdata as $row){
										echo "<tr>";
										echo "<td></td>";
										echo "<td>{$row['email']}</td>";
										echo "<td><input type='checkbox' onclick=\"iplockAction('{$row['id']}');\" " .($row['ip_lock']==1?"checked":""). "/></td>";
										echo "<td>{$row['name']}</td>";
										echo "<td>{$row['center']}</td>";
										echo "<td>{$state[$row['state']]}</td>";
                                        echo "<td>{$row['reg_date']}</td>";
                                        echo "<td>";
                                        if($row['state']==0||$row['state']==2){
                                            echo "<button onclick=\"userAction('{$row['id']}',1,2);\" type=\"button\" class=\"btn bg-success btn-xs\">{$state[1]}</button>";
                                        }else if($row['state']==1){
                                            echo "<button onclick=\"userAction('{$row['id']}',2,2);\" type=\"button\" class=\"btn bg-orange btn-xs\">{$state[2]}</button>";
                                        }
										echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"userAction('{$row['id']}',3,2);\" type=\"button\" class=\"btn bg-maroon btn-xs\">delete</button></td>";
										echo "<td>{$row['visited_count']}</td>";
										echo "<td>{$row['last_visited_time']}</td>";
										echo "<td>{$row['id']}</td>";
										echo "</tr>";
									}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane<?php if($tab==3)echo " active";?>" id="tab_3">
                    <div class="box">
                        <div class="box-body">
                            <table width="100%">
                                <tr><td width="*" align="right">
                                  <select id="locationemail_adm" onchange="chglocationcenter(2);" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    foreach($admindata as $c){
                                        echo "<option value=\"{$c['email']}\">{$c['name']} - {$c['email']}</option>";
                                    }
                                  ?>
                                  </select>
                                  <select id="locationcenter_adm" onchange="chglocationcenter(2);" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    $selcenter="";
                                    foreach(explode("###",$centerpermission) as $c){
                                        if($_now_user['center']!=$c){
                                            if($selcenter=="")$selcenter=$c;
                                            echo "<option>{$c}</option>";
                                        }
                                    }
                                  ?>    
                                  </select>
                                </td><td width="40px">
                                    <?php 
                                        $f=0;
                                        if(count($admindata)>0){
                                        if(!isset($addedlocation[$admindata[0]['email']]))
                                        $addedlocation[$admindata[0]['email']]="";
                                        foreach(explode(',',$addedlocation[$admindata[0]['email']]) as $a){
                                            if($a==$selcenter){$f=1;break;}
                                        }
                                        }
                                        if($f==0){?>
                                    <button type="button" id="addlocationadmbtn" onclick="addLocationAdm();" class="btn btn-info pull-left"><i class="fa fa-angle-double-left"></i>Add</button>
                                    <?php }else{?>
                                    <button type="button" id="addlocationadmbtn" onclick="addLocationAdm();" class="btn btn-danger pull-left">Delete<i class="fa fa-angle-double-right"></i></button>
                                    <?php }?>
                                </td>
                            </table>
                            <table id="example3" width="100%" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Email</th>
                                        <th>IP</th>
                                        <th>Name</th>
                                        <th>ADDED LOCATION</th>
                                        <th>State</th>
                                        <th>Register Date</th>
                                        <th>Action</th>
                                        <th>visited_count</th>
                                        <th>last_visited_time</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $i=0;
									foreach($admindata as $row){
									    if(!isset($addedlocation[$row['email']]))$addedlocation[$row['email']]="";
									    //if(strpos($addedlocation[$row['email']],$row['center'])==false&&$row['center']!=$_user_name['center'])$addedlocation[$row['email']].=($addedlocation[$row['email']]==""?"":",").$row['center'];
									    if($row['center']!=$_user_name['center']){
									        $f=0;
									        foreach(explode(",",$addedlocation[$row['email']]) as $rr)if($rr==$row['center']){$f=1;break;}
									        if($f==0)$addedlocation[$row['email']]=$row['center'].($addedlocation[$row['email']]==""?"":",").$addedlocation[$row['email']];
								        }
									    //$addedlocation[$row['email']]=str_replace($row['center'],"<font style=\"font-weight:bold;color:red;\">{$row['center']}</font>",$addedlocation[$row['email']]);
									    $ss="";
									    foreach(explode(",",$addedlocation[$row['email']]) as $rr){
									        $ss.=($ss==""?"":",");
									        if($rr==$row['center'])$rr="<font style=\"font-weight:bold;color:red;\">{$rr}</font>";
									        $ss.=$rr;
									    }
									    $addedlocation[$row['email']]=$ss;
										echo "<tr id='{$i}'>";$i++;
										echo "<td></td>";
										echo "<td>{$row['email']}</td>";
										echo "<td><input type='checkbox' onclick=\"iplockAction('{$row['id']}');\" " .($row['ip_lock']==1?"checked":""). "/></td>";
										echo "<td>{$row['name']}</td>";
										echo "<td>".(isset($addedlocation[$row['email']])?$addedlocation[$row['email']]:"")."</td>";
										echo "<td>{$state[$row['state']]}</td>";
                                        echo "<td>{$row['reg_date']}</td>";
                                        echo "<td>";
                                        if($row['state']==0||$row['state']==2){
                                            echo "<button onclick=\"userAction('{$row['id']}',1,3);\" type=\"button\" class=\"btn bg-success btn-xs\">{$state[1]}</button>";
                                        }else if($row['state']==1){
                                            echo "<button onclick=\"userAction('{$row['id']}',2,3);\" type=\"button\" class=\"btn bg-orange btn-xs\">{$state[2]}</button>";
                                        }
										echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"userAction('{$row['id']}',3,3);\" type=\"button\" class=\"btn bg-maroon btn-xs\">delete</button></td>";
										echo "<td>{$row['visited_count']}</td>";
										echo "<td>{$row['last_visited_time']}</td>";
										echo "<td>{$row['id']}</td>";
										echo "</tr>";
									}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane<?php if($tab==5)echo " active";?>" id="tab_5">
                    <div class="box">
                        <div class="box-body">
                            <table id="example5" width="100%" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>Email</th>
                                        <th>IP</th>
                                        <th>Name</th>
                                        <th>Location</th>
										<th>Register Date</th>
                                        <th>visited_count</th>
                                        <th>last_visited_time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									foreach($removeddata as $row){
										echo "<tr>";
										////echo "<td></td>";
										echo "<td>{$row['email']}</td>";
										echo "<td><input type='checkbox' onclick=\"iplockAction('{$row['id']}');\" " .($row['ip_lock']==1?"checked":""). "/></td>";
										echo "<td>{$row['name']}</td>";
										echo "<td>{$row['center']}</td>";
                                        echo "<td>{$row['reg_date']}</td>";
                                        echo "<td>{$row['visited_count']}</td>";
										echo "<td>{$row['last_visited_time']}</td>";
										//echo "<td>{$row['id']}</td>";
										echo "</tr>";
									}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="tab_4">
                    <div class="box">
                        <div class="box-body">
                            <table width="100%">
                                <tr><td width="170px" align="left">
                                    <h1 style="font-size: 21px;font-weight: bold;">Addition Location</h1>
                                </td><td width="*" align="right">
                                  <select id="locationcenter" onchange="" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    foreach(explode("###",$centerpermission) as $c){
                                        echo "<option ".($_now_user['center']==$c?"selected":"").">{$c}</option>";
                                    }
                                  ?>    
                                  </select>
                                  <select id="locationemail" onchange="" style="font-size: 22px;line-height: 20px;height: 34px;">
                                  <?php 
                                    foreach(explode("###",$centeremail) as $c){
                                        echo "<option>{$c}</option>";
                                    }
                                  ?>    
                                  </select>
                                </td><td width="40px">
                                    <button type="button" onclick="addLocation();" class="btn btn-info pull-left"><i class="fa fa-angle-double-left"></i>Add</button>
                                </td>
                            </table>
                            <table id="location_tbl" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>PrimaryLocation</th>
                                        <th>AddedLocatioin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</div>
<style>
tr div.expand {
  width: 20px;
  height: 20px;
  background-image: url('http://www.datatables.net/release-datatables/examples/examples_support/details_open.png');
}

tr div.open {
  background-image: url('http://www.datatables.net/release-datatables/examples/examples_support/details_close.png');  
}
</style>
<script>
function chglocationcenter(f){
    
    var center='';
    var email='';
    if(f==1){
        if($('#locationcenter_ins').val()==""||$('#locationemail_ins').val()=="")        return;
        center=$('#locationcenter_ins').val();
        email=$('#locationemail_ins').val();
    }else{
        if($('#locationcenter_adm').val()==""||$('#locationemail_adm').val()=="")
        return;
        center=$('#locationcenter_adm').val();
        email=$('#locationemail_adm').val();
    }
    res = $.ajax({
        url: "islocationcenter",
        type: 'post',
        data: {
            center:center,
            email:email
        },
        dataType: "json",
        success: function( data ) {
            if(f==1){
                if(data.res=="1"){
                    $("#addlocationinsbtn").attr("class","btn btn-danger pull-left");
                    $("#addlocationinsbtn").html("Delete<i class=\"fa fa-angle-double-right\"></i>");
                }else{
                    $("#addlocationinsbtn").attr("class","btn btn-info pull-left");
                    $("#addlocationinsbtn").html("<i class=\"fa fa-angle-double-left\">Add</i>");
                }
            }else{
                if(data.res=="1"){
                    $("#addlocationadmbtn").attr("class","btn btn-danger pull-left");
                    $("#addlocationadmbtn").html("Delete<i class=\"fa fa-angle-double-right\"></i>");
                }else{
                    $("#addlocationadmbtn").attr("class","btn btn-info pull-left");
                    $("#addlocationadmbtn").html("<i class=\"fa fa-angle-double-left\">Add</i>");
                }
            }
        },
        error: function(data) {
            if(data.res=="ok"){
            }
        }
    });
}
function addLocationIns(){
    if($('#locationcenter_ins').val()==""||$('#locationemail_ins').val()=="")return;
    if($("#addlocationinsbtn").attr("class")=="btn btn-info pull-left"){
        res = $.ajax({
            url: "addlocation",
            type: 'post',
            data: {
                center:$('#locationcenter_ins').val(),
                email:$('#locationemail_ins').val()
            },
            dataType: "json",
            success: function( data ) {
                if(data.res=="ok"){//btn bg-maroon btn-xs
                    location.href="viewuser?tab=1";
                }
            },
            error: function(data) {
                if(data.res=="ok"){
                    location.href="viewuser?tab=1";
                    //$("#addlocationinsbtn").attr("class","btn btn-maroon pull-left");
                }
            }
        });
    }else{
        res = $.ajax({
            url: "deletelocation",
            type: 'post',
            data: {
                center:$('#locationcenter_ins').val(),
                email:$('#locationemail_ins').val()
            },
            dataType: "json",
            success: function( data ) {
                location.href="viewuser?tab=1";
            },
            error: function(e) {
                //location.href="viewuser?tab=1";
            }
        });
    }
}
function addLocationAdm(){
    if($('#locationcenter_adm').val()==""||$('#locationemail_adm').val()=="")return;
    if($("#addlocationadmbtn").attr("class")=="btn btn-info pull-left"){
        res = $.ajax({
            url: "addlocation",
            type: 'post',
            data: {
                center:$('#locationcenter_adm').val(),
                email:$('#locationemail_adm').val()
            },
            dataType: "json",
            success: function( data ) {
                if(data.res=="ok"){//btn bg-maroon btn-xs
                    location.href="viewuser?tab=3";
                }
            },
            error: function(data) {
                if(data.res=="ok"){
                    location.href="viewuser?tab=3";
                    //$("#addlocationinsbtn").attr("class","btn btn-maroon pull-left");
                }
            }
        });
    }else{
        res = $.ajax({
            url: "deletelocation",
            type: 'post',
            data: {
                center:$('#locationcenter_adm').val(),
                email:$('#locationemail_adm').val()
            },
            dataType: "json",
            success: function( data ) {
                location.href="viewuser?tab=3";
            },
            error: function(e) {
                //location.href="viewuser?tab=1";
            }
        });
    }
}
var tbls=new Array(3);
function iplockAction(id){
    res = $.ajax({
        url: "setiplock",
        type: 'post',
        data: {
            id:id
        },
        dataType: "json",
        success: function( data ) {
            
        },
        error: function(e) {
            
        }
    });
}
var location_tbl=null;
$(document).ready(function(){
    
    
    //$('#example1').DataTable();
    //$('#example2').DataTable();
    var colDef=[
                    {mData: null,bSearchable: false,bSortable: false,sDefaultContent: '<div class="expand /">',sWidth: "30px"},
                    { mData: 'Email', bSearchable: true,  bSortable: true },
                    { mData: 'ip_lock',        bSearchable: false, bSortable: false },
                    { mData: 'Name',       bSearchable: false, bSortable: true },
                    { mData: 'Location',           bSearchable: false, bSortable: true },
                    { mData: 'State',           bSearchable: false, bSortable: true },
                    { mData: 'Register Date',           bSearchable: false, bSortable: true },
                    { mData: 'Action',           bSearchable: false, bSortable: true },
                    { mData: 'visited_count',      visible:false,     bSearchable: false, bSortable: true },
                    { mData: 'last_visited_time',   visible:false,         bSearchable: false, bSortable: true },
                    { mData: 'id',   visible:false,         bSearchable: false, bSortable: true }
                ];
    var tblDef={
        bJQueryUI: true,
        sPaginationType: 'full_numbers',            //aaData: data,
        aaSorting: [[5, 'asc']],
        aoColumns: colDef
    };
    function fnFormatDetails(oTable, nTr) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table bgcolor="yellow" cellpadding="8" border="0" style="padding-left:250px;margin-left: 10px;">';
        //sOut += '<tr><td>Email:</td><td>' + "" + '</td></tr>';
        //sOut += '<tr><td>Name:</td><td>' + "" + '</td></tr>';
        sOut += '<tr><td width="200px">Visited Count:</td><td>' + aData['visited_count'] + '</td></tr>';
        sOut += '<tr><td>last visited time:</td><td>' + aData['last_visited_time'] + '</td></tr>';
        //sOut += '<tr><td>IP Interlock:</td><td>' + "<input type='checkbox' onclick=\"iplockAction('"+aData['id']+"');\" "  +(aData['ip_lock']==1?"checked":"")+ "/>" + '</td></tr>';
        sOut += '<tr><td>Session Count(Day/Month/Year):</td><td>' + "1/10/10" + '</td></tr>';
        sOut += '<tr><td>Sending(SendingCount/TotalCount):</td><td>' + "44/100" + '</td></tr>';
        sOut += '</table>';
        return sOut;
    }
    
    //for(var i=1;i<4;i++){
    tbl1= $('#example1').dataTable(tblDef);
    tbl2= $('#example2').dataTable(tblDef);
    tbl3= $('#example3').dataTable(tblDef);
    //tbl5= $('#example5').dataTable();
    
    $('#example1 tbody').on('click', 'tr', function () {
        var nTr = $(this);
        if(tbl1.fnIsOpen($(this))){
            tbl1.fnClose(nTr);
            $(this).find('td div.open').removeClass('open');
        }else{
            $(this).parent().find('tr').each(function (i, el) {
                $(this).find('td div.open').removeClass('open');
                tbl1.fnClose($(this));
            });
        
            $.fn.dataTableExt.sErrMode = 'throw' ;
            $(this).find('td div.expand').addClass('open');
            tbl1.fnOpen(nTr, fnFormatDetails(tbl1, nTr), 'details');
        }
    });
    
    $('#example2 tbody').on('click', 'tr', function () {
        var nTr = $(this);
        if(tbl2.fnIsOpen($(this))){
            tbl2.fnClose(nTr);
            $(this).find('td div.open').removeClass('open');
        }else{
            $(this).parent().find('tr').each(function (i, el) {
                $(this).find('td div.open').removeClass('open');
                tbl2.fnClose($(this));
            });
        
            $.fn.dataTableExt.sErrMode = 'throw' ;
            $(this).find('td div.expand').addClass('open');
            tbl2.fnOpen(nTr, fnFormatDetails(tbl2, nTr), 'details');
        }
    });
    $('#example3 tbody').on('click', 'tr', function () {
        var nTr = $(this);
        if(tbl3.fnIsOpen($(this))){
            tbl3.fnClose(nTr);
            $(this).find('td div.open').removeClass('open');
        }else{
            $(this).parent().find('tr').each(function (i, el) {
                $(this).find('td div.open').removeClass('open');
                tbl3.fnClose($(this));
            });
        
            $.fn.dataTableExt.sErrMode = 'throw' ;
            $(this).find('td div.expand').addClass('open');
            tbl3.fnOpen(nTr, fnFormatDetails(tbl3, nTr), 'details');
        }
    });
    
    /*
    var cols=[];
    var i,j,visible,sortable,searchable;
    var _cols=(new String("num,rolename,email,baselocation,location,action")).split(",");//sWidth: "30px"
    //var _cols=(new String("num,rolename,email,location,action")).split(",");
    for(i=0;i<_cols.length;i++){
        visible=true;
        searchable=true;
        sortable=true;
        cols.push({ "mData": _cols[i],'visible':visible,'bSearchable':searchable,'bSortable':sortable,  });
    }
    var tblDef1={
        "ajax": {
            url:'getlocation',
            dataSrc:"",
            "type" : "POST"
        },
        bJQueryUI: true,
        sPaginationType: 'full_numbers',
        //aaSorting: [[1, 'asc']],
        aoColumns: cols,
        dom: 'Bfrtip'
    };
    location_tbl=$('#location_tbl').DataTable(tblDef1);*/
    //location_tbl.ajax.reload();
});
function addLocation(){
    var str=$('#locationemail').val().split(',');
    res = $.ajax({
    url: "addlocation",
    type: 'post',
    data: {
        center:$('#locationcenter').val(),
        email:str[1]
    },
    dataType: "json",
    success: function( data ) {
        location_tbl.ajax.reload();
    },
    error: function(e) {
        location_tbl.ajax.reload();
    }
});
}
function deleteLocation(e){
    res = $.ajax({
    url: "deletelocation",
    type: 'post',
    data: {
        email:e
    },
    dataType: "json",
    success: function( data ) {
        location_tbl.ajax.reload();
    },
    error: function(e) {
        location_tbl.ajax.reload();
    }
});
}
</script>