var tabName;
var length;
var applicationNumber;
var applicationName;
var printable = false;
var alphabet = Array ('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

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
            applicationNumber = applicationName.length;
        },
        "json"
    );
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
        for (j = 0; j<3; j++){
            var td = document.createElement('td');
            var button = document.createElement("input");
            button.setAttribute("type","radio");
            button.setAttribute("class","radioButtonFS");            
            button.setAttribute("name","radio"+i);
            td.appendChild(button);
            table_row.appendChild(td);
        }
        table.appendChild(table_row);  
    }
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

function getQuestionsName(a) {
    $.get(
        "index.php",
        {
            "action":"FSQuestionName",
            "controller":"FSQuestion",
            "formId":JSON.stringify(a),
        },
        function(res) {
            tabName = res;
            length = tabName.length;
            var name = tabName[0].split("/");
            randomizeAA();
            randomizeFS();
            
        },
        "json"
    );
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
}

function makePrintable(event){
    if (!printable) {
        var selected = document.getElementsByClassName('radioButtonFS');
        for (i = 0; i<selected.length;i++) {
            selected[i].style.visibility = "hidden";
        }
        for (i = 0; i<length;i++){
            var className = "FSmove"+i;
            selected = document.getElementsByClassName(className);
            for (j = 0; j<selected.length;j++){
                selected[j].style.visibility = "hidden";
            }
        }
        printable = true;
    }else{
        var selected = document.getElementsByClassName('radioButtonFS');
        for (i = 0; i<selected.length;i++) {
            selected[i].style.visibility = "visible";
        }
        for (i = 0; i<length;i++){
            var className = "FSmove"+i;
            selected = document.getElementsByClassName(className);
            for (j = 0; j<selected.length;j++){
                selected[j].style.visibility = "visible";
            }
        }
        printable = false;
    }
}

function pdf(event){
	var html = document.body.innerHTML;
	    $.post(
        "lib/TCPDFImport.php",
        {
            "test":html
        },
        function(res) {
            console.log(res);
        }
    );
}



function init(){
    getApplication('1');
    getQuestionsName('1'); //1 is the form ID
    document.getElementById("print").addEventListener("click",makePrintable);
	$("#pdf").click(pdf);
}


$(init);