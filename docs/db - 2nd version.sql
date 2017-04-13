-- utf8_general_ci

-- User a table in the main db
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS UserQuestion;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS Application;
DROP TABLE IF EXISTS DateComplete;
DROP TABLE IF EXISTS Form;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS FSQuestion;




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

CREATE TABLE UserQuestion (
    questionId int(11) PRIMARY KEY AUTO_INCREMENT,
    userNickname varchar(20)
)DEFAULT CHARSET=utf8;

CREATE TABLE Question (
  questionId varchar(20) PRIMARY KEY,
  questionName varchar(30),
  questionAnswers varchar(500),
  applicationId varchar(20),
  FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
  FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
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
    FSQuestionName varchar(50)
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
    questionTypeId int (11),
    FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
)DEFAULT CHARSET=utf8;

--
-- Triggers
	
DROP TRIGGER IF EXISTS complete_form_insert;
DROP TRIGGER IF EXISTS complete_form_delete;
	
	
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

--
-- Insert data

INSERT INTO Users Values("Me", "MySurname", "MyForname", "me@mail.com", "716cdc1e5e682a031f824d889778c3b1ee5f9d26871d15c1c8574029539919d2e75ad5a9e2545ea3b27a3491060738b23c2366e42c1e9d0d86410de792379411", "fad6e082cdeea610a7e3b4e04c12a501", 1);

INSERT INTO QuestionType VALUES(1, "thumbs");
INSERT INTO QuestionType VALUES(2, "smiley");
INSERT INTO QuestionType VALUES(3, "textarea");
INSERT INTO QuestionType VALUES(4, "yesno");

INSERT INTO AnswerType VALUES(1, "textarea", "", 3);
INSERT INTO AnswerType VALUES(2, "awful", "thumb1image", 1);
INSERT INTO AnswerType VALUES(3, "bad", "thumb2image", 1);
INSERT INTO AnswerType VALUES(4, "cool", "thumb3image", 1);
INSERT INTO AnswerType VALUES(5, "nice", "thumb4image", 1);
INSERT INTO AnswerType VALUES(6, "awesome", "thumb5image", 1);
INSERT INTO AnswerType VALUES(7, "smiley1", "smiley1image", 2);
INSERT INTO AnswerType VALUES(8, "smiley2", "smiley2image", 2);
INSERT INTO AnswerType VALUES(9, "smiley3", "smiley3image", 2);
INSERT INTO AnswerType VALUES(10, "smiley4", "smiley4image", 2);
INSERT INTO AnswerType VALUES(11, "smiley5", "smiley5image", 2);
INSERT INTO AnswerType VALUES(12, "yes", "", 4);
INSERT INTO AnswerType VALUES(13, "no", "", 4);

INSERT INTO Form VALUES(1, 'Manger ou boire', "Me", 0);


INSERT INTO Application VALUES('1Applic0', 'Manger', '', 1);
INSERT INTO Application VALUES('1Applic1', 'Boire', 'L\'alcool c\'est bon pour la santé', 1);
INSERT INTO Application VALUES('1Applic2', 'Manger au toilette', 'Exprimez vous', 1);

INSERT INTO Question VALUES('1Applic0Q1', 'Manger une banane', '1Applic0', 2);
INSERT INTO Question VALUES('1Applic0Q2', 'J\'aime la merguez', '1Applic0', 1);
INSERT INTO Question VALUES('1Applic0Q3', 'Manger des choux', '1Applic0', 2);
INSERT INTO Question VALUES('1Applic1Q1', 'Boire de l\'eau', '1Applic1', 2);
INSERT INTO Question VALUES('1Applic1Q2', 'J\'aime la vodka', '1Applic1', 1);
INSERT INTO Question VALUES('1Applic2Q1', 'Des chips au toilette ', '1Applic2', 3);
INSERT INTO Question VALUES('1Applic2Q2', 'Du popcorn au toilette', '1Applic2', 1);


INSERT INTO `FSQuestion` (`FSQuestionId`, `FSQuestionName`) VALUES ('1', 'Easy to do / Hard to do');
INSERT INTO `FSQuestion` (`FSQuestionId`, `FSQuestionName`) VALUES ('2', 'Most fun / Least fun');
INSERT INTO `FSQuestion` (`FSQuestionId`, `FSQuestionName`) VALUES ('3', 'Learned the most / Learned the least');
INSERT INTO `FSQuestion` (`FSQuestionId`, `FSQuestionName`) VALUES ('4', 'Most cool / Least cool');
INSERT INTO `FSQuestion` (`FSQuestionId`, `FSQuestionName`) VALUES ('5', 'Most boring / Least boring');

INSERT INTO `Donnerunnom` (`formId`, `FSQuestionId`) VALUES ('1', '1');
INSERT INTO `Donnerunnom` (`formId`, `FSQuestionId`) VALUES ('1', '2');
INSERT INTO `Donnerunnom` (`formId`, `FSQuestionId`) VALUES ('1', '3');
INSERT INTO `Donnerunnom` (`formId`, `FSQuestionId`) VALUES ('1', '4');
INSERT INTO `Donnerunnom` (`formId`, `FSQuestionId`) VALUES ('1', '5');
-- mdp : 123456
