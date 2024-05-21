<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati dal form
$titolo = $conn->real_escape_string($_POST['titolo']);
$descrizione = $conn->real_escape_string($_POST['descrizione']);
$idUtentePost = $_POST['idUtentePost'];

// Controlla se il titolo è vuoto
if ($titolo == "") {
    // Reindirizza alla pagina di registrazione con un messaggio di errore
    header("Location: http://localhost/socialMedia/home.php?error");
    exit();
}

$media_path = null;

// Controlla se è stato fornito un nuovo media
if (!empty($_FILES['media']['name']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = "media/";
    $media_filename = $_FILES['media']['name'];
    $media_path = $upload_dir . $media_filename;
    move_uploaded_file($_FILES['media']['tmp_name'], $media_path);
}

// Inserisci i dati del post nel database
$query = "INSERT INTO `post` (`id`, `titolo`, `descrizione`, `media`, `data_post`, `id_utente`) VALUES (NULL, '$titolo', '$descrizione', '$media_path', CURRENT_TIMESTAMP, '$idUtentePost')";

if ($conn->query($query) === TRUE) {
    // Ottieni l'ID del post appena inserito
    $id_post = $conn->insert_id;
    // Reindirizza alla home con l'ID del post
    header("Location: http://localhost/socialMedia/home.php?id_post=$id_post");
    exit();
} else {
    // Reindirizza alla pagina di registrazione con un messaggio di errore
    header("Location: http://localhost/socialMedia/home.php?error");
    exit();
}

// Chiudi la connessione al database
$conn->close();
?>
