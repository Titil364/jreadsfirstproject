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
	constructor(id, label, type, pre){
		this.id = id;
		this.label = label;
		this.type = type;
		this.pre = pre;
	}
}
class QType{
	constructor(type){
		this.type = type;
	}
}