var b = document.body;
var nbApplication = 0;
var placeholders;
var fsquestions;
var qType = [];

var customTitleState = []; //0 : not custom , 1 valid custom title, -1 invalid or empty custom title
/**
* [Form Creation] Add an application to the DOM
*
*/
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
	nameWrapper.setAttribute('class','appCreationTitle')
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
		
		    
		//Add the event for adding the question
			buttonQuestion.addEventListener("click", function(event){
				addQuestion(event, wrapQuestionPre, "pre");
			});
		//Add the event for adding the question
			buttonQuestionPost.addEventListener("click", function(event){
				addQuestion(event, wrapQuestionPost, "post");
			});
	
	nbApplication++;

	customTitleState.push([ [] , [] ]); // 1st : pre quest of app, 2 nde post quest
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

/**
* [Form Creation] Add a pre question to the DOM
*@param event the event
*@param parent the parent application
*/
function addQuestion(event, parent, preOrPost) {
    //console.log(button);
	//console.log(button.parentElement);
	
	var p = preOrPost;
	var P = preOrPost.capitalizeFirstLetter();
	//Recovery of the application associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		//
	var nbQuestions = application.children.length-1;
	
	var questionName = application.parentNode.id+"Q"+nbQuestions;

	var applicNumber = application.parentNode.id.split("Applic")[1];
	customTitleState[applicNumber][0].push(0);
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName+p);
	qWrapper.setAttribute("class", "question"+P);
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var questionInfoWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", questionName+"Name");
			applicationNameLabel.innerHTML ="Question "+P+" n°"+nbQuestions+" : ";
			questionInfoWrapper.appendChild(applicationNameLabel);
			
			
			//The input of the application's name
		var inputQuestion = document.createElement("input");
			inputQuestion.type = "text";
			inputQuestion.id= questionName+p+"name";
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

/**
* [Form Creation] change the answer area depending on questionType
*@param event the event
*/
function answers(event){

	var id = event.target.parentElement.parentElement.id; 
	var folder = "media/";
	var ext = ".png";
	var answerArea = $("#"+id+" .answerArea")[0];
	answerArea.innerHTML = "";
	var questionType = placeholders[event.target.value];

	var questFirstPart = $(answerArea.parentNode).find(":first-child")[0]; //getting first part of the question (with title..)
	//console.log($(answerArea.parentNode).find(":first-child")[0]);

	//deleting previous custom checkbox if it exists
	var checkbox = $(answerArea.parentNode).find(".divCheckbox"); // deleting checkbox if it exists
	for (var i = checkbox.length - 1; i>=0; i-- ){
			checkbox[i].parentNode.removeChild(checkbox[i]);

	}

	if(questionType[0].questionTypeId == 2 || questionType[0].questionTypeId == 3){ // smiley or thumbs case
		//parent = 
		var div  = document.createElement('div');		//create div for custom fields
		div.setAttribute('class', 'divCheckbox');
		questFirstPart.appendChild(div);

		var label = document.createElement("label");
			label.setAttribute("for", ""); //not yet id (waiting to decide for checkbox id format)
			label.innerHTML ="custom : ";
			div.appendChild(label);

		var customCheckbox = document.createElement('input');
		customCheckbox.setAttribute('type', 'checkbox');
		customCheckbox.setAttribute('id', 'checkbox'+id);
		div.appendChild(customCheckbox);

		$(customCheckbox).on('change',function(){customQuestion(customCheckbox, answerArea);}); //eventListener on custom option (un)check

	}
				
		


	for(var ans in questionType){
		if(questionType[ans]["answerTypeImage"] !== "")
			makeLabelImage(questionType[ans]["answerTypeName"],id,folder+questionType[ans]["answerTypeImage"]+ext, answerArea);
	}
}
/**
* makes (dis)appear custom fields on (un)checking the custom checkbox
*@customCheckbox the custom checkbox that had triggered the function
*@answerArea the answer area that will ce modified
*/
function customQuestion(customCheckbox, answerArea){
	var customCheckboxId = customCheckbox.id;

	var splittedId  = customCheckboxId.match(/[a-zA-Z]+|[0-9]+/g); //separating numbers and characters into an array ex : "Applic1Q5pre"

	var numApp = splittedId[1]; // in ex will be 1

	var numQuest = splittedId[3]; //in ex will be 5

	var prepost = (splittedId[4]=="pre")?0:1; //in ex pre -> 0


	if ($(customCheckbox).is(':checked'))  { // ------- CHECKED : creating fields, collapsing titles

		customTitleState[numApp][prepost][numQuest-1] = -1; //setting to state "invalid custom title or empty"

		div = customCheckbox.parentNode; 


		var subdiv = document.createElement("div");
		subdiv.setAttribute("class","divCustomTitle");

		var label = document.createElement("label"); //asking yser for custom field title
		label.setAttribute("for", ""); 
		label.innerHTML ="Title : ";
		subdiv.appendChild(label);

		var name = document.createElement('input'); 
		name.setAttribute("class","customCheckboxName");
		name.setAttribute("id","title"+customCheckbox.id);
		subdiv.appendChild(name);

		var msgRes  = document.createElement('p');
		msgRes.setAttribute("id","msg"+customCheckbox.id);
		subdiv.appendChild(msgRes);


		div.appendChild(subdiv);


		var answerAreadivs = $(answerArea).find("div"); //finding answers div
		console.log(answerAreadivs);
		for (var i = 0; i<answerAreadivs.length; i++ ){ //for each one
			var span = $(answerAreadivs[i]).find("span")[0];	//finding the span of title

			var customField = document.createElement('input'); //creating a input field
			customField.setAttribute("class","field"+customCheckbox.id);
			customField.setAttribute("id","custom"+ span.id);
			answerAreadivs[i].appendChild(customField);

			span.style.visibility = "collapse";		//collapsing title

		}


	}else{									// ------- UNCHECKED : deleting all fields, setting visibility back for titles

		customTitleState[numApp][prepost][numQuest-1] = 0; //setting to state "not custom"

		div = customCheckbox.parentNode; 

		var titleToDelete = $(div).find(".divCustomTitle")[0]; //deleting title div
		titleToDelete.parentNode.removeChild(titleToDelete);

		var spanList = $(answerArea).find("span");		//setting title visibility back
		for (var i = 0; i<spanList.length; i++ ){
			spanList[i].style.visibility = "visible";
		}
		var inputList = $(answerArea).find("input");	//deleting input fields
		for (var i = inputList.length - 1; i>=0; i-- ){
			inputList[i].parentNode.removeChild(inputList[i]);
		}
	}
}

