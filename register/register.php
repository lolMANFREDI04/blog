<?php
// Connessione al database
$conn = new mysqli('localhost', 'root', 'root', 'blog');

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
    $query = "INSERT INTO login (email, username, passworld) VALUES ('$email', '$username', '$password')";
    if ($conn->query($query) === TRUE) {
        // Registrazione avvenuta con successo, esegui il login automatico se l'opzione "Ricordami" è stata selezionata
        $_SESSION['email'] = $email; // Salva l'email dell'utente in sessione
        $_SESSION['password'] = $password;
        // Se l'utente ha selezionato Ricordami, salva l'email come cookie per un mese
        setcookie('email', $email, time() + (30 * 24 * 60 * 60), '/');
        setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');
        header("Location: http://localhost/blog/home.php");
        exit();
    } else {
        // Se si verifica un errore durante l'inserimento nel database, reindirizza alla pagina di registrazione con un messaggio di errore
        header("Location: index.html?error=1");
        exit();
    }
}

// Chiudi la connessione al database
$conn->close();
?>