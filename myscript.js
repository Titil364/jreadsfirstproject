var b = document.body;
var nbTasks = 0;
var tasks = ["null"];

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

function addQuestion(event, button) {
    console.log(button);
    alert(button);
     alert(button);
}

