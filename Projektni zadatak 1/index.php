<?php
session_start();
require_once 'db_connect.php';

// Fetch featured food items from database
$featuredItems = [];
$result = $MySQL->query("SELECT fi.*, fc.name as category_name FROM food_items fi JOIN food_category fc ON fi.category_id = fc.id ORDER BY RAND() LIMIT 3");
while ($row = $result->fetch_assoc()) {
    $featuredItems[] = $row;
}

$pageTitle = "RESTORAN SLJEMENSKI GONIČ";
$currentYear = date("Y");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data here
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Planinarenje i hrana.">
    <meta name="keywords" content="Planinarenje, Hrana">
    <meta name="author" content="Krešimir Lovrić">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>

    <main>
        <div id="banner">
            <img src="img/sljeme.jpg" alt="Restoran Sljemenski Gonič Banner">
            <div class="banner-content">
                <h2>Dobrodošli u Restoran Sljemenski Gonič</h2>
                <p>Otkrijte jedinstvene okuse naše kuhinje</p>
                <a href="menu.php" class="menu-button">Pogledajte Naš Meni</a>
            </div>
        </div>


        <section id="featured-items">
            <h2>Izdvojena jela</h2>
            <div class="featured-grid">
                <?php foreach ($featuredItems as $item): ?>
                <div class="featured-dish">
                    <?php if (!empty($item['photo_url'])): ?>
                        <img src="<?php echo $item['photo_url']; ?>" alt="<?php echo $item['name']; ?>" style="max-width: 300px;">
                    <?php endif; ?>
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Kategorija: <?php echo $item['category_name']; ?></p>
                    <p><?php echo $item['description']; ?></p>
                    <p>Cijena: <?php echo number_format($item['price'], 2); ?> EUR</p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <h2>Lokacija</h2>
        <div class="kontaktinfo">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2778.8821737799807!2d15.968255776891362!3d45.90800710356872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765dd6d5d7b9a2f%3A0x3ec5f0fe41c6b5d1!2sSljeme!5e0!3m2!1sen!2shr!4v1683842697929!5m2!1sen!2shr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>