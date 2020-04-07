$(document).ready(function(){
	$('.select2').select2({
	  tags: true
	});
});
function saveAction(type){
	var res = $.ajax({
		url: "saveTemplate",
		type: 'post',
		data: {
			body:$('#body').val(),
			type:type
		},
		dataType: "json",
		success: function( data ) {
			//var color=(new String("primary,success,info")).split(",");//alert(color[cr]);
			//var html=$('#body').val();//alert(cr+","+color[cr]);
			$("#preview").html("<p>"+$('#body').val().replace(/\n/g,'<br>')+"</p>");
		},
		error: function(e) {
			//alert(e['msg']);
		}
	});
}
function dropimtempaction(type){
	//alert($("#dropimtemp").val());
	var res = $.ajax({
		url: "saveIMTemp",
		type: 'post',
		data: {
			body:$("#dropimtemp").val(),
			type:type
		},
		dataType: "json",
		success: function( data ) {
			//alert(data);
			if(data==1){
				if(type==0)location.href="rmtemplate";
				else if(type==7)location.href="imtemplate";
			}
		},
		error: function(e) {
			//alert(e);
		}
	});
}
