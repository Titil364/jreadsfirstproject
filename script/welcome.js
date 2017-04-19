
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


function init(){
	$("#visitor").click(visit);
	$(".return").click(who);
	$("#user").click(connection);
	who();
}


$(init);