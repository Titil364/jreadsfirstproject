

function getFormId(){
    var f = document.getElementsByClassName("formCss");
    var g = f[0].getAttribute("id");
    var split =  g.split("-");
    return split[1];
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
function addEventToInput(){
	$(document).on("change","input[type=radio]", saveAnswer);
    
    $(document).on("change","textarea", saveAnswer);
}

function submit(){
	var visitorId = getVisitorId();
	var applicationId = getApplicationId();
	var pre = getPre();
	console.log(pre);
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
        },
        "json"
    );
}

function init(){
	$("#submit").click(submit);
	addEventToInput();
}


$(init);