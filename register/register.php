<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati dal form
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirmPass'];


// Controlla se le password coincidono
if ($password !== $confirm_password) {
    // Reindirizza alla pagina di registrazione con un messaggio di errore
    header("Location: index.html?error=3");
    exit();
}

// Verifica se l'email è già presente nel database
$query = "SELECT * FROM login WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Se l'email è già presente, reindirizza alla pagina di registrazione con un messaggio di errore
    header("Location: index.html?error=2");
    exit();
} else {
    // Inserisci i dati dell'utente nel database
    $query = "INSERT INTO login (email, username, passworld) VALUES ('$email', '$username', '$password');";

    if ($conn->query($query) === TRUE) {
        // Registrazione avvenuta con successo, esegui il login automatico se l'opzione "Ricordami" è stata selezionata
        $_SESSION['email'] = $email; // Salva l'email dell'utente in sessione
        $_SESSION['password'] = $password;
        // Se l'utente ha selezionato Ricordami, salva l'email come cookie per un mese
        setcookie('email', $email, time() + (30 * 24 * 60 * 60), '/');
        setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');

        $get_id = "SELECT login.id FROM login WHERE email = '$email' AND passworld = '$password'";

        echo $get_id;
        
        $get_id_respost = mysqli_query($conn, $get_id);

        if (mysqli_num_rows($get_id_respost) > 0) {
            // Estrai la riga risultante come un array associativo
            $idUser = mysqli_fetch_assoc($get_id_respost);

            $id = $idUser["id"];
            
            $insert_details = "INSERT INTO `userdata` (`id`, `banner`, `descrizione`, `idUser`) VALUES (NULL, 'banner/default.png', NULL, '$id')";

            if ($conn->query($insert_details) === TRUE) {
                header("Location: http://localhost/socialMedia/home.php");
                exit();

            }else{

                $delite = "DELETE FROM login WHERE email = '$email' AND passworld = $password";
                // Se si verifica un errore durante l'inserimento nel database, reindirizza alla pagina di registrazione con un messaggio di errore
                header("Location: index.html?error=4");
                exit();
            }

            
        } else {

            $delite = "DELETE FROM login WHERE email = '$email' AND passworld = $password";
            if ($conn->query($insert_details) === TRUE) {
                header("Location: index.html?error=5");
            exit();
            }
            
            // Se si verifica un errore durante l'inserimento nel database, reindirizza alla pagina di registrazione con un messaggio di errore
            
            
        }
    }
}

// Chiudi la connessione al database
$conn->close();
?>