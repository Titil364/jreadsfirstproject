var applicationNumber;
var applicationName;
var formId;
var visitorId;
var alphabet = Array ('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

function getFormId(){
    var f = document.getElementsByClassName("formCss");
    var g = f[0].getAttribute("id");
    var split =  g.split("-");
    formId = split[1];
    getApplication(formId);
}

function getVisitorId(){
    var f = document.getElementById("visitorId");
    if (f==null) {
        visitorId = 0;
    }else{
        visitorId = f.value;
    }
}
function getApplication(b){
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
			getQuestionsName(b);
        },
        "json"
    );
}
function getQuestionsName(a){
    $.get(
        "index.php",
        {
            "action":"FSQuestionName",
            "controller":"FSQuestion",
            "formId":JSON.stringify(a),
        },
        function(res) {
            if (res.length ==0) {
                var changeCss = $(".fsAndAa");
                if (visitorId !== 0) {
                    randomizeAA();
                }
                return null;
            }
            tabName = res;
            length = tabName.length;
            var name = tabName[0].split("/");
			if (visitorId !== 0) {
                randomizeAA();
                randomizeFS();
            }
        },
        "json"
    );
}

function extractAnswers(){
	var answers=[];
	var n = "", val = "";
	

	var shortcut = $(".shortcut");
	for(var i = 0; i < shortcut.length; i++){
		n = shortcut[i].name;
		val = $("input[name="+n+"]:checked").val();
		/*if(val === undefined | val === ""){
			alert("Please answer to all the questions. ");
			return null;
		}*/
		answers.push(new Answer(n, val));
	}
	var textarea = $("textarea");
		
	for(var i = 0; i < textarea.length; i++){
		val = $(textarea[i]).val();
		/*if(val === undefined | val === ""){
			alert("Please answer to all the questions. aaa ");
			return null;
		}*/
		answers.push(new Answer(textarea[i].name, val));
	}
	
	var f = $("div[id^=form]")[0].id.split("-")[1];
    if (visitorId == 0) {
		var personnalInfo=[];
		var info = $("#userInformation input");
		for(var i = 0; i < info.length; i++){
			val = $(info[i]).val();
			if(val === undefined | val === ""){
				alert("Please answer to all the personnal questions. ");
				return null;
			}
			personnalInfo.push(new Information(info[i].name, val));
		}
        sendPre(f, personnalInfo, answers);
    } else{
		//Extracting the aa datas
		var tr = $("#aa tbody tr");
		var aa = [], td, name, val;
		for(var i = 0; i < tr.length; i++){
			td = $(tr[i]).children();
		 	//console.log(tr[i]);
			//console.log(tr[i].id);
			name = tr[i].id.slice(3, tr[i].id.length);

			val = $("input[name=radio"+i+"]:checked").val();
			if(val === undefined){
				alert("Please answer the again again table. ");
				return null;
			}
			aa.push(new AA(name, val));
		}
		
		//console.log(aa);
		//console.log(JSON.stringify(aa));
		
		
		//Extracting the funsorter data
		var tr = $("#FunSorter tbody tr");
		var fs = [], td, name, tab;
		for(var i = 0; i < tr.length; i++){
			tab = [];
			td = $(tr[i]).children();
			name = td[0].innerHTML + "/" + td[td.length-1].innerHTML;
			//console.log(name);
			for(var y = 1; y < td.length-1; y++){
				tab.push($(td[y]).children()[0].innerHTML);
			}
			fs.push(new FSQ(name, tab));
		}
		
		//console.log(fs);
		//console.log(JSON.stringify(fs));
		

		
        sendPost(f, answers, fs, aa);
    }
	
}

