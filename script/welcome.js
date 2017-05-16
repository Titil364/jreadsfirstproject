/**
 * \author Cyril Govin
 * \brief Displays the #visitorAccess element and hides the #welcome element
 */
function visit(){
	$("#visitorAccess").css("display", "block");
	$("#welcome").css("display", "none");
}

/**
 * \author Cyril Govin
 * \brief Displays the #connect element and hides the #welcome element
 */
function connection(){
	$("#connect").css("display", "block");
	$("#welcome").css("display", "none");
}

/**
 * \author Cyril Govin
 * \brief Displays the #welcome element and hides the other element. 
 */
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
