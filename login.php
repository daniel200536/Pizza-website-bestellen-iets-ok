<?php
session_start();

// Verbinding maken met de database
$servername = "localhost";  // Vervang dit met de juiste database servernaam
$username = "root";  // Vervang dit met de juiste database gebruikersnaam
$password = "";  // Vervang dit met het juiste database wachtwoord
$dbname = "Pizzawebsite";  // Vervang dit met de juiste database naam

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kan geen verbinding maken met de database: " . $conn->connect_error);
}

// Gegevens uit het inlogformulier verwerken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["naam"];
    $password = $_POST["password"];

    // Controleren of de gebruiker bestaat in de database
    $loginQuery = "SELECT * FROM Login WHERE Naam = '$name' AND Password = '$password'";
    $loginResult = $conn->query($loginQuery);

    if ($loginResult->num_rows > 0) {
        // Inloggen succesvol, sessievariabelen instellen en doorverwijzen naar index.php
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $name;
        header("Location: index.php");
        exit();
    } else {
        echo "Ongeldige naam of wachtwoord.";
    }
}

$conn->close();
?>
