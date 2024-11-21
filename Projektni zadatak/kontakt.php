<?php
session_start();
require_once 'db_connect.php';

// Fetch countries from the drzave table
$countries = [];
$result = $MySQL->query("SELECT * FROM drzave");
while ($row = $result->fetch_assoc()) {
    $countries[] = $row;
}

$pageTitle = "Kontakt";
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
        <h2>Rezervacija</h2>
        <form action="process_reservation.php" method="POST">
            <div class="form-grupa">
                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required>
            </div>
            <div class="form-grupa">
                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" required>
            </div>
            <div class="form-grupa">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-grupa">
                <label for="telefon">Telefon:</label>
                <input type="tel" id="telefon" name="telefon" required>
            </div>
            <div class="form-grupa">
                <label for="drzava">Država:</label>
                <select id="drzava" name="drzava" required>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-grupa">
                <label for="datum">Datum rezervacije:</label>
                <input type="date" id="datum" name="datum" required>
            </div>
            <div class="form-grupa">
                <label for="vrijeme">Vrijeme rezervacije:</label>
                <input type="time" id="vrijeme" name="vrijeme" required>
            </div>
            <div class="form-grupa">
                <label for="broj_osoba">Broj osoba:</label>
                <input type="number" id="broj_osoba" name="broj_osoba" min="1" required>
            </div>
            <button type="submit">Pošalji rezervaciju</button>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>