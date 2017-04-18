-- utf8_general_ci

-- User a table in the main db
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS AnswerType;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS QuestionType;
DROP TABLE IF EXISTS Application;
DROP TABLE IF EXISTS DateComplete;
DROP TABLE IF EXISTS Form;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS FSQuestion;
DROP TABLE IF EXISTS Donnerunnom;
DROP TABLE IF EXISTS AssocFormPI;
DROP TABLE IF EXISTS PersonnalInformation;
DROP TABLE IF EXISTS Information;



CREATE TABLE Users (
  userNickname varchar (20) PRIMARY KEY,
  userSurname varchar(20),
  userForename varchar(20),
  userMail varchar(20),
  userPassword varchar(250),
  userNonce varchar(64),
  isAdmin int(1)
)DEFAULT CHARSET=utf8;


CREATE TABLE Visitor (
  visitorId int(11) PRIMARY KEY AUTO_INCREMENT,
  visitorGroupId int(11),
  visitorSecretName varchar(20),
  visitorSchool varchar(20),
  visitorAge int(11),
  visitorClass varchar(20)
)DEFAULT CHARSET=utf8;


CREATE TABLE Form (
  formId int(11) PRIMARY KEY AUTO_INCREMENT,
  formName varchar(20),
  userNickname varchar (20),
  completedForm int(11),
  FOREIGN KEY (userNickname) REFERENCES Users(userNickname)
)DEFAULT CHARSET=utf8;

CREATE TABLE DateComplete (
  dateComplete varchar(11),
  visitorId int(11),
  formId int(11),
  PRIMARY KEY (visitorId, formId),
  FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
  FOREIGN KEY (formId) REFERENCES Form(formId)
)DEFAULT CHARSET=utf8;


CREATE TABLE Application (
  applicationId varchar(20) PRIMARY KEY,
  applicationName varchar(30),
  applicationDescription varchar(80),
  formId int(11),
  FOREIGN KEY (formId) REFERENCES Form(formId)
)DEFAULT CHARSET=utf8;

CREATE TABLE QuestionType (
    questionTypeName varchar(20) PRIMARY KEY
)DEFAULT CHARSET=utf8;


CREATE TABLE Question (
  questionId varchar(20) PRIMARY KEY,
  questionName varchar(30),
  applicationId varchar(20),
  questionTypeName varchar(20),
  FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
  FOREIGN KEY (questionTypeName) REFERENCES QuestionType(questionTypeName)
)DEFAULT CHARSET=utf8;


CREATE TABLE Answer (
   visitorId  int(11),
   questionId  varchar(20),
   FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
   FOREIGN KEY (questionId) REFERENCES Question(questionId),
   PRIMARY KEY (visitorId, questionId)
)DEFAULT CHARSET=utf8;


CREATE TABLE FSQuestion (
    FSQuestionId int(11) PRIMARY KEY AUTO_INCREMENT,
    FSQuestionName varchar(50),
	defaultFSQuestion int(1)
)DEFAULT CHARSET=utf8;


CREATE TABLE Donnerunnom (
    formId int(11),
    FSQuestionId int (11),
    FOREIGN KEY (FSQuestionId) REFERENCES FSQuestion(FSQuestionId),
    FOREIGN KEY (formId) REFERENCES Form(formId),
    PRIMARY KEY (FSQuestionId, formId)
)DEFAULT CHARSET=utf8;
    

CREATE TABLE AnswerType (
    answerTypeId int(11) PRIMARY KEY AUTO_INCREMENT,
    answerTypeName varchar(20),
    answerTypeImage varchar(20),
    questionTypeName varchar(20),
    FOREIGN KEY (questionTypeName) REFERENCES QuestionType(questionTypeName)
)DEFAULT CHARSET=utf8;


CREATE TABLE PersonnalInformation (
    personnalInformationName varchar(20) PRIMARY KEY,
	defaultPersonnalInformation int(1)
)DEFAULT CHARSET=utf8;


CREATE TABLE Information (
    informationId int(11) PRIMARY KEY AUTO_INCREMENT,
    informationName varchar(20),
    personnalInformationName varchar(20),
    FOREIGN KEY (personnalInformationName) REFERENCES PersonnalInformation(personnalInformationName)
)DEFAULT CHARSET=utf8;


CREATE TABLE AssocFormPI (
    formId int(11),
    personnalInformationName varchar(20),
    PRIMARY KEY (formId, personnalInformationName),
    FOREIGN KEY (formId) REFERENCES Form(formId),
    FOREIGN KEY (personnalInformationName) REFERENCES PersonnalInformation(personnalInformationName)
)DEFAULT CHARSET=utf8; 

-- Triggers
	
DROP TRIGGER IF EXISTS complete_form_insert;
DROP TRIGGER IF EXISTS complete_form_delete;
DROP TRIGGER IF EXISTS insert_assoc_personnal_info;
	
	
DELIMITER //

CREATE TRIGGER complete_form_insert AFTER INSERT
	ON DateComplete FOR EACH ROW
	BEGIN
			UPDATE Form SET completedForm = (completedForm+1) WHERE NEW.formId = formId;
	END;//
	
DELIMITER ;

DELIMITER //

