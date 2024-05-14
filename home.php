<?php
    // if (!isset($_COOKIE['email' && 'password'])) {
    //     header("Location: login.html");
    //     exit();
    // }

    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
    } elseif (isset($_COOKIE['email']) && isset($_COOKIE['password'])) { // Controlla se è presente un cookie con l'email memorizzata
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
        echo $email;
        echo $password;
    } else { // Se l'utente non è autenticato ne tramite sessione ne tramite cookie, reindirizza alla pagina di login
        header("Location: login/index.html");
        exit();
    }

    $host = "localhost"; // Modifica questo con l'host del tuo database
    $username = "root"; // Modifica questo con il tuo nome utente del database
    $passwor = ""; // Modifica questo con la tua password del database
    $dbname = "prova"; // Modifica questo con il nome del tuo database

    $con = mysqli_connect($host, $username, $passwor, $dbname);

    if (!$con) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    $query = "SELECT userdata.banner FROM login, userdata WHERE login.id = userdata.idUser AND login.email = '$email' AND login.passworld = '$password';";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Estrai la riga risultante come un array associativo
        $row = mysqli_fetch_assoc($result);
        
        // Accesso alla colonna banner dalla riga risultante
        $banner = $row['banner'];
        
        // Ora puoi usare $banner come URL dell'immagine
        $userLogo = "<img style=\"height: 100px; width: 100px; border-radius: 50%;\" src=\"$banner\">";
    } else {
        // Se non ci sono risultati, puoi assegnare un'immagine predefinita
        $userLogo = "<img style=\"height: 100px; border-radius: 50%;\" src=\"https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg\">";
    }

    // Chiudi la connessione
    mysqli_close($con);

?>
<html>
    <head>
        <link rel="stylesheet" href="api.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div id="banner"  style="text-align: right; margin-right: 100px;"><?php echo $userLogo ?></div>
        

        
    </body>
    <script src="api.js"></script>
</html>