function sendPre(f, pi, a){

	$.post(
		"index.php", // url
		{
			"action":"completeForm",
			"controller":"form",
			"formId":f,
			"visitorInfo":JSON.stringify(pi),
            "pre":JSON.stringify(0),
			"answers":JSON.stringify(a)
		},  //data
		function(res){ //callback
				if(res !== false){
						$("#submit").unbind("click", extractAnswers);
                        alert(res);
						//setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);					
				}else{
					console.log("Error when saving the answers");
				}
			},
		"json" // type
	);
}
function sendPost(f, a, fs, aa){

	$.post(
		"index.php", // url
		{
			"action":"completeForm",
			"controller":"form",
			"formId":f,
            "visitorId":visitorId,
			"fs": JSON.stringify(fs),
			"aa": JSON.stringify(aa),
            "pre":1,
			"answers":JSON.stringify(a)
		},  //data
		function(res){ //callback
				if(res !== false){
						$("#submit").unbind("click", extractAnswers);
                        alert(res);
						//setTimeout(function(){ window.location="index.php?controller=form&action=read&id="+res; }, 3000);					
				}else{
					console.log("Error when saving the answers");
				}
			},
		"json" // type
	);
}

function randomizeFS() {
        var array = new Array();
         for(i = 0; i < length; i++){
             var a = Math.random()*length;
             var b = Math.ceil(a);
             while (array.includes(b-1)){
                 a = Math.random()*length;
                 b = Math.ceil(a);
             }
            array[i] = b-1;
         }
         var table = document.getElementById("fs"); 
         var tbody = document.createElement("tbody"); //Create tbody 
         table.appendChild(tbody); //Add tbody to the table
         for (i = 0; i<length; i++) {
            var table_row = document.createElement('tr'); //create a table row
            table_row.id = "tr"+array[i]; //Add id to the table row
             
            var name = tabName[array[i]].split("/"); //Split the name when / is met on the string
            var textLeft = document.createTextNode(name[0]); //Two text are created one is containing the left part of the question
            var textRight = document.createTextNode(name[1]); //And the second one, the right part
            var td = document.createElement('td'); //Create TD 
                td.appendChild(textLeft);       //Add left text to the Td
                table_row.appendChild(td);      //Add td to the TR
            for(j=0;j<applicationNumber;j++){   //For each application we let an empty td
                var td = document.createElement('td');
                var div = document.createElement('div');
                    div.setAttribute("class","FSmove"+array[i]);
                var textDiv = document.createTextNode(alphabet[j]);
                div.appendChild(textDiv);
                td.appendChild(div);
                table_row.appendChild(td);
            }
            var td2 = document.createElement('td');
                td2.appendChild(textRight);
                table_row.appendChild(td2);     //Add right text to the td and td to the tr                  
             
             tbody.appendChild(table_row);      //Add tr to the table
         }
         makeFSDraggable();
}
function randomizeAA(){
    var array = new Array();
    for (i = 0; i<applicationNumber;i++) {
        var a = Math.random()*applicationNumber;
        var b = Math.ceil(a);
        while (array.includes(b-1)){
            a = Math.random()*applicationNumber;
            b = Math.ceil(a);
        }
        array[i] = b-1;
    }
    var table = document.getElementById("aa");
    var tbody = document.createElement("tbody");
    for (i=0; i<applicationNumber;i++){
        var table_row = document.createElement('tr');
            table_row.id = "trA"+array[i];
        var td = document.createElement('td');
        var text = document.createTextNode(applicationName[array[i]]);
        td.appendChild(text);
        table_row.appendChild(td);
        for (j = 2; j>=0; j--){
			/* Value : 
			 * 2 = yes
			 * 1 = maybe
			 * 0 = no
			 */
            var td = document.createElement('td');
            var button = document.createElement("input");
            button.setAttribute("type","radio");
            button.setAttribute("class","radioButtonFS");            
            button.setAttribute("name","radio"+i);
            button.setAttribute("value", j);
            td.appendChild(button);
            table_row.appendChild(td);
        }
        tbody.appendChild(table_row);  
    }
	table.appendChild(tbody);
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
    for (k =0; k < length; k++){
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


function init(){
    getFormId();
    getVisitorId();
	$("#submit").click(extractAnswers);
	
}


$(init);