var b = document.body;
var nbTasks = 1;

function addTask(event){
	//Recovery of the container
	var form = document.getElementById("newForm");
	
	//Creation of the task wrapper
	var task = document.createElement("div");
		task.setAttribute("class", "task");
		task.setAttribute("id", "T"+nbTasks);
		form.appendChild(task);
	
	//Creation of the childs
	
	var wrapper = document.createElement("div");
	task.appendChild(wrapper);
	
		//The label of the task's name
	var taskNameLabel = document.createElement("label");
		taskNameLabel.setAttribute("for","nameTaskLabel"+nbTasks);
		taskNameLabel.innerHTML ="Name of the task : ";
		wrapper.appendChild(taskNameLabel);
		//The input of the task's name
    var inputTaskName = document.createElement("input");
		inputTaskName.type = "text";
		inputTaskName.id="nameTaskLabel"+nbTasks;
		inputTaskName.name="title";
		inputTaskName.placeholder="Task's Title";
		wrapper.appendChild(inputTaskName);
	
	//Creation of the remove task button
	var removeTaskButton = document.createElement("button");
		removeTaskButton.setAttribute("class", "removeButton");
		removeTaskButton.type="button";
		removeTaskButton.value= "Remove the task";
		removeTaskButton.innerHTML ="Remove the task";
		wrapper.appendChild(removeTaskButton);
		
		//Add the event for removing the task
			removeTaskButton.addEventListener("click", function(event){
				removeMe(event, task);
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
	
	nbTasks++;
}
function removeMe(event, me){

	var inputChild = me.getElementsByTagName("input")[0];
	var parent = me.parentElement;
	if(me.className === "task" & !(inputChild.value=="")){
				if(confirm("Are you sure you wanna delete this task ? \nIt will delete all the questions included in the task.")){
			parent.removeChild(me);
		}
	}
	else
		parent.removeChild(me);
}

function addQuestion(event, button) {
    //console.log(button);
	//console.log(button.parentElement);
	
	//Recovery of the task associated with the question (button's parent)
		//the button is in a wrapper but we need to climb up to the task container
	var task = button.parentElement.parentElement;
		//
	var nbQuestions = task.children.length;
	
	//Creation of the question wrapper
	var qWrapper = document.createElement("div");
	qWrapper.setAttribute("id", "q"+nbQuestions);
	qWrapper.setAttribute("class", "question");
	task.appendChild(qWrapper);
	
	//Creation of the childs
		
		//The label of the question
	var taskNameLabel = document.createElement("label");
		taskNameLabel.setAttribute("for","id1");
		taskNameLabel.innerHTML ="Question n°"+nbQuestions+" : ";
		qWrapper.appendChild(taskNameLabel);
		
		
		//The input of the task's name
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
		
		//Add the event for removing the task
			removeQButton.addEventListener("click", function(event){
				removeMe(event, qWrapper);
			});
	
}
function addField(event) {
    //fieldset creation
    var fieldset = document.createElement("fieldset");
    
    //wrapper creation
    var wrapper = document.createElement("div");
    wrapper.setAttribute("class","addQuestionButton");
    
    //Create label
    var inputLabel = document.createElement("input");
    inputLabel.type = "text";
    inputLabel.placeholder ="Your Field name";
    wrapper.appendChild(inputLabel);
        
    var removeTaskButton = document.createElement("button");
		removeTaskButton.setAttribute("class", "removeButton");
		removeTaskButton.type="button";
		removeTaskButton.value= "Remove the Field";
		removeTaskButton.innerHTML ="Remove the Field";
		wrapper.appendChild(removeTaskButton);
		
		//Add the event for removing the task
			removeTaskButton.addEventListener("click", function(event){
				removeMe(event, wrapper);
			});
            
    //Add fieldset to thecode
    var newField = document.getElementById("newField");
    newField.appendChild(wrapper);
}


document.getElementById("addTask").addEventListener("click", addTask);
document.getElementById("addField").addEventListener("click",addField);

//#############################################
//
// Remove the number : "Task n°x", will be difficult to deal with if we remove a task
// Same for the question
//
//
//##############################################
