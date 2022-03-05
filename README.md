# School Library Management System
A Simple School Library Management System for a school library that manages the condition of the books, borrowed books, students or the borrowers, penalty for overdue books. This design is inspired by simple library management systems in libraries which helps librarians to have a system for organizing a library.

[![PHP 8.1.1](https://img.shields.io/badge/php-8.1.1-purple?logo=php&logoColor=B0B3D6)](https://www.php.net/downloads.php)
___
### Domain Description
Final description will be posted soon!
___
### Relational Schema
Images will be posted soon!
___
### Database Diagram
Images will be posted soon!
___
### Changelog
###### v0.1.0
* The first version of LibraryMS pushed in Github.
* Consists of the current project files used.
  * `assets` - contains the `css`, `images`, `node_modules`, and `scss` used for the project.
  * `dashboard` - contains the second part of the project. The dashboard section is going to be used by both users: the students and librarian.
  * `db` - contains the initial database query in SQL Server and some sample data.
  * `functions` - contains php functions or codes to be referenced in the main PHP files.
  *  `includes` - contains some redudant HTML code referenced over the login section such as the Header and Footer.
* The files outside these folders are the main files and `index.php` is the first page that is rendered.
###### v0.2.0
* Version v0.2.0 creates a set of new files for the `admin` section of the Dashboard. This includes five different navigations: Issuing Books, Archive, Books, Students, and Settings.
* Can be able to login and logout on the Administrator part.
###### v0.3.0
* Version v0.3.0 consists of reworking the database and its queries including some of the Stored Procedures.
* Updates with the Home Dashboard and Books Section are on the way.
###### v0.4.0
* Version v0.4.0 consists of adding the section for the students and reworked their Signup, Forgot Password, and Login section.
* This version also introduced the notification system by using the package `sweetalert2`. Notifications for confirmation are already implemented mostly in the login process.
* On the `db` folder, `procedures.sql` is added to seperate the codes that are used for creating Stored Procedures. 
* Provided below the Installation and Setup is the checklist of the things that are soon to be implemented. For this version, there are 10 things that are needed to be implemented.
___
### Installation and Setup
All guides for setting up and installing the LibraryMS (PHP Edition) on your local device will be posted once the project reaches v1.0.0 or to the point that it is almost complete.
___
### Project Implementation Checklist
*Legend:*
C - Create
R - Retrieve (View)
U - Update

**<ins>STUDENT SIDE</ins>**
✅ C - Create New Student (Student Sign Up)
✅ R - Student Login
✅ U - Forgot Student Password

**Dashboard - Home Panel**
✅ R - View All Books
**Borrow Books Panel**
❌ C - Student Borrow Books
**Archive Log**
❌ R - View All Student Borrow Transactions (specific to that student only -> access session variable)
**Settings**
❌ U - Update Student Data (Personal Info only)

**<ins>ADMIN SIDE</ins>**
**Dashboard - Home Panel**
✅ R - View All Books
✅ R - View All Students
✅ R - View All Currently Issued Books
**Books Panel**
✅ C - Create New Books
❌ U - Update Book Information
**Students Panel**
❌ U - Update Student Data (Personal Info + Status)
**Issue Books**
❌ U - Update Issued Book Information (Kapag isasauli na)
**Archive Log**
❓ R - View Book Data *(not updated)*
**Settings**
❌ C - Create New Librarian (Admin Sign Up)
❌ U - Update Admin Name

**Security**
❌ - Check Active Status of the Student - Student can't login if they are flagged as `0` in the `Student_Status` in the database.
❌ - Kapag pumunta ka sa Main Page, tapos bumalik ka, wala pang authorization kaya nagbablangko ang `$_SESSION['admin_login'];` sa Dashboard
Reference for Possible Solution: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
✅ - Password Hashing 
