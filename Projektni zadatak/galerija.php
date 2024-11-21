<?php
session_start();
$pageTitle = "Galerija";
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
        <h2>Galerija</h2>
        <div class="gallery">
            <div class="gallery-item">
                <img src="img/clanak1rostilj.HEIC" alt="Sljemenski rostilj">
                <div class="gallery-natpis">
                <p>Nadmorska visina dokazano pomaže u pripremi mesa</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-natpis">
                <img src="img/sljemetoranj.jpg" alt="Toranj">
                <p>Tu se dobro jede</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-natpis">
                <img src="img/wagyu.jpg" alt="Dobro meso">
                <p>Najbolji komadi mesa uhvaćeni u samoj blizini tornja</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-natpis">
                <img src="img/sljeme2.jpg" alt="Zalazak sljeme">
                <p>Dobar način za završiti dan</p>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>