<header>
    <nav class="navbar d-flex justify-content-around navbar-expand">
        <a href="dashboard.php"><img src="../../assets/images/logo.png" /></a>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <?php print_r($g_admin_name) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                <?php
                if ($current_librarian == 'admin') {
                    echo '<li><a class="dropdown-item" href="add_librarian.php">Add New Librarian</a></li>';
                    echo '<li><a class="dropdown-item" href="view_librarian.php">View All Librarian</a></li>';
                }
                ?>
                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>