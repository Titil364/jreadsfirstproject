var visitorId = getVisitorId();
var formId = getFormId();

function getFormId(){
    var f = document.getElementById("formId");
    return f.value;
}

function getVisitorId(){
    var f = document.getElementById("visitorId");
    return f.value;
}

function getApplicationId(){
    var f = document.getElementById("applicationId");
    return f.value;
}
function getPre(){
    var f = document.getElementById("pre");
    return f.value;
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
function addAAEvent(){           //Add eventListener on each table Row of the AA table
    var select = $("#aa tbody tr");
    for (i = 0; i<select.length; i++) {
        select[i].addEventListener("change", function(){
           var tmp = $(this);
           saveAA(tmp);
        });
    }
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

function addEventToAll(){
	$(document).on("change",".question input[type=radio]", saveAnswer);
    
    $(document).on("change","textarea", saveAnswer);
    
    addAAEvent();
}

function submit(){
	var visitorId = getVisitorId();
	var applicationId = getApplicationId();
	var pre = getPre();

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

function init(){
	$("#submit").click(submit);
	addEventToAll();
}


$(init);