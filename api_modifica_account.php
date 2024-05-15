<?php
session_start();

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se sono stati inviati dati tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    
    $idUser = $_POST['idUser'];

    $insert_query = "UPDATE `login` SET `username` = '$username' WHERE `login`.`id` = $idUser";

    if ($conn->query($insert_query) === TRUE) {
        echo "username aggiornato";
    } else {
        // Si è verificato un errore durante l'inserimento del post nel database
        echo "Errore durante l'inserimento del post nel database: " . $conn->error;
    }

    $descrizione = $_POST['description'];

    $id = $_POST['id'];

    
    // Recupera il file multimediale (se presente)
    $new_banner = $_FILES['new_banner'];

    // Se il file multimediale è stato caricato con successo, salvalo nel server e ottieni il percorso
    if ($new_banner['error'] == UPLOAD_ERR_OK) {
        // Percorso in cui salvare il file multimediale sul server (puoi personalizzarlo a seconda del tuo ambiente)
        $upload_dir = "banner/";
        $media_filename = $new_banner['name'];
        $media_path = $upload_dir . $media_filename;

        // Sposta il file dalla sua posizione temporanea alla cartella di destinazione
        move_uploaded_file($new_banner['tmp_name'], $media_path);
    } else {
        // Nessun file multimediale è stato caricato o si è verificato un errore durante il caricamento
        $media_path = null;
    }

    // Inserisci il post nel database
    // Query per inserire il post nel database
    $insert_query = "UPDATE `userdata` SET `banner` = '$media_path', `descrizione` = '$descrizione' WHERE `userdata`.`id` = $id";

    if ($conn->query($insert_query) === TRUE) {
        // Il post è stato inserito nel database con successo
        header("Location: impostazioni.php"); // Reindirizza alla homepage o a un'altra pagina di successo
        exit();
    } else {
        // Si è verificato un errore durante l'inserimento del post nel database
        echo "Errore durante l'inserimento del post nel database: " . $conn->error;
    }
} else {
    // Se i dati non sono stati inviati tramite POST, reindirizza alla homepage
    header("Location: impostazioni.php");
    exit();
}

// Chiudi la connessione al database
$conn->close();
?>