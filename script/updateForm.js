
persoInfoToDelete = []; //!< The personnal information that need to be deleted to the form
FSToDelete = []; //!<  The FS questions that need to be deleted to the form. 
deletedObject = []; //!< This array can be used to cancel a deletion. Add a couple [parent, child] to make it works. 

/**
 * \author Alexandre Comas
 * \brief Get the id of the form. 
	Adapted by Cyril Govin
 * \return The id of the form
 */
function getFormId(){
    var f = document.getElementsByClassName("formCss");
    return f[0].getAttribute("id");
}
/**
 * \author Cyril Govin
 * \brief Delete a custom personnal information to the form and add it to the persoInfoToDelete tab. 
	
 * \param self The remove button
 */
function deletePersonnalInformation(self){
	var parent = self.currentTarget.parentNode;
	persoInfo = $(parent).find("input").val();

	//!< remove
	$(parent).remove();
	persoInfoToDelete.push(persoInfo);

}
/**
 * \author Cyril Govin
 * \brief Delete a custom FQ Question to the form and add it to the persoInfoToDelete tab. 
	
	
 * \param self The remove button
 */
function deleteFSQuestion(self){	
	var parent = self.currentTarget.parentNode;
	var input = $(parent).find("input");
	var name = $(input[0]).val() + "/" + $(input[2]).val();
	FSToDelete.push(name);
	//!< remove
	$(parent).remove();
}

/**
 * \author Cyril Govin
 * \brief Delete an element from his parent. 
	
	
 * \param self The remove button
 */
function removeMe(self){
	var parent = self.currentTarget.parentNode;
	$(parent).remove();
}


function toDelete(self, tab){
	var parent = self.currentTarget.parentNode;
	var elem = $(parent).find("input");
	var info = elem[0].id;
	
	if($(elem).is(":checked")){
		var index = persoInfoToDelete.indexOf(info);
		if(index > -1)
			tab.splice(index, 1);		
	}else{
		tab.push(info);
	}
}

/**
 * \author Cyril Govin
 * \brief Count the number of current applications and return it. 
	
 * \return nb The number of applications
 */
function countApplications(){
	var nb = $(".application").length;
	for(var i = 0; i < nb; i++){
		customTitleState.push([ [] , [] ]);
	}
	return nb;
}
/**
 * \author Cyril Govin
 * \brief Add an application to the form. 
	
	The id created so that we don"t need to manage it in the php script. 
 * \param event The event when the user clicks on the add button. 
 */
