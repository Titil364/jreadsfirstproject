/*CREATE TABLE Visitor(
    visitorId int PRIMARY KEY,
    visitorGroupId int,
    visitorSecretName varchar(20),
    visitorSchool varchar(20),
    visitorAge int,
    visitorClass varchar(20)
);
CREATE TABLE User(
    userId int PRIMARY KEY,
    userMail varchar(20),
    userSurname varchar(20),
    userForename varchar(20)
);*/

CREATE TABLE Form(
    formId int PRIMARY KEY,
    formName varchar(20),
    userId int,
    CONSTRAINT fk_user_form
        FOREIGN KEY (userId) REFERENCES User(id)
);

CREATE TABLE Application(
    applicationId int PRIMARY KEY,
    applicationName varchar(20),
    applicationDescription varchar(20),
    formId int,
    CONSTRAINT fk_form_application
        FOREIGN KEY (formId)
        REFERENCES Form(formId)
);

CREATE TABLE Question(
    questionId int PRIMARY KEY,
    questionName varchar(20),
    applicationId int,
    CONSTRAINT fk_application_question
        FOREIGN KEY (applicationId)
        REFERENCES Application(applicationId)
);

CREATE TABLE Answer(
    visitorId int,
    questionId int,
    CONSTRAINT pk_answer PRIMARY KEY (visitorId, questionId);
    CONSTRAINT fk_question_answer
        FOREIGN KEY (questionId)
        REFERENCES Question(questionId)
    CONSTRAINT fk_visitor_answer
        FOREIGN KEY (visitorId)
        REFERENCES Visitor(visitorId)    
);

CREATE TABLE date(
    visitorId int,
    formId int,
    CONSTRAINT pk_answer PRIMARY KEY (visitorId, formId);
    CONSTRAINT fk_form_date
        FOREIGN KEY (formId)
        REFERENCES Form(formId)
    CONSTRAINT fk_visitor_date
        FOREIGN KEY (visitorId)
        REFERENCES Visitor(visitorId)    
);













