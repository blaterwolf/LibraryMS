<?php
if (basename($_SERVER['PHP_SELF']) == 'dashboard-home.php' or basename($_SERVER['PHP_SELF']) == 'dashboard-borrow.php' or basename($_SERVER['PHP_SELF']) == 'dashboard-stud.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary active text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'books-add.php' or basename($_SERVER['PHP_SELF']) == 'books-edit-search.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary active text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'students.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary active text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'issue_books.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary active text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'archive.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary active text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php else : ?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard-home.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="books" type="button" class="btn btn-primary text-start" href="books-add.php">
        <i class="bi bi-book-fill"></i>&emsp;
        BOOKS
    </a>
    <a id="students" type="button" class="btn btn-primary text-start" href="students.php">
        <i class="bi bi-person-circle"></i>&emsp;
        STUDENTS
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="issue_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        ISSUE BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="archive.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php endif; ?>