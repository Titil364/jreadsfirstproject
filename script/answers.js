
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
		personnalInfo.push(new Information(info[i].name, val));
	}

	var shortcut = $(".shortcut");
	for(var i = 0; i < shortcut.length; i++){
		n = shortcut[i].name;
		val = $("input[name="+n+"]:checked").val();
		if(val === undefined | val === ""){
			alert("Please answer to all the questions. ");
			return null;
		}
		answers.push(new Answer(n, val));
	}
	var textarea = $("textarea");
		
	for(var i = 0; i < textarea.length; i++){
		val = $(textarea[i]).val();
		if(val === undefined | val === ""){
			alert("Please answer to all the questions. aaa ");
			return null;
		}
		answers.push(new Answer(textarea[i].name, val));
	}
	
	var f = $("div[id^=form]")[0].id.split("-")[1];
	send(f, personnalInfo, answers);
}

function send(f, pi, a){

	$.post(
		"index.php", // url
		{
			"action":"completeForm",
			"controller":"form",
			"formId":f,
			"visitorInfo":JSON.stringify(pi),
			"answers":JSON.stringify(a)
		},  //data
		function(res){ //callback
				console.log("Le resultat = "+res);
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