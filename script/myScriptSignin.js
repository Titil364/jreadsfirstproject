function checkExisting(event){
	var nique = $("#userNickname").val();
    var taille = $("#userPassword").val().length;
    console.log(taille);
	$.post(
		"index.php", // url cible
		{
			"action":JSON.stringify("existingUser"),
			"controller":JSON.stringify("users"),
			"userNickname":JSON.stringify(nique)
		}, // données envoyées
		function(res){ // le callback
			var message = res;
            var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			console.log("Réponse '"+message+"'");
            if (message == '0') {
                if ($("#userForname").val() == '' || $("#userSurname").val() == '' || $("#userMail").val() == '' || $("#userPassword").val() == '' ) {
                    alert("Fill in the empty fields");                    
                }
                else{
                    if ($("#userMail").val().match(regex)) {
                        if (taille >= 6) {
                            console.log("Ca passe creme");
                            $("#userForm").submit();
                        }
                        else {
                            alert("Password too short");
                        }
                    }
                    else{
                        alert("Please enter a valid mail address");
                    }
                }
            }
            else if (message == 1) {
                alert("This nickname is already taken !")
            }
		},
		"json" // type de données reçues
	);
	
}

function init(){
    document.getElementById("validation").addEventListener("click",checkExisting);
	
}

$(init);