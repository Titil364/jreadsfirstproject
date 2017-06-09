var b = document.body;
var nbApplication = 0;
var placeholders;
var fsquestions;
var qType = [];

/**
  * \brief Add an application to the DOM
	
	This function is triggered when clicking on the "Add an application" button.
	This function has beend modified by 
  * \author Cyril Govin
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
}

/**
  * \author Cyril Govin
  * \brief Display the image from the input in the imgDisplayer parameter.
	
	This function is triggered when the input file is changed (this input accepts only image files)
	When the file is finnaly loaded, the image is displayed in the imgDisplayer
  * \param input The image input which accepts only img files
  * \param imgDisplayer The wrapper which supposed to display the img file
  */
function displayImage(input, imgDisplayer){
 	if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(imgDisplayer).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
/**
  * \author Cyril Govin
  * \brief Add an event "on focus" to the body which will empty the imgDisplayer if no file has been loaded. 
	
	This function is triggered when the img-file input is clicked by the user. 
  * \param input The image input which accepts only img files
  * \param imgDisplayer The wrapper which supposed to display the img file
  *
  */
function noSelection(input, imgDisplayer){
 	document.body.onfocus = function(event){
 		emptyImage(input, imgDisplayer);
 	};	
}

/**
  * \author Cyril Govin
  * \brief Empty the img variable which display the img
	
	This function is triggered when the body has the focus. 
  * \param input The image input which accepts only img files
  * \param img The wrapper which supposed to display the img file (this variable is the same imgDisplayer variable as the previous function )
  *
  */
function emptyImage(input, img){
 	if($(input).val()){
 		img.src = "";
 	}
 	document.body.onfocus = null;
}

/**
  * \author Cyril Govin
  * \brief Delete an element from the DOM
	
	This function is triggered when clicking on each "Remove" button and is adaptative. 
	This function is messy and can be changed. Don't forget to refreshApplication and refreshQuestion when deleting an application or question. 
  * \param input The image input which accepts only img files
  * \param img The wrapper which supposed to display the img file (this variable is the same imgDisplayer variable as the previous function )
  *
  */
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
/**
  * \author Cyril Govin
  * \brief Correct the id of all applications, changing each id according to their order
	
	This function is invoked in RemoveMe. 
  *
  */
function refreshApplication(){
	var application = $(".application");
	var idForm = $(".formCss")[0].id;
	idForm = (idForm==="newForm"?"":idForm);
	for(var x = 0; x < application.length; x++){
		var currentA = application[x];
		var prevId = currentA.id;
		var newId = idForm+"Applic"+x;
		currentA.id = newId;
		
		//!< info - idA + "Info"
		var infoA = $(currentA).children()[0];
			infoA.id = newId+"Info";
			//.appCreationTitle
				//!< Maj title - label for - idA + "Name"
				$(infoA).find("label")[0].setAttribute("for", newId+"Name");
				//!< Maj title - input id + name - idA + "Name"
				$("#"+prevId+"Name").attr("name", newId+"Name");
				$("#"+prevId+"Name").attr("id", newId+"Name");
			//!< div
				//!< Maj desc - label for - idA + "Desc"
				$(infoA).find("label")[1].setAttribute("for", newId+"Desc");
				//!< Maj desc - textarea id + name - idA + "Desc
				$("#"+prevId+"Desc").attr("name", newId+"Desc");
				$("#"+prevId+"Desc").attr("id", newId+"Desc");
			//!< div
				//!< Maj img - label for - idA + "Img"
				$(infoA).find("label")[2].setAttribute("for", newId+"Img");
				//!< Maj img - input id + name - idA + "Img"
				$("#"+prevId+"Img").attr("name", newId+"Img");
				$("#"+prevId+"Img").attr("id", newId+"Img");
			

		refreshQuestion(currentA);
	}
}


/**
  * \author Cyril Govin
  * \brief Correct the id of all questions, changing each id according to their order
	
	This function is invoked in RemoveMe and consider the questions' parent.
  * \param parent The 
  */
function refreshQuestion(application){
	var parentId = application.id;
	var preQuestions = $(application).find(".questionPre");
	var postQuestions = $(application).find(".questionPost");
	refreshQuestionPreOrPost(preQuestions, parentId, "pre");
	refreshQuestionPreOrPost(postQuestions, parentId, "post");
}
/**
 * \author Cyril Govin
 * \brief Update all the id, name, class of all questions given in paramater using the parentId and the type ("post" or "pre")
 * \param questions An array containing the questions
 * \param parentId The id of the parent (formId + Applic + position of the application)
 * \param text The type of the question. It shall be 'post' or 'pre'
 */
function refreshQuestionPreOrPost(questions, parentId, text){

	for(var i = 0; i < questions.length; i++){
		var currentQ = questions[i];
		
		console.log(currentQ);
	//!< Maj id wrapper - IdQ
		var newId = parentId + "Q" + (i+1) + text;
		var prevId = currentQ.id;
		currentQ.id = newId;
		//!< div
		var questionInfo = $(currentQ).children()[0];
		
		console.log(questionInfo);
			//!< Maj label for idQ + "Name"
		$(questionInfo).children()[0].setAttribute("for", newId+"Name");
		$(questionInfo).children()[0].innerHTML = "Question "+text.capitalizeFirstLetter()+" n°"+(i+1)+" : ";
		
			//!< Maj input id idQ + "Name"
		$("#"+prevId+"Name").attr("id", newId+"Name");
		$("#"+prevId+"Name").attr("name", newId+"Name");

		var option = $(questionInfo).find("select").children();
		
		for(var y = 0; y < option.length; y++){
			option[y].id = $(option[y]).val()+newId;
		}
			//!< divCheckbox	
		var divCheckbox = $(currentQ).find(".divCheckbox");
		if($(divCheckbox).children().length > 0){
					//!< Maj label box
			$(divCheckbox).find("label")[0].setAttribute("for", "checkbox"+newId);
					//!< Maj input box - "checkbox" + IdQ
			$(divCheckbox).find("input")[0].setAttribute("id", "checkbox"+newId);
			
			var isCustom = "";
			if($("#checkbox"+newId).is(':checked')){
				//!< divCustomTitle
					//!< If checked maj label custom
				$(divCheckbox).find(".divCustomTitle label")[0].setAttribute("for", "titlecheckbox"+newId);
					//!< If checked maj title custom - "titlecheckbox" + IdQ
				$(divCheckbox).find(".divCustomTitle input")[0].setAttribute("id", "titlecheckbox"+newId);
					//!< If checked maj id p - "msgcheckbox" + IdQ
				$(divCheckbox).find(".divCustomTitle p")[0].setAttribute("id", "msgcheckbox"+newId);

				isCustom = "custom";

			}
			//.answerArea
				var answerArea = $($(currentQ).find(".answerArea")).children();
					//!< foreach div
				for(var y = 0; y < answerArea.length; y++){
					var elem = answerArea[y];
					//!< span - IdQ + value
					var value = $(elem).find("span")[0].innerHTML;
					$(elem).find("span")[0].setAttribute("id", newId+value);
					//!< label - IdQ + value (ex smiley1)
					$(elem).find("label")[0].setAttribute("for", isCustom+newId+value);
					if(isCustom === "custom"){
						
						//!< If checked maj id input custom - custom + idQ + value
							//!< If checked maj class input custon - fieldcheckbox + IdQ
						$(elem).find("input")[0].setAttribute("id", isCustom+newId+value);
						$(elem).find("input")[0].setAttribute("class", "fieldcheckbox"+newId);
					}
				}
		}
	}
}

/**
 * \author Cyril Govin
 * \author Alexandre Comas
 * \brief Add a question to the form
	This function is triggered when clicking on the "Add a question" button. 
	It takes in account if the question is pre or post. 
 * \param event The clicking event
 * \param parent The application parent
 * \param preOrPost The type "pre" or "post" shall be given
 */
function addQuestion(event, parent, preOrPost) {
    //console.log(button);
	//console.log(button.parentElement);
	
	var p = preOrPost;
	var P = preOrPost.capitalizeFirstLetter();
	//!< Recovery of the application associated with the question (button's parent)
		//!< the button is in a wrapper but we need to climb up to the application container
	var application = parent;
		
	var nbQuestions = application.children.length-1;
	
	var questionName = application.parentNode.id+"Q"+nbQuestions;

	var applicNumber = application.parentNode.id.split("Applic")[1];
	
	//!< Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", questionName+p);
	qWrapper.setAttribute("class", "question"+P);
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
				removeQButton.addEventListener("click", function(event){
					removeMe(event, qWrapper);
				});
	qWrapper.appendChild(questionInfoWrapper);
			
	//!< Add evalutation choices
	
	
		//!< Add a choice wrapper
		var cWrapper  = document.createElement("select");
			questionInfoWrapper.appendChild(cWrapper);

		
		for(var name in placeholders){
			var option = document.createElement('option');
				option.setAttribute('required', 'required');
				option.setAttribute('value', name);
				option.setAttribute('id', name+questionName+p);
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
 * \brief Change the answer area depending on questionType
 * \param event The clicking event 
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

	var questionId = "Applic"+customCheckboxId.split('Applic')[1];

	var splittedId  = questionId.match(/[a-zA-Z]+|[0-9]+/g); //separating numbers and characters into an array ex : "Applic1Q5pre"

	var numApp = splittedId[1]; // in ex will be 1

	var numQuest = splittedId[3]; //in ex will be 5

	var prepost = (splittedId[4]=="pre")?0:1; //in ex pre -> 0


	if ($(customCheckbox).is(':checked'))  { // ------- CHECKED : creating fields, collapsing titles

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
		//console.log(answerAreadivs);
		for (var i = 0; i<answerAreadivs.length; i++ ){ //for each one
			var span = $(answerAreadivs[i]).find("span")[0];	//finding the span of title

			var customField = document.createElement('input'); //creating a input field
			customField.setAttribute("class","field"+customCheckbox.id);
			customField.setAttribute("id","custom"+ span.id);
			answerAreadivs[i].appendChild(customField);

			span.style.visibility = "collapse";		//collapsing title

		}


	}else{									// ------- UNCHECKED : deleting all fields, setting visibility back for titles


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
 * \author Cyril GOvin
 * \brief Add a new custom field for personnal information
 * \param event the event
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
 * \brief Make radio button
	
 * \param the radio button name
 * \param value its value
 * \param text the text inside the button
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

/**
 * \author Cyril Govin
 * \brief JSON function which ask to the database all the question types available for the user. 
 
	The types are put in qType as 'questionTypeName' => 'questionTypeId'
	This function is invoked when the DOM is ready. 
 */
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
				$("select").trigger("change");
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
				removeMe(event, wrapperv);
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
				}
				
				else { // if already existing : not available 
					msgZone.style.color = "red";
					msgZone.innerHTML = "Title already used." 
				}
			},
			"json"
		);
	}

}

/**
 * \author Cyril Govin
 * \author Alexandre Comas
 * \brief Initialize the page. 
	Add all required events and invokes the answersPlaceholder function? 
 */
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




/**
 * \brief Capitalize the first letter of a string
	
 * \return The string which the first letter capitalized. 
 */
String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}