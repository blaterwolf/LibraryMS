CREATE TABLE Admin
(
    AdminID VARCHAR(11) NOT NULL PRIMARY KEY,
    AdminName VARCHAR (100) NOT NULL,
    AdminUsername VARCHAR(20) NOT NULL,
    AdminPassword VARCHAR(16) NOT NULL,
)

INSERT INTO Admin
VALUES
    ('ADMIN-00001', 'Administrator', 'admin', 'admin');

CREATE TABLE Book_Category
(
    Category_ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    Category_Name VARCHAR(100) NOT NULL,
    Category_Status INT DEFAULT NULL,
)

INSERT INTO Book_Category
    (Category_Name, Category_Status)
VALUES
    ('Fiction', 1);
INSERT INTO Book_Category
    (Category_Name, Category_Status)
VALUES
    ('Romance', 1);
INSERT INTO Book_Category
    (Category_Name, Category_Status)
VALUES
    ('Technology', 1);
INSERT INTO Book_Category
    (Category_Name, Category_Status)
VALUES
    ('Management', 0);

CREATE TABLE Book
(
    Book_ID VARCHAR(11) NOT NULL PRIMARY KEY,
    BOOK_ISBN VARCHAR(13) NOT NULL,
    Book_Name VARCHAR(100) NOT NULL,
    Book_Author VARCHAR(100) NOT NULL,
    Book_Description VARCHAR(500) DEFAULT NULL,
    Book_Category_ID INT NOT NULL,
    Book_Status INT DEFAULT NULL,
    Book_Copies_Actual INT DEFAULT NULL,
    Book_Copies_Current INT DEFAULT NULL,
    FOREIGN KEY (Book_Category_ID) REFERENCES Book_Category(Category_ID)
)

INSERT INTO Book
    (Book_ID, BOOK_ISBN, Book_Name, Book_Author, Book_Description, Book_Category_ID, Book_Status, Book_Copies_Actual, Book_Copies_Current)
VALUES
    ('BOOKS-XAS13', '9783161484100', 'The Alchemist', 'Paulo Coelho', 'The Alchemist is a novel by Brazilian writer Paulo Coelho. Published in 1988, the book is the first of five planned books by the author.', 1, 1, 10, 10);
INSERT INTO Book
    (Book_ID, BOOK_ISBN, Book_Name, Book_Author, Book_Description, Book_Category_ID, Book_Status, Book_Copies_Actual, Book_Copies_Current)
VALUES
    ('BOOKS-BYI56', '9781524763282', 'Ready Player One', 'Ernest Cline', 'Ready Player One is a 2011 science fiction novel, and the debut novel of American author Ernest Cline. The story, set in a dystopia in 2045, follows protagonist Wade Watts on his search for an Easter egg in a worldwide virtual reality game, the discovery of which would lead him to inherit the game creator''s fortune.', 1, 1, 5, 5);

CREATE TABLE Student
(
    Student_ID VARCHAR(12) NOT NULL PRIMARY KEY,
    Student_Name VARCHAR(100) NOT NULL,
    Student_Email VARCHAR(100) NOT NULL,
    Student_Password VARCHAR(16) NOT NULL,
    Student_Status INT DEFAULT NULL
)

INSERT INTO Student
    (Student_ID, Student_Name, Student_Email, Student_Password, Student_Status)
VALUES
    ('109461010624', 'Wilbur Soot', 'wilbursoot@gmail.com', 'wilburrocks13', 1);
INSERT INTO Student
    (Student_ID, Student_Name, Student_Email, Student_Password, Student_Status)
VALUES
    ('109461010625', 'George Davidson', 'georgenotfound@gmail.com', 'gogy_hw_11', 1);


CREATE TABLE Book_Issue
(
    Issue_UQID VARCHAR(13) PRIMARY KEY,
    Issue_Book_ID VARCHAR(11) NOT NULL,
    Issue_Student_ID VARCHAR(12) NOT NULL,
    Issue_Date DATE NOT NULL,
    Issue_Due_Date DATE NOT NULL,
    Issue_Status INT DEFAULT NULL,
    FOREIGN KEY (Issue_Book_ID) REFERENCES Book(Book_ID),
    FOREIGN KEY (Issue_Student_ID) REFERENCES Student(Student_ID)
)

SELECT *
FROM Student;
SELECT *
FROM Book_Issue;

-- ! On PHP: Use uniqid() to generate unique ID to Issue_UQID