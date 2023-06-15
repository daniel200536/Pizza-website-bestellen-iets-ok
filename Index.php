<?php
session_start();

// Controleren of de gebruiker is ingelogd
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $userName = $_SESSION['username'];
    $isLogged = true;
} else {
    $userName = "Gast";
    $isLogged = false;
}

// Verwerken van inloggegevens
if(isset($_POST['email']) && isset($_POST['password'])) {
    // Controleer de inloggegevens en log de gebruiker in als ze correct zijn
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Voeg hier je eigen validatielogica toe
    // Hieronder staat een voorbeeld van een eenvoudige validatie (niet veilig voor productiegebruik!)

    // Controleer of de gebruiker bestaat en het wachtwoord overeenkomt
    if($email === 'voorbeeld@example.com' && $password === 'wachtwoord') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $email;
        $userName = $email;
        $isLogged = true;
    } else {
        // Ongeldige inloggegevens, toon een foutmelding of voer andere acties uit
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepagina</title>
</head>
<body>
    <h2>Welkom op de Homepagina</h2>
    <?php if($isLogged) { ?>
        <p>Welkom, <?php echo $userName; ?></p>
    <?php } else { ?>
        <p>Welkom, Gast</p>
    <?php } ?>

    <div>
        <select id="account-dropdown" onchange="handleDropdownChange(this)">
            <option selected disabled>Account</option>
            <?php if($isLogged) { ?>
                <option><?php echo $userName; ?></option>
                <option value="account">Edit Account</option>
                <option value="logout">Logout</option>
            <?php } else { ?>
                <option value="register">Register</option>
                <option value="login">Login</option>
            <?php } ?>
        </select>
    </div>

    <script>
        function handleDropdownChange(dropdown) {
            var selectedValue = dropdown.value;

            if (selectedValue === "account") {
                window.location.href = "account.php";
            } else if (selectedValue === "logout") {
                window.location.href = "logout.php";
            } else if (selectedValue === "register") {
                window.location.href = "register.html";
            } else if (selectedValue === "login") {
                window.location.href = "login.html";
            }
        }
    </script>
</body>
</html>