function addApplication(event){
	//!< Recovery of the container
	var form = document.getElementById("newForm");
	
	var applicationParent = document.getElementById("applications");
	
	//!< Name of the application
	var applicationName = getFormId()+"Applic"+nbApplication;
	
	//!< Creation of the application wrapper
	var application = document.createElement("div");
		application.setAttribute("class", "application newApplication");
		application.setAttribute("id", applicationName);
		applicationParent.appendChild(application);
	
	//!< Creation of the childs
	
	var applicationInformationWrapper = document.createElement("div");
		applicationInformationWrapper.setAttribute("id", applicationName+"Info");
	application.appendChild(applicationInformationWrapper);
	
	var imgDisplayer = document.createElement("img");
		imgDisplayer.setAttribute("class","imgDisplayer");
	applicationInformationWrapper.appendChild(imgDisplayer);
	
		//!< The label of the application's name
	var nameWrapper = document.createElement("div");
	nameWrapper.setAttribute('class','appCreationTitle')
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", applicationName+"Name");
			applicationNameLabel.innerHTML ="Name of the application : ";
			nameWrapper.appendChild(applicationNameLabel);
			//!< The input of the application's name
		var inputApplicationName = document.createElement("input");
			inputApplicationName.type = "text";
			inputApplicationName.id = applicationName+"Name";
			inputApplicationName.name = applicationName+"Name";
			inputApplicationName.placeholder="Application's Title";
			nameWrapper.appendChild(inputApplicationName);
			
		//!< Creation of the remove application button
		var removeApplicationButton = document.createElement("button");
			removeApplicationButton.setAttribute("class", "removeButton");
			removeApplicationButton.type="button";
			removeApplicationButton.value= "Remove the application";
			removeApplicationButton.innerHTML ="Remove the application";
			nameWrapper.appendChild(removeApplicationButton);
			//!< Add the event for removing the application
			removeApplicationButton.addEventListener("click", function(event){
				removeMe(event, application);
			});
	applicationInformationWrapper.appendChild(nameWrapper);

		
	
	//!< Adding the description field for the application
	var descWrapper = document.createElement("div");
		var applicationDescLabel = document.createElement("label");
			applicationDescLabel.setAttribute("for", applicationName+"Desc");
			applicationDescLabel.innerHTML ="Describe your application : ";
			descWrapper.appendChild(applicationDescLabel);
			//!< Adding the textarea section
		var inputApplicationDesc = document.createElement("textArea");
			inputApplicationDesc.type = "text";
			inputApplicationDesc.id = applicationName+"Desc";
			inputApplicationDesc.name = applicationName+"Desc";
			inputApplicationDesc.placeholder="Describe me";
			descWrapper.appendChild(inputApplicationDesc);
	applicationInformationWrapper.appendChild(descWrapper);	
	
	//!< Adding the img downloading field for the application
	var imgWrapper = document.createElement("div");
		var applicationImg = document.createElement("label");
			applicationImg.setAttribute("for", applicationName+"Img");
			applicationImg.innerHTML ="Image of the application : ";
			imgWrapper.appendChild(applicationImg);
			//!< The input of the application's name
		var inputApplicationImg = document.createElement("input");
			inputApplicationImg.type = "file";
			inputApplicationImg.id = applicationName+"Img";
			inputApplicationImg.name = applicationName+"Img";
			inputApplicationImg.accept = "image/*";
			
			$(inputApplicationImg).change(function(event){
 				displayImage(this, imgDisplayer, applicationName);
				});
 			$(inputApplicationImg).click(function(event){
 				noSelection(this, imgDisplayer);
				});
			imgWrapper.appendChild(inputApplicationImg);
	applicationInformationWrapper.appendChild(imgWrapper);	
	
	
	//!< Creation of the add question button
	var wrapQuestionPre = document.createElement("div");
		wrapQuestionPre.setAttribute("class", "questionPreDiv");
	var titlePre = document.createElement('h3');
	titlePre.innerHTML="Pre questions :";
	wrapQuestionPre.appendChild(titlePre);
	var buttonQuestion = document.createElement("button");
		buttonQuestion.setAttribute("class", "addQuestionButton");
		buttonQuestion.type = "button";
		buttonQuestion.value = "Add Pre Question";
		buttonQuestion.innerHTML = "Add a Pre question";
		wrapQuestionPre.appendChild(buttonQuestion);
		application.appendChild(wrapQuestionPre);
		
	
	var wrapQuestionPost = document.createElement("div");
		wrapQuestionPost.setAttribute("class", "questionPostDiv");
	var titlePost = document.createElement('h3');
	titlePost.innerHTML="Post questions :";
	wrapQuestionPost.appendChild(titlePost);
	var buttonQuestionPost = document.createElement("button");
		buttonQuestionPost.setAttribute("class", "addQuestionButton");
		buttonQuestionPost.type = "button";
		buttonQuestionPost.value = "Add Post Question";
		buttonQuestionPost.innerHTML = "Add a Post question";
		wrapQuestionPost.appendChild(buttonQuestionPost);
		application.appendChild(wrapQuestionPost);
		
		    
		//!< Add the event for adding the question
			buttonQuestion.addEventListener("click", function(event){
				addQuestion(event, wrapQuestionPre, "pre");
			});
		//!< Add the event for adding the question
			buttonQuestionPost.addEventListener("click", function(event){
				addQuestion(event, wrapQuestionPost, "post");
			});
	
	nbApplication++;

	customTitleState.push([ [] , [] ]); //!<  1st : pre quest of app, 2 nde post quest
}

