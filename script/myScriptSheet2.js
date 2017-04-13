

    
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

var length  = ($("#FunSorter>table>tbody>tr").length);

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
function randomizeFS(event) {
    var array = new Array();
    for(i = 0; i < length; i++){
        var a = Math.random()*length;
        var b = Math.ceil(a);
        while (array.includes(b)){
            var a = Math.random()*length;
            var b = Math.ceil(a);
        }
        array[i] = b;
    }
}
$(".randomizeFS");




function init(){
    makeFSDraggable();
}

$(init);