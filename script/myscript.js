var b = document.body;
var nbApplication = 0;

function addApplication(event){
	//Recovery of the container
	var form = document.getElementById("newForm");
	
	//Creation of the application wrapper
	var application = document.createElement("div");
		application.setAttribute("class", "application");
		application.setAttribute("id", "A"+nbApplication);
		form.appendChild(application);
	
	//Creation of the childs
	
	var wrapper = document.createElement("div");
	application.appendChild(wrapper);
	
		//The label of the application's name
	var applicationNameLabel = document.createElement("label");
		applicationNameLabel.setAttribute("for","nameApplicationLabelA"+nbApplication);
		applicationNameLabel.innerHTML ="Name of the application : ";
		wrapper.appendChild(applicationNameLabel);
		//The input of the application's name
    var inputApplicationName = document.createElement("input");
		inputApplicationName.type = "text";
		inputApplicationName.id="nameApplicationLabelA"+nbApplication;
		inputApplicationName.name="title";
		inputApplicationName.placeholder="Application's Title";
		wrapper.appendChild(inputApplicationName);
	
	//Creation of the remove application button
	var removeApplicationButton = document.createElement("button");
		removeApplicationButton.setAttribute("class", "removeButton");
		removeApplicationButton.type="button";
		removeApplicationButton.value= "Remove the application";
		removeApplicationButton.innerHTML ="Remove the application";
		wrapper.appendChild(removeApplicationButton);
		
		//Add the event for removing the application
			removeApplicationButton.addEventListener("click", function(event){
				removeMe(event, application);
			});
	
	
	//Creation of the add question button
	var buttonQuestion = document.createElement("button");
		buttonQuestion.setAttribute("class", "addQuestionButton");
		buttonQuestion.type="button";
		buttonQuestion.value= "Add Question";
		buttonQuestion.innerHTML ="Add a question";
		wrapper.appendChild(buttonQuestion);
		
		    
		//Add the event for adding the question
			buttonQuestion.addEventListener("click", function(event){
				addQuestion(event, buttonQuestion);
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

		refreshApplication(me, parent);
	}
	else if(meClassName[0] === "question"){
		parent.removeChild(me);
		refreshQuestion(me, parent);
	}
	else{
		parent.removeChild(me);
	}
		
}
function refreshApplication(me, parent){
	var applications = $(".application");
	for(var i = 0; i < applications.length; i++){
		applications[i].id = "A"+i;
		
		var children = $($(applications[i]).children()[0]).children();
		//console.log(children);
		children[0].setAttribute("for","nameApplicationLabelA"+i);
		children[1].setAttribute("id", "nameApplicationLabelA"+i)
		if($(applications[i]).children().length >= 2)
			refreshQuestion($(applications[i]).children()[1], applications[i]);
	}
}
function refreshQuestion(me, parent){
	var id = me.id.slice(3, me.id.length);
		
	var questions = $("#"+parent.id+" > .question");
	//console.log(parent.id);
	if(id == questions.length+1){

	}else{
		//parent.removeChild(me);

		//console.log(questions[id]);
		var y = 0;
		//console.log("ID me : "+id);
		for(var i = 0; i < questions.length; i++){
			var formerId = me.id;
			//console.log($(questions[i]));
			var children = $(questions[i]).children();

			var newId = parent.id+"Q"+parseInt(i+1, 10);
			questions[i].setAttribute("id", newId);
			children[0].setAttribute("for", "question"+newId);
			children[0].innerHTML = "Question n°"+newId.slice(3, newId.length)+" : ";
			children[1].setAttribute("id", "question"+newId);
			
			var options = $(children[3]).children();
				$(options[0]).children()[0].setAttribute("for", "thumb"+newId);
				$(options[0]).children()[1].setAttribute("name", "option"+newId);
				$(options[0]).children()[1].setAttribute("id", "thumb"+newId);
				
				$(options[1]).children()[0].setAttribute("for", "smiley"+newId);
				$(options[1]).children()[1].setAttribute("name", "option"+newId);
				$(options[1]).children()[1].setAttribute("id", "smiley"+newId);
				
				$(options[2]).children()[0].setAttribute("for", "textArea"+newId);
				$(options[2]).children()[1].setAttribute("name", "option"+newId);
				$(options[2]).children()[1].setAttribute("id", "textArea"+newId);
			

			
			var who = $("input[name=option"+newId+"]:checked").val();
			if((who === "smiley") || (who === "thumbs")){
				for(var t = 0; t < 5; t++){
					var name = who+t+formerId;
					//console.log($("input[id="+name+"]"));
					$("input[id^="+name+"]")[0].setAttribute("id", who+t+newId);
				}
			}
		}
	}
}

function addQuestion(event, button) {
    //console.log(button);
	//console.log(button.parentElement);
	
	//Recovery of the application associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the application container
	var application = button.parentElement.parentElement;
		//
	var nbQuestions = application.children.length;
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", application.id+"Q"+nbQuestions);
	qWrapper.setAttribute("class", "question");
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var applicationNameLabel = document.createElement("label");
		applicationNameLabel.setAttribute("for", application.id+"Q"+nbQuestions);
		applicationNameLabel.innerHTML ="Question n°"+nbQuestions+" : ";
		qWrapper.appendChild(applicationNameLabel);
		
		
		//The input of the application's name
    var inputQuestion = document.createElement("input");
		inputQuestion.type = "text";
		inputQuestion.id="question"+application.id+"Q"+nbQuestions;
		inputQuestion.name="title";
		inputQuestion.placeholder="Do you like carrots ?";
		qWrapper.appendChild(inputQuestion);
		
		
		//Creation of the remove question button
	var removeQButton = document.createElement("button");
		removeQButton.setAttribute("class", "removeButton");
		removeQButton.type="button";
		removeQButton.value= "Remove the question";
		removeQButton.innerHTML ="Remove the question";
		qWrapper.appendChild(removeQButton);
		
		//Add the event for removing the application
			removeQButton.addEventListener("click", function(event){
				removeMe(event, qWrapper);
			});

			
	//Add evalutation choices

		//Add a choice wrapper
		var cWrapper  = document.createElement("div");
			qWrapper.appendChild(cWrapper);


		//Creating the thumbs option
    	
		var radioInputThumb = document.createElement('input');
			radioInputThumb.setAttribute('type', 'radio');
			radioInputThumb.setAttribute('name', 'option'+application.id+"Q"+nbQuestions);
			radioInputThumb.setAttribute('required', 'required');
			radioInputThumb.setAttribute('value', 'thumbs');
			radioInputThumb.setAttribute('id', 'thumb'+application.id+"Q"+nbQuestions);
			radioInputThumb.innerHTML = "thumbs";
		var labelThumb = document.createElement("label");
			labelThumb.setAttribute("for", "thumb"+application.id+"Q"+nbQuestions);
			labelThumb.appendChild(document.createTextNode("Thumbs"));
		var thumbWrapper = document.createElement("div");
			thumbWrapper.appendChild(labelThumb);
			thumbWrapper.appendChild(radioInputThumb);
			
		//Creating the smiley option

		var radioInputSmiley = document.createElement('input');
			radioInputSmiley.setAttribute('type', 'radio');
			radioInputSmiley.setAttribute('name', 'option'+application.id+"Q"+nbQuestions);
			radioInputSmiley.setAttribute('value', 'smiley');
			radioInputSmiley.setAttribute('id', 'smiley'+application.id+"Q"+nbQuestions);
		var labelSmiley = document.createElement("label");
			labelSmiley.setAttribute("for", "smiley"+application.id+"Q"+nbQuestions);
			labelSmiley.appendChild(document.createTextNode("smiley"));
		var smileyWrapper = document.createElement("div");
			smileyWrapper.appendChild(labelSmiley);
			smileyWrapper.appendChild(radioInputSmiley);
			
		//Creating the textArea option
    	
		var radioInputTextArea = document.createElement('input');
			radioInputTextArea.setAttribute('type', 'radio');
			radioInputTextArea.setAttribute('name', 'option'+application.id+"Q"+nbQuestions);
			radioInputTextArea.setAttribute('value', 'textArea');
			radioInputTextArea.setAttribute('id', 'textArea'+application.id+"Q"+nbQuestions);
		var labelTextArea = document.createElement("label");
			labelTextArea.setAttribute("for", "textArea"+application.id+"Q"+nbQuestions);
			labelTextArea.appendChild(document.createTextNode("textArea"));
		var textAreaWrapper = document.createElement("div");
			textAreaWrapper.appendChild(labelTextArea);
			textAreaWrapper.appendChild(radioInputTextArea);
		
		//Add the options to form
			cWrapper.appendChild(thumbWrapper);
			cWrapper.appendChild(smileyWrapper);
			cWrapper.appendChild(textAreaWrapper);

		//Add the answer area (ex : the area where the smileys will be displayed)
		var answerArea = document.createElement("div");
			answerArea.setAttribute("class","answerArea");
			cWrapper.parentElement.appendChild(answerArea);

			//add listener on radio changement
			$(cWrapper).bind("change", function(event){
				answers(event)
			});

}

function answers(event){
	var id = event.target.parentElement.parentElement.parentElement.id;
	var answerArea = $("#"+event.target.parentElement.parentElement.parentElement.id+"> .answerArea")[0];
	//Bug lorsque l'on clique sur le même truc
	answerArea.innerHTML = "";
	//console.log(id);
	switch(event.target.value){
		case 'smiley':
			//emojis http://emojipedia.org/emoji-one/
			//console.log("smiley");
			makeInputImage("smiley0",id,"media/vsadsmiley.png", answerArea);
			makeInputImage("smiley1",id,"media/sadsmiley.png", answerArea);
			makeInputImage("smiley2",id,"media/neutralsmiley.png", answerArea);
			makeInputImage("smiley3",id,"media/happysmiley.png", answerArea);
			makeInputImage("smiley4",id,"media/vhappysmiley.png", answerArea);
			break;
		case 'textArea':
			console.log("textArea"); 
			break;
		case 'thumbs':
			//console.log("thumbs");
			makeInputImage("thumbs0",id,"media/twothumbsdown.png", answerArea);
			makeInputImage("thumbs1",id,"media/thumbdown.png", answerArea);
			makeInputImage("thumbs2",id,"media/thumbup.png", answerArea);
			makeInputImage("thumbs3",id,"media/twothumbsup.png", answerArea);
			makeInputImage("thumbs4",id,"media/threethumbsup.png", answerArea);
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
            
    //Add fieldset to thecode
    var newField = document.getElementById("newField");
		newField.appendChild(wrapper);
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
	var id = name+value;
	
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

document.getElementById("addApplication").addEventListener("click", addApplication);
//Adding one application
addApplication();

document.getElementById("addField").addEventListener("click",addField);

$("#submit").click(extractData);
//#############################################
//
// Remove the number : "Application n°x", will be difficult to deal with if we remove a application
// Same for the question
//
//
//##############################################

function send(url, applications, questions) {
	//
  /*  var requete = new XMLHttpRequest();
	var url = "test.php";
	$.post()
	console.log(object);
    requete.open("POST", url, true);
    requete.addEventListener("load", function () {
        callback(requete);
    });
    requete.send("application="+object);*/
	//console.log(object);
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


//function to return an array of the name of the checked default information	
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
document.getElementById("makeMoveable").addEventListener("click",makeDraggble);

function makeDraggble(event) {
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
			
			refreshQuestion(droppable[0], droppable.parent()[0]);
		}
	});
		
}
