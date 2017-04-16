var nicknameExists = false;
var passwordEquals = false;
function checkForm(event){
    var taille = $("#userPassword").val().length;    
	var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if ($("#userForname").val() == '' || $("#userSurname").val() == '' || $("#userMail").val() == '' || $("#userPassword").val() == '' || $("#userPasswordVerif").val() == '') {
		alert("Fill in the empty fields");
	}
	else{
		if (nicknameExists == false) {
			if ($("#userMail").val().match(regex)) {
				if (taille >= 6) {
					var password = $("#userPassword").val();
					var confirmPassword = $("#userPasswordVerif").val();
					if (passwordEquals==false) {
						alert("Passwords do not match !");
						return 0;
					}
					else{
						$("#userForm").submit();
						window.change("index.php?action=displaySelf&controller=users");						
					}
				}
				else {
					alert("Password too short");
					return 0;
				}
			}
			else{
				alert("Please enter a valid mail address");
				return 0;
			}
		}
		else if (message == 1) {
			alert("This nick name is already taken");
			return 0;
		}
	}	
}
function passwordMatch(event) {
    var password = $("#userPassword").val();
    var confirmPassword = $("#userPasswordVerif").val();

    if (password != confirmPassword){
		passwordEquals = false;
        $("#passwordVerif").html("Passwords do not match!");
		document.getElementById("passwordVerif").style.color="red";
    }
    else{
		passwordEquals = true;
        $("#passwordVerif").html("Passwords match.");
		document.getElementById("passwordVerif").style.color="green";
    }

}
function nicknameVerif (event){
	var nique = $("#userNickname").val();
	if (nique ==="") {
         $("#nicknameVerif").html(" ");
    }else{
		$.post(
			"index.php", // url cible
			{
				"action":JSON.stringify("existingUser"),
				"controller":JSON.stringify("users"),
				"userNickname":JSON.stringify(nique)
			}, // données envoyées
			function(res){ // le callback
				var message = res;
				if (message == 0) {
					nicknameExists = false;
					$("#nicknameVerif").html("This Nickname is free !");
					document.getElementById("nicknameVerif").style.color="green";
				}
				else if (message == 1) {
					nicknameExists = true;
					$("#nicknameVerif").html("This Nickname is already taken!");
					document.getElementById("nicknameVerif").style.color="red";
				}
			},
			"json"
		);
	}
}

function backToForm(event) {
    window.location='index.php';
}

function init(){
    document.getElementById("validation").addEventListener("click",checkForm);
	document.getElementById("userNickname").addEventListener("change",nicknameVerif);
	document.getElementById("userPasswordVerif").addEventListener("change",passwordMatch);
}

$(init);