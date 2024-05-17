<?php

    $host = "localhost"; // Modifica questo con l'host del tuo database
    $usernam = "root"; // Modifica questo con il tuo nome utente del database
    $passwor = "root"; // Modifica questo con la tua password del database
    $dbname = "blog"; // Modifica questo con il nome del tuo database

    // Effettua la connessione al database
    $con = mysqli_connect($host, $usernam, $passwor, $dbname);

    if (mysqli_connect_errno()) {
        echo json_encode(array("message" => "Impossibile connettersi al database: " . mysqli_connect_error()));
        exit();
    }

    // Verifica se è stato fornito un ID valido
    if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $_GET['id_like']; // Ottieni l'ID dal corpo della richiesta e convertilo in un intero

        if($id) {

            $query = "DELETE FROM likes WHERE id = $id";

            // Esegui la query
            if (mysqli_query($con, $query)) {
                echo json_encode(array("message" => "Record eliminato con successo."));
                
            } else {
                echo json_encode(array("message" => "Errore durante l'eliminazione del record: " . mysqli_error($con)));
            }
            
        } else {
            echo json_encode(array("message" => "ID non valido."));
        }
    } else {
        // Se la richiesta non è stata fatta tramite il metodo DELETE
        echo json_encode(array("message" => "Metodo non consentito."));
    }

    // Chiudi la connessione al database
    mysqli_close($con);

?>
