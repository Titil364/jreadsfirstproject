-- utf8_general_ci

-- User a table in the main db
DROP TABLE IF EXISTS AssocFormPI;
DROP TABLE IF EXISTS Information;
DROP TABLE IF EXISTS PersonnalInformation;
DROP TABLE IF EXISTS AnswerType;
DROP TABLE IF EXISTS AssocFormFS;
DROP TABLE IF EXISTS FSQuestion;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS QuestionType;
DROP TABLE IF EXISTS Application;
DROP TABLE IF EXISTS Form;
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS SortApplication;
DROP TABLE IF EXISTS AgainAgain;
DROP TABLE IF EXISTS ApplicationDateComplete;



CREATE TABLE Users (
  userNickname varchar (20) PRIMARY KEY,
  userSurname varchar(20),
  userForename varchar(20),
  userMail varchar(60),
  userPassword varchar(250),
  userNonce varchar(64),
  isAdmin int(1),
  numberCreatedForm int(5)
)DEFAULT CHARSET=utf8;



CREATE TABLE Form (
  formId varchar(20) PRIMARY KEY,
  formName varchar(30),
  userNickname varchar (20),
  completedForm int(11),
  fillable int(1),
  FOREIGN KEY (userNickname) REFERENCES Users(userNickname)
)DEFAULT CHARSET=utf8;

CREATE TABLE Visitor (
  visitorId varchar(40) PRIMARY KEY,
  visitorSecretName varchar(20),
  dateCompletePre varchar(19),
  dateCompletePost varchar(19),
  formId varchar(20),
  applicationOrder varchar(60),
  FOREIGN KEY (formId) REFERENCES Form(formId)
)DEFAULT CHARSET=utf8;


CREATE TABLE Application (
  applicationId varchar(30) PRIMARY KEY,
  applicationName varchar(30),
  applicationDescription varchar(80),
  formId varchar(20),
  FOREIGN KEY (formId) REFERENCES Form(formId)
)DEFAULT CHARSET=utf8;

CREATE TABLE QuestionType (
	questionTypeId int(11) PRIMARY KEY AUTO_INCREMENT,
    questionTypeName varchar(20) NOT NULL,
	userNickname varchar (20),
	FOREIGN KEY (userNickname) REFERENCES Users(userNickname)
)DEFAULT CHARSET=utf8;


CREATE TABLE Question (
  questionId varchar(20) PRIMARY KEY,
  questionName varchar(100),
  applicationId varchar(30),
  questionTypeId int(20),
  questionPre int(1),
  FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
  FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
)DEFAULT CHARSET=utf8;


CREATE TABLE Answer (
   visitorId varchar(30),
   questionId  varchar(20),
   answer varchar(255),
   FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
   FOREIGN KEY (questionId) REFERENCES Question(questionId),
   PRIMARY KEY (visitorId, questionId)
)DEFAULT CHARSET=utf8;


CREATE TABLE FSQuestion (
    FSQuestionName varchar(50) PRIMARY KEY,
	defaultFSQuestion int(1)
)DEFAULT CHARSET=utf8;


CREATE TABLE AssocFormFS (
    formId varchar(20),
    FSQuestionName varchar(50),
    FOREIGN KEY (FSQuestionName) REFERENCES FSQuestion(FSQuestionName),
    FOREIGN KEY (formId) REFERENCES Form(formId),
    PRIMARY KEY (formId, FSQuestionName)
)DEFAULT CHARSET=utf8;
    

CREATE TABLE AnswerType (
    answerTypeId int(11) PRIMARY KEY AUTO_INCREMENT,
    answerTypeName varchar(100),
    answerTypeImage varchar(20),
    questionTypeId int(20),
    FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
)DEFAULT CHARSET=utf8;


CREATE TABLE PersonnalInformation (
    personnalInformationName varchar(30) PRIMARY KEY,
	defaultPersonnalInformation int(1)
)DEFAULT CHARSET=utf8;


CREATE TABLE Information (
    personnalInformationName varchar(30),
    informationName varchar(30),
	visitorId varchar(40),
    FOREIGN KEY (personnalInformationName) REFERENCES PersonnalInformation(personnalInformationName),
    FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
    PRIMARY KEY (personnalInformationName, visitorId)
)DEFAULT CHARSET=utf8;


