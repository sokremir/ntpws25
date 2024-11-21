<nav>
    <div class="nav-logo">
        <a href="index.php">
            <img src="img/sljemenskigonic.png" alt="Logo">
        </a>
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="galerija.php">Galerija</a>
        <a href="kontakt.php">Rezervacija</a>
    </div>
    <div class="nav-admin">
        <?php if (isset($_SESSION['admin_id'])): ?>
            <a href="admin_food.php">Admin Food</a>
            <a href="admin_panel.php">Admin Panel</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="admin_login.php">Admin Login</a>
        <?php endif; ?>
    </div>
</nav>