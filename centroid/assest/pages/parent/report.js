$(document).ready(function(){
    if(alertmsg!='')alert(alertmsg);
	$('.select2').select2();
	$('#example1').DataTable({
			'paging'      : true,
		//'lengthChange': true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		"order": [[ 0, "desc" ]]
		  
	});
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
