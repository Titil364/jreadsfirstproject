var deletedUsers = [];
/**
 * \author Cyril Govin
 * \brief Delete an user from the database
 */
function deleteUser(){
	var children = this.parentNode.parentNode.getElementsByTagName("td"), s = children[0].innerHTML, f = children[1].innerHTML;
	

	if(confirm("Do you really want to delete "+ s + " " + f + " ?")){
		var id = this.parentNode.parentNode.id;
	
		$.ajax({
			type: 'GET',
			url: "index.php",
			data: {
					"controller":"users",
					"action": "delete",
					"userId":id
				}, 
			dataType: "json",
			success: function(res){console.log(res)},
			async:true
		});
		$("#"+id).remove();
		deletedUsers.push(id);
	}
}
/**
 * \author Cyril Govin
 * \brief JSON Activate or desactivate and account
 */
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
/**
 * \author Cyril Govin
 * \brief JSON syncronized Delete the $_SESSION['users'] containing all the users
	This function is triggered before the window is unload (onbeforeunload event)
 */
function destroySessionUser(){
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
	$('.deleteAccount').on('click', deleteUser);
	window.onbeforeunload = destroySessionUser;
}
$(init);