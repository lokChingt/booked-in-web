DROP DATABASE IF EXISTS Users;
CREATE TABLE Users
(
    Username        VARCHAR(15) NOT NULL PRIMARY KEY,
    Password        VARCHAR(15) NOT NULL,
    FirstName       VARCHAR(15),
    Surname         VARCHAR(15),
    AddressLine1    VARCHAR(20),
    AddressLine2    VARCHAR(15),
    City            VARCHAR(15),
    Telephone       VARCHAR(7),
    Mobile          VARCHAR(9)
);
INSERT INTO Users VALUES('alanjmckenna','t1234s','Alan','McKenna','38 Cranley Road','Fairview','Dublin', '9998377', '856625567');
INSERT INTO Users VALUES('joecrotty','kj7899','Joseph','Crotty','Apt 5 Clyde Road','Donnybrook','Dublin', '8887889', '876654456');
INSERT INTO Users VALUES('tommy100','123456','tom','behan','14 hyde Road','Fairview','dublin', '9983747', '876738782');



DROP DATABASE IF EXISTS Categories;
CREATE TABLE Categories
(
    CategoryID      CHAR(3)     NOT NULL PRIMARY KEY,
    CategoryDetail  VARCHAR(15) NOT NULL
);

INSERT INTO Categories VALUES('001','Health');
INSERT INTO Categories VALUES('002','Business');
INSERT INTO Categories VALUES('003','Biography');
INSERT INTO Categories VALUES('004','Technology');
INSERT INTO Categories VALUES('005','Travel');
INSERT INTO Categories VALUES('006','Self-Help');
INSERT INTO Categories VALUES('007','Cookery');
INSERT INTO Categories VALUES('008','Fiction');



DROP DATABASE IF EXISTS Books;
CREATE TABLE Books
(
    ISBN        VARCHAR(15) NOT NULL PRIMARY KEY,
    BookTitle   VARCHAR(25) NOT NULL,
    Author      VARCHAR(20),
    Edition     CHAR(1),
    Year        INT,
    CategoryID  CHAR(3),
    FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
);

INSERT INTO Books VALUES('093-403992','Computers in Business','Alicia Oneill','3',1997,'003');
INSERT INTO Books VALUES('23472-8729','Exploring Peru','Stephanie Birchi','4',2005,'005');
INSERT INTO Books VALUES('237-34823','Business Strategy','Joe Peppard','2',2002,'002');
INSERT INTO Books VALUES('23u8-923849','A guide to nutrition','John Thorpe','2',1997,'001');
INSERT INTO Books VALUES('2983-3494','Cooking for children','Anabelle Sharpe','1',2003,'007');
INSERT INTO Books VALUES('82n8-308','computers for idiots',"Susan O'Neill",'5',1998,'004');
INSERT INTO Books VALUES('9823-23984','My life in picture','Kevin Graham','8',2004,'001');
INSERT INTO Books VALUES('9823-2403-0','Da Vinci Code','Dan Brown','1',2003,'008');
INSERT INTO Books VALUES('98234-029384','My ranch in Texas','George Bush','1',2005,'001');
INSERT INTO Books VALUES('9823-98345','How to cook Italian food','Jamie Oliver','2',2005,'007');
INSERT INTO Books VALUES('9823-98487','Optimising your business','Cleo Blair','1',2001,'002');
INSERT INTO Books VALUES('988745-234','Tara Road','Maeve Binchy','4',2002,'008');



DROP DATABASE IF EXISTS Reservations;
CREATE TABLE Reservations
(
    ISBN            VARCHAR(15) NOT NULL,
    Username        VARCHAR(15) NOT NULL,
    ReservedDate    DATE,
    FOREIGN KEY (ISBN) REFERENCES Books(ISBN),
    FOREIGN KEY (Username) REFERENCES Users(Username),
    CONSTRAINT pk_Reservations PRIMARY KEY (ISBN, Username)
);

INSERT INTO Reservations VALUES('98234-029384','joecrotty','2008-10-11');
INSERT INTO Reservations VALUES('9823-98345','tommy100','2008-10-11');