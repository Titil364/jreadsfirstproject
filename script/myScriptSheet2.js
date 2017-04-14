
var tabName;
var length;
var applicationNumber;

/*function getApplicationNumber(b){
    $.get(
        "index.php",
        {
            "action":JSON.stringify("getApplicationCount"),
            "controller":JSON.stringify("Application"),
            "formId":JSON.stringify(b),
        },
        function(res){
            alert("ca passe");
            applicationNumber = res;
            console.log(applicationNumber);
        },
        "json"
    );
}*/
function getQuestionsName(a) {
    $.get(
        "index.php",
        {
            "action":JSON.stringify("FSQuestionName"),
            "controller":JSON.stringify("FSQuestion"),
            "formId":JSON.stringify(a),
        },
        function(res) {
            alert("ca passe FS");
            tabName = res;
            length = tabName.length;
            var name = tabName[0].split("/");
            function randomizeFS() {
                var array = new Array();
                for(i = 0; i < length; i++){
                    var a = Math.random()*length;
                    var b = Math.ceil(a);
                    while (array.includes(b)){
                        a = Math.random()*length;
                        b = Math.ceil(a);
                    }
                array[i] = b;
                }
                var wrap = ($("#FunSorter>table>tbody"));
                var table = document.getElementById("fs");
                var tbody = document.createElement("tbody");
                table.appendChild(tbody);
                for (i = 0; i<length; i++) {
                    var table_row = document.createElement('tr');
                    table_row.id = "tr"+array[i];
                    tbody.appendChild(table_row);
                }
                for (i = 0; i<length; i++){
                    var name = tabName[i].split("/");
                    var textLeft = document.createTextNode(name[0]);
                    var textRight = document.createTextNode(name[1]);
                    var tr = document.createElement('td');
                        tr.appendChild(textLeft);
                    
                    
                }
            }
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


function makeFSDraggable(event) {
    for (i =0; i < length; i++){
        var select = ".FSmove"+i;
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





function init(){
    //makeFSDraggable();
   // getApplicationNumber('1');
    getQuestionsName('1'); //1 is the form ID
    //randomizeFS();
}


$(init);