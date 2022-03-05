CREATE DATABASE LibraryMS;
GO

-- ! I recommend creating the database first then running the scripts below on a new query.

USE LibraryMS;
GO

CREATE TABLE Admin
(
    AdminID VARCHAR(36) NOT NULL PRIMARY KEY,
    AdminName VARCHAR (100) NOT NULL,
    AdminUsername VARCHAR(20) NOT NULL,
    AdminPassword VARCHAR(255) NOT NULL,
)
GO

-- * Thanks to this article, automatic na magegegenerate ng Modified Date itong mga tables:
-- * https://database.guide/create-a-last-modified-column-in-sql-server/
CREATE TRIGGER trg_Admin_UpdateModifiedDate
ON Admin
AFTER UPDATE
AS
UPDATE Admin
SET ModifiedDate = CURRENT_TIMESTAMP
WHERE AdminID IN (SELECT DISTINCT AdminID
FROM inserted);
GO

INSERT INTO Admin
VALUES
    ('yDwn4mgJi7KMQukbjLqAFlhUxHo1PXNvcRBG', 'Administrator', 'admin', '$2y$10$ErNqtNt5rsk1CQZ6Ms2VmueaMSqKmymIzobraMZJ/EADLGOVZ3ZjS');

CREATE TABLE Book_Category
(
    Category_ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    Category_Name VARCHAR(100) NOT NULL,
)

INSERT INTO Book_Category
    (Category_Name)
VALUES
    ('Fiction');
INSERT INTO Book_Category
    (Category_Name)
VALUES
    ('Romance');
INSERT INTO Book_Category
    (Category_Name)
VALUES
    ('Technology');
INSERT INTO Book_Category
    (Category_Name)
VALUES
    ('Management');

CREATE TABLE Book
(
    Book_ID VARCHAR(36) NOT NULL PRIMARY KEY,
    BOOK_ISBN VARCHAR(13) NOT NULL,
    Book_Name VARCHAR(100) NOT NULL,
    Book_Author VARCHAR(100) NOT NULL,
    Book_Description VARCHAR(500) DEFAULT NULL,
    Book_Category_ID INT NOT NULL,
    Book_Status INT DEFAULT 0,
    Book_Copies_Actual INT DEFAULT NULL,
    Book_Copies_Current INT DEFAULT NULL,
    CreateDate datetime DEFAULT CURRENT_TIMESTAMP,
    ModifiedDate datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Book_Category_ID) REFERENCES Book_Category(Category_ID)
)
GO

CREATE TRIGGER trg_Book_UpdateModifiedDate
ON Book
AFTER UPDATE
AS
UPDATE Book
SET ModifiedDate = CURRENT_TIMESTAMP
WHERE Book_ID IN (SELECT DISTINCT Book_ID
FROM inserted);
GO

INSERT INTO Book
    (Book_ID, BOOK_ISBN, Book_Name, Book_Author, Book_Description, Book_Category_ID, Book_Status, Book_Copies_Actual, Book_Copies_Current)
VALUES
    ('xzt4gb65KrYkSGXiTvMpPZJqmEd0fQeUChF8', '9783161484100', 'The Alchemist', 'Paulo Coelho', 'The Alchemist is a novel by Brazilian writer Paulo Coelho. Published in 1988, the book is the first of five planned books by the author.', 1, 1, 10, 10);
GO
INSERT INTO Book
    (Book_ID, BOOK_ISBN, Book_Name, Book_Author, Book_Description, Book_Category_ID, Book_Status, Book_Copies_Actual, Book_Copies_Current)
VALUES
    ('1vnsz2IgHuXPdVWoymUNMxhfJbD4iG8YLROw', '9781524763282', 'Ready Player One', 'Ernest Cline', 'Ready Player One is a 2011 science fiction novel, and the debut novel of American author Ernest Cline. The story, set in a dystopia in 2045, follows protagonist Wade Watts on his search for an Easter egg in a worldwide virtual reality game, the discovery of which would lead him to inherit the game creator''s fortune.', 1, 1, 5, 5);
GO

