
function visit(){
	who();
}
function connexion(){
	$("#connect").css("display", "block");
	$("#welcome").css("display", "none");
}

function who(){
	$("#connect").css("display", "none");
	$("#welcome").css("display", "flex");
}


function init(){
	$("#visitor").click(visit);
	$("#return").click(who);
	$("#user").click(connexion);
	who();
}


$(init);