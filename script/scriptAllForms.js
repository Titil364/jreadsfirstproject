$('select').on('change',function(){
    
  var formId =  $(this).parent().parent().children().get(0).textContent;
  var value = $(this).val();
  console.log("formId = "+formId);
  console.log("valueSelect = "+value);
  changeFillable(formId, value);
})

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