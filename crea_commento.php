<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati dal form

$commentoText = $_POST['commento-text'];
$id_post = $_POST['id_post'];
$idUser = $_POST['id_user'];


// Controlla se le password coincidono
if ($commentoText == "") {
    // Reindirizza alla pagina di registrazione con un messaggio di errore
    header("Location: http://localhost/socialMedia/home.php#post-". $id_post);
    exit();
}

// Inserisci i dati dell'utente nel database
$query = "INSERT INTO `commenti` (`id`, `testo`, `data_commento`, `id_utente`, `id_post`) VALUES (NULL, '$commentoText', current_timestamp(), $idUser, $id_post)";
if ($conn->query($query) === TRUE) {
    // Registrazione avvenuta con successo, esegui il login automatico se l'opzione "Ricordami" è stata selezionata
    header("Location: http://localhost/socialMedia/home.php#post-". $id_post);
    exit();
    
}

// Chiudi la connessione al database
$conn->close();
?>