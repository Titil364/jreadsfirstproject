class Application{
	constructor(title, description){
		this.title = title;
		this.description = description;
	}
	getTitle(){
		return this.title;
	}
}
class Question{
	constructor(l){
		this.label = l;
	}
}
class QType{
	constructor(type){
		this.type = type;
	}
}