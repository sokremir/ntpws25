<?php
session_start();
$pageTitle = "Menu";
$currentYear = date("Y");
require_once 'db_connect.php';

$currencies = [
    'EUR' => 'Euro',
    'AUD' => 'Australski dolar',
    'CAD' => 'Kanadski dolar',
    'CZK' => 'Češke krune',
    'DKK' => 'Danske krune',
    'HUF' => 'Mađarske forinte',
    'JPY' => 'Japanski yen',
    'NOK' => 'Norveške krune',
    'SEK' => 'Švedske krune',
    'CHF' => 'Švicarski frank',
    'GBP' => 'Funta',
    'USD' => 'Američki dolar',
    'BAM' => 'Konvertibilna Marka',
    'PLN' => 'Poljski zloti'
];

$exchangeRate = null;
$selectedCurrency = isset($_GET['valuta']) ? $_GET['valuta'] : 'EUR';

if ($selectedCurrency !== 'EUR') {
    $url = "https://api.hnb.hr/tecajn-eur/v3?valuta=" . $selectedCurrency;
    $response = file_get_contents($url);
    if ($response !== false) {
        $data = json_decode($response, true);
        if (!empty($data)) {
            $exchangeRate = $data[0];
        }
    }
}

// Fetch food items from database
$foodItems = [];
$result = $MySQL->query("SELECT fi.*, fc.name as category_name FROM food_items fi JOIN food_category fc ON fi.category_id = fc.id");
while ($row = $result->fetch_assoc()) {
    $foodItems[] = $row;
}

// Function to convert price from EUR to selected currency
function convertPrice($priceEUR, $exchangeRate) {
    if ($exchangeRate === null) {
        return $priceEUR;
    }
    return $priceEUR * floatval(str_replace(',', '.', $exchangeRate['srednji_tecaj']));
}
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
        <h2>Menu</h2>
        
        <form action="" method="get">
            <label for="valuta">Odaberite valutu:</label>
            <select name="valuta" id="valuta" onchange="this.form.submit()">
                <?php foreach ($currencies as $code => $name): ?>
                    <option value="<?php echo $code; ?>" <?php echo $code === $selectedCurrency ? 'selected' : ''; ?>>
                        <?php echo $name; ?> (<?php echo $code; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($exchangeRate): ?>
        <div class="exchange-rate">
            <p>Tečaj: 1 EUR = <?php echo $exchangeRate['srednji_tecaj']; ?> <?php echo $selectedCurrency; ?></p>
            <p>Datum: <?php echo $exchangeRate['datum_primjene']; ?></p>
        </div>
        <?php endif; ?>

        <div class="food-grid">
            <?php foreach ($foodItems as $item): ?>
            <div class="food-item">
                <?php if (!empty($item['photo_url'])): ?>
                    <img src="<?php echo $item['photo_url']; ?>" alt="<?php echo $item['name']; ?>">
                <?php endif; ?>
                <h3><?php echo $item['name']; ?></h3>
                <p>Kategorija: <?php echo $item['category_name']; ?></p>
                <p>Cijena: 
                    <?php 
                    $price = convertPrice($item['price'], $exchangeRate);
                    echo number_format($price, 2) . ' ' . $selectedCurrency; 
                    ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>