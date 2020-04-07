$(document).ready(function(){
	$('.select2').select2();
	$('#example1').DataTable({
		'paging'      : true,
		'lengthChange': true,
		//'searching'   : false,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false		  
	});
});
function sendAction(){if($("#checkoutname").val()==""){alert("Please type your name in bottom input box.");return;}
if($("#student").val()==""){alert("Please select student box.");return;}
	res = $.ajax({
        url: "getParentByStdId",
        type: 'post',
        data: {
            studentidx:$('#student').val()
        },
        dataType: "json",
        success: function( data ) {
            var body="";
            if(data['name']==''){
                alert("There is no the guardian.");
            }else if(data['mail']==''){
                alert(body="There is no the email of guardian ");
            }else{
				var name=data['name'].split("#");
				var mail=data['mail'].split("#");
				var pnum=data['pnum'].split("#");//alert(data['mail']+mail.length);
				for(var i=0;i<name.length;i++){
					alert("Sent the message to "+mail[i]+".\nSent the sms to "+pnum[i]+".\n");
					var body=$('#body').val();
					body=body.replace(/_PARENTNAME_/g,name[i]);
					body=body.replace(/_STUDENTNAME_/g,data['stname']);
					//body=body.replace(/_FIXEDBODY_/g,data['url'].replace(/##/g,"<br>"));
					body=body.replace(/_CHECKOUTNAME_/g,$("#checkoutname").val());  
					res = $.ajax({
						url: "sendingEmail",
						type: 'post',
						data: {
							mail:mail[i],
							subj:"EXTRA HOMEWORK MESSAGE",
							student:$('#student').val(),
							sessionid:-1,
							type:1,
							body:body.replace(/\n/g,'<br>')
						},
						dataType: "json",
						success: function( data ) {
							
						},
						error: function(e) {
							
						}
					});

					res = $.ajax({
						url: "sendingSmsMessage",
						type: 'post',
						data: {
							pnum:pnum[i],
							student:$('#student').val(),
							subj:"EXTRA HOMEWORK MESSAGE",
							type:4,
							sessionid:-1,
							body:$('#body').val().replace(/\n/g,'<br>')
						},
						dataType: "json",
						success: function( data ) {
							
						},
						error: function(e) {
							
						}
					});
				}
            }
			
        },
        error: function(e) {
            //alert(e);
        }
    });  
	
}