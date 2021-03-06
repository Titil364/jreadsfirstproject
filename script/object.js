/** \author Cyril Govin
 *  \brief Contains all the objcets used to send information using JSON 
 */

class Form{
	constructor(id, name, userId){
		this.id = id;
		this.name = name;
		this.userId = userId;
	}
}
class Application{
	constructor(id, name, description, img){
		this.id = id;
		this.name = name;
		this.description = description;
		this.img = img;
	}
}
class Question{
	constructor(id, label, type, pre, customAns, applicationId = null){
		this.id = id;
		this.label = label;
		this.type = type;
		this.pre = pre;
		this.customAns = customAns;
		this.applicationId = applicationId;
	}
}
class QType{
	constructor(type){
		this.type = type;
	}
}
class Answer{
	constructor(questionId, ans){
		this.questionId = questionId;
		this.answer = ans;
	}
}
class Information{
	constructor(persoIfoNa, info){
		this.personnalInformationName = persoIfoNa;
		this.informationName = info;
	}
}
class AA{
	constructor(name, ans){
		this.applicationId = name;
		this.again = ans;
	}
}

class FSQ{
	constructor(a, t){
		this.name = a;
		this.tab = t;
	}
}