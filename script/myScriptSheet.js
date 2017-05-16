var tabName;
var length;
var applicationNumber;
var applicationName;
var printable = false;
var AAfilled;
var alphabet = Array ('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
var formId;
var visitorId;
var FSfilled;

function getApplication(b){
    $.get(
        "index.php",
        {
            "action":JSON.stringify("getApplicationCount"),
            "controller":JSON.stringify("Application"),
            "formId":JSON.stringify(b),
        },
        function(res){
            applicationName = res;
            applicationNumber = applicationName.length;
			//getQuestionsName(formId); //1 is the form ID
        },
        "json"
    );
}

function getVisitorId(){
    var f = document.getElementById("visitorId");
    visitorId = f.value;
}

function getQuestionsName(a){
    $.get(
        "index.php",
        {
            "action":"FSQuestionName",
            "controller":"FSQuestion",
            "formId":JSON.stringify(a),
        },
        function(res) {
            if (res.length ==0) {
                var changeCss = $(".fsAndAa");
                for (var k = 0; k <changeCss.length; k++) {
                   // changeCss[k].style.visibility = "hidden";
                }
                randomizeAA();
                return null;
            }
            tabName = res;
            length = tabName.length;
            var name = tabName[0].split("/");
			
            randomizeAA();
            randomizeFS();
        },
        "json"
    );
}


    
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


function makePrintable(event){
    if (!printable) {
        var selected = document.getElementsByClassName('radioButtonFS');
        for (i = 0; i<selected.length;i++) {
            selected[i].style.visibility = "hidden";
        }
        for (i = 0; i<length;i++){
            var className = "FSmove"+i;
            selected = document.getElementsByClassName(className);
            for (j = 0; j<selected.length;j++){
                selected[j].style.visibility = "hidden";
            }
        }
        printable = true;
    }else{
        var selected = document.getElementsByClassName('radioButtonFS');
        for (i = 0; i<selected.length;i++) {
            selected[i].style.visibility = "visible";
        }
        for (i = 0; i<length;i++){
            var className = "FSmove"+i;
            selected = document.getElementsByClassName(className);
            for (j = 0; j<selected.length;j++){
                selected[j].style.visibility = "visible";
            }
        }
        printable = false;
    }
}
var 
	form = $('#form1'),
    heightPDF = form.height(),
    widthPDF = form.width(),
	a4  =[widthPDF, heightPDF];  // for a4 size paper width and height

function pdf(event){
	var html = document.body.innerHTML;
	    $.post(
        "lib/TCPDFImport.php",
        {
            "test":html
        },
        function(res) {
            console.log(res);
        }
    );
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
//document.getElementById("formId").value;
//This line as been put as a commentary, it was breaking the AATable and the FS

//create pdf

function createPDF(event){
    /**
    $('html, body').animate({ scrollTop: 0 }, 'fast');
	getCanvas().then(function(canvas){
		var 
		img = canvas.toDataURL("image/png"),
		doc = new jsPDF(
          'p',"px",[widthPDF / 1.5,heightPDF / 1.4]
        );     
        doc.addImage(img, 'JPEG', 0, 0);
        doc.save('Form.pdf');
        form.width(widthPDF);
        doc.addHTML(document.body,function() {
            pdf.output('datauri');
        })
	});*/
    var id = getFormId();

    var adr = "index.php?";
    var params = jQuery.param({
            "action":"toPDF",
            "controller":"form",
            "id":id,
        });
    adr+=params;
    console.log(adr);
        window.location.href = adr;


}


// create canvas object
function getCanvas(){
	//form.width((a4[0]) -80).css('max-width','none');
	return html2canvas(form,{
    	imageTimeout:2000,
    	removeContainer:true
    });	
}

function getFormId() {
    var select = $( "div[id*='form']");
    var f = $(select).attr('id');
    var id = f.split("-");
    formId = id[1];

    return formId;
}

function init(){
    getFormId();
    getVisitorId();
    getApplication(formId);
    var print = document.getElementById("print");
	if(print){
		print.addEventListener("click",makePrintable);
	}
	//ar pdf = document.getElementById("create_pdf");

	//pdf.addEventListener("click",createPDF);

    $( "#create_pdf" ).on( "click", createPDF);

}


$(init);