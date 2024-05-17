<?php
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
    } elseif (isset($_COOKIE['email']) && isset($_COOKIE['password'])) { // Controlla se è presente un cookie con l'email memorizzata
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
    } else { // Se l'utente non è autenticato ne tramite sessione ne tramite cookie, reindirizza alla pagina di login
        header("Location: login/index.html");
        exit();
    }


    $host = "localhost"; // Modifica questo con l'host del tuo database
    $usernam = "root"; // Modifica questo con il tuo nome utente del database
    $passwor = ""; // Modifica questo con la tua password del database
    $dbname = "blog"; // Modifica questo con il nome del tuo database

    $con = mysqli_connect($host, $usernam, $passwor, $dbname);

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
        $userLogo = $banner;
    } else {
        // Se non ci sono risultati, puoi assegnare un'immagine predefinita
        $userLogo = 'https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg';
    }

    // Chiudi la connessione
    mysqli_close($con);
?>
<header>
    <div class="logo">
        <img style="border-radius: 50%;" src="IMG-20190831-WA0002.jpg" alt="Logo">
    </div>
    <nav>
        <ul>
            <li><a href="http://localhost/socialMedia/home.php">Home</a></li>
            <li><a href="#">Dai Seguiti</a></li>
            <li><a href="#">Esplora</a></li>
            <li><a href="#">Profilo</a></li>
            <li><a href="http://localhost/socialMedia/impostazioni.php">Impostazioni</a></li>
        </ul>
    </nav>
    <div class="user-banner" style="margin-right: 20px;">
        <img id="userLogo" onclick="toggleProfileMenu()" style="height: 50px; width: 50px; border-radius: 50%;" src="<?php echo $userLogo?>" alt="User Icon">
        <div id="userMenu" class="dropdown-content nascosto" style=" position: absolute; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); padding: 12px 16px; z-index: 1;">
            <a href="#" onclick="logout()">Logout</a>
            <a href="http://localhost/socialMedia/login/index.html">Change Account</a>
        </div>
    </div>
</header>

<script>
    // <?php
    //     function logout() {
    //         // Cancella email e password dalla sessione
    //         if (isset($_SESSION['email'])) {
    //             unset($_SESSION['email']);
    //         }
    //         if (isset($_SESSION['password'])) {
    //             unset($_SESSION['password']);
    //         }

    //         // Cancella email e password dai cookie
    //         if (isset($_COOKIE['email'])) {
    //             unset($_COOKIE['email']);
    //         }
    //         if (isset($_COOKIE['password'])) {
    //             unset($_COOKIE['password']);
    //         }

    //         // Reindirizza alla pagina di login
    //         header("Location: http://localhost/socialMedia/login/index.html");
    //         exit(); // Assicura che lo script termini dopo il reindirizzamento
    //     }
    ?>

        function logout() {
            debugger
            // Chiamata AJAX per effettuare il logout
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Reindirizza alla pagina di login dopo il logout
                        
                    } else {
                        // Gestisci eventuali errori
                        console.error("Errore durante il logout:", xhr.responseText);
                    }
                }
            };
            xhr.open("GET", "logout.php", true);
            xhr.send();
        }

    // function toggleProfileMenu() {
    //     debugger
    //     var elemento = document.getElementById('userMenu');
    //     if (elemento.classList.contains('nascosto')) {
    //         elemento.classList.remove('nascosto');
    //     } else {
    //         elemento.classList.add('nascosto');
    //     }
    // }

    // function toggleProfileMenu() {
    //     debugger
    //     var menu = document.getElementById('userMenu');
    //     var profileImg = document.querySelector('#userLogo');
    //     // profileImg.classList.toggle('square'); // Alterna tra l'immagine circolare e quadrata
    //     var display = window.getComputedStyle(menu).getPropertyValue('display');
    //     if (display === 'none') {
    //         menu.style.display = 'block';
    //     } else {
    //         menu.style.display = 'none';
    //     }
    // }

</script>
