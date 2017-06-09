var visitorId = getVisitorId();
var applicationNumber;
var formId;

function getFormId(){
    var f = document.getElementById("formId");
    formId = f.value;
    getApplication(formId);
}

function getVisitorId(){
    var f = document.getElementById("visitorId");
    return f.value;
}

function getApplicationId(){
    var f = document.getElementById("applicationId");
    if (f != null) {
        return f.value;
    }
    
}
function getApplication(b){ //Getting the applications for the given formId 
    $.get(
        "index.php",
        {
            "action":JSON.stringify("getApplicationCount"),
            "controller":JSON.stringify("Application"),
            "formId":JSON.stringify(b),
        },
        function(res){
            applicationName = res;              
            applicationNumber = res.length;
        },
        "json"
    );
}
function getPre(){
    var f = document.getElementById("pre");
    if (f != null) {
        return f.value;
    }
}
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


function makeFSDraggable() {
    var FSlength = $("#fs tbody tr").length;
    for (k =0; k < FSlength; k++){
        var select = ".FSmove"+k;
        $( select ).draggable({containment : $(select).parent().parent(), revert: true, helper: "clone" });
    
        $( select ).droppable({
            accept: select,
            drop: function( event, ui) {
    
                var draggable = ui.draggable, droppable = $(this),
                    dragPos = draggable.position(), dropPos = droppable.position();

            
                draggable.css({
                    left: dropPos.left+'px',
                    top: dropPos.top+'px'
                });
                
        
                droppable.css({
                    left: dropPos.left+'px',
                    top: dropPos.top+'px'
                });
                draggable.swap(droppable);                
            }
        });
    }
}

function addAAEvent(){           //Add eventListener on each table Row of the AA table
    var select =$("#aa tbody tr");      
    for (i = 0; i<select.length; i++) {
        select[i].addEventListener("change", function(){
           var tmp = $(this);
           saveAA(tmp);
        });
    }
}
function addFSEvent() {          //Add EventListenr on each table Row of the fun sorter
    var tr = $("#FunSorter tbody tr");
    for (j = 0;j<tr.length;j++){
        tr[j].addEventListener("mouseup", function(){       //The event is the mouseup, so the function is thrown when the user drop the item
            var tmp = $(this);
            setTimeout(function(){ saveFS(tmp); }, 500);        //The function is delayed to give some time to the html to update
        });
    }
}

function saveFS(tmp){       //Save the 
    children = tmp.children();          //Each row is made of FirstPartOfFSQuestion / Appli1 / Appli2/ ... / Appli*/SecondPartOfTheFSQuestion
    var FSQuestionName = children[0].textContent +"/"+ children[(applicationNumber+1)].textContent; //To write the FSQuestionName on the table, we split, so here, to find back the FSQuestion name, which is the primaryKey,we concatenate
    var stringRes = "";
    for (i=1; i<=applicationNumber; i++){ //Form the Second <td> to the before last <td> (=for eachapplication)
        child = children[i];
        grandChild = child.childNodes;
        stringRes += grandChild[0].textContent; //We add each HTML to the stringRes, to build the string which will be saved
    }
    //console.log(FSQuestionName);
    //console.log(stringRes);
    $.post(
		"index.php", // url
		{
			"action":"saveFS",
			"controller":"form",
            "visitorId" : JSON.stringify(visitorId),
            "FSQuestionName" : JSON.stringify(FSQuestionName),
			"applicationOrder" : JSON.stringify(stringRes)
		},
        function (res){
            
        },
        "json"
    );
    
       
    //console.log(applicationNumber);
}
function saveAA(tmp){
    var id = tmp.prop("id");
    //console.log(id);
    val = $("#"+id+" td input:checked").val();  //Looking for the checked item with the given id
    $.post(
		"index.php", // url
		{
			"action":"saveAA",
			"controller":"form",
            "visitorId" : JSON.stringify(visitorId),
            "applicationId" : JSON.stringify(id),
			"value" : JSON.stringify(val)
		},
        function (res){
            
        },
        "json"
    ); 
}



function saveAnswer(self){
	//the input or textarea
	var me = self.currentTarget;
	//console.log(me);
	var visitorId = getVisitorId();
	//console.log(visitorId);
	var questionId = me.name;
	//console.log(questionId);
	
	answer = $(me).val();
	//console.log(answer);
	
	$.post(
        "index.php",
        {
            "action":"saveAnswer",
            "controller":"answer",
            "answer":JSON.stringify(answer),
			"questionId":questionId,
			"visitorId":visitorId
        },
        function(res) {
				console.log(res)
        },
        "json"
    );
}


function addEventToAll(){
	$(document).on("change",".question input[type=radio]", saveAnswer);
    
    $(document).on("change","textarea", saveAnswer);
    
    addAAEvent();
}

function submit(){
    
	var visitorId = getVisitorId();
	var applicationId = getApplicationId();
	var pre = getPre();
    if (applicationId == null) {
        $.post(
            "index.php",
            {
                "action":"sendEnd",
                "controller":"visitor",
                "visitorId":visitorId
            },
            function(res) {
                    if (res) {
                         window.location="index.php?controller=visitor&action=ended";
                    }
            },
            "json"
        );
       
    } else{
        var input = $(".question input");
        
        for(var i = 0; i < input.length; i++){
            if(!$.trim($(input[i]).val())){
                alert("Please answer all the questions. ");
                return;
            }        
        }
        
        var textarea = $(".question textarea");
        for(var i = 0; i < textarea.length; i++){
            if(!$.trim($(textarea[i]).val())){
                alert("Please answer all the questions. ");
                return;
            }        
        }
        
    
    
        $.post(
            "index.php",
            {
                "action":"sendAnswer",
                "controller":"visitor",
                "applicationId":applicationId,
                "visitorId":visitorId,
                "pre":pre
            },
            function(res) {
                    console.log(res)
                    if (res) {
                        location.reload()
                    }
            },
            "json"
        );
    }
}


function init(){
    getFormId();
    getVisitorId();
    makeFSDraggable();
    addFSEvent();
    addAAEvent();
    document.getElementById("submit").addEventListener("click", submit);
	addEventToAll();
}


$(init);