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

-- ? Used in borrow_books.php
-- ? Get all available book names.

CREATE PROCEDURE R_Get_Available_Books
AS
BEGIN
    SELECT Book_Name
    FROM Book
    WHERE Book_Status = 1;
END
GO

EXEC R_Get_Available_Books;
GO

-- ? Used in borrow_books.php
-- ? Get Student_ID based on _SESSION['Student_Number'].

CREATE PROCEDURE R_Stud_Id_By_Stud_Num
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT Student_ID
    FROM Student
    WHERE Student_Number = @StudNum;
END
GO

EXEC R_Stud_Id_By_Stud_Num @StudNum = '109461060131';
GO

-- ? Used in borrow_books.php
-- ? The main function for creating a borrowed book transaction.

CREATE PROCEDURE C_Add_Borrow_Book
    @BorrowID VARCHAR(36),
    @BookID VARCHAR(36),
    @StudentID VARCHAR(36),
    @NumCopies INT
AS
BEGIN
    INSERT INTO Borrow
        (Borrow_ID, Borrow_Book_ID, Borrow_Student_ID, Borrow_Copies_Got)
    VALUES
        (@BorrowID, @BookID, @StudentID, @NumCopies);

    -- * UPDATE THE NUMBER OF COPIES OF BOOK
    UPDATE Book
	SET Book_Copies_Current -= @NumCopies
	WHERE Book_ID = @BookID AND Book_Status = 1;


    -- * UPDATE TO UNAVAILABLE (Book_Status) KAPAG BOOK_COPIES_CURRENT = 0
    UPDATE Book
	SET Book_Status = 0
	WHERE Book_ID = @BookID AND Book_Copies_Current = 0;
END
GO

-- ? Used in transactions.php
-- ? The main function for retrieving the borrow history of the student.

CREATE PROCEDURE R_Transaction_History
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT
        Book_Name AS 'Book Borrowed',
        Student_Name AS 'Student Name',
        Borrow_Copies_Got AS 'Number of Copies',
        Borrow_Status AS 'Status',
        Borrow_Date AS 'Borrow Date',
        Borrow_Return_Date AS 'Return Date'
    FROM Borrow
        LEFT JOIN Book
        ON Borrow.Borrow_Book_ID = Book.Book_ID
        LEFT JOIN Student
        ON Borrow.Borrow_Student_ID = Student.Student_ID
    WHERE Student_Number = @StudNum;
END
GO

EXEC R_Transaction_History @StudNum = '109461010625';
GO

-- ? Used in settings.php
-- ? Populate student data so that student can easily edit what to edit.

CREATE PROCEDURE R_Get_Stud_Info_For_Settings
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT Student_Number, Student_Name, Student_Email
    FROM Student
    WHERE Student_Number = @StudNum;
END
GO

EXEC R_Get_Stud_Info_For_Settings @StudNum = '109461060128';
GO

-- ? Used in: (Student) dashboard.php -> welcome_card.php and header.php 
-- ? Retrieve the current student user name.

CREATE PROCEDURE R_Get_Stud_Name_For_Display
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT Student_Name
    FROM Student
    WHERE Student_Number = @StudNum;
END
GO

EXEC R_Get_Stud_Name_For_Display @StudNum = '109461010626';
GO

-- ? Used in books-add/edit.php -> call_categories.php 
-- ? Retrieve the book categories to be rendered in the form.

CREATE PROCEDURE R_Get_Book_Categories
AS
BEGIN
    SELECT Category_Name AS 'Category'
    FROM Book_Category;
END
GO

EXEC R_Get_Book_Categories;
GO

-- ? Used in books-add/edit.php
-- ? Retrieve the id based on the category name.

CREATE PROCEDURE R_Get_Category_Name
    @Cat_Name VARCHAR(100)
AS
BEGIN
    SELECT Category_ID
    FROM Book_Category
    WHERE Category_Name = @Cat_Name;
END
GO

EXEC R_Get_Category_Name @Cat_Name = 'Fiction';
GO

-- ? Used in issue_books.php
-- ? Returns all of the currently return books to be shown in a datalist.

CREATE PROCEDURE R_Get_Checked_Return_Books
    @Book VARCHAR(100),
    @Student VARCHAR(100),
    @Copies INT
AS
BEGIN
    SELECT
        Borrow_ID,
        Book_Name AS 'Book',
        Student_Name AS 'Student',
        Borrow_Copies_Got AS 'Copies'
    FROM Borrow
        LEFT JOIN Book
        ON Borrow.Borrow_Book_ID = Book.Book_ID
        LEFT JOIN Student
        ON Borrow.Borrow_Student_ID = Student.Student_ID
    WHERE 
Book_Name = @Book AND
        Student_Name = @Student AND
        Borrow_Copies_Got = @Copies;
END
GO

-- ? Used in issue_books.php
-- ? Check for the data provided by the use to avoid exploits.

CREATE PROCEDURE R_Get_Checked_Return_Books
    @Book VARCHAR(100),
    @Student VARCHAR(100),
    @Copies INT
AS
BEGIN
    SELECT
        Borrow_ID,
        Book_Name AS 'Book',
        Student_Name AS 'Student',
        Borrow_Copies_Got AS 'Copies'
    FROM Borrow
        LEFT JOIN Book
        ON Borrow.Borrow_Book_ID = Book.Book_ID
        LEFT JOIN Student
        ON Borrow.Borrow_Student_ID = Student.Student_ID
    WHERE 
