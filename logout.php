<?php
    // Cancella email e password dalla sessione
    if (isset($_SESSION['email'])) {
        unset($_SESSION['email']);
    }
    if (isset($_SESSION['password'])) {
        unset($_SESSION['password']);
    }

    // Cancella email e password dai cookie
    if (isset($_COOKIE['email'])) {
        unset($_COOKIE['email']);
        setcookie('email', '', time() - 3600, '/');
    }
    if (isset($_COOKIE['password'])) {
        unset($_COOKIE['password']);
        setcookie('password', '', time() - 3600, '/');
    }

    // Reindirizza alla pagina di login
    
    exit(); // Assicura che lo script termini dopo il reindirizzamento
?>
