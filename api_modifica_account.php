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
    $descrizione = $_POST['description'];
    $id = $_POST['id'];
    $media_path = null;

    // Aggiorna l'username nella tabella 'login'
    $update_username_query = $conn->prepare("UPDATE `login` SET `username` = ? WHERE `id` = ?");
    $update_username_query->bind_param("si", $username, $idUser);
    if ($update_username_query->execute()) {
        $_SESSION['success_message'] = "Username aggiornato con successo.";
    } else {
        $_SESSION['error_message'] = "Errore durante l'aggiornamento dell'username.";
    }
    $update_username_query->close();

    // Controlla se è stato fornito un nuovo banner
    if (!empty($_FILES['new_banner']['name']) && $_FILES['new_banner']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "banner/";
        $media_filename = $_FILES['new_banner']['name'];
        $media_path = $upload_dir . basename($media_filename);
        move_uploaded_file($_FILES['new_banner']['tmp_name'], $media_path);
    }

    // Costruzione della query di aggiornamento per 'userdata'
    $update_userdata_query = "UPDATE `userdata` SET ";
    $params = [];
    $types = '';

    if (!empty($media_path)) {
        $update_userdata_query .= "`banner` = ?, ";
        $params[] = $media_path;
        $types .= 's';
    }
    
    $update_userdata_query .= "`descrizione` = ? WHERE `id` = ?";
    $params[] = $descrizione;
    $params[] = $id;
    $types .= 'si'; // 's' per stringa (descrizione) e 'i' per intero (id)

    $stmt = $conn->prepare($update_userdata_query);
    if ($stmt === false) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Dettagli aggiornati con successo.";
    } else {
        $_SESSION['error_message'] = "Errore durante l'aggiornamento dei dettagli.";
    }

    $stmt->close();
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
