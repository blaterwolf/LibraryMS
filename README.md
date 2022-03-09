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
###### v0.5.0
* Student Side Implementation Completed! *(sort of...?)*
* Just a few bug fixes to there and the final implementations for the Admin Side will be finished by the subsequent versions.
* Added Badges for some of the tables that has a Status mark.
* Removed the Project Timeline below the `readme.md` because it's messy lol. Will do something similar in the future updates when documentation starts.
###### v0.6.0
* Finished the Edit Book feature for the Admin Side. There are 4 more things to build before we can say that this is the v1.0.0
* There are no other updates aside from this feature. Just some additional procedures were added to the `procedures.sql` and unnecessary comments were removed.

###### v0.7.0
* All Admin Side Implementations are 90% complete!
* The only thing to be implemented there is the Archive Log section.
* Also updated all names that are still using hypens to underscores. If there is an event of a 404, this will be fixed in the following update.
* There are also niche updates in the following updates.
___
### Installation and Setup
All guides for setting up and installing the LibraryMS (PHP Edition) on your local device will be posted once the project reaches v1.0.0 or to the point that it is almost complete.
