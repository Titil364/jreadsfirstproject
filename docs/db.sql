-- utf8_general_ci

-- User a table in the main db
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Form;
DROP TABLE IF EXISTS DateComplete;
DROP TABLE IF EXISTS Application;
DROP TABLE IF EXISTS QuestionType;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS AnswerType;

CREATE TABLE Users (
  userId int(11) PRIMARY KEY,
  userMail varchar(20),
  userPassword varchar(64),
  userNickname varchar (20),
  userSurname varchar(20),

  userForname varchar(20),
  userNonce varchar (64)
)DEFAULT CHARSET=utf8;

CREATE TABLE Visitor (
  visitorId int(11) PRIMARY KEY,
  visitorGroupId int(11),
  visitorSecretName varchar(20),
  visitorSchool varchar(20),
  visitorAge int(11),
  visitorClass varchar(20)
)DEFAULT CHARSET=utf8;

CREATE TABLE Form (
  formId int(11) PRIMARY KEY,
  formName varchar(20),
  userId int(11),
  completedForm int(11),
  FOREIGN KEY (userId) REFERENCES Users(userId)
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
  applicationId int(11) PRIMARY KEY,
  applicationName varchar(20),
  applicationDescription varchar(20),
  formId int(11),
  FOREIGN KEY (formId) REFERENCES Form(formId)
)DEFAULT CHARSET=utf8;

CREATE TABLE QuestionType (
    questionTypeId int(11) PRIMARY KEY,
    questionTypeName varchar(20)
)DEFAULT CHARSET=utf8;

CREATE TABLE Question (
  questionId int(11) PRIMARY KEY,
  questionName varchar(20),
  applicationId int(11),
  questionTypeId int(11),
  FOREIGN KEY (applicationId) REFERENCES Application(applicationId),
  FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
)DEFAULT CHARSET=utf8;

CREATE TABLE Answer (
   visitorId  int(11),
   questionId  int(11),
   FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
   FOREIGN KEY (questionId) REFERENCES Question(questionId),
   PRIMARY KEY (visitorId, questionId)
)DEFAULT CHARSET=utf8;

CREATE TABLE AnswerType (
    answerTypeId int(11) PRIMARY KEY,
    answerTypeName varchar(20),
    answerTypeImage varchar(20),
    questionTypeId int (11),
    FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId)
)DEFAULT CHARSET=utf8;

--
-- Triggers
/*
CREATE OR REPLACE TRIGGER complete_form AFTER DELETE OR INSERT
	ON DateComplete FOR EACH ROW
	BEGIN 
-- A réfléchir
		--IF(UPDATING or INSERTING) THEN
		/*
			IF(v_nb = 0) THEN
				RAISE_APPLICATION_ERROR(-20003, '');
			END IF;
			
			IF(UPDATING) THEN
				IF(:OLD.formId != :NEW.formId) THEN
					UPDATE Form SET completeForm = (completeForm-1)
					WHERE :OLD.visitorId = visitorId;	
					
					UPDATE Form SET completeForm = (completeForm+1)
					WHERE :NEW.formId = formId;
				END IF;
				
				
			END IF;
		

			IF(INSERTING) THEN
				UPDATE Form SET completeForm = (completeForm+1)
				WHERE NEW.formId = formId;
				
			END IF;
	--	END IF;
		

		IF(DELETING) THEN
			UPDATE Form SET completeForm = (completeForm-1)
			WHERE OLD.formId = formId;
		END IF;
	END;*/
	
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
INSERT INTO QuestionType VALUES(0, "thumb");
INSERT INTO QuestionType VALUES(1, "smiley");
INSERT INTO QuestionType VALUES(2, "textarea");
INSERT INTO QuestionType VALUES(3, "yesno");

INSERT INTO AnswerType VALUES(0, "textarea", "", 2);
INSERT INTO AnswerType VALUES(1, "awful", "thumb1image", 0);
INSERT INTO AnswerType VALUES(2, "bad", "thumb2image", 0);
INSERT INTO AnswerType VALUES(3, "cool", "thumb3image", 0);
INSERT INTO AnswerType VALUES(4, "nice", "thumb4image", 0);
INSERT INTO AnswerType VALUES(5, "awesome", "thumb5image", 0);
INSERT INTO AnswerType VALUES(6, "smiley1", "smiley1image", 1);
INSERT INTO AnswerType VALUES(7, "smiley2", "smiley2image", 1);
INSERT INTO AnswerType VALUES(8, "smiley3", "smiley3image", 1);
INSERT INTO AnswerType VALUES(9, "smiley4", "smiley4image", 1);
INSERT INTO AnswerType VALUES(10, "smiley5", "smiley5image", 1);
INSERT INTO AnswerType VALUES(11, "yes", "", 3);
INSERT INTO AnswerType VALUES(12, "no", "", 3);


