class Form{
	constructor(id, title, description, img){
		this.id = id;
		this.title = title;
		this.description = description;
		this.img = img;
	}
}
class Application{
	constructor(id, title, description){
		this.id = id;
		this.title = title;
		this.description = description;
	}
}
class Question{
	constructor(id, label, type){
		this.id = id;
		this.label = label;
		this.type = type;
	}
}
class QType{
	constructor(type){
		this.type = type;
	}
}