CREATE TRIGGER complete_form_delete AFTER DELETE
	ON DateComplete FOR EACH ROW
	BEGIN
			UPDATE Form SET completedForm = (completedForm-1)WHERE OLD.formId = formId;
	END;//
	
DELIMITER ;


DROP TRIGGER IF EXISTS insert_assoc_personnal_info;
DELIMITER //

CREATE TRIGGER insert_assoc_personnal_info BEFORE INSERT
	ON AssocFormPI FOR EACH ROW
	BEGIN
		DECLARE v_nb INTEGER;
		SELECT COUNT(*) INTO v_nb
		FROM PersonnalInformation
		WHERE personnalInformationName = NEW.personnalInformationName;
	
		-- The personnal information doesn't exist
		-- We're going to insert the personnal information and set it non default
		if(v_nb = 0) THEN
			INSERT INTO PersonnalInformation VALUES(NEW.personnalInformationName, 0);
		END IF;
	END;//
	
DELIMITER ;

--
-- Insert data

INSERT INTO Users Values("Me", "MySurname", "MyForname", "me@mail.com", "716cdc1e5e682a031f824d889778c3b1ee5f9d26871d15c1c8574029539919d2e75ad5a9e2545ea3b27a3491060738b23c2366e42c1e9d0d86410de792379411", "fad6e082cdeea610a7e3b4e04c12a501", 1);

INSERT INTO QuestionType VALUES("textarea");
INSERT INTO QuestionType VALUES("thumbs");
INSERT INTO QuestionType VALUES("smiley");
INSERT INTO QuestionType VALUES("yesno");

INSERT INTO AnswerType VALUES(1, "textarea", "", "textarea");
INSERT INTO AnswerType VALUES(2, "awful", "thumb1image", "thumbs");
INSERT INTO AnswerType VALUES(3, "bad", "thumb2image", "thumbs");
INSERT INTO AnswerType VALUES(4, "cool", "thumb3image", "thumbs");
INSERT INTO AnswerType VALUES(5, "nice", "thumb4image", "thumbs");
INSERT INTO AnswerType VALUES(6, "awesome", "thumb5image", "thumbs");
INSERT INTO AnswerType VALUES(7, "smiley1", "smiley1image", "smiley");
INSERT INTO AnswerType VALUES(8, "smiley2", "smiley2image", "smiley");
INSERT INTO AnswerType VALUES(9, "smiley3", "smiley3image", "smiley");
INSERT INTO AnswerType VALUES(10, "smiley4", "smiley4image", "smiley");
INSERT INTO AnswerType VALUES(11, "smiley5", "smiley5image", "smiley");
INSERT INTO AnswerType VALUES(12, "yes", "", "yesno");
INSERT INTO AnswerType VALUES(13, "no", "", "yesno");

INSERT INTO Form VALUES(1, 'Manger ou boire', "Me", 0);


INSERT INTO Application VALUES('1Applic0', 'Manger', '', 1);
INSERT INTO Application VALUES('1Applic1', 'Boire', 'L\'alcool c\'est bon pour la santé', 1);
INSERT INTO Application VALUES('1Applic2', 'Manger au toilette', 'Exprimez vous', 1);

INSERT INTO Question VALUES('1Applic0Q1', 'Manger une banane', '1Applic0', "smiley");
INSERT INTO Question VALUES('1Applic0Q2', 'J\'aime la merguez', '1Applic0', "thumbs");
INSERT INTO Question VALUES('1Applic0Q3', 'Manger des choux', '1Applic0', "smiley");
INSERT INTO Question VALUES('1Applic1Q1', 'Boire de l\'eau', '1Applic1', "smiley");
INSERT INTO Question VALUES('1Applic1Q2', 'J\'aime la vodka', '1Applic1', "thumbs");
INSERT INTO Question VALUES('1Applic2Q1', 'Des chips au toilette ', '1Applic2', "textarea");
INSERT INTO Question VALUES('1Applic2Q2', 'Du popcorn au toilette', '1Applic2', "smiley");


INSERT INTO FSQuestion VALUES ('1', 'Easy to do / Hard to do', 1);
INSERT INTO FSQuestion VALUES ('2', 'Most fun / Least fun', 1);
INSERT INTO FSQuestion VALUES ('3', 'Learned the most / Learned the least', 1);
INSERT INTO FSQuestion VALUES ('4', 'Most cool / Least cool', 1);
INSERT INTO FSQuestion VALUES ('5', 'Most boring / Least boring', 1);

INSERT INTO Donnerunnom VALUES ('1', '1');
INSERT INTO Donnerunnom VALUES ('1', '2');
INSERT INTO Donnerunnom VALUES ('1', '3');
INSERT INTO Donnerunnom VALUES ('1', '4');
INSERT INTO Donnerunnom VALUES ('1', '5');
-- mdp : 123456

INSERT INTO PersonnalInformation VALUES ('Name', 1);
INSERT INTO PersonnalInformation VALUES ('Age', 1);
INSERT INTO PersonnalInformation VALUES ('Class', 1);

INSERT INTO AssocFormPI VALUES ('1','Name');
INSERT INTO AssocFormPI VALUES ('1','Age');
INSERT INTO AssocFormPI VALUES ('1','Class');