<?php
session_start();

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se sono stati inviati dati tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current-password'];

    $newPassword = $_POST['new-password'];
    $confirm_password = $_POST['confirmPass'];
    
    $email = $_POST['email'];
    // Aggiorna l'username
    $update_password_query = "UPDATE `login` SET `passworld` = '$newPassword' WHERE  login.email = '$email' AND login.passworld = '$currentPassword';";

    if ($conn->query($update_password_query) === TRUE) {
        $_SESSION['success_message'] = "Password aggiornato con successo.";
        
        $_SESSION['password'] = $newPassword;
        // Se l'utente ha selezionato Ricordami, salva l'email come cookie per un mese

        setcookie('password', $newPassword, time() + (30 * 24 * 60 * 60), '/');
    } else {
        $_SESSION['error_message'] = "Errore durante l'aggiornamento della password";
    }
    
    header("Location: impostazioni.php");
    exit();
} else {
    // Se i dati non sono stati inviati tramite POST, reindirizza alla homepage
    header("Location: impostazioni.php");
    exit();
}


// Chiudi la connessione al database
$conn->close();
?>
