var b = document.body;
var nbApplication = 0;
var placeholders;
var predefInformation;
var fsquestions;

function addApplication(event){
	//Recovery of the container
	var form = document.getElementById("newForm");
	
	var applicationParent = document.getElementById("applications");
	
	//Name of the application
	var applicationName = "Applic"+nbApplication;
	
	//Creation of the application wrapper
	var application = document.createElement("div");
		application.setAttribute("class", "application");
		application.setAttribute("id", applicationName);
		applicationParent.appendChild(application);
	
	//Creation of the childs
	
	var applicationInformationWrapper = document.createElement("div");
		applicationInformationWrapper.setAttribute("id", applicationName+"Info");
	application.appendChild(applicationInformationWrapper);
	
	var imgDisplayer = document.createElement("img");
		imgDisplayer.setAttribute("class","imgDisplayer");
	applicationInformationWrapper.appendChild(imgDisplayer);
	
		//The label of the application's name
	var nameWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", applicationName+"Name");
			applicationNameLabel.innerHTML ="Name of the application : ";
			nameWrapper.appendChild(applicationNameLabel);
			//The input of the application's name
		var inputApplicationName = document.createElement("input");
			inputApplicationName.type = "text";
			inputApplicationName.id = applicationName+"Name";
			inputApplicationName.name = applicationName+"Name";
			inputApplicationName.placeholder="Application's Title";
			nameWrapper.appendChild(inputApplicationName);
			
		//Creation of the remove application button
		var removeApplicationButton = document.createElement("button");
			removeApplicationButton.setAttribute("class", "removeButton");
			removeApplicationButton.type="button";
			removeApplicationButton.value= "Remove the application";
			removeApplicationButton.innerHTML ="Remove the application";
			nameWrapper.appendChild(removeApplicationButton);
			//Add the event for removing the application
			removeApplicationButton.addEventListener("click", function(event){
				removeMe(event, application);
			});
	applicationInformationWrapper.appendChild(nameWrapper);

		
	
	//Adding the description field for the application
	var descWrapper = document.createElement("div");
		var applicationDescLabel = document.createElement("label");
			applicationDescLabel.setAttribute("for", applicationName+"Desc");
			applicationDescLabel.innerHTML ="Describe your application : ";
			descWrapper.appendChild(applicationDescLabel);
			//Adding the textarea section
		var inputApplicationDesc = document.createElement("textArea");
			inputApplicationDesc.type = "text";
			inputApplicationDesc.id = applicationName+"Desc";
			inputApplicationDesc.name = applicationName+"Desc";
			inputApplicationDesc.placeholder="Describe me";
			descWrapper.appendChild(inputApplicationDesc);
	applicationInformationWrapper.appendChild(descWrapper);	
	
	//Adding the img downloading field for the application
	var imgWrapper = document.createElement("div");
		var applicationImg = document.createElement("label");
			applicationImg.setAttribute("for", applicationName+"Img");
			applicationImg.innerHTML ="Image of the application : ";
			imgWrapper.appendChild(applicationImg);
			//The input of the application's name
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
	
	
	//Creation of the add question button
	var wrapQuestionPre = document.createElement("div");
		wrapQuestionPre.setAttribute("class", "questionPreDiv");
	var buttonQuestion = document.createElement("button");
		buttonQuestion.setAttribute("class", "addQuestionButton");
		buttonQuestion.type = "button";
		buttonQuestion.value = "Add Pre Question";
		buttonQuestion.innerHTML = "Add a Pre question";
		wrapQuestionPre.appendChild(buttonQuestion);
		application.appendChild(wrapQuestionPre);
		
	
	var wrapQuestionPost = document.createElement("div");
		wrapQuestionPost.setAttribute("class", "questionPostDiv");
	var buttonQuestionPost = document.createElement("button");
		buttonQuestionPost.setAttribute("class", "addQuestionButton");
		buttonQuestionPost.type = "button";
		buttonQuestionPost.value = "Add Post Question";
		buttonQuestionPost.innerHTML = "Add a Post question";
		wrapQuestionPost.appendChild(buttonQuestionPost);
		application.appendChild(wrapQuestionPost);
		
		    
		//Add the event for adding the question
			buttonQuestion.addEventListener("click", function(event){
				addQuestionPre(event, wrapQuestionPre);
			});
		//Add the event for adding the question
			buttonQuestionPost.addEventListener("click", function(event){
				addQuestionPost(event, wrapQuestionPost);
			});
	
	nbApplication++;
}

