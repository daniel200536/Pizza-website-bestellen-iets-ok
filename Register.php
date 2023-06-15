<?php
// Verbinding maken met de database
$servername = "localhost";  // Vervang dit met de juiste database servernaam
$username = "root";  // Vervang dit met de juiste database gebruikersnaam
$password = "";  // Vervang dit met het juiste database wachtwoord
$dbname = "Pizzawebsite";  // Vervang dit met de juiste database naam

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kan geen verbinding maken met de database: " . $conn->connect_error);
}

// Gegevens uit het registratieformulier verwerken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $name = $_POST["name"];

    // Controleren of de e-mail al bestaat in de database
    $checkQuery = "SELECT * FROM Login WHERE Mail = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Deze e-mail is al geregistreerd.";
    } elseif ($password !== $confirmPassword) {
        echo "De wachtwoorden komen niet overeen.";
    } else {
        // E-mail bestaat nog niet en wachtwoorden komen overeen, registreren in de database
        $insertQuery = "INSERT INTO Login (Mail, Password, Naam) VALUES ('$email', '$password', '$name')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "Registratie succesvol. U kunt nu inloggen.";
        } else {
            echo "Er is een fout opgetreden bij het registreren: " . $conn->error;
        }
    }
}

$conn->close();
?>
