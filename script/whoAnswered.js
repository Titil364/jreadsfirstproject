var formId;
var cpt;

function getFormId(){
    formId = document.getElementById("formId").value;
}
function getCpt(){
    var select = $("#users>tr");
    var f = select[select.length-1];
    cpt = f.id;
}

function addUser(event){
    var f = document.getElementById("numberVisitor").value;
    if (f===null) {
        f = 1;
    }
    console.log(f);
    for (i=0; i<f; i++){
        cpt++;
        var visitorId = formId+cpt;
        console.log(visitorId);
        send(visitorId, formId);
    }
}

function send(v, f) {
    $.post(
        "index.php",
        {
            "action":"addVisitor",
            "controller":"visitor",
            "visitorId":JSON.stringify(v),
            "formId":JSON.stringify(f)
        },
        function(res){
            if (res == true) {
                var table = document.getElementById("users");
                var tableRow = document.createElement('tr');
                var tableDId = document.createElement('td');
                var tableDUsed = document.createElement('td');
                var visitorId = v;
                console.log(visitorId);
                var textId = document.createTextNode(visitorId);
                var textUse = document.createElement("img");
                    textUse.setAttribute('src', 'docs/No.png');
                    textUse.setAttribute('width', '44px');
                    textUse.setAttribute('height', '30px');
                    tableDId.appendChild(textId);
                    tableDUsed.appendChild(textUse);
                    tableRow.appendChild(tableDId);
                    tableRow.appendChild(tableDUsed);
                    table.appendChild(tableRow);
            }else{
                alert ("error when saving the new user");
            }
        },
        "json"
    );
}

function init() {
    getFormId();
    getCpt();
    document.getElementById("addUser").addEventListener("click", addUser);
}

$(init);