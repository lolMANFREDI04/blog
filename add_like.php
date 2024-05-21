<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se sono stati inviati dati POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Estrai i dati JSON dalla richiesta
    $data = json_decode(file_get_contents("php://input"));

    // Assicurati che siano presenti entrambi i campi
    if (isset($data->id_utente) && isset($data->id_post)) {
        $id_utente = $data->id_utente;
        $id_post = $data->id_post;

        // Prepara la query per l'inserimento dei dati nella tabella likes
        $sql = "INSERT INTO likes (id_utente, id_post) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_utente, $id_post);

        // Esegui la query
        if ($stmt->execute()) {
            // Invia una risposta JSON di successo
            http_response_code(200);
            echo json_encode(array("message" => "Like aggiunto con successo"));
        } else {
            // Invia una risposta JSON in caso di errore
            http_response_code(500);
            echo json_encode(array("message" => "Errore durante l'aggiunta del like"));
        }
    } else {
        // Invia una risposta JSON se i dati non sono completi
        http_response_code(400);
        echo json_encode(array("message" => "Dati incompleti"));
    }
} else {
    // Invia una risposta JSON se la richiesta non è una richiesta POST
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito"));
}

// Chiudi la connessione al database
$conn->close();
?>