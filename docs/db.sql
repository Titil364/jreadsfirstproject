-- utf8_general_ci

-- User a table in the main db
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Form;
DROP TABLE IF EXISTS Application;
DROP TABLE IF EXISTS QuestionType;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS AnswerType;

CREATE TABLE Users (
  userId int(11) PRIMARY KEY,
  userMail varchar(20),
  userSurname varchar(20),
  userForename varchar(20)
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
  FOREIGN KEY (userId) REFERENCES User(userId)
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
  questionId int(11) NOT NULL,
  questionName varchar(20),
  applicationId int(11),
  questionTypeId int(11),
  PRIMARY KEY (questionId),
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