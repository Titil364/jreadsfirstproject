/**
 * \author Cyril Govin
 * \brief Extract all the personnal information entered by the user and put it in the "info" tab. 
	
	If a custom information (field) is empty, the function ignore it. 
 */

function extractInformation(){
	//!< Collecting the checked default information
	var predef = $(".defaultInformation:checked");
	var info = [];
	for(var i = 0; i < predef.length; i++){
		info.push(predef[i].id);
		}
	
	//!< Collection the custom information
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



/**
 * \author Cyril Govin
 * \brief Extract the form datas, applications datas and questions datas of the page. 
	
	If a field is empty (name of form for example), the extraction is cancelled and an alert popped out. 
 */
function extractData(){
	//!< Liste of application in the form
	var formName = $("#formName").val();
	if(formName.trim() === ""){
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
		
		var applicationDesc = $("#"+id+"Desc").val();
		
		var applicationImg = id+"Img";
		
		a.push(new Application(id, applicationName, applicationDesc, applicationImg));
		qPre.push([]);
		qPost.push([]);
		
		
		if(applicationName.trim() === "" | (applicationDesc.trim() === "" & $("#"+applicationImg).val() === "")){
			alert("At least one application is not fully completed. Please check and add a description or image and a title. ");
			return null;
		}
		var questionsPre =  $("#"+id+" > .questionPreDiv > .questionPre");
		for(var y = 0; y < questionsPre.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			
			var idQ = questionsPre[y].id;

			var qPreLabel = $("#"+idQ+"Name").val();
			if (qPreLabel.trim() === "") {
                alert("At least one question has no name. Please check and add a name or delete the question");
				return null;
			}
			
			var qPreType = $("#"+idQ+" select").val();
			
			var customAns = null;

			if ($("#checkbox"+idQ).is(":checked")){

				customAns = [];
				var title = $("#titlecheckbox"+idQ)[0].value;
				console.log(title+"title");
				if(title.trim() === ""){
					alert("At least one custom title is empty. ");
					return null;
				}
				if($("#msgcheckbox"+idQ)[0].style.color === "red"){
					alert("At least one custom title is already taken. ");
					return null;
				}
				customAns.push(title);


				var fieldList = $(".fieldcheckbox"+idQ);
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
					if(fieldList[j].value.trim() === ""){	
						alert("At least one custom answers is empty");
						return null;
					}
				}

			}


			qPre[i].push(new Question(idQ, qPreLabel, qType[qPreType], 1, customAns));
		}
		var questionsPost = $("#"+id+" > .questionPostDiv > .questionPost");
		for(var y = 0; y < questionsPost.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questionsPost[y].id;
			//console.log(idQ);
			var qPostLabel = $("#"+idQ+"Name").val();
			console.log(idQ);
			console.log(qPostLabel);
			if (qPostLabel === "") {
                alert("At least one question has no name. Please check and add a name or delete the question");
				return null;
			}
			//console.log(qPostLabel);
			var qPostType = $("#"+idQ+" select").val();

			var customAns = null;

			if ($("#checkbox"+idQ).is(":checked")){

				customAns = [];
				var title = $("#titlecheckbox"+idQ).value;
				if(title.trim() === ""){
					alert("At least one custom title is empty. ");
					return null;
				}
				
				if($("#msgcheckbox"+idQ)[0].style.color === "red"){
					alert("At least one custom title is already taken. ");
					return null;
				}
				customAns.push(title);

				var fieldList = $(".fieldcheckbox"+idQ);
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
					if(fieldList[j].value.trim() === ""){	
						alert("At least one custom answers is empty");
						return null;
					}
				}

			}
			
			
			qPost[i].push(new Question(idQ, qPostLabel, qType[qPostType], 0, customAns));
		}
	 }

	//!< Collecting the personnal information and the fs questions
	var info = extractInformation();
	var fs = extractFSQuestions();
	//!< Sending all the information to the php script 
	send(formName, a, qPre, qPost, info, fs);
}

/**
 * \author Cyril Govin
 * \brief JSON Send the datas (form, applications, pre questions, post questions, informations and FSQuestions to the php script
	
	If the save succeeds, the image files are sent to an other php script to be saved in the server. 
	If all saves succeed, a confirmation alert pops and the user is redirected
 * \param f A form object defined in objects.js
 * \param a An array of application object defined in objects.js
 * \param qPre An array of questions object defined in objects.js
 * \param qPost An array of questions object defined in objects.js
 * \param i An array of information object defined in objects.js
 * \param fs An array of FS Question object defined in objects.js
 */

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


/**
 * \brief Initilize the page. 
	
 * Required event are set up and an application is added. 
 */
function init(){
	//Adding one application
	addApplication();
	$("#submit").click(extractData);

}

$(init);