function extractInformation(){
	var predef = $(".defaultInformation:checked");
	var info = [];
	for(var i = 0; i < predef.length; i++){
		info.push(predef[i].id);
	}
	var custom = $(".fieldInput");
	for(var i = 0; i < custom.length; i++){
		if($(custom[i]).val() === "" ){
			
		}else{
			info.push($(custom[i]).val());			
		}
	}
	console.log("extractInfoDone");
	return (info.length == 0? false : info);
}

function extractFSQuestions(){
	var predefs = $(".defaultFSQuestion:checked");
	var FSQuestions = [];
	for (var i = 0; i < predefs.length; i++) {
		FSQuestions.push(predefs[i].id);
    }
	var customFS = $(".FSQuestionCustom");
	for (var i = 0; i<customFS.length; i++){	
		var left = $($(".questionInputLeft")[i]).val();
		var right = $($(".questionInputRight")[i]).val();
		if (left==="" |right==="") {
        }else{
			var FSQuestionName =left+"/"+right;
			FSQuestions.push(FSQuestionName);
			if (FSQuestionName.length>50) {
                alert("trop grand");
				return null;
            }
		}
	}
	console.log("extractFSdone");
	return (FSQuestions.length == 0? false : FSQuestions);
}




function extractData(){
	//Liste of application in the form
	var formName = $("#formName").val();
	if(formName === ""){
		alert("Please enter the name of the form. ");
		return null;
	}
	var applications = $(".application");
	
	var a = [];
	var qPre = [];
	var qPost = [];
		
	for(var i = 0; i < applications.length; i++){
		var id = applications[i].id;
		var applicationName = $("#"+id+"Name").val();
		//console.log("Task : "+applicationName);
		var applicationDesc = $("#"+id+"Desc").val();
		//console.log("Description : "+applicationDesc);
		var applicationImg = id+"Img";
		//console.log("Image : "+applicationImg);
		a.push(new Application(id, applicationName, applicationDesc, applicationImg));
		qPre.push([]);
		qPost.push([]);
		//console.log("desc "+applicationDesc);
		//console.log("img "+applicationImg);
		
		if(applicationName === "" | (applicationDesc === "" & $("#"+applicationImg).val() === "")){
			alert("At least one application is not fully completed. Please check and add a description or image and a title. ");
			return null;
		}
		var questionsPre =  $("#"+id+" > .questionPreDiv > .questionPre");
		for(var y = 0; y < questionsPre.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			
			var idQ = questionsPre[y].id;

			var qPreLabel = $("#"+idQ+"name").val();
			if (qPreLabel === "") {
                alert("At least one question has no name. Please check and add a name or delete the question");
				return null;
			}
			//console.log("label pre = "+qPreLabel);
			var qPreType = $("#"+idQ+" select").val();
			//console.log(qType);
			
			var customAns = null;

			if ($("#checkbox"+idQ).is(":checked")){

				customAns = [];
				var title = $("#titlecheckbox"+idQ)[0].value;
				customAns.push(title);


				var fieldList = $(".fieldcheckbox"+idQ);
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
				}

			}


			qPre[i].push(new Question(idQ, qPreLabel, qType[qPreType], 1, customAns));


		}
		var questionsPost = $("#"+id+" > .questionPostDiv > .questionPost");
		for(var y = 0; y < questionsPost.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questionsPost[y].id;
			//console.log(idQ);
			var qPostLabel = $("#"+idQ+"name").val();
			if (qPostLabel === "") {
                alert("At least one question has no name. Please check and add a name or delete the question");
				return null;
			}
			//console.log(qPostLabel);
			var qPostType = $("#"+idQ+" select").val();

			var customAns = null;

			if ($("#checkbox"+idQ).is(":checked")){

				customAns = [];
				var title = $("#titlecheckbox"+idQ)[0].value;
				customAns.push(title);

				var fieldList = $(".fieldcheckbox"+idQ);
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
				}

			}
			//console.log(qType);
			
			qPost[i].push(new Question(idQ, qPostLabel, qType[qPostType], 0, customAns));
		}


	}

	////verification  of cutomField answers
	var allCustomfields = $(".answerArea input");
	for (var customFieldsCount = 0; customFieldsCount < allCustomfields.length; customFieldsCount++ ){
		if (allCustomfields[customFieldsCount].value == ""){
			alert("At least one custom answers is empty");
			return null;
		}
	}


	///// verification of customFielState
	
	for (var appCpt = 0; appCpt < customTitleState.length; appCpt ++){
		for (var prePostCpt = 0; prePostCpt < customTitleState[appCpt].length; prePostCpt++){
			for (var questCpt = 0; questCpt < customTitleState[appCpt][prePostCpt].length; questCpt ++ ){
				if (customTitleState[appCpt][prePostCpt][questCpt] == -1){
					alert("at least one customFieldTitle is incorrect");
					return null;
				} 
			}
		}
	}

	var info = extractInformation();
	var fs = extractFSQuestions();
	send(formName, a, qPre, qPost, info, fs);
}


function send(f, a, qPre, qPost, i, fs) {

	//console.log(JSON.stringify(a));
	//console.log(JSON.stringify(q));
	//normalement les données seront envoyés en post
	$.post(
		"index.php", // url
		{
			"action":"created",
			"controller":"form",
			"form":JSON.stringify(f),
			"applications":JSON.stringify(a),
			"questionsPre":JSON.stringify(qPre),
			"questionsPost":JSON.stringify(qPost),
			"information":JSON.stringify(i),
			"FSQuestions":JSON.stringify(fs)
		},  //data
		function(res){ //callback
				console.log("Le resultat = "+res);
					//res is supposed to send the id of the form
					//We need this form ID to save the image
				if(res !== false){
					var re = /(?:\.([^.]+))?$/;
					var ext = "";
					for(var i = 0; i < a.length; i++){
						var name = a[i]['img'];

						var file_data = $("#"+name).prop("files")[0];
		
						if(file_data !== undefined){
							ext = re.exec(file_data.name)[1];
							var form_data = new FormData();

							form_data.append("file", file_data, res+name+"."+ext);
								$.ajax({
									url: "index.php?controller=application&action=saveImg",
									cache: false,
									contentType: false,
									processData: false,
									data: form_data,                  
									type: 'post',
									success: function(result){
											  //console.log(result);
											},
									error: function(){
											  console.log("Error while downloading the file. ");
									}   
								});  
						}
					}
					alert("The form has been successfully registered ! (You will be redirected)");
					$("#submit").unbind("click", extractData);
					setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);
					
				}else{
					console.log("Error when saving the form. ");
				}
			},
		"json" // type
	);
	//alert("done");
}

function saveQuestion(event) {
    var questions = $(".question");
	for(i = 0; i<questions.length;i++){
		var left = questions[i].getElementsByClassName("questionInputLeft")[0];
		var right = questions[i].getElementsByClassName("questionInputRight")[0];
		if (left.value==="" || right.value==="") {
            alert("A question is empty, fill it or delete it.");
        } else {
			console.log("Question " +i +" left : "+left.value);
			console.log("Question " +i +" right : "+right.value);
		}
	}
}



function init(){
	//Adding one application
	addApplication();
	$("#submit").click(extractData);

}


$(init);