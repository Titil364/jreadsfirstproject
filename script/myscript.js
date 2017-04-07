var b = document.body;
var nbElement = 0;
var _func;

function addApplication(event){
	//Recovery of the container
	var form = document.getElementById("newForm");
	
	//Creation of the application wrapper
	var application = document.createElement("div");
		application.setAttribute("class", "application");
		application.setAttribute("id", "T"+nbElement);
		form.appendChild(application);
	
	//Creation of the childs
	
	var wrapper = document.createElement("div");
	application.appendChild(wrapper);
	
		//The label of the application's name
	var applicationNameLabel = document.createElement("label");
		applicationNameLabel.setAttribute("for","nameApplicationLabel"+nbElement);
		applicationNameLabel.innerHTML ="Name of the application : ";
		wrapper.appendChild(applicationNameLabel);
		//The input of the application's name
    var inputApplicationName = document.createElement("input");
		inputApplicationName.type = "text";
		inputApplicationName.id="nameApplicationLabel"+nbElement;
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
	
	nbElement++;
}
function removeMe(event, me){

	var inputChild = me.getElementsByTagName("input")[0];
	var parent = me.parentElement;
	if(me.className === "application" & (!(inputChild.value=="") || $(me).children().length > 1)){
		if(confirm("Are you sure you wanna delete this application ? \nIt will delete all the questions included in the application.")){
			parent.removeChild(me);
		}
	}
	else if(me.className === "question"){
		var id = me.id.slice(1, me.id.length);
		
		
		var questions = $("#"+parent.id+" > .question");
		if(id == questions.length){
			parent.removeChild(me);
		}else{
			parent.removeChild(me);
			//console.log(questions[id]);
			var y = 0;
			for(var i = id; i < questions.length; i++){
				var children = $(questions[i]).children();
				var newId = parseInt(id, 10)+y;
				questions[i].setAttribute("id", "q"+newId);
				children[0].setAttribute("for", "question"+newId);
				children[0].innerHTML = "Question n°"+newId+" : ";
				children[1].setAttribute("id", "question"+newId);
				
				var options = $(children[3]).children();
					$(options[0]).children()[0].setAttribute("for", "thumb"+newId);
					$(options[0]).children()[1].setAttribute("name", "optionQ"+newId);
					$(options[0]).children()[1].setAttribute("id", "thumb"+newId);
					
					$(options[1]).children()[0].setAttribute("for", "smiley"+newId);
					$(options[1]).children()[1].setAttribute("name", "optionQ"+newId);
					$(options[1]).children()[1].setAttribute("id", "smiley"+newId);
					
					$(options[2]).children()[0].setAttribute("for", "textArea"+newId);
					$(options[2]).children()[1].setAttribute("name", "optionQ"+newId);
					$(options[2]).children()[1].setAttribute("id", "textArea"+newId);
				
				var who = $("input[name=optionQ"+newId+"]:checked").val();
				console.log(who);
				if((who === "smiley") || (who === "thumbs")){
					for(var t = 0; t < 5; t++){
						var name = who+t+(newId+1);
						//console.log($("input[id="+name+"]"));
						$("input[id^="+name+"]")[0].setAttribute("id", who+t+newId);
					}
					$(children[4])[0].removeEventListener('change', _func);
					var answerArea = $("input[id^="+who+"0"+newId+"]").parent().parent()[0];
					_func = function(event){answers(event, answerArea, newId);};
					$(children[4])[0].addEventListener('change', _func);
				}
				y++;
			}
		}
	}
	else{
		parent.removeChild(me);
		nbElement--;
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
	qWrapper.setAttribute("id", "q"+nbQuestions);
	qWrapper.setAttribute("class", "question");
	application.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var applicationNameLabel = document.createElement("label");
		applicationNameLabel.setAttribute("for","question"+nbQuestions);
		applicationNameLabel.innerHTML ="Question n°"+nbQuestions+" : ";
		qWrapper.appendChild(applicationNameLabel);
		
		
		//The input of the application's name
    var inputQuestion = document.createElement("input");
		inputQuestion.type = "text";
		inputQuestion.id="question"+nbQuestions;
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
			radioInputThumb.setAttribute('name', 'optionQ'+nbQuestions);
			radioInputThumb.setAttribute('required', 'required');
			radioInputThumb.setAttribute('value', 'thumbs');
			radioInputThumb.setAttribute('id', 'thumb'+nbQuestions);
			radioInputThumb.innerHTML = "thumbs";
		var labelThumb = document.createElement("label");
			labelThumb.setAttribute("for", "thumb"+nbQuestions);
			labelThumb.appendChild(document.createTextNode("Thumbs"));
		var thumbWrapper = document.createElement("div");
			thumbWrapper.appendChild(labelThumb);
			thumbWrapper.appendChild(radioInputThumb);
			
		//Creating the smiley option

		var radioInputSmiley = document.createElement('input');
			radioInputSmiley.setAttribute('type', 'radio');
			radioInputSmiley.setAttribute('name', 'optionQ'+nbQuestions);
			radioInputSmiley.setAttribute('value', 'smiley');
			radioInputSmiley.setAttribute('id', 'smiley'+nbQuestions);
		var labelSmiley = document.createElement("label");
			labelSmiley.setAttribute("for", "smiley"+nbQuestions);
			labelSmiley.appendChild(document.createTextNode("smiley"));
		var smileyWrapper = document.createElement("div");
			smileyWrapper.appendChild(labelSmiley);
			smileyWrapper.appendChild(radioInputSmiley);
			
		//Creating the textArea option
    	
		var radioInputTextArea = document.createElement('input');
			radioInputTextArea.setAttribute('type', 'radio');
			radioInputTextArea.setAttribute('name', 'optionQ'+nbQuestions);
			radioInputTextArea.setAttribute('value', 'textArea');
			radioInputTextArea.setAttribute('id', 'textArea'+nbQuestions);
		var labelTextArea = document.createElement("label");
			labelTextArea.setAttribute("for", "textArea"+nbQuestions);
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

			_func = function(event){answers(event, answerArea, nbQuestions)};
			//add listener on radio changement
			cWrapper.addEventListener('change', _func);

}

function answers(event, aArea, id){
	var answerArea = aArea;
	//Bug lorsque l'on clique sur le même truc
	answerArea.innerHTML = "";
	switch(event.target.value){
		case 'smiley':
			//emojis http://emojipedia.org/emoji-one/
			//console.log("smiley");
			makeInputImage("smiley0",id,"media/vsadsmiley.png", aArea);
			makeInputImage("smiley1",id,"media/sadsmiley.png", aArea);
			makeInputImage("smiley2",id,"media/neutralsmiley.png", aArea);
			makeInputImage("smiley3",id,"media/happysmiley.png", aArea);
			makeInputImage("smiley4",id,"media/vhappysmiley.png", aArea);
			break;
		case 'textArea':
			console.log("textArea"); 
			break;
		case 'thumbs':
			//console.log("thumbs");
			makeInputImage("thumbs0",id,"media/twothumbsdown.png", aArea);
			makeInputImage("thumbs1",id,"media/thumbdown.png", aArea);
			makeInputImage("thumbs2",id,"media/thumbup.png", aArea);
			makeInputImage("thumbs3",id,"media/twothumbsup.png", aArea);
			makeInputImage("thumbs4",id,"media/threethumbsup.png", aArea);
			break;
	}
}
function addField(event){
    
    //wrapper creation
    var wrapper = document.createElement("div");
    wrapper.setAttribute("class","field");
    
    //Create label
    var inputLabel = document.createElement("input");
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
		var id = applications[i].id.slice(1, applications[i].id.length);
		//console.log("#################");
		var title = $("#nameApplicationLabel"+id).val();
		//console.log("Task : "+title);
		var a = new Application(title);
		//console.log(a.getTitle());
		send("test", JSON.stringify(a));
		
		var questions = $("#T"+id+"> .question");
		//me.id.slice(1, me.id.length);
		for(var y = 0; y < questions.length; y++){
			//Dig out the type of the question (the radio button checked)
			
			var idQ = questions[y].id.slice(1, questions[y].id.length);
			//console.log(idQ);
			var qLabel = $("#question"+idQ).val();
			//console.log(qLabel)
			var qType = $("input[name=optionQ"+idQ+"]:checked").val();
			//console.log(qType);
		}
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

function send(url, object) {
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
	$.get(
		url+".php", // url cible
		"json="+object, // données envoyées 
		function(res){ // le callback
			var message = res;
			console.log(message);
			},
		"json" // type de données reçues
	);
}

//Le résultat de la requête php est encodé en JSON
//Le résultat est converti ensuite en objet Javascript et ranger dans la variable globale armes contenant
// toutes les armes
function processing(req) {
	var message = req.response;
	console.log(JSON.parse(message));
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
	console.log("salut");
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
		}
	});
		
}

$(function() {


	

  });

