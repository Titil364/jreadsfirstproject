

function changeStatus(id, n, v) {
    $.post(
        "index.php",
        {
            "controller":"users",
            "action": "changeUser",
			"userPosition": id,
            "name": n,
			"val": v
        },
        function (res){
            console.log(res);
        }, 
		"json"
    );
}

function destroySessionUser(){
	alert("bite");
	$.ajax({
		type: 'POST',
		url: "index.php",
		data: {
				"controller":"users",
				"action": "deleteSessionUser",
			}, 
		success: function(res){console.log(res)},
		async:false
	});
}
function init(){
	$('select').on('change',function(){

		var id = this.parentNode.parentNode.id;
		var name = this.name;
		var val = $(this).val();
		changeStatus(id, name, val);
	});
	window.onbeforeunload = destroySessionUser;
}
$(init);