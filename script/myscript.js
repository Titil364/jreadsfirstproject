var b = document.body;
var nbApplication = 0;

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
			applicationDescLabel.innerHTML ="Decribe your application : ";
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
			imgWrapper.appendChild(inputApplicationImg);
	applicationInformationWrapper.appendChild(imgWrapper);	
	
	
	//Creation of the add question button
	var buttonQuestion = document.createElement("button");
		buttonQuestion.setAttribute("class", "addQuestionButton");
		buttonQuestion.type="button";
		buttonQuestion.value= "Add Question";
		buttonQuestion.innerHTML ="Add a question";
		applicationInformationWrapper.appendChild(buttonQuestion);
		
		    
		//Add the event for adding the question
			buttonQuestion.addEventListener("click", function(event){
				addQuestion(event, application);
			});
	
	nbApplication++;
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
	for(var i = 0; i < applications.length; i++){
		// The method who make the application dragable and dropabble create a moving div
		// build exactly as the application with the same class but with no id
		// because of this, the application tab "applications" above contains one more div 
		// without any id which is modified as his comrades whereas it whould normally disappear
		// we need not to modify this one otherwise the form and the drag&drop will not work. 
		if(!(applications[i].id === "")){
			var formerId = applications[i].id;
			var newId = "Applic"+i;
			if(!(formerId === newId)){
				applications[i].id = newId;
			
				var aInfoWrapper = $("#"+formerId+"Info");
				aInfoWrapper[0].setAttribute("id", newId+"Info");				
				var aInfo = $("#"+formerId+"Info > div");
				//Each component is composed of a label and an input
				for(var y = 0; y < aInfo.length; y++){
					//Modifying the label
					var children = $(aInfo[y]).children();
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

function addQuestion(event, parent) {
    //console.log(button);
	//console.log(button.parentElement);
	
	//Recovery of the application associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		//
	var nbQuestions = application.children.length;
	
	var questionName = application.id+"Q"+nbQuestions;
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName);
	qWrapper.setAttribute("class", "question");
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var questionInfoWrapper = document.createElement("div");
		var applicationNameLabel = document.createElement("label");
			applicationNameLabel.setAttribute("for", questionName+"Name");
			applicationNameLabel.innerHTML ="Question n°"+nbQuestions+" : ";
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
	
	//NOTE : It is supposed to be drop down list
	
		//Add a choice wrapper
		var cWrapper  = document.createElement("select");
			questionInfoWrapper.appendChild(cWrapper);

		//Creating the textArea option
    	
		var textAreaOption = document.createElement('option');
			textAreaOption.setAttribute('value', 'textArea');
			textAreaOption.setAttribute('id', 'textArea'+application.id+"Q"+nbQuestions);
			textAreaOption.innerHTML = "textArea"

			cWrapper.appendChild(textAreaOption);
			
		//Creating the thumbs option
    	
		var thumbOption = document.createElement('option');
			thumbOption.setAttribute('required', 'required');
			thumbOption.setAttribute('value', 'thumbs');
			thumbOption.setAttribute('id', 'thumb'+questionName);
			thumbOption.innerHTML = "thumbs";
			cWrapper.appendChild(thumbOption);
			
		//Creating the smiley option

		var smileyOption = document.createElement('option');
			smileyOption.setAttribute('value', 'smiley');
			smileyOption.setAttribute('id', 'smiley'+questionName);
			smileyOption.innerHTML = "smiley";
			cWrapper.appendChild(smileyOption);
			

		


		//Add the answer area (ex : the area where the smileys will be displayed)
		var answerArea = document.createElement("div");
			answerArea.setAttribute("class","answerArea");
			qWrapper.appendChild(answerArea);

			//add listener on radio changement
			$(cWrapper).bind("change", function(event){
				answers(event)
			});

}

function answers(event){
	console.log("teub");
	var id = event.target.parentElement.parentElement.id;
	var answerArea = $("#"+id+" .answerArea")[0];
	answerArea.innerHTML = "";
	//console.log(id);
	switch(event.target.value){
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
	}
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
		label.setAttribute("id", id);

    var inputBox = document.createElement("input");
		inputBox.setAttribute("type", "text");
		inputBox.setAttribute("id", id);

    var image = document.createElement("img");
		image.setAttribute("src", imageAdr);
		label.appendChild(image)
  
	var wrapper = document.createElement("div");
		wrapper.appendChild(label);
		wrapper.appendChild(inputBox);
		
	parent.appendChild(wrapper);
}






function extractData(){
	//Liste of application in the form
	var applications = $(".application");
	for(var i = 0; i < applications.length; i++){
		var id = applications[i].id;
		console.log("#################");
		var title = $("#nameApplicationLabel"+id).val();
		console.log("Task : "+title);
		var a = new Application(5,title, "Test");
		
		var questions = $("#"+id+" > .question");
		var q = []
		for(var y = 0; y < questions.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questions[y].id;
			//console.log(idQ);
			var qLabel = $("#question"+idQ).val();
			//console.log(qLabel)
			var qType = $("input[name=option"+idQ+"]:checked").val();
			//console.log(qType);
			
			q.push(new Question(idQ, qLabel, qType));
		}
		send("test", a, q);
		//console.log("");
	}
}
function extractAnswers(question, type){
	return null;
}





function send(url, applications, questions) {

	var data = "applications="+JSON.stringify(applications)+"&questions="+JSON.stringify(questions);
	//console.log(data);
	$.get(
		url+".php", // url cible
		data, // données envoyées 
		function(res){ // le callback
			var message = res;
			console.log(message);
			},
		"json" // type de données reçues
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
		

function init(){
	
	$("#submit").click(extractData);
	document.getElementById("addApplication").addEventListener("click", addApplication);
	//Adding one application
	addApplication();
	document.getElementById("makeMoveableQuestion").addEventListener("click",makeDraggbleQuestion);
	document.getElementById("makeMoveableApplication").addEventListener("click",makeDraggbleApplication);
	document.getElementById("addField").addEventListener("click",addField);			
}

$(init);