function displayImage(input, imgDisplayer){
 	if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(imgDisplayer).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function noSelection(input, imgDisplayer){
 	document.body.onfocus = function(event){
 		emptyImage(input, imgDisplayer);
 	};	
}
function emptyImage(input, img){
 	if($(input).val()){
 		img.src = "";
 	}
 	document.body.onfocus = null;
}

function removeMe(event, me){

	var inputChild = me.getElementsByTagName("input")[0];
	var parent = me.parentElement;
	var meClassName = me.className.split(" ");
	
	if(meClassName[0] === "application"){
		if(!(inputChild.value=="") || $(me).children().length > 1){
			if(confirm("Are you sure you wanna delete this application ? \nIt will delete all the questions included in the application.")){
				parent.removeChild(me);
				nbApplication--;
			}			
		}else{
			parent.removeChild(me);
		}

		refreshApplication();
	}
	else if(meClassName[0] === "question"){
		parent.removeChild(me);
		refreshQuestion(parent);
	}
	else{
		parent.removeChild(me);
	}
}
function refreshApplication(){
	var applications = $(".application");
	var count = 0;
	console.log(applications.length);
	for(var i = 0; i < applications.length; i++){
		// The method who make the application dragable and dropabble create a moving div
		// build exactly as the application with the same class but with no id
		// because of this, the application tab "applications" above contains one more div 
		// without any id which is modified as his comrades whereas it whould normally disappear
		// we need not to modify this one otherwise the form and the drag&drop will not work. 
		if(!(applications[i].id === "")){
			var formerId = applications[i].id;
			var newId = "Applic"+count;
			
			if(!(formerId === newId)){
				applications[i].id = newId;
			
				var aInfoWrapper = $(applications[i]).children()[0];
				aInfoWrapper.setAttribute("id", newId+"Info");

				
				var aInfo = $("#"+aInfoWrapper.id + " > div");
				console.log(aInfo);
				//Each component is composed of a label and an input
				for(var y = 0; y < aInfo.length; y++){
					//Modifying the label
					var children = $(aInfo[y]).children();
					
					console.log(children[1]);
					var name = newId+children[1].id.slice(newId.length, children[1].id.length);

					children[0].setAttribute("for", name);
					
					//Modifying the input
					children[1].setAttribute("name", name);
					children[1].setAttribute("id", name);
				}
				
				//This mean that if there is at least one question
				//The question will be refreshed
				if($(applications[i]).children().length >= 2)
					refreshQuestion(applications[i]);
			}
			count++;
		}
	}
}

function refreshQuestion(parent){
	
	var parentId = parent.id;
	var questions = $("#"+parentId+" > .question");
	for(var i = 0; i < questions.length; i++){
		var formerId = questions[i].id;
		var newId = parentId+"Q"+(i+1);
		if(!(formerId === newId)){
			questions[i].id = newId;
			
			var questionInfoWrapper = $(questions[i]).children()[0];

			
			
			//Modifying the label and the input id
			var children = $(questionInfoWrapper).children();
			//id
			var id = children[1].id = newId+children[1].id.slice(formerId.length, children[1].id.length);
			//label
			children[0].setAttribute("for", id);
			children[0].innerHTML = "Question n°"+(i+1)+" : ";
			//input
			children[1].id = id;
			

			var options = $("#"+newId+" option");
		
			for(var y = 0; y < options.length; y++){
				options[y].id = options[y].value+newId;
			}
			//Selected option
			var value = $("#"+newId+" select");
			if((value === "smiley") || (value == "thumbs")){
				var items = $("#"+newId+" > .answerArea > div");
				for(var y = 0; y < items.length; y++){
					children = $(items[y]).children();
					id = newId+children[1].id.slice(formerId.lengt, children[1].id.length);
					//label
					children[0].setAttribute("for", id);
					//input
					children[1].setAttribute("id", id);
				}
			}
		}

	}
}

function addQuestionPre(event, parent) {
    //console.log(button);
	//console.log(button.parentElement);
	
	//Recovery of the application associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		//
	var nbQuestions = application.children.length;
	
	var questionName = application.parentNode.id+"Q"+nbQuestions;
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName);
	qWrapper.setAttribute("class", "questionPre");
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var questionInfoWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", questionName+"Name");
			applicationNameLabel.innerHTML ="Question Pre n°"+nbQuestions+" : ";
			questionInfoWrapper.appendChild(applicationNameLabel);
			
			
			//The input of the application's name
		var inputQuestion = document.createElement("input");
			inputQuestion.type = "text";
			inputQuestion.id= questionName+"name";
			inputQuestion.name= questionName+"Name";
			inputQuestion.placeholder="Do you like carrots ?";
			questionInfoWrapper.appendChild(inputQuestion);	
			
			
			//Creation of the remove question button
		var removeQButton = document.createElement("button");
			removeQButton.setAttribute("class", "removeButton");
			removeQButton.type="button";
			removeQButton.value= "Remove the question";
			removeQButton.innerHTML ="Remove the question";
			questionInfoWrapper.appendChild(removeQButton);
			
			//Add the event for removing the application
				removeQButton.addEventListener("click", function(event){
					removeMe(event, qWrapper);
				});
	qWrapper.appendChild(questionInfoWrapper);
			
	//Add evalutation choices
	
	
		//Add a choice wrapper
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
		

		//Add the answer area (ex : the area where the smileys will be displayed)
		var answerArea = document.createElement("div");
			answerArea.setAttribute("class","answerArea");
			qWrapper.appendChild(answerArea);

			//add listener on radio changement
			$(cWrapper).bind("change", answers);
		$(cWrapper).trigger("change");
}
function addQuestionPost(event, parent) {
    //console.log(button);
	//console.log(button.parentElement);
	
	//Recovery of the application associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		//
	var nbQuestions = application.children.length;
	
	var questionName = application.parentNode.id+"Q"+nbQuestions;
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName);
	qWrapper.setAttribute("class", "questionPost");
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var questionInfoWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", questionName+"Name");
			applicationNameLabel.innerHTML ="Question Post n°"+nbQuestions+" : ";
			questionInfoWrapper.appendChild(applicationNameLabel);
			
			
			//The input of the application's name
		var inputQuestion = document.createElement("input");
			inputQuestion.type = "text";
			inputQuestion.id= questionName+"name";
			inputQuestion.name= questionName+"Name";
			inputQuestion.placeholder="Do you like carrots ?";
			questionInfoWrapper.appendChild(inputQuestion);	
			
			
			//Creation of the remove question button
		var removeQButton = document.createElement("button");
			removeQButton.setAttribute("class", "removeButton");
			removeQButton.type="button";
			removeQButton.value= "Remove the question";
			removeQButton.innerHTML ="Remove the question";
			questionInfoWrapper.appendChild(removeQButton);
			
			//Add the event for removing the application
				removeQButton.addEventListener("click", function(event){
					removeMe(event, qWrapper);
				});
	qWrapper.appendChild(questionInfoWrapper);
			
	//Add evalutation choices
	
	
		//Add a choice wrapper
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
		

		//Add the answer area (ex : the area where the smileys will be displayed)
		var answerArea = document.createElement("div");
			answerArea.setAttribute("class","answerArea");
			qWrapper.appendChild(answerArea);

			//add listener on radio changement
			$(cWrapper).bind("change", answers);
		$(cWrapper).trigger("change");
}

