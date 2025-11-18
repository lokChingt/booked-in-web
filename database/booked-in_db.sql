DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
    UserID          AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Username        VARCHAR(15) NOT NULL UNIQUE,
    Password        VARCHAR(15) NOT NULL,
    FirstName       VARCHAR(15),
    Surname         VARCHAR(15),
    AddressLine1    VARCHAR(20),
    AddressLine2    VARCHAR(15),
    City            VARCHAR(15),
    Telephone       VARCHAR(7),
    Mobile          VARCHAR(9)
);
INSERT INTO Users VALUES
('alanjmckenna','t1234s','Alan','McKenna','38 Cranley Road','Fairview','Dublin', '9998377', '856625567'),
('joecrotty','kj7899','Joseph','Crotty','Apt 5 Clyde Road','Donnybrook','Dublin', '8887889', '876654456'),
('tommy100','123456','tom','behan','14 hyde Road','Fairview','dublin', '9983747', '876738782');



DROP TABLE IF EXISTS Categories;
CREATE TABLE Categories
(
    CategoryID      CHAR(3)     NOT NULL PRIMARY KEY,
    CategoryDetail  VARCHAR(15) NOT NULL
);

INSERT INTO Categories VALUES
('001','Health'),
('002','Business'),
('003','Biography'),
('004','Technology'),
('005','Travel'),
('006','Self-Help'),
('007','Cookery'),
('008','Fiction');



DROP TABLE IF EXISTS Books;
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

INSERT INTO Books VALUES
('093-403992','Computers in Business','Alicia Oneill','3',1997,'003'),
('23472-8729','Exploring Peru','Stephanie Birchi','4',2005,'005'),
('237-34823','Business Strategy','Joe Peppard','2',2002,'002'),
('23u8-923849','A guide to nutrition','John Thorpe','2',1997,'001'),
('2983-3494','Cooking for children','Anabelle Sharpe','1',2003,'007'),
('82n8-308','computers for idiots',"Susan O'Neill",'5',1998,'004'),
('9823-23984','My life in picture','Kevin Graham','8',2004,'001'),
('9823-2403-0','Da Vinci Code','Dan Brown','1',2003,'008'),
('98234-029384','My ranch in Texas','George Bush','1',2005,'001'),
('9823-98345','How to cook Italian food','Jamie Oliver','2',2005,'007'),
('9823-98487','Optimising your business','Cleo Blair','1',2001,'002'),
('988745-234','Tara Road','Maeve Binchy','4',2002,'008');



DROP TABLE IF EXISTS Reservations;
CREATE TABLE Reservations
(
    ISBN          VARCHAR(15) NOT NULL,
    UserID        INT NOT NULL,
    ReservedDate  DATE,
    FOREIGN KEY (ISBN) REFERENCES Books(ISBN),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    CONSTRAINT pk_Reservations PRIMARY KEY (ISBN, UserID)
);

INSERT INTO Reservations VALUES
('98234-029384','2','2008-10-11'),
('9823-98345','3','2008-10-11');