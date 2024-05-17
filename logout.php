<?php
// Avvia la sessione
session_start();

// Cancella la variabile di sessione 'email' se presente
if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}
if (isset($_SESSION['password'])) {
    unset($_SESSION['password']);
}
// Cancella il cookie contenente il token di sessione
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time()-3600, '/');
}
if (isset($_COOKIE['password'])) {
    setcookie('password', '', time()-3600, '/');
}

// Reindirizza alla pagina di login o alla pagina principale
header('Location: Home.php'); // Modifica 'index.php' con il percorso della tua pagina principale o di login
exit;