/**
* [Form Creation] Add a pre question to the DOM
*@param event the event
*@param parent the parent application
*/
function addQuestion(event, parent, preOrPost) {
    //!< console.log(button);
	//!< console.log(button.parentElement);
	
	var p = preOrPost;
	var P = preOrPost.capitalizeFirstLetter();
	//!< Recovery of the application associated with the question (button's parent)
		//!< the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		//!< 
	var nbQuestions = application.children.length-1;
	
	var questionName = application.parentNode.id+"Q"+nbQuestions;

	var applicNumber = application.parentNode.id.split("Applic")[1];
	customTitleState[applicNumber][0].push(0);
	
	//!< Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName+p);
	qWrapper.setAttribute("class", "question"+P+" new"+P+"Question");
	application.appendChild(qWrapper);
	
	//!< Creation of the childs
		
		//!< The label of the question
	var questionInfoWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", questionName+"Name");
			applicationNameLabel.innerHTML ="Question "+P+" n°"+nbQuestions+" : ";
			questionInfoWrapper.appendChild(applicationNameLabel);
			
			
			//!< The input of the application's name
		var inputQuestion = document.createElement("input");
			inputQuestion.type = "text";
			inputQuestion.id= questionName+p+"Name";
			inputQuestion.name= questionName+"Name";
			inputQuestion.placeholder="Do you like carrots ?";
			questionInfoWrapper.appendChild(inputQuestion);	
			
			
			//!< Creation of the remove question button
		var removeQButton = document.createElement("button");
			removeQButton.setAttribute("class", "removeButton");
			removeQButton.type="button";
			removeQButton.value= "Remove the question";
			removeQButton.innerHTML ="Remove the question";
			questionInfoWrapper.appendChild(removeQButton);
			
			//!< Add the event for removing the application
				removeQButton.addEventListener("click", removeQuestion);
	qWrapper.appendChild(questionInfoWrapper);
			
	//!< Add evalutation choices
	
	
		//!< Add a choice wrapper
		var cWrapper  = document.createElement("select");
			questionInfoWrapper.appendChild(cWrapper);

		
		for(var name in placeholders){
			var option = document.createElement('option');
				option.setAttribute('required', 'required');
				option.setAttribute('value', name);
				option.setAttribute('id', name+questionName);
				option.innerHTML = name;
				cWrapper.appendChild(option); 
		}
		

		//!< Add the answer area (ex : the area where the smileys will be displayed)
		var answerArea = document.createElement("div");
			answerArea.setAttribute("class","answerArea");
			qWrapper.appendChild(answerArea);

			//!< add listener on radio changement
			$(cWrapper).bind("change", answers);
		$(cWrapper).trigger("change");
}

/**
 * \author Cyril Govin
 * \brief Add all the events needed. 
	
 */