function answers(event){
	var id = event.target.parentElement.parentElement.id;
	var folder = "media/";
	var ext = ".png";
	var answerArea = $("#"+id+" .answerArea")[0];
	answerArea.innerHTML = "";
	//console.log(id);
	var questionType = placeholders[event.target.value];
	for(var ans in questionType){
		if(questionType[ans]["answerTypeImage"] !== "")
			makeLabelImage(questionType[ans]["answerTypeName"],id,folder+questionType[ans]["answerTypeImage"]+ext, answerArea);
	}/*
	switch(){
		case 'smiley':
			//emojis http://emojipedia.org/emoji-one/
			//console.log("smiley");
			makeInputImage("smiley1",id,"media/smiley1image.png", answerArea);
			makeInputImage("smiley2",id,"media/smiley2image.png", answerArea);
			makeInputImage("smiley3",id,"media/smiley3image.png", answerArea);
			makeInputImage("smiley4",id,"media/smiley4image.png", answerArea);
			makeInputImage("smiley5",id,"media/smiley5image.png", answerArea);
			break;
		case 'textArea':
			console.log("textArea"); 
			break;
		case 'thumbs':
			//console.log("thumbs");
			makeInputImage("thumbs1",id,"media/thumb1image.png", answerArea);
			makeInputImage("thumbs2",id,"media/thumb2image.png", answerArea);
			makeInputImage("thumbs3",id,"media/thumb3image.png", answerArea);
			makeInputImage("thumbs4",id,"media/thumb4image.png", answerArea);
			makeInputImage("thumbs5",id,"media/thumb5image.png", answerArea);
			break;
	}*/
}
function addField(event){
    
    //wrapper creation
    var wrapper = document.createElement("div");
    wrapper.setAttribute("class","field");
    
    //Create label
    var inputLabel = document.createElement("input");
	inputLabel.setAttribute("class","fieldInput");
    inputLabel.type = "text";
    inputLabel.placeholder ="Your Field name";
    wrapper.appendChild(inputLabel);
        
    var removeApplicationButton = document.createElement("button");
		removeApplicationButton.setAttribute("class", "removeButton");
		removeApplicationButton.type="button";
		removeApplicationButton.value= "Remove the Field";
		removeApplicationButton.innerHTML ="Remove the Field";
		wrapper.appendChild(removeApplicationButton);
		
		//Add the event for removing the application
			removeApplicationButton.addEventListener("click", function(event){
				removeMe(event, wrapper);
			});
            
    //Add fieldset to thecodex
    var customInfo = document.getElementById("customInformation");
		customInfo.appendChild(wrapper);
}



