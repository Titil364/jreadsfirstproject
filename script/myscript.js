var b = document.body;
var nbElement = 0;

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
	/*if(me.className === "question"){
		var id = me.id.slice(1, me.id.length);
		
		var questions = $("#"+parent.id+" > .question");
		console.log(questions);
		console.log(questions.length);
		for(var i = id; i < questions.length-1; i++){
			questions[id+1].id = "q"+id;
			$(questions).children()[0].setAttribute("for", "question"+id);
			$(questions).children()[1].id = "question"+id;
			if($ques)
		}
	}*/
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
			cWrapper.appendChild(answerArea);

			//add listener on radio changement
			cWrapper.addEventListener('change', function(event){
				answers(event, answerArea);
			});




}

function answers(event, aArea){
	var answerArea = aArea;
	//on vide la zone rep
	answerArea.innerHTML = "";
	switch(event.target.value){
		case 'smiley':
			//emojis http://emojipedia.org/emoji-one/
			//console.log("smiley");
			makeInputImage("smiley",-2,"media/vsadsmiley.png", aArea);
			makeInputImage("smiley",-1,"media/sadsmiley.png", aArea);
			makeInputImage("smiley",0,"media/neutralsmiley.png", aArea);
			makeInputImage("smiley",1,"media/happysmiley.png", aArea);
			makeInputImage("smiley",-2,"media/vhappysmiley.png", aArea);
			break;
		case 'textArea':
			console.log("textArea"); 
			break;
		case 'thumbs':
			//console.log("thumbs");
			makeInputImage("thumbs",-2,"media/twothumbsdown.png", aArea);
			makeInputImage("thumbs",-1,"media/thumbdown.png", aArea);
			makeInputImage("thumbs",0,"media/thumbup.png", aArea);
			makeInputImage("thumbs",1,"media/twothumbsup.png", aArea);
			makeInputImage("thumbs",-2,"media/threethumbsup.png", aArea);
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

    label.appendChild(radio);

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
sy		var title = $("#nameApplicationLabel"+id).val();
		//console.log("Task : "+title);
		//var a = new Application(title);
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


	