function addEventDelete(){
	$(document).on("click",".removeButtonAECustom", deletePersonnalInformation);

	$(document).on("click",".removeButtonAE", removeMe);
	$(document).on("click",".removeButtonFS", deleteFSQuestion);
	
	$(document).on("change",".defaultInformationAlreadyChecked", function(self){
		toDelete(self, persoInfoToDelete)
	});

	$(document).on("change",".defaultFSQuestionAlreadyChecked", function(self){
		toDelete(self, FSToDelete)
	});
	
	
	
	
	//<<focusin>> save the previous value
	//<<change>> check if the value are different and delete the link between the form and the personnal information
	$(document).on('focusin', '.fieldInputCustom', function(){
		//!< console.log("Saving value " + $(this).val());
		$(this).data('val', $(this).val());
	}).on('change','.fieldInputCustom', function(){
		var prev = $(this).data('val');
		var current = $(this).val();
		
		persoInfoToDelete.push(prev);
		
		$(this).switchClass("fieldInputCustom", "fieldInput");
		
		var parent = this.parentNode;
		$(parent).find("button").switchClass("removeButtonAECustom", "removeButtonAE");
		
		//!< console.log("Prev value " + prev);
		//!< console.log("New value " + current);
	});
	
	//<<focusin>> save the previous value
	//<<change>> check if the value are different and delete the link between the form and the personnal information
	$(document).on('focusin', '.questionInputLeftCustom, .questionInputRightCustom', function(){
		//!< console.log("Saving value " + $(this).val());
		$(this).data('val', $(this).val());
	}).on('change','.questionInputLeftCustom, .questionInputRightCustom', function(){
		var prev = $(this).data('val');
		var current = $(this).val();
		
		
		var parent = this.parentNode.parentNode.parentNode.parentNode.parentNode;
		//!< console.log(parent);
		var input = $(parent).find("input");
		
		
		$(input[0]).switchClass("questionInputLeftCustom", "questionInputLeft");
		$(input[2]).switchClass("questionInputRightCustom", "questionInputRight");

		if(this.className === "questionInputLeft"){
			var name = prev + "/" + $(input[2]).val();
			FSToDelete.push(name);
		}else{
			var name =  $(input[0]).val()+ "/" + prev;
			FSToDelete.push(name);
		}
		
		$(parent).find("button").switchClass("removeButtonFS", "removeButton");
	});
	
	//!< Div answer event 
	
	$(document).on('change', "select", answers);
	//!< remove application event
	$(document).on('click', ".appCreationTitle .removeButton", removeApplication);
	//!< remove question event
	$(document).on("click", ".questionPre .removeButton, .questionPost .removeButton", removeQuestion);
	
	$(document).on("click", ".questionPreDiv .addQuestionButton", function(event){
		var button = event.currentTarget;
		addQuestion(null, button.parentNode, "pre");
	});	
	$(document).on("click", ".questionPostDiv .addQuestionButton", function(event){
		var button = event.currentTarget;
		addQuestion(null, button.parentNode, "post");
	});
	$(document).on("click", ".removeImage", removeImage);
}

/**
 * \author Cyril Govin
 * \brief Change the src of the imgDisplayer to "" for removing the image. 
	
	
 * \param event The event when the user clicks on the removeImage button
 */
function removeImage(event){
	if(confirm("Are you sure you want to the image of the application ?")){
		var button = event.currentTarget;
		var application = button.parentNode.parentNode;
		$(application).find(".imgDisplayer")[0].src = "";
		//$(application).find(".imgDisplayer")[0].className = "imgDisplayer";
	}
}

/**
 * \author Cyril Govin
 * \brief Remove an application 
	
	Ask if you are sure to remove the application before deleting it if not empty (application name and number of pre and post questions). 
	Automaticly refresh the id of the application. 
	The parent and the application are added to the deletedObject tab. 
	This function is triggered when clicking on the "Remove application" button. 
 * \param self The remove button
 */
function removeApplication(button){

	var application = button.currentTarget.parentNode.parentNode.parentNode;
	var inputName = $("#"+application.id+"Name").val();
	var nbQPre = $("#"+application.id+" .questionPre").length;
	var nbQPost = $("#"+application.id+" .questionPost").length;
	

	if(!(inputName==="") || nbQPre > 0 || nbQPost > 0){
			if(confirm("Are you sure you want to delete this application ? \nIt will delete all the questions included in the application.")){
				nbApplication--;
				deletedObject.push([application.parentNode, application]);
				$(application).remove();
				refreshApplication();
			}	
	}else{
		deletedObject.push([application.parentNode, application]);
		$(application).remove();
		refreshApplication();
	}
}
/**
 * \author Cyril Govin
 * \brief Remove a question  
	
	Ask if you are sure to remove the question before deleting it if not empty. 
	Automaticly refresh the id of all the questions of the parent application. 
	The parent and the question are added to the deletedObject tab. 
	This function is triggered when clicking on the "Remove question" button. 
 * \param button The event when clicking on the remove button
 */
function removeQuestion(button){
	var question = button.currentTarget.parentNode.parentNode;
	var inputName = $("#"+question.id+"Name").val();
	var application = question.parentNode.parentNode; 
	if(!(inputName=="") && (inputName !== undefined)){
		if(confirm("Are you sure you want to delete this question ?")){
				deletedObject.push([question.parentNode, question]);
				$(question).remove();
				refreshQuestion(application);
			}	
	}else{
		deletedObject.push(question.parentNode, question);
		$(question).remove();
		refreshQuestion(application);
	}
	console.log(question);
}