/**
* add field for custom information
*@event the event
*/
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


/**
* make radio button
*@name the radio button name
*@value its value
*@text the text inside the button
*/
function makeRadioButton(name, value, text){

    var label = document.createElement("label");
    var radio = document.createElement("input");
		radio.type = "radio";
		radio.name = name;
		radio.value = value;


    label.appendChild(document.createTextNode(text));
    return label;
}

/**
* make a image with a 
*@name the radio button name
*@value its value
*@text the text inside the button
*/
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


function answersPlaceholder(){
	$.get(
		"index.php", // url
		{
			"action":"answersPlaceholder",
			"controller":"questionType",
		},  //data
		function(res){ //callback
				placeholders = res;
				for(var key in placeholders){
					qType[key] = placeholders[key][0]["questionTypeId"];
				}
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
	$( ".questionPre, .questionPost" ).draggable({containment : "parent", revert: true, helper: "clone" });

	$( ".questionPre, .questionPost" ).droppable({
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
/**
*Check if the cutsomTitle is free in DB
*upadate the customTitleState global array 
*@event the event from the modified title field
*
*/
function isCustomTitleFree(event){
	var isFree;// = false;
	var field = event.target;
	var fieldID = field.id;

	var title = field.value;
	var parentDiv = field.parentNode;
	var msgZone = $(parentDiv).find(":last-child")[0];


	var splittedId  = fieldID.match(/[a-zA-Z]+|[0-9]+/g); //splitting id by numbers and char

	var numApp = splittedId[1];
	var numQuest = splittedId[3];
	var prepost = (splittedId[4]=="pre")?0:1; 



	if (title =="") { // if empty
		msgZone.style.color = "red";
		msgZone.innerHTML = "Title needed." 
         console.log("pas de titre");         
         customTitleState[numApp][prepost][numQuest-1] = -1; //setting to state "invalid custom title or empty"
    }else{
		$.post( //making async request to the serv
			"index.php", //target url
			{
				"action":JSON.stringify("existingQuestionType"),
				"controller":JSON.stringify("questionType"),
				"questionTypeTitle":JSON.stringify(title)
			}, 
			function(res){ //callback
				var existing = res;
				if (!existing) { //if not existing in DB : title possible
				console.log("free");					
					msgZone.style.color = "green";
					msgZone.innerHTML = "title available." 
					customTitleState[numApp][prepost][numQuest-1] = 1; //setting to state "valid custom title"
				}
				
				else { // if already existing : not available 
					msgZone.style.color = "red";
					msgZone.innerHTML = "Title already used." 
					customTitleState[numApp][prepost][numQuest-1] = -1; //setting to state "invalid custom title or empty"
				}
			},
			"json"
		);
	}

}


function init(){
	answersPlaceholder();
	document.getElementById("addApplication").addEventListener("click", addApplication);
	document.getElementById("makeMoveableQuestion").addEventListener("click",makeDraggbleQuestion);
	document.getElementById("makeMoveableApplication").addEventListener("click",makeDraggbleApplication);
	document.getElementById("addField").addEventListener("click",addField);
	document.getElementById("addFSQuestion").addEventListener("click",addFSQuestion);

	//Trigger on every change on every customCheckboxName
	$(document).on("change",".customCheckboxName",isCustomTitleFree)
}


$(init);



















String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}