<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati dal form
$commentoText = $conn->real_escape_string($_POST['commento-text']);
$id_post = $_POST['id_post'];
$idUser = $_POST['id_user'];

// Controlla se il testo del commento è vuoto
if ($commentoText == "") {
    // Reindirizza alla pagina del post con un messaggio di errore
    header("Location: http://localhost/socialMedia/home.php#post-". $id_post);
    exit();
}

// Inserisci i dati del commento nel database
$query = "INSERT INTO `commenti` (`id`, `testo`, `data_commento`, `id_utente`, `id_post`) VALUES (NULL, '$commentoText', current_timestamp(), $idUser, $id_post)";

if ($conn->query($query) === TRUE) {
    // Commento inserito con successo, reindirizza alla pagina del post
    header("Location: http://localhost/socialMedia/home.php#post-". $id_post);
    exit();
} else {
    // In caso di errore, reindirizza alla pagina del post con un messaggio di errore
    header("Location: http://localhost/socialMedia/home.php#post-". $id_post . "&error");
    exit();
}

// Chiudi la connessione al database
$conn->close();
?>
