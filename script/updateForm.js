	persoInfoToDelete = [];
FSToDelete = [];

function getFormId(){
    var f = document.getElementsByClassName("formCss");
    return f[0].getAttribute("id");
}

function deletePersonnalInformation(self){	
	var parent = self.currentTarget.parentNode;
	persoInfo = $(parent).find("input").val();

	//remove
	$(parent).remove();
	persoInfoToDelete.push(persoInfo);

}

function deleteFSQuestion(self){	
	var parent = self.currentTarget.parentNode;
	var input = $(parent).find("input");
	var name = $(input[0]).val() + "/" + $(input[2]).val();
	FSToDelete.push(name);
	//remove
	$(parent).remove();
}


function removeMe(self){
	var parent = self.currentTarget.parentNode;
	$(parent).remove();
}


function toDelete(self, tab){
	var parent = self.currentTarget.parentNode;
	var elem = $(parent).find("input");
	var info = elem[0].id;
	
	if($(elem).is(":checked")){
		var index = persoInfoToDelete.indexOf(info);
		if(index > -1)
			tab.splice(index, 1);		
	}else{
		tab.push(info);
	}
}


function addEventDelete(){
	$(document).on("click",".removeButtonAECustom", deletePersonnalInformation);

	$(document).on("click",".removeButtonAE", removeMe);
	$(document).on("click",".removeButtonFS", deleteFSQuestion);
	
	$(document).on("change",".defaultInformationAlreadyChecked", function(self){
		toDelete(self, persoInfoToDelete)
	});

	$(document).on("change",".defaultFSQuestionAlreadyChecked", function(self){
		toDelete(self, FSToDelete)
	});
	
	
	
	
	//<<focusin>> save the previous value
	//<<change>> check if the value are different and delete the link between the form and the personnal information
	$(document).on('focusin', '.fieldInputCustom', function(){
		//console.log("Saving value " + $(this).val());
		$(this).data('val', $(this).val());
	}).on('change','.fieldInputCustom', function(){
		var prev = $(this).data('val');
		var current = $(this).val();
		console.log(prev)
		
		deletePersonnalInformation(null, prev);
		
		$(this).switchClass("fieldInputCustom", "fieldInput");
		
		var parent = this.parentNode;
		$(parent).find("button").switchClass("removeButtonAECustom", "removeButtonAE");
		
		//console.log("Prev value " + prev);
		//console.log("New value " + current);
	});
	
	//<<focusin>> save the previous value
	//<<change>> check if the value are different and delete the link between the form and the personnal information
	$(document).on('focusin', '.questionInputLeftCustom, .questionInputRightCustom', function(){
		//console.log("Saving value " + $(this).val());
		$(this).data('val', $(this).val());
	}).on('change','.questionInputLeftCustom, .questionInputRightCustom', function(){
		var prev = $(this).data('val');
		var current = $(this).val();
		
		
		var parent = this.parentNode.parentNode.parentNode.parentNode.parentNode;
		console.log(parent);
		var input = $(parent).find("input");
		
		console.log(input);
		
		$(input[0]).switchClass("questionInputLeftCustom", "questionInputLeft");
		$(input[2]).switchClass("questionInputRightCustom", "questionInputRight");

		if(this.className === "questionInputLeft"){
			var name = prev + "/" + $(input[2]).val();
			FSToDelete.push(name);
		}else{
			var name =  $(input[0]).val()+ "/" + prev;
			FSToDelete.push(name);
		}
		
		$(parent).find("button").switchClass("removeButtonFS", "removeButton");
	});
}


function init2(){
	addEventDelete();
	$("#submit").click();

}


$(init2);