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
		
        for(var i=0;i<mail.length;i++){
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