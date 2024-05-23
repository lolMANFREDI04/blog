<?php
session_start();

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se sono stati inviati dati tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postTitle = $_POST['postTitle'];
    $postDescription = $_POST['postDescription'];
    $id_post = $_POST['id_post'];
    $media_path = null;

    // Controlla se la checkbox 'nessunMedia' è selezionata
    if (isset($_POST['nessunMedia']) && $_POST['nessunMedia'] == 'on') {
        $media_path = null;
    } else {
        // Controlla se è stato fornito un nuovo media
        if (!empty($_FILES['media']['name']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = "media/";
            $media_filename = $_FILES['media']['name'];
            $media_path = $upload_dir . $media_filename;
            if (!move_uploaded_file($_FILES['media']['tmp_name'], $media_path)) {
                die("Errore durante il caricamento del file media.");
            }
        }
    }

    // Costruzione della query di aggiornamento per 'post'
    $update_userdata_query = "UPDATE `post` SET ";
    $params = [];
    $types = '';

    if (!is_null($media_path)) {
        $update_userdata_query .= "`media` = ?, ";
        $params[] = $media_path;
        $types .= 's';
    } else if($_POST['nessunMedia'] == 'on'){
        $update_userdata_query .= "`media` = NULL, ";
    }

    if (!empty($postTitle)) {
        $update_userdata_query .= "`titolo` = ?, ";
        $params[] = $postTitle;
        $types .= 's';
    }
    
    $update_userdata_query .= "`descrizione` = ? WHERE `id` = ?";
    $params[] = $postDescription;
    $params[] = $id_post;
    $types .= 'si'; // 's' per stringa (descrizione) e 'i' per intero (id)

    $stmt = $conn->prepare($update_userdata_query);
    if ($stmt === false) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Dettagli aggiornati con successo.";
    } else {
        $_SESSION['error_message'] = "Errore durante l'aggiornamento dei dettagli.";
    }

    $stmt->close();
    header("Location: http://localhost/socialMedia/home.php#post-$id_post");
    exit();
} else {
    // Se i dati non sono stati inviati tramite POST, reindirizza alla homepage
    header("Location: http://localhost/socialMedia/home.php#post-$id_post");
    exit();
}

// Chiudi la connessione al database
$conn->close();
?>
