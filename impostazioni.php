<?php

session_start();

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

    $query = "SELECT userdata.*, login.username FROM login, userdata WHERE login.id = userdata.idUser AND login.email = '$email' AND login.passworld = '$password';";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Estrai la riga risultante come un array associativo
        $row = mysqli_fetch_assoc($result);
        
        // Accesso alla colonna banner dalla riga risultante
        $banner = $row['banner'];
        $id = $row['id'];
        $idUser = $row['idUser'];
        $descrizione = $row['descrizione'];
        $username = $row['username'];
        
        // Ora puoi usare $banner come URL dell'immagine
        
        $userLogo = $banner;
        if($userLogo=='') {
            $userLogo = "https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg";
        }
    } else {
        // Se non ci sono risultati, puoi assegnare un'immagine predefinita
        $userLogo = "https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg";

        // Esegui una query per ottenere l'id dell'utente utilizzando l'email e la password
        $queryIdByEmail = "SELECT login.id FROM login WHERE login.email = '$email' AND login.passworld = '$password';";
        $resultIdByEmail = mysqli_query($con, $queryIdByEmail);

        // Verifica se la query ha prodotto un risultato
        if (mysqli_num_rows($resultIdByEmail) > 0) {
            // Estrai l'id dell'utente
            $rowIdByEmail = mysqli_fetch_assoc($resultIdByEmail);
            $idUser = $rowIdByEmail['id'];
            
            // Esegui una query per inserire i dati dell'utente nel caso in cui non esista nella tabella userdata
            $insertQuery = "INSERT INTO `userdata` (`id`, `banner`, `descrizione`, `idUser`) VALUES (NULL, 'banner/20201213175850n562a.jpg', null, '$idUser')";
            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult === false) {
                // Gestisci l'errore nell'inserimento dei dati
                echo "Errore nell'inserimento dei dati dell'utente.";
            }
        } else {
            // Gestisci il caso in cui non viene trovato un ID utente
            echo "Nessun utente trovato con l'email e la password fornite.";
        }
    }

    // Chiudi la connessione
    mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 50px;
        }

        nav ul {
            list-style-type: none;
        }

        nav ul li {
            display: inline;
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
        }

        .user-banner img {
            height: 50px;
            border-radius: 50%;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 80px); /* Altezza dello schermo meno altezza del footer */
            margin-bottom: 10px; /* Altezza del footer */
        }

        .profile {
            margin-bottom: 20px;
        }

        .profile h1 {
            margin-bottom: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-avatar {
            position: relative;
            margin-right: 20px;
        }

        .user-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .banner-edit-button {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 30px;
            height: 45px;
            background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/5ef95353-9f74-45ba-a400-5494417ca165/ddmcdr5-d973f8f4-425c-4c29-9ff0-a7ded220a78a.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzVlZjk1MzUzLTlmNzQtNDViYS1hNDAwLTU0OTQ0MTdjYTE2NVwvZGRtY2RyNS1kOTczZjhmNC00MjVjLTRjMjktOWZmMC1hN2RlZDIyMGE3OGEucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.A53txybOuMUARZCnYA74VGXBzPcYDwwU07q2R-eN-CA');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border: none;
            padding: 0;
            margin: 0;
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            border-radius: 2px;
        }

        .banner-edit-button:hover {
            transform: rotate(-30deg);
        }

        .user-details {
            flex: 1;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            color: #555;
        }

        .user-details label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .user-details input[type="text"],
        .user-details textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        .user-details textarea {
            height: 100px;
        }

        .user-details .edit-details-button {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .user-details .edit-details-button:hover {
            background-color: #45a049;
        }

        .user-details .edit-details-button:focus {
            outline: none;
        }

        .user-details input[type="text"]::placeholder,
        .user-details textarea::placeholder {
            color: #999;
        }

        .user-details input[type="text"]:focus,
        .user-details textarea:focus {
            border-color: #007bff;
        }

        /* CSS aggiunto */
        .edit-details-button {
            margin-top: 10px; /* Spazio sopra il pulsante */
        }

        .password {
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .password h2 {
            margin-bottom: 10px;
        }

        .password form label {
            display: block;
            margin-bottom: 5px;
        }

        .password form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .password form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            position: relative;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
        }

        .alert {
            width: 500px;
            padding: 20px;
            background-color: #f44336;
            color: white;
            opacity: 1;
            transition: opacity 0.6s;
            margin-bottom: 15px;
            /* position: relative; */
            z-index: 1;
            position: absolute;
            display: inline-block;
        }

        .alert.success {background-color: #04AA6D;}
        .alert.warning {background-color: #ff9800;}

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }

        .nascosto{
            display: none; /* Nasconde la sezione dei commenti per impostazione predefinita */
        }

    </style>
</head>
<body>
    <?php include ("header.php")?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert warning">
            <span class="closebtn">&times;</span>  
            <strong>Error!</strong> <?php echo $_SESSION['error_message'] ?>
        </div>
        <?php unset($_SESSION['error_message']); ?> <!-- Rimuove il messaggio dalla sessione dopo averlo mostrato -->
    <?php endif; ?>

    <!-- Visualizza un messaggio di successo se presente -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert success">
            <span class="closebtn">&times;</span>  
            <strong>Success!</strong> <?php echo $_SESSION['success_message'] ?>
        </div>
        <?php unset($_SESSION['success_message']); ?> <!-- Rimuove il messaggio dalla sessione dopo averlo mostrato -->
    <?php endif; ?>

    <main>
        <section class="profile">
            <form id="uploadForm" enctype="multipart/form-data" method="POST" action="api_modifica_account.php" onchange="updateUserLogo()">
                <h1>Profilo Utente</h1>
                <div class="user-info">
                    <div class="user-avatar">
                        <img id="userLogoo" style="height: 100px; border-radius: 50%;" src="<?php echo $userLogo ?>" alt="User Avatar">
                        <label for="fileInput" class="banner-edit-button"></label>
                        <input id="fileInput" name="new_banner" type="file" accept="image/*" style="display: none;">
                        <p id="fileName" style="display: none;"></p>
                    </div>
                    <div class="user-details">
                        <input type="hidden" name="idUser" value="<?php echo $idUser; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <label for="username">Username:</label>
                        <input type="text" id="username" required name="username" value="<?php echo $username?>">
                        <br>
                        <br>
                        <br>
                        <label for="description">Descrizione:</label>
                        <textarea id="description" placeholder="Una breve descrizione..." name="description" style="resize: none;"><?php echo $descrizione?></textarea>
                        <br>
                        <button type="submit" class="edit-details-button">Modifica dettagli</button>
                    </div>
                </div>
            </form>


            <div class="password">
                <h2>Modifica Password</h2>
                <form action="change_password.php" onsubmit="return isValid()" method="POST">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">

                    <label for="current-password">Password Attuale:</label>
                    <input type="password" required id="current-password" name="current-password">
                    <label for="new-password">Nuova Password:</label>
                    <input type="password" required id="new-password" name="new-password">
                    <label for="confirmPass">Conferma Nuova Password:</label>
                    <input type="password" required id="confirm-new-password" name="confirmPass">
                    <button type="submit">Salva Password</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog</p>
    </footer>
    
    <script src="api.js"></script>

    <script>

        function isValid() {
            var currentPassword = document.getElementById('current-password').value;
            var newPassword = document.getElementById('new-password').value;
            var confirmPass = document.getElementById('confirm-new-password').value;

            if (currentPassword === "" || newPassword === "" || confirmPass === "") {
                alert("Please fill in all fields!");
                return false;
            } else if (currentPassword !== "<?php echo $password ?>") {
                alert("Current password is not correct!");
                return false;
            } else if (newPassword !== confirmPass) {
                alert("Passwords do not match!");
                return false;
            } else if (newPassword.length < 8 || !/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/\W/.test(newPassword)) {
                alert("The new password must be at least 8 characters long and contain uppercase, lowercase, and special characters!");
                return false;
            }

            return true;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var close = document.getElementsByClassName("closebtn");
            var i;

            for (i = 0; i < close.length; i++) {
                close[i].onclick = function() {
                    var div = this.parentElement;
                    div.style.opacity = "0";
                    setTimeout(function() { 
                        div.style.display = "none"; 
                    }, 600);
                }
            }

            // Chiudere l'alert dopo 2 secondi
            var alerts = document.getElementsByClassName("alert");
            for (var j = 0; j < alerts.length; j++) {
                var alert = alerts[j];
                setTimeout(function() {
                    alert.style.opacity = "0";
                    setTimeout(function() {
                        alert.style.display = "none";
                    }, 800);
                }, 1000);
            }
        });


        function updateFileName() {
            var fileInput = document.getElementById('fileInput'); // Ottiene l'input del file
            var fileNameDisplay = document.getElementById('fileName'); // Ottiene l'elemento per visualizzare il nome del file
            var fileName = fileInput.files[0].name; // Ottiene il nome del file selezionato

            fileNameDisplay.innerText = fileName; // Aggiorna il testo con il nome del file
            fileNameDisplay.style.display = 'block'; // Mostra l'elemento
        }

        function updateUserLogo() {
            var fileInput = document.getElementById('fileInput');
            var userLogo = document.getElementById('userLogoo');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    userLogo.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        function toggleProfileMenu() {
            debugger
            var elemento = document.getElementById('userMenu');
            if (elemento.classList.contains('nascosto')) {
                elemento.classList.remove('nascosto');
            } else {
                elemento.classList.add('nascosto');
            }
        }

        

    </script>
</body>
</html>
