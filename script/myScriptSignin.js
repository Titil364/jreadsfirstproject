function checkExisting(event){
	console.log("début");
	var nique = $("#userNickname").val();
	$.post(
		"index.php", // url cible
		{
			"action":JSON.stringify("existingUser"),
			"controller":JSON.stringify("users"),
			"userNickname":JSON.stringify(nique)
		}, // données envoyées
		function(res){ // le callback
			var message = JSON.decode(res);
			alert("nique ta mere");
		},
		"json" // type de données reçues
	);
    console.log("fin");
	
}

function init(){
    document.getElementById("validation").addEventListener("click",checkExisting);
	
}

$(init);