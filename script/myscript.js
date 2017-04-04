var b = document.body;
var nbTasks = 1;

function addTask() {
    nbTasks ++;
    var question =[];
    tasks.push(question);
	
    var div = document.getElementById("newTask");
    var field = document.createElement("fieldset");
    field.id = nbTasks;
    div.appendChild(field);
    var newDiv = document.getElementsByTagName("fieldset");
    var label1 = document.createElement("label");
    label1.setAttribute("for","id1");
    label1.innerHTML ="Name : ";
    newDiv[nbTasks].appendChild(label1);
    var input = document.createElement("input");
    input.type = "text";
    input.id="id1";
    input.name="title";
    input.placeholder="Task's Title";
    newDiv[nbTasks].appendChild(input);
	
    var button = document.createElement("button");
    button.type="button";
    button.value="Preview";
    button.innerHTML ="Preview";
    newDiv[nbTasks].appendChild(button);
    var divClass = document.createElement("div");
    divClass.class ="button";
    newDiv[nbTasks].appendChild(divClass);
    var buttonQuestion = document.createElement("button");
    buttonQuestion.type = "button";
    buttonQuestion.value= "Add Question";
    buttonQuestion.innerHTML ="Add a question";
    divClass.appendChild(buttonQuestion);
		//Add the event for adding the question
		buttonQuestion.addEventListener("click", function(event){
			addQuestion(event, buttonQuestion);
		});
}

function addTask2(event){
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
		taskNameLabel.innerHTML ="Name of the task n°"+nbTasks+" : ";
		wrapper.appendChild(taskNameLabel);
		//The input of the task's name
    var inputTaskName = document.createElement("input");
		inputTaskName.type = "text";
		inputTaskName.id="nameTaskLabel"+nbTasks;
		inputTaskName.name="title";
		inputTaskName.placeholder="Task's Title";
		wrapper.appendChild(inputTaskName);
	
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
	
}


document.getElementById("addTask").addEventListener("click", addTask2);
