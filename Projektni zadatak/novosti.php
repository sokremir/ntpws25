<?php
session_start();
$pageTitle = "Novosti";
$currentYear = date("Y");
require_once 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>

    <main>
        <h2>Novosti</h2>
        <p>Ovdje će biti prikazane najnovije vijesti i događaji.</p>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>