<header>
    <nav class="navbar d-flex justify-content-around navbar-expand">
        <a href="dashboard.php"><img src="../../assets/images/logo.png" /></a>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <?php print_r($current_librarian) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>