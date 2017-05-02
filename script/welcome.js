
function visit(){
	$("#visitorAccess").css("display", "block");
	$("#welcome").css("display", "none");
}
function connection(){
	$("#connect").css("display", "block");
	$("#welcome").css("display", "none");
}


function who(){
	$("#connect").css("display", "none");
	$("#visitorAccess").css("display", "none");
	$("#welcome").css("display", "flex");
}

function getFormIdByVisitor(){
	var select = $("#visitor_id").val();
	$.post(
		"index.php",
		{
			"action":"getFormIdByVisitor",
			"controller":"visitor",			
			"visitorId":JSON.stringify(select)
		},
		function(res){
			var f = res;
			console.log(f);
			window.location.href = "index.php?controller=visitor&action=read&formId="+res+"&visitorId="+select;
			
		},
		"json"
	);
}

function init(){
	$("#visitor").click(visit);
	$(".return").click(who);
	$("#user").click(connection);
	document.getElementById("submit").addEventListener("click",getFormIdByVisitor);
	who();
}


$(init);