function makeRadioButton(name, value, text){

    var label = document.createElement("label");
    var radio = document.createElement("input");
		radio.type = "radio";
		radio.name = name;
		radio.value = value;


    label.appendChild(document.createTextNode(text));
    return label;
}

function makeInputImage(name, value, imageAdr, parent){
	var id = value+name;
	
	var label = document.createElement("label");
		label.setAttribute("for", id);

    var inputBox = document.createElement("input");
		inputBox.setAttribute("type", "text");
		inputBox.setAttribute("id", id);

    var image = document.createElement("img");
		image.setAttribute("src", imageAdr);
                image.setAttribute("class", "answerIcon");
		label.appendChild(image)
  
	var wrapper = document.createElement("div");
		wrapper.appendChild(label);
		wrapper.appendChild(inputBox);
		
	parent.appendChild(wrapper);
}

function makeLabelImage(name, value, imageAdr, parent){
	var id = value+name;
	
	var label = document.createElement("label");
		label.setAttribute("for", id);

    var inputBox = document.createElement("span");
		inputBox.setAttribute("id", id);
		inputBox.innerHTML = name;

    var image = document.createElement("img");
		image.setAttribute("src", imageAdr);
                image.setAttribute("class", "answerIcon");
		label.appendChild(image)
  
	var wrapper = document.createElement("div");
		wrapper.appendChild(label);
		wrapper.appendChild(inputBox);
		
	parent.appendChild(wrapper);
}

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
		var questionsPre = $("#"+id+" > .questionPreDiv > .questionPre");
		console.log("questionsPre = "+questionsPre);
		for(var y = 0; y < questionsPre.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questionsPre[y].id;
			//console.log(idQ);
			var qPreLabel = $("#"+idQ+"name").val();
			//console.log("label pre = "+qPreLabel);
			var qPreType = $("#"+idQ+" select").val();
			//console.log(qType);
			var qPrePre = '1';
			
			qPre[i].push(new Question(idQ, qPreLabel, qPreType, qPrePre));
		}
		var questionsPost = $("#"+id+" > .questionPostDiv > .questionPost");
		console.log("questionsPost = "+questionsPost);
		for(var y = 0; y < questionsPost.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questionsPost[y].id;
			//console.log(idQ);
			var qPostLabel = $("#"+idQ+"name").val();
			//console.log("label post = "+qPostLabel);
			var qPostType = $("#"+idQ+" select").val();
			//console.log(qType);
			var qPostPre = '0';
			
			qPost[i].push(new Question(idQ, qPostLabel, qPostType,qPostPre));
		}
	}
	var info = extractInformation();
	var fs = extractFSQuestions();
	console.log("sent to send");
	send(formName, a, qPre, qPost, info, fs);
}


