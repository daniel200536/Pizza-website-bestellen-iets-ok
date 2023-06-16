<!DOCTYPE html>
<html>
<head>
    <title>Bestellijst</title>
</head>
<body>
    <h1>Bestellijst</h1>

    <?php
    // Databaseconfiguratie
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Pizzawebsite";

    // Start de sessie en maak de winkelwagen indien nodig
    session_start();
    if (!isset($_SESSION['winkelwagen'])) {
        $_SESSION['winkelwagen'] = array();
    }

    // Controleer of er items in de winkelwagen zijn
    if (!empty($_SESSION['winkelwagen'])) {
        // Controleer of er een timeout is
        if (isset($_SESSION['winkelwagen_timeout']) && $_SESSION['winkelwagen_timeout'] < time()) {
            // Verwijder alle items uit de winkelwagen en timeout
            $_SESSION['winkelwagen'] = array();
            unset($_SESSION['winkelwagen_timeout']);
        }
    }

    // Maak verbinding met de database
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query om pizzagegevens op te halen
    $query = "SELECT * FROM Voedsel";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Verwerk de resultaten
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<h2>" . $row['Eten'] . "</h2>";
            echo "<p>Beschrijving: " . $row['Beschrijving'] . "</p>";
            echo "<p>Ingrediënten: " . $row['Ingrediënten'] . "</p>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='pizza_id' value='" . $row['ID'] . "'>";
            echo "<input type='submit' name='add_to_cart' value='Toevoegen aan winkelwagen'>";
            echo "</form>";
            echo "<hr>";
        }
    } else {
        echo "Geen pizzagegevens gevonden.";
    }

    // Voeg geselecteerde pizza toe aan de winkelwagen
    if (isset($_POST['add_to_cart'])) {
        $pizza_id = $_POST['pizza_id'];
       
        
        // Query om de geselecteerde pizza op te halen
        $query = "SELECT * FROM Voedsel WHERE ID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $pizza_id);
        $stmt->execute();
      
        if ($stmt->rowCount() > 0) {
            $pizza = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['winkelwagen'][] = $pizza;
            $_SESSION['winkelwagen_timeout'] = time() + (20 * 60); // 20 minuten timeout
            echo "Pizza succesvol toegevoegd aan de winkelwagen.";
        }
        header("Location: bestellijst.php"); // Vervang 'bestellijst.php' door de juiste naam van je huidige pagina
        exit();
    }
// Functie om de resterende tijd te berekenen
function getRemainingTime($timeout) {
    $now = time();
    $remainingSeconds = $timeout - $now;
    $minutes = floor($remainingSeconds / 60);
    $seconds = $remainingSeconds % 60;

    return sprintf('%02d:%02d', $minutes, $seconds);
}

    // Verwijder geselecteerde pizza uit de winkelwagen
    if (isset($_POST['remove_from_cart'])) {
        
        $pizza_id = $_POST['pizza_id'];
      

        foreach ($_SESSION['winkelwagen'] as $key => $pizza) {
            if ($pizza['ID'] == $pizza_id) {
                unset($_SESSION['winkelwagen'][$key]);
                echo "Pizza succesvol verwijderd uit de winkelwagen.";
                break;
            }
        }
        header("Location: bestellijst.php"); // Vervang 'bestellijst.php' door de juiste naam van je huidige pagina
        exit();
    }

    // Toon de inhoud van de winkelwagen
    echo "<h2>Winkelwagen</h2>";
    if (!empty($_SESSION['winkelwagen'])) {
        foreach ($_SESSION['winkelwagen'] as $pizza) {
            echo "<p>Pizza: " . $pizza['Eten'] . " - " . $pizza['Beschrijving'] . "</p>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='pizza_id' value='" . $pizza['ID'] . "'>";
            echo "<input type='submit' name='remove_from_cart' value='Verwijderen'>";
            echo "</form>";
            echo "<hr>";
        }
    } else {
        echo "De winkelwagen is leeg.";
    }

    // Sluit de databaseverbinding
    $pdo = null;
    ?>

</body>
</html>
