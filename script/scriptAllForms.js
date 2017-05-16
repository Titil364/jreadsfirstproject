
//Not used atm
//Fillable was a state of the form regarding if the form is available or not
$('select').on('change',function(){
  var formId =  this.parentNode.parentNode.id;
  var value = $(this).val();
  console.log("formId = "+formId);
  console.log("valueSelect = "+value);
  changeFillable(formId, value);
});
//Not used atm
function changeFillable(form, newfill) {
    $.post(
        "index.php",
        {
            "controller":"form",
            "action": "changeFillable",
            "form": JSON.stringify(form),
            "newFill": JSON.stringify(newfill)
        },
        function (res){
            console.log("ca passe");
            if (res === false) {
                console.log("res = false");
            } else{
                console.log("res = true");
            }
        }, "json"
    );
}

function updateForm(event){
  var formId = event.target.id;
 
  var adr = "index.php?";
  var params = jQuery.param({
          "action":"update",
          "controller":"form",
          "id":formId,
      });
  adr+=params;
  console.log(adr);
      window.location.href = adr;


}

function deleteForm(event){
var r = confirm("Are you sure? (this will delete ALL informations related to this form (including visitor and their answers))");
if (r == true) {
 
  var formId = event.target.id;
    console.log(formId);
      $.get(
        "index.php",
        {
            "controller":"form",
            "action": "delete",
            "id": formId
        },
        function (res){
            location.reload();
        }, "json"
    );
  }
}



function init(){
  $('.updateForm').on('click',updateForm);
  $('.deleteForm').on('click',deleteForm);
}
$(init);