function send(f, a, qPre, qPost, i, fs) {

	//console.log(JSON.stringify(a));
	//console.log(JSON.stringify(q));
	console.log("gonna post");
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
						//alert("The form has been successfully registered ! (You will be redirected)");
						//$("#submit").unbind("click", extractData);
						setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);
					}
					
				}else{
					console.log("Error when saving the form. ");
				}
			},
		"json" // type
	);
}


//function which return an array of the name of the checked default information	
//Il y a plus simple, tu récupères par className
function checkDefaultInformations(){
	var checkBoxes = document.getElementById("defaultInfCheckboxes").children;
	var infoArray = [];

	for (var i = checkBoxes.length - 1; i >= 0; i--) {
		if (checkBoxes[i].type === "checkbox" && checkBoxes[i].checked){
			infoArray.push(checkBoxes[i].value);
		}

	}
	return infoArray;
}

//Changement de l'ordre des questions
//Drag and drop to switch
jQuery.fn.swap = function(b){ 
    // method from: http://blog.pengoworks.com/index.cfm/2008/9/24/A-quick-and-dirty-swap-method-for-jQuery
    b = jQuery(b)[0]; 
    var a = this[0]; 
    var t = a.parentNode.insertBefore(document.createTextNode(''), a); 
    b.parentNode.insertBefore(a, b); 
    t.parentNode.insertBefore(b, t); 
    t.parentNode.removeChild(t); 
    return this; 
};


function makeDraggbleQuestion(event) {
	$( ".question" ).draggable({containment : "parent", revert: true, helper: "clone" });

	$( ".question" ).droppable({
		accept: ".question",
		drop: function( event, ui ) {

			var draggable = ui.draggable, droppable = $(this),
				dragPos = draggable.position(), dropPos = droppable.position();
			
			
			draggable.css({
				left: dropPos.left+'px',
				top: dropPos.top+'px'
			});
	
			droppable.css({
				left: dragPos.left+'px',
				top: dragPos.top+'px'
			});
			draggable.swap(droppable);
			
			refreshQuestion(droppable.parent()[0]);
		}
	});
		
}

function makeDraggbleApplication(event) {
	$( ".application" ).draggable({containment : "parent", revert: true, helper: "clone" });

	$( ".application" ).droppable({
		accept: ".application",
		drop: function( event, ui ) {

			var draggable = ui.draggable, droppable = $(this),
				dragPos = draggable.position(), dropPos = droppable.position();
			
			
			draggable.css({
				left: dropPos.left+'px',
				top: dropPos.top+'px'
			});
	
			droppable.css({
				left: dragPos.left+'px',
				top: dragPos.top+'px'
			});
			draggable.swap(droppable);
			
			refreshApplication();
		}
	});
}



function answersPlaceholder(){
	$.get(
		"index.php", // url
		{
			"action":"answersPlaceholder",
			"controller":"questionType",
		},  //data
		function(res){ //callback
				placeholders = res;
			},
		"json" // type
	);
}
function predefinedInformation(){
	$.get(
		"index.php", // url
		{
			"action":"predefinedInformation",
			"controller":"personnalInformation",
		},  //data
		function(res){ //callback
				predefInformation = res;
				if(predefInformation.length > 0)
					showInformation("predefinedInformation", "information", predefInformation);
			},
		"json" // type
	);	
}
function predefinedFSQuestion(){
	$.get(
		"index.php", // url
		{
			"action":"predefinedFSQuestions",
			"controller":"FSQuestion",
		},  //data
		function(res){ //callback
				fsquestions = res;
				if(fsquestions.length > 0)
					showInformation("funSorterInformation", "FSQuestion", fsquestions);
			},
		"json" // type
	);	
}

function showInformation(id, type, tab){
	var infoWrapper = $("#"+id)[0];
	for(var i = 0; i < tab.length; i++){
		var name = tab[i];
		var wrapper = document.createElement("div");
			infoWrapper.appendChild(wrapper);
		var input = document.createElement("input");
			input.setAttribute("type", "checkbox");
			input.setAttribute("name", type);
			input.setAttribute("class", "default"+type.capitalizeFirstLetter());
			input.setAttribute("id", name);
		wrapper.appendChild(input);
		
		var label = document.createElement("label");
			label.setAttribute("for", name);
			label.innerHTML = name;
		wrapper.appendChild(label);
	}
}

function addFSQuestion(event) {
    //wrapper creation
    var wrapper = document.createElement("div");
    wrapper.setAttribute("class","FSQuestionCustom");
	
	var table = document.createElement("table");
	var tr = document.createElement('tr');
	
    
    //Create label left
    var inputLeft = document.createElement("input");
	inputLeft.setAttribute("class","questionInputLeft");
    inputLeft.type = "text";
    inputLeft.placeholder ="First part ";
	var tdleft = document.createElement('td');
	tdleft.appendChild(inputLeft);
	
	//create fake input
	var inputFake = document.createElement("input");
    inputFake.type = "text";
    inputFake.placeholder ="Fake part";
	inputFake.style.visibility='hidden';
	var tdmiddle = document.createElement('td');
	tdmiddle.appendChild(inputFake);
	
	//Create label left
    var inputRight = document.createElement("input");
	inputRight.setAttribute("class","questionInputRight");
    inputRight.type = "text";
    inputRight.placeholder ="Second part";
	var tdright = document.createElement('td');
    tdright.appendChild(inputRight);
    
	tr.appendChild(tdleft);
	tr.appendChild(tdmiddle);
	tr.appendChild(tdright);
	table.appendChild(tr);
	
	wrapper.appendChild(table);
	    
    var removeApplicationButton = document.createElement("button");
		removeApplicationButton.setAttribute("class", "removeButton");
		removeApplicationButton.type="button";
		removeApplicationButton.value= "Remove the Question";
		removeApplicationButton.innerHTML ="Remove the Question";
		wrapper.appendChild(removeApplicationButton);
		
		//Add the event for removing the application
			removeApplicationButton.addEventListener("click", function(event){
				removeMe(event, wrapper);
			});
            
   //Add fieldset to thecodex
    var customInfo = document.getElementById("customQuestion");
		customInfo.appendChild(wrapper);
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


String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}



function init(){
	
	$("#submit").click(extractData);
	answersPlaceholder();
	predefinedInformation();
	predefinedFSQuestion();
	document.getElementById("addApplication").addEventListener("click", addApplication);
	//Adding one application
	addApplication();
	//uploadImage$("#test").click(uploadImage);
	document.getElementById("makeMoveableQuestion").addEventListener("click",makeDraggbleQuestion);
	document.getElementById("makeMoveableApplication").addEventListener("click",makeDraggbleApplication);
	document.getElementById("addField").addEventListener("click",addField);
	document.getElementById("addFSQuestion").addEventListener("click",addFSQuestion);
}


$(init);