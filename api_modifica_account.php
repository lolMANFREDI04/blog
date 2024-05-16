

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
    
    // Aggiorna l'username
    $update_username_query = "UPDATE `login` SET `username` = '$username' WHERE `login`.`id` = $idUser";

    if ($conn->query($update_username_query) === TRUE) {
        $_SESSION['success_message'] = "Username aggiornato con successo.";
    } else {
        $_SESSION['success_message'] = "Username aggiornato con successo.";
    }

    // Aggiorna il banner e la descrizione solo se sono stati forniti nuovi valori

        $descrizione = $_POST['description'];
        $id = $_POST['id'];
        $media_path = null;

        // Controlla se è stato fornito un nuovo banner
        if (!empty($_FILES['new_banner']['name']) && $_FILES['new_banner']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = "banner/";
            $media_filename = $_FILES['new_banner']['name'];
            $media_path = $upload_dir . $media_filename;
            move_uploaded_file($_FILES['new_banner']['tmp_name'], $media_path);
        }

        // Aggiorna il banner e la descrizione
        $update_userdata_query = "UPDATE `userdata` SET ";
        if (!empty($media_path)) {
            $update_userdata_query .= "`banner` = '$media_path', ";
        }
        
        $update_userdata_query .= "`descrizione` = '$descrizione', ";
        
        $update_userdata_query = rtrim($update_userdata_query, ", "); // Rimuove l'ultima virgola dalla query

        $update_userdata_query .= " WHERE `userdata`.`id` = $id";

        if ($conn->query($update_userdata_query) === TRUE) {
            $_SESSION['success_message'] = "Username aggiornato con successo.";
            
        } else {
            $_SESSION['success_message'] = "Username aggiornato con successo.";
        }
    
    header("Location: impostazioni.php");
    exit();
} else {
    // Se i dati non sono stati inviati tramite POST, reindirizza alla homepage
    header("Location: impostazioni.php");
    exit();
}
header("Location: impostazioni.php");
exit();

// Chiudi la connessione al database
$conn->close();
?>
