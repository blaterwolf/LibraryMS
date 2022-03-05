<?php
if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary active text-center" href="dashboard.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="borrow_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        BORROW BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="transactions.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'borrow_books.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="issue-books" type="button" class="btn btn-primary active text-start" href="borrow_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        BORROW BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="transactions.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php
elseif (basename($_SERVER['PHP_SELF']) == 'transactions.php') :
?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="borrow_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        BORROW BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary active text-start" href="transactions.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php else : ?>
<div class="nav-panel btn-group-vertical">
    <a id="home" type="button" class="btn btn-primary text-center" href="dashboard.php">
        <i class="bi bi-house-fill"></i>&emsp;
        HOME
    </a>
    <a id="issue-books" type="button" class="btn btn-primary text-start" href="borrow_books.php">
        <i class="bi bi-clipboard-check-fill"></i>&emsp;
        BORROW BOOKS
    </a>
    <a id="archive-log" type="button" class="btn btn-primary text-start" href="transactionss.php">
        <i class="bi bi-archive-fill"></i>&emsp;
        ARCHIVE LOG
    </a>
</div>
<?php endif; ?>