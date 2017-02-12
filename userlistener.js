$(document).ready(function() {  	
	var pagework = window.location.pathname.slice(window.location.pathname.lastIndexOf('/')+1);	
	if (pagework=='location.php'){		
		$.ajax({
			url: "ajaxuser.php",
			type: "POST",
			dataType: "json",		
			data: {listenerID: $("#listenerID").val()},
			success: function(json){
				//var listenerWorkID = json.listener['action_ID'];
				//var worksp = json.listener['workspecialty'];				
				//var workresID = json.listener['res_ID'];
				//var worktime = json.listener['worktime'];				
				//var workcountres = json.listener['count_resource'];
				//var workname = json.listener['workname'];
				//workstart(workspecialty,workresID,worktime,workcountres,workname);
				
			}
		}); 
	} else {
		$.ajax({
			url: "ajaxuser.php",
			type: "POST",
			dataType: "json",		
			data: {listenerID: $("#listenerID").val()},
			success: function(json){
				var listenerWorkID = json.listener['action_ID'];
				var locID = json.listener['loc_ID'];
				var hash = $("#hash").val();			
				if (listenerWorkID>0) {
					var hrefstring ='location.php?hash='+hash+'&loc_ID='+locID;
					location.replace(hrefstring);					
				}
			}
		}); 
	}
});
function workstart(workspecialty,workresID,worktime,workcountres,workname){				
	$.ajax({
		url: "resandloot.php",
		type: "POST",
		dataType: "json",
		data: {User_ID: $('#UserID').text(),locID:$('#locID').val(),workID:$('#workID').val(),workspecialty: workspecialty,workresID: workresID,worktime: worktime,workcountres: workcountres}
	});
	$('.work_contener').css("display", "none");	
	$('.employment_fon').css("display", "block");
	$('.employment_contener').css("display", "block");
	$('#workname').text(workname);
	workfunc(worktime,workcountres);
}