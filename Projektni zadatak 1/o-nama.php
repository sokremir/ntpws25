<?php
session_start();
$pageTitle = "Menu";
$currentYear = date("Y");
require_once 'db_connect.php';

$currencies = [
    'AUD' => 'Australski dolar',//-
    'CAD' => 'Kanadski dolar',//-
    'CZK' => 'Češke krune',//-
    'DKK' => 'Danske krune',//-
    'HUF' => 'Mađarske forinte',//-
    'JPY' => 'Japanski yen',//-
    'NOK' => 'Norveške krune',//-
    'SEK' => 'Švedske krune',//-
    'CHF' => 'Švicarski frank',//-
    'GBP' => 'Funta',//-
    'USD' => 'Pravi dolar',//-
    'BAM' => 'Konvertibilna Marka',//-
    'PLN' => 'Poljski zloti'
];

$exchangeRate = null;
$selectedCurrency = isset($_GET['valuta']) ? $_GET['valuta'] : 'AUD';

if (isset($_GET['valuta'])) {
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

// Calculate total price in EUR
$totalPriceEUR = array_sum(array_column($foodItems, 'price'));
// Function to convert price from EUR to selected currency
function convertPrice($priceEUR, $exchangeRate) {
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
        <h1><?php echo $pageTitle; ?></h1>
        <?php include 'nav.php'; ?>
    </header>

    <main>
        <h3>Tečajna lista HNB-a</h3>
        <form action="" method="get">
            <label for="valuta">Odaberite valutu:</label>
            <select name="valuta" id="valuta">
                <?php foreach ($currencies as $code => $name): ?>
                    <option value="<?php echo $code; ?>" <?php echo $code === $selectedCurrency ? 'selected' : ''; ?>>
                        <?php echo $name; ?> (<?php echo $code; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Dohvati tečaj">
        </form>

        <?php if ($exchangeRate): ?>
        <div class="exchange-rate">
            <h4>Tečaj za <?php echo $currencies[$selectedCurrency]; ?> (<?php echo $selectedCurrency; ?>):</h4>
            <p>Datum: <?php echo $exchangeRate['datum_primjene']; ?></p>
            <p>Kupovni tečaj: <?php echo $exchangeRate['kupovni_tecaj']; ?></p>
            <p>Srednji tečaj: <?php echo $exchangeRate['srednji_tecaj']; ?></p>
            <p>Prodajni tečaj: <?php echo $exchangeRate['prodajni_tecaj']; ?></p>
        </div>

        <h3>Cjenik hrane</h3>
        <table class="food-menu">
            <tr>
                <th>Jelo</th>
                <th>Kategorija</th>
                <th>Cijena (EUR)</th>
                <?php if ($exchangeRate): ?>
                    <th>Cijena (<?php echo $selectedCurrency; ?>)</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($foodItems as $item): ?>
            <tr>
                <td>
                    <?php if (!empty($item['photo_url'])): ?>
                        <img src="<?php echo $item['photo_url']; ?>" alt="<?php echo $item['name']; ?>" style="max-width: 100px; max-height: 100px;">
                    <?php endif; ?>
                    <?php echo $item['name']; ?>
                </td>
                <td><?php echo $item['category_name']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?> EUR</td>
                <?php if ($exchangeRate): ?>
                    <td><?php echo number_format(convertPrice($item['price'], $exchangeRate), 2); ?> <?php echo $selectedCurrency; ?></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>

        <?php if (isset($_GET['valuta']) && !$exchangeRate): ?>
            <p>Nije moguće dohvatiti tečaj za odabranu valutu.</p>
        <?php endif; ?>