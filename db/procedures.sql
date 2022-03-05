-- ? Used in dashboard-home.php
-- ? Query books for the find books section.

CREATE PROCEDURE R_Get_Find_Book
AS
BEGIN
    SELECT
        Book_ISBN as 'ISBN',
        Book_Name as 'Name',
        Book_Author as 'Author',
        Book_Description as 'Description',
        Category_Name as 'Category',
        Book_Status as 'Status'
    FROM Book
        LEFT JOIN Book_Category
        ON Book.Book_Category_ID = Book_Category.Category_ID
END
GO

-- EXEC R_Get_Find_Book;
-- GO

-- ? Used in dashboard-stud.php
-- ? Query students for the find students section.

CREATE Procedure R_Get_Find_Student
AS
BEGIN
    SELECT
        Student_Number as 'LRN Number',
        Student_Name as 'Name',
        Student_Email as 'Email',
        Student_Status as 'Status'
    FROM Student
END
GO

-- EXEC R_Get_Find_Student;
-- GO

-- ? Used in dashboard-borrow.php
-- ? Query all borrowed books data for the find borrow section.

CREATE PROCEDURE R_Get_Find_Borrow
AS
BEGIN
    SELECT
        Book_Name,
        Student_Name,
        Borrow_Status,
        Borrow_Date
    FROM Borrow
        LEFT JOIN Book
        ON Borrow.Borrow_Book_ID = Book.Book_ID
        LEFT JOIN Student
        ON Borrow.Borrow_Student_ID = Student.Student_ID;
END
GO

-- EXEC R_Get_Find_Borrow;
-- GO

-- ? Used in books-add.php
-- ? Inserts book data to the user.

CREATE PROCEDURE C_Add_New_Book
    @BookID VARCHAR(36),
    @ISBN VARCHAR(13),
    @Name VARCHAR(100),
    @Author VARCHAR(100),
    @Description VARCHAR(500),
    @CatID INT,
    @Status INT,
    @CopiesActual INT,
    @CopiesCurrent INT
AS
BEGIN
    INSERT INTO 
Book
        (Book_ID, Book_ISBN, Book_Name, Book_Author, Book_Description, Book_Category_ID, Book_Status, Book_Copies_Actual, Book_Copies_Current)
    VALUES
        (@BookID, @ISBN, @Name, @Author, @Description, @CatID, @Status, @CopiesActual, @CopiesCurrent);
END
GO

-- EXEC C_Add_New_Book 
-- @BookID = 'W8OH2NbKFxuhd5teBcfyQLvEi0CnDTlA9kwr', 
-- @ISBN = '9780545227247', 
-- @Name = 'The Hunger Games: Catching Fire',
-- @Author = 'Suzzane Collins',
-- @Description = 'After arriving safely home from their unprecedented victory in the 74th Annual Hunger Games, Katniss Everdeen and Peeta Mellark discover that they must do a quick turnaround and begin a Victors Tour.',
-- @CatID = 1,
-- @Status = 1,
-- @CopiesActual = 3,
-- @CopiesCurrent = 3;

-- SELECT * FROM Book;

-- ? Used in student_sign_up.php
-- ? Inserts student data to the database.

CREATE PROCEDURE C_Signup_Student
    @StudID VARCHAR(36),
    @StudNum VARCHAR(12),
    @Name VARCHAR(100),
    @Email VARCHAR(255),
    @Password VARCHAR(255),
    @Status INT
AS
BEGIN
    INSERT INTO Student
        (Student_ID, Student_Number, Student_Name, Student_Email, Student_Password, Student_Status)
    VALUES
        (@StudID, @StudNum, @Name, @Email, @Password, @Status);
END
GO

-- EXEC C_Signup_Student 
-- @StudID = '1WjuFVDHPcaT08xezJvCOyktM3lqndiLK9oh', 
-- @StudNum = '109461010627', 
-- @Name = 'Dua Lipa', 
-- @Email = 'dualipa@gmail.com', 
-- @Password = '$2y$10$lBiRJkHZBXHG733H3veF7.1k/8j.J8SuLM7J2ApT2jFQquEg4j9Tm', 
-- @Status = 1;
-- GO

-- ? Used in student_reset_password.php
-- ? Retrieve Email based off sa provided email ng user.

CREATE PROCEDURE R_Get_Stud_Email
    @StudNum VARCHAR(12),
    @Email VARCHAR(255)
AS
BEGIN
    SELECT Student_Email
    FROM Student
    WHERE Student_Number = @StudNum AND Student_Email = @Email;
END
GO

EXEC R_Get_Stud_Email @StudNum = '109461010626', @Email = 'karljacobs@gmail.com';
GO

-- ? Used in student_reset_password.php
-- ? Update Student Password.

CREATE PROCEDURE U_Update_Student_Password
    @Password VARCHAR(255),
    @StudNum VARCHAR(12)
AS
BEGIN
    UPDATE Student SET Student_Password = @Password WHERE Student_Number = @StudNum;
END
GO

-- ! Wala pa dito yung R_Get_Book_Categories (pang query ng names para sa choices) at R_Get_Category_Name (pang query ng id, mali name ko dito)