/** \author Cyril Govin
  *	\brief Append to the parent the child 
	The feature hasn't been implemented in the user interface but the function associated is working. 
	Pop the last element in the deletedObject and add it to his parent. The previous position is not kept. 
 */
function cancelDeletion(){
	if(deletedObject.length > 0){
		var tab = deletedObject.pop();
		var parent = tab[0], child = tab[1];
		parent.appendChild(child);
		refreshApplication();
	}
}
/**
 * \author Cyril Govin
 * \brief Extract all the datas of the form for saving the modifications. 
 */
function extractData(){
	var formName = $("#formName").val();
	if(formName === ""){
		alert("Please enter the name of the form. ");
		return null;
	}
	form = new Form(getFormId(), formName, null);
	var applications = $(".application"), a=[], pre = [], post = [], q=[];
	
	for(var i = 0; i < applications.length; i++){
		var applic = applications[i];
		var id = applic.id;
		var name = $("#"+id+"Name").val();
		if(name === undefined || name == ""){
			console.log("Please name your application");
			return null;
		}
		var desc = $("#"+id+"Desc").val();
		var img = $("#"+id+"Img").val();
		if(img === "" && $("#"+id+" .displayed").length > 0){
			//!< false -> to delete
			img = ($("#"+id+" .displayed").attr("src") != "" ?id+"Img":"ToDelete");
		}else{
			img = id+"Img";
		}
		
		if(desc === "" && img === ""){
			console.log("Please put an application description or an application image. ");
			//!< return null;
		}
		a.push(new Application(id, name, desc, img));
		
		pre = $(applic).find(".questionPre");

		for(var y = 0; y < pre.length; y++){
			qId = pre[y].id;
			qLabel = $("#"+qId+"Name").val();
			qqType = $(pre[y]).find("select").val();
			qPre = 1;

			var customAns = null;

			if ($("#checkbox"+qId).is(":checked")){ //!< if is custom question

				customAns = [];	//!< defining an array
				var title = $("#titlecheckbox"+qId)[0].value; //!< first value  = custom questionType title
				if(title.trim() === ""){
					alert("At least one custom title is empty. ");
					return null;
				}
				
				if($("#msgcheckbox"+idQ)[0].style.color === "red"){
					alert("At least one custom title is already taken. ");
					return null;
				}
				customAns.push(title);


				var fieldList = $(".fieldcheckbox"+qId); //!< next are the fields by order 
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
					if(fieldList[j].value.trim() === ""){	
						alert("At least one custom answers is empty");
						return null;
					}
				}
			}
			
			q.push(new Question(qId, qLabel, qType[qqType], qPre, customAns, id));
		}		
		post = $(applic).find(".questionPost");
		for(var y = 0; y < 	post.length; y++){
			qId = post[y].id;
			qLabel = $("#"+qId+"Name").val();
			qqType = $(post[y]).find("select").val();
			qPre = 0;

			var customAns = null;

			if ($("#checkbox"+qId).is(":checked")){ //!< if is custom question

				customAns = [];	//!< defining an array
				var title = $("#titlecheckbox"+qId)[0].value; //!< first value  = custom questionType title
				if(title.trim() === ""){
					alert("At least one custom title is empty. ");
					return null;
				}	
				
				if($("#msgcheckbox"+idQ)[0].style.color === "red"){
					alert("At least one custom title is already taken. ");
					return null;
				}
				
				customAns.push(title);


				var fieldList = $(".fieldcheckbox"+qId); //!< next are the fields by order 
				for(var j = 0; j<fieldList.length; j++){
					customAns.push(fieldList[j].value);
					if(fieldList[j].value.trim() === ""){	
						alert("At least one custom answers is empty");
						return null;
					}
				}

			}
			q.push(new Question(qId, qLabel, qType[qqType], qPre, customAns, id));
		}
	}
	//!< 	console.log(a);
	//!< 	console.log(q);
		
	var pi = extractPersonnalInfo(), fs = extractFSQuestion();
	send(form, a, q, pi, fs);
}
/**
 * \author Cyril Govin
 * \brief Extract the FS questions
 * \return fs An array containing FSQ object defined in objects.js
 */
function extractFSQuestion(){
	var fs = [], def = $("input.defaultFSQuestion:checked");
	
	//!< Pushing the defautFSQuestion not already checked in the list
	for(var i = 0; i < def.length; i++){
		fs.push(new FSQ(def[i].id, 1));
	}
	
	//!< Pushing the FSQuestions that have been created
	def = $(".FSQuestionCustom");
	for(var i = 0; i < def.length; i++){
		if($(def[i]).find(".questionInputLeft").length > 0){
			var name = $(def[i]).find(".questionInputLeft").val() + "/" + $(def[i]).find(".questionInputRight").val()
			fs.push(new FSQ(name, 0));		
		}
	}
	return fs;
}
/**
 * \author Cyril Govin
 * \brief Extract the personnal information
 * \return pInfo An array containing string
 */
function extractPersonnalInfo(){
	var pInfo = [], def = $("input.defaultInformation:checked");
	
	//!< Pushing the defaut personnal information not already checked in the list
	for(var i = 0; i < def.length; i++){
		pInfo.push(def[i].id);
	}
	def = $(".fieldInput");
	for(var i = 0; i < def.length; i++){
		pInfo.push($(def[i]).val());
	}	
	
	return pInfo;
}
/**
 * \author Cyril Govin
 * \brief JSON Send the datas (form, applications, questions (pre and post), informations and FSQuestions to the php script for updating the form
	
	If the save succeeds, the image files are sent to an other php script to be saved in the server. 
	If all saves succeed, a confirmation alert pops and the user is redirected
 * \param f A form object defined in objects.js
 * \param a An array of application objects defined in objects.js
 * \param q An array of question objects defined in objects.js (the questions mixed pre and post objects)
 * \param i An array of information objects defined in objects.js
 * \param fs An array of FS Question objects defined in objects.js
 */

function send(form, a, q, pInfo, fs){	
	$.post(
		"index.php", //!<  url
		{
			"action":"updated",
			"controller":"form",
			"form":JSON.stringify(form),
			"applications":JSON.stringify(a),
			"questions":JSON.stringify(q),
			"information":JSON.stringify(pInfo),
			"FSQuestions":JSON.stringify(fs),
			"informationToDelete": JSON.stringify(persoInfoToDelete),
			"fsToDelete": JSON.stringify(FSToDelete)
		},  //!< data
		function(res){ //!< callback
				console.log("Le resultat = "+res);
					//!< res is supposed to send the id of the form
					//!< We need this form ID to save the image
				if(res !== false){
					var re = /(?:\.([^.]+))?$/;
					var ext = "";
					for(var i = 0; i < a.length; i++){
						var name = a[i]['img'];
						
						if(name !== "NotDelete")
							var file_data = $("#"+name).prop("files")[0];
						else
							var file_data = undefined;
						console.log(file_data);
						if(file_data !== undefined){
							ext = re.exec(file_data.name)[1];
							var form_data = new FormData();

							form_data.append("file", file_data, name+"."+ext);
								$.ajax({
									url: "index.php?controller=application&action=saveImg&formId="+form['id'],
									cache: false,
									contentType: false,
									processData: false,
									data: form_data,                  
									type: 'post',
									success: function(result){
											  //!< console.log(result);
											},
									error: function(){
											  console.log("Error while downloading the file. ");
									}   
								});  
						}
					}
					alert("The form has been successfully registered ! (You will be redirected)");
					//$("#submit").unbind("click", extractData);
					//!< setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);
					
				}else{
					console.log("Error when saving the form. ");
				}
			},
		"json" //!<  type
	);
}

function init2(){
	addEventDelete();
	nbApplication = countApplications();
	$("#submit").click(extractData);
}


$(init2);