CREATE TABLE Student
(
    Student_ID VARCHAR(36) NOT NULL PRIMARY KEY,
    Student_Number VARCHAR(12) NOT NULL,
    Student_Name VARCHAR(100) NOT NULL,
    Student_Email VARCHAR(255) NOT NULL,
    Student_Password VARCHAR(255) NOT NULL,
    Student_Status INT DEFAULT 1,
    CreateDate datetime DEFAULT CURRENT_TIMESTAMP,
    ModifiedDate datetime DEFAULT CURRENT_TIMESTAMP
)
GO

CREATE TRIGGER trg_Student_UpdateModifiedDate
ON Student
AFTER UPDATE
AS
UPDATE Student
SET ModifiedDate = CURRENT_TIMESTAMP
WHERE Student_ID IN (SELECT DISTINCT Student_ID
FROM inserted);
GO

INSERT INTO Student
    (Student_ID, Student_Number, Student_Name, Student_Email, Student_Password)
VALUES
    ('0ZmwdgsSrczBkel4FIvXtfb6WQaC5TA31nOV', '109461010624', 'Wilbur Soot', 'wilbursoot@gmail.com', '$2y$10$Ocg76T8eyH/NeU8feCWI/.5BuSdd2mkh..iwRAbHSp.NTdSbNT.aK');
GO
INSERT INTO Student
    (Student_ID, Student_Number, Student_Name, Student_Email, Student_Password)
VALUES
    ('z1nduyQHXYO8BrSpwfeNM6qI3WEs57TJmUR2', '109461010625', 'George Davidson', 'georgenotfound@gmail.com', '$2y$10$.0FXI6kFWa7AHXSRMf2RCukdq4nQbK1aZP/FlcsnFP2guJLgJNpDC');
GO

CREATE TABLE Borrow
(
    Borrow_ID VARCHAR(36) PRIMARY KEY,
    Borrow_Book_ID VARCHAR(36) NOT NULL,
    Borrow_Student_ID VARCHAR(36) NOT NULL,
    Borrow_Status INT DEFAULT 0,
    Borrow_Copies_Got INT NOT NULL,
    Borrow_Date datetime DEFAULT CURRENT_TIMESTAMP,
    Borrow_Return_Date datetime DEFAULT NULL,
    FOREIGN KEY (Borrow_Book_ID) REFERENCES Book(Book_ID),
    FOREIGN KEY (Borrow_Student_ID) REFERENCES Student(Student_ID)
)
GO

CREATE TRIGGER trg_Borrow_UpdateBorrowReturnDate
ON Borrow
AFTER UPDATE
AS
UPDATE Borrow
SET Borrow_Return_Date = CURRENT_TIMESTAMP
WHERE Borrow_ID IN (SELECT DISTINCT Borrow_ID
FROM inserted);
GO

INSERT INTO Borrow
    (Borrow_ID, Borrow_Book_ID, Borrow_Student_ID, Borrow_Copies_Got)
VALUES
    ('E4imJHqlvZVwgURhPfaX1pLsktTFcNO0C8xu', '1vnsz2IgHuXPdVWoymUNMxhfJbD4iG8YLROw', 'z1nduyQHXYO8BrSpwfeNM6qI3WEs57TJmUR2', 1);
GO

UPDATE Book
SET Book_Copies_Current -= 1
WHERE Book_ID = '1vnsz2IgHuXPdVWoymUNMxhfJbD4iG8YLROw' AND Book_Status = 1;
GO

-- * UPDATE TO UNAVAILABLE (Book_Status) KAPAG BOOK_COPIES_CURRENT = 0
UPDATE Book
SET Book_Status = 0
WHERE Book_ID = '1vnsz2IgHuXPdVWoymUNMxhfJbD4iG8YLROw' AND Book_Copies_Current = 0;
GO

SELECT *
FROM Student;
GO

SELECT *
FROM Book;
GO

SELECT *
FROM Borrow;
GO

-- ! On PHP: Use uniqid() to generate unique ID to Issue_UQID
-- * Update: Note above is not useful, using this instead to generate 36 string IDs:
-- ?    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
-- ?    echo substr(str_shuffle($permitted_chars), 0, 36);
