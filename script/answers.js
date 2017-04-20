
function extractAnswers(){
	var answers=[], personnalInfo=[];
	var n = "", val = "";
	var info = $("#userInformation input");
	for(var i = 0; i < info.length; i++){
		val = $(info[i]).val();
		if(val === undefined | val === ""){
			alert("Please answer to all the personnal questions. ");
			return null;
		}
		personnalInfo[info[i].name] = val;
	}

	var shortcut = $(".shortcut");
	for(var i = 0; i < info.length; i++){
		n = shortcut[i].name;
		val = $("input[name="+n+"]:checked").val();
		if(val === undefined | val === ""){
			alert("Please answer to all the questions. ");
			return null;
		}
		answers[n] = val;
	}
	var textarea = $("textarea");
		
	for(var i = 0; i < textarea.length; i++){
		val = $(textarea[i]).val();
		if(val === undefined | val === ""){
			alert("Please answer to all the questions. aaa ");
			return null;
		}
		answers[textarea[i].name] = val;
	}
	console.log(answers);
	console.log(answers.length);
}

function send(f, a, pi) {
	$.post(
		"index.php", // url
		{
			"action":"completeForm",
			"controller":"form",
			"form":JSON.stringify(f),
			"answers":JSON.stringify(a),
			"visitorInfo":JSON.stringify(pi)
		},  //data
		function(res){ //callback
				console.log("Le resultat = "+res);
					//res is supposed to send the id of the form
					//We need this form ID to save the image
				if(res !== false){
						$("#submit").unbind("click", extractAnswers);
						//setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);					
				}else{
					console.log("Error when saving the answers");
				}
			},
		"json" // type
	);
}




function init(){
	
	$("#submit").click(extractAnswers);
}


$(init);