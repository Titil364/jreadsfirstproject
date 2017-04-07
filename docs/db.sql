CREATE TABLE User (
  userId int(11) NOT NULL,
  userMail varchar(20) DEFAULT NULL,
  userSurname varchar(20) DEFAULT NULL,
  userForename varchar(20) DEFAULT NULL,
  PRIMARY KEY (userId);
)

CREATE TABLE Visitor (
  visitorId int(11) NOT NULL,
  visitorGroupId int(11) DEFAULT NULL,
  visitorSecretName varchar(20) DEFAULT NULL,
  visitorSchool varchar(20) DEFAULT NULL,
  visitorAge int(11) DEFAULT NULL,
  visitorClass varchar(20) DEFAULT NULL;
)

CREATE TABLE Form (
  formId int(11) NOT NULL,
  formName varchar(20) DEFAULT NULL,
  userId int(11) DEFAULT NULL,
  PRIMARY KEY (formId),
  FOREIGN KEY (userId) REFERENCES User(userId);
)

CREATE TABLE Application (
  applicationId int(11) NOT NULL,
  applicationName varchar(20) DEFAULT NULL,
  applicationDescription varchar(20) DEFAULT NULL,
  formId int(11) DEFAULT NULL,
  PRIMARY KEY (applicationId),
  FOREIGN KEY (formId) REFERENCES Form(formId);
)

CREATE TABLE QuestionType (
    questionTypeId int(11) NOT NULL,
    questionTypeName varchar(20) DEFAULT NULL,
    PRIMARY KEY (questionTypeId);
)

CREATE TABLE Question (
  questionId int(11) NOT NULL,
  questionName varchar(20) DEFAULT NULL,
  applicationId int(11) DEFAULT NULL,
  questionTypeId int(11) DEFAULT NULL,
  PRIMARY KEY (questionId),
  FOREIGN KEY (applicationId) REFERENCES Application(applicationId)
  FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId);
)

CREATE TABLE Answer (
   visitorId  int(11) DEFAULT NULL,
   questionId  int(11) DEFAULT NULL,
   FOREIGN KEY (visitorId) REFERENCES Visitor(visitorId),
   FOREIGN KEY (questionId) REFERENCES Question(questionId),
   PRIMARY KEY (visitorId,questionId);
)

CREATE TABLE AnswerType (
    answerTypeId int(11) NOT NULL,
    answerTypeName varchar(20) DEFAULT NULL,
    answerTypeImage varchar(20) DEFAULT NULL,
    questionTypeId int (11) DEFAULT NULL,
    PRIMARY KEY (answerTypeId),
    FOREIGN KEY (questionTypeId) REFERENCES QuestionType(questionTypeId);
)