Book_Name = @Book AND
        Student_Name = @Student AND
        Borrow_Copies_Got = @Copies;
END
GO

-- EXEC R_Get_Checked_Return_Books @Book = 'The Hunger Games', @Student = 'George Davidson', @Copies = 3;
-- GO

CREATE PROCEDURE U_Return_Books
    @BorrowID VARCHAR(36),
    @BookID VARCHAR(36),
    @Copies INT
AS
BEGIN
    -- * UPDATE THE NUMBER OF COPIES OF BOOK BASED ON COPIES
    UPDATE Book
    SET Book_Copies_Current += @Copies
    WHERE Book_ID = @BookID;

    -- * UPDATE TO AVAILABLE (Book_Status) KAPAG BOOK_COPIES_CURRENT > 0
    UPDATE Book
    SET Book_Status = 1
    WHERE Book_ID = @BookID AND Book_Copies_Current > 0;

    UPDATE Borrow
    SET Borrow_Status = 1
    WHERE Borrow_ID = @BorrowID;
END
GO

CREATE PROCEDURE R_Get_Book_Names_For_Search
AS
BEGIN
    SELECT Book_Name AS 'Books'
    FROM Book;
END
GO

EXEC R_Get_Book_Names_For_Search;
GO

SELECT *
FROM Book;
GO

-- ? Used in book-edit.php
-- ? Retrieves the data of the book to be edited.

CREATE PROCEDURE R_Get_Book_To_Edit
    @BookName VARCHAR(100)
AS
BEGIN
    SELECT
        Book_ID,
        Book_ISBN,
        Book_Name,
        Book_Author,
        Book_Description,
        Category_Name,
        Book_Copies_Actual,
        Book_Copies_Current
    FROM Book
        LEFT JOIN Book_Category
        ON Book.Book_Category_ID = Book_Category.Category_ID
    WHERE Book_Name = @BookName;
END
GO

EXEC R_Get_Book_To_Edit @BookName = 'Ready Player One';
GO

CREATE PROCEDURE U_Edit_Book
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
    UPDATE Book
    SET
    Book_ISBN = @ISBN,
    Book_Name = @Name,
    Book_Author = @Author, 
    Book_Description = @Description,
    Book_Category_ID = @CatID,
    Book_Status = @Status,
    Book_Copies_Actual = @CopiesActual,
    Book_Copies_Current = @CopiesCurrent
    WHERE 
    Book_ID = @BookID;
END
GO

CREATE PROCEDURE R_Get_Student_Info_For_Edit
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT Student_ID, Student_Number, Student_Name, Student_Email, Student_Status
    FROM Student
    WHERE Student_Number = @StudNum;
END
GO

CREATE PROCEDURE R_Get_Return_Books
AS
BEGIN
    SELECT
        Book_Name + ' - ' + Student_Name + ' - ' + CAST(Borrow_Copies_Got AS VARCHAR) + ' Copies' AS 'Return Books'
    FROM Borrow
        LEFT JOIN Book
        ON Borrow.Borrow_Book_ID = Book.Book_ID
        LEFT JOIN Student
        ON Borrow.Borrow_Student_ID = Student.Student_ID
    WHERE Borrow_Status != 1;
END
GO

CREATE PROCEDURE R_Get_Admin_Name_For_Display
    @Username VARCHAR(100)
AS
BEGIN
    SELECT AdminName
    FROM Admin
    WHERE AdminUsername = @Username;
END
GO

CREATE PROCEDURE R_Check_Student_Number
    @StudNum VARCHAR(12)
AS
BEGIN
    SELECT Student_Number
    FROM Student
    WHERE Student_Number = @StudNum;
END
GO

CREATE PROCEDURE U_Update_Category_Name
    @CatID INT,
    @Name VARCHAR(100)
AS
BEGIN
    UPDATE Book_Category
SET Category_Name = @Name
WHERE Category_ID = @CatID
END
GO

CREATE PROCEDURE R_Get_Admin_Info_For_Settings
    @Username VARCHAR(20)
AS
BEGIN
    SELECT AdminID, AdminName, AdminUsername
    FROM Admin
    WHERE AdminUsername = @Username;
END
GO

CREATE PROCEDURE U_Admin_Info_Settings
    @Name VARCHAR(100),
    @Username VARCHAR(20),
    @Password VARCHAR(255),
    @AdminID VARCHAR(36)
AS
BEGIN
    UPDATE Admin
    SET AdminName = @Name, AdminUsername = @Username, AdminPassword = @Password
    WHERE AdminID = @AdminID;
END
GO

CREATE PROCEDURE R_Admin_Login
    @Username VARCHAR(20)
AS
BEGIN
    SELECT AdminUsername, AdminPassword
    FROM Admin
    WHERE AdminUsername = @Username;
END
GO

EXEC R_Admin_Login @Username = 'admin';
GO

CREATE PROCEDURE R_Check_Username_Exists
    @Username VARCHAR(20)
AS
BEGIN
    SELECT AdminUsername
    FROM Admin
    WHERE AdminUsername = @Username;
END
GO

EXEC R_Check_Username_Exists @Username = 'admin';
GO

CREATE PROCEDURE C_Add_New_Librarian
    @AdminID VARCHAR(36),
    @Name VARCHAR(100),
    @Username VARCHAR(20),
    @Password VARCHAR(255)
AS
BEGIN
    INSERT INTO Admin
        (AdminID, AdminName, AdminUsername, AdminPassword)
    VALUES
        (@AdminID, @Name, @Username, @Password);
END
GO