CREATE TABLE AssocFormPI (
    formId varchar(20),
    personnalInformationName varchar(20),
    PRIMARY KEY (formId, personnalInformationName),
    FOREIGN KEY (formId) REFERENCES Form(formId),
    FOREIGN KEY (personnalInformationName) REFERENCES PersonnalInformation(personnalInformationName)
)DEFAULT CHARSET=utf8; 


CREATE TABLE SortApplication (
    visitorId varchar(40),
    FSQuestionName varchar(50),
	applicationRatingOrder varchar(250),
    FOREIGN KEY (FSQuestionName) REFERENCES FSQuestion(FSQuestionName),
    FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
    PRIMARY KEY (visitorId, FSQuestionName)
)DEFAULT CHARSET=utf8;

CREATE TABLE AgainAgain (
    visitorId varchar(40),
    applicationId varchar(30),
	again varchar(250),
    FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
    FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
    PRIMARY KEY (applicationId, visitorId)
)DEFAULT CHARSET=utf8;

CREATE TABLE ApplicationDateComplete (
    applicationDateCompletePre varchar(19),
    applicationDateCompletePost varchar(19),
	visitorId varchar(40),
    applicationId varchar(30),
    FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
    FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
    PRIMARY KEY (applicationId, visitorId)
)DEFAULT CHARSET=utf8;



-- Triggers
	
DROP TRIGGER IF EXISTS complete_form_insert;
DROP TRIGGER IF EXISTS complete_form_delete;
DROP TRIGGER IF EXISTS insert_assoc_personnal_info;
DROP TRIGGER IF EXISTS insert_assoc_fs;
DROP TRIGGER IF EXISTS after_insert_form;

DROP TRIGGER IF EXISTS update_answer;
	
DELIMITER //

CREATE TRIGGER complete_form_udpate AFTER UPDATE
	ON Visitor FOR EACH ROW
	BEGIN
		IF(NEW.dateCompletePost IS NOT NULL) THEN 
			UPDATE Form SET completedForm = (completedForm+1) WHERE NEW.formId = formId;
		END IF;
	END;//
	
DELIMITER ;



DELIMITER //

CREATE TRIGGER complete_form_delete AFTER DELETE
	ON Visitor FOR EACH ROW
	BEGIN
		IF(OLD.dateCompletePost IS NOT NULL) THEN 
			UPDATE Form SET completedForm = (completedForm-1) WHERE OLD.formId = formId;
		END IF;
	END;//
	
DELIMITER ;



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



DELIMITER //

CREATE TRIGGER insert_assoc_fs BEFORE INSERT
	ON AssocFormFS FOR EACH ROW
	BEGIN
		DECLARE v_nb INTEGER;
		SELECT COUNT(*) INTO v_nb
		FROM FSQuestion
		WHERE FSQuestionName = NEW.FSQuestionName;
	
		-- The FSQuestion doesn't exist
		-- We're going to insert the FSQuestion and set it non default
		if(v_nb = 0) THEN
			INSERT INTO FSQuestion VALUES(NEW.FSQuestionName, 0);
		END IF;
	END;//
	
DELIMITER ;



DELIMITER //

CREATE TRIGGER after_insert_form AFTER INSERT
	ON Form FOR EACH ROW
	BEGIN
		UPDATE Users SET numberCreatedForm = (numberCreatedForm+1) WHERE userNickname = NEW.userNickname;
	END;//
DELIMITER ;



DROP TRIGGER IF EXISTS update_answer;
DELIMITER //

CREATE TRIGGER update_answer BEFORE UPDATE
	ON Answer FOR EACH ROW
	BEGIN

		-- If answer hasn't been created yet
		-- Let's insert the association and set the answer as null
		if(OLD.questionId IS NULL and OLD.visitorId IS NULL) THEN
			INSERT INTO Answer VALUES(NEW.visitorId, NEW.questionId, NULL);
		END IF;
	END;//
	
DELIMITER ;


--
-- Insert data

-- mdp : 123456
INSERT INTO Users Values("Me", "MySurname", "MyForname", "me@mail.com", "716cdc1e5e682a031f824d889778c3b1ee5f9d26871d15c1c8574029539919d2e75ad5a9e2545ea3b27a3491060738b23c2366e42c1e9d0d86410de792379411", NULL, 1, 1);
INSERT INTO Users Values("Test", "John", "Smith", "johnSmithTest@yahoo.com", "716cdc1e5e682a031f824d889778c3b1ee5f9d26871d15c1c8574029539919d2e75ad5a9e2545ea3b27a3491060738b23c2366e42c1e9d0d86410de792379411", NULL, 1, 0);

INSERT INTO QuestionType VALUES(1, "textarea", NULL);
INSERT INTO QuestionType VALUES(2, "thumb", NULL);
INSERT INTO QuestionType VALUES(3, "smiley", NULL);
INSERT INTO QuestionType VALUES(4, "yesno", NULL);

INSERT INTO AnswerType VALUES(1, "textarea", "", 1);
INSERT INTO AnswerType VALUES(2, "awful", "thumb1image", 2);
INSERT INTO AnswerType VALUES(3, "bad", "thumb2image", 2);
INSERT INTO AnswerType VALUES(4, "cool", "thumb3image", 2);
INSERT INTO AnswerType VALUES(5, "nice", "thumb4image", 2);
INSERT INTO AnswerType VALUES(6, "awesome", "thumb5image", 2);
INSERT INTO AnswerType VALUES(7, "smiley1", "smiley1image", 3);
INSERT INTO AnswerType VALUES(8, "smiley2", "smiley2image", 3);
INSERT INTO AnswerType VALUES(9, "smiley3", "smiley3image", 3);
INSERT INTO AnswerType VALUES(10, "smiley4", "smiley4image", 3);
INSERT INTO AnswerType VALUES(11, "smiley5", "smiley5image", 3);
INSERT INTO AnswerType VALUES(12, "yes", "Oui", 4);
INSERT INTO AnswerType VALUES(13, "no", "Non", 4);

INSERT INTO Form VALUES("FOMM0MA", 'Eat or drink', "Me", 0, 0);


INSERT INTO Application VALUES('FOMM0MAApplic0', 'Eat', '', "FOMM0MA");
INSERT INTO Application VALUES('FOMM0MAApplic1', 'Drink', '', "FOMM0MA");
INSERT INTO Application VALUES('FOMM0MAApplic2', 'Both', '', "FOMM0MA");



INSERT INTO Question VALUES('FOMM0MAApplic0Q1pre', 'Eat a Banana PRE', 'FOMM0MAApplic0', 3, 1);
INSERT INTO Question VALUES('FOMM0MAApplic0Q1post', 'Eat a Banana POST', 'FOMM0MAApplic0', 3, 0);
INSERT INTO Question VALUES('FOMM0MAApplic1Q1pre', 'Drink tap PRE', 'FOMM0MAApplic1', 3, 1);
INSERT INTO Question VALUES('FOMM0MAApplic1Q1post', 'Drink tap POST', 'FOMM0MAApplic1', 3, 0);
INSERT INTO Question VALUES('FOMM0MAApplic2Q1pre', 'Both together PRE', 'FOMM0MAApplic2', 2, 1);
INSERT INTO Question VALUES('FOMM0MAApplic2Q1post', 'Both together POST', 'FOMM0MAApplic2', 2, 0);


INSERT INTO FSQuestion VALUES ('Easy to do/Hard to do', 1);
INSERT INTO FSQuestion VALUES ('Most fun/Least fun', 1);
INSERT INTO FSQuestion VALUES ('Learned the most/Learned the least', 1);
INSERT INTO FSQuestion VALUES ('Most cool/Least cool', 1);
INSERT INTO FSQuestion VALUES ('Most boring/Least boring', 1);

INSERT INTO AssocFormFS VALUES ("FOMM0MA", 'Easy to do/Hard to do');
INSERT INTO AssocFormFS VALUES ("FOMM0MA", 'Most fun/Least fun');
INSERT INTO AssocFormFS VALUES ("FOMM0MA", 'Learned the most/Learned the least');
INSERT INTO AssocFormFS VALUES ("FOMM0MA", 'Most cool/Least cool');
INSERT INTO AssocFormFS VALUES ("FOMM0MA", 'Most boring/Least boring');


INSERT INTO PersonnalInformation VALUES ('Name', 1);
INSERT INTO PersonnalInformation VALUES ('Age', 1);
INSERT INTO PersonnalInformation VALUES ('Class', 1);
INSERT INTO PersonnalInformation VALUES ('Groupe', 1);

INSERT INTO AssocFormPI VALUES ("FOMM0MA",'Name');
INSERT INTO AssocFormPI VALUES ("FOMM0MA",'Age');
INSERT INTO AssocFormPI VALUES ("FOMM0MA",'Class');