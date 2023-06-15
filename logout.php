<?php
session_start();
session_destroy(); // Sessie beëindigen en alle sessiegegevens wissen
header("Location: index.php"); // Doorverwijzen naar het inlogscherm
exit();
?>
