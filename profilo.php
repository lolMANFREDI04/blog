<?php
    $host = "localhost"; // Modifica questo con l'host del tuo database
    $username = "root"; // Modifica questo con il tuo nome utente del database
    $passwor = "root"; // Modifica questo con la tua password del database
    $dbname = "blog"; // Modifica questo con il nome del tuo database

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
        $userLogo = "$banner";
    } else {
        // Se non ci sono risultati, puoi assegnare un'immagine predefinita
        $userLogo = "https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg";
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
    <link rel="stylesheet" href="style.css">
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

/* Aggiunta stile per il pulsante di modifica del banner */
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
    border: none; /* Rimuove il bordo */
    padding: 0; /* Rimuove il padding */
    margin: 0; /* Rimuove il margine */
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
    border-radius: 2px;
}



.banner-edit-button:hover {
    transform: rotate(-30deg);
}


.user-details {
    flex: 1;
}

.user-details form label {
    display: block;
    margin-bottom: 5px;
}

.user-details form input[type="text"],
.user-details form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.user-details form textarea {
    height: 100px;
}

.user-details form button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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
    text-align: center;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
}


    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="IMG-20190831-WA0002.jpg" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Dai Seguiti</a></li>
                <li><a href="#">Esplora</a></li>
                <li><a href="#">Profilo</a></li>
                <li><a href="#">Impostazioni</a></li>
            </ul>
        </nav>
        <div class="user-banner">
            <img src="https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg" alt="User Banner">
        </div>
    </header>

    <main>
        <section class="profile">
            <h1>Profilo Utente</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <img id="userLogo" style="height: 100px; border-radius: 50%;" src="<?php echo $userLogo ?>" alt="User Avatar">
                    <form id="uploadForm" enctype="multipart/form-data" method="POST" action="URL_del_server" onchange="updateUserLogo()">
                        <label for="fileInput" class="banner-edit-button"></label>
                        <input id="fileInput" type="file" accept="image/*" style="display: none;">
                        <p id="fileName" style="display: none;"></p>
                    </form>
                </div>
                <div class="user-details">
                    <form>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="utente123" readonly>
                        <label for="description">Descrizione:</label>
                        <textarea id="description" name="description" readonly>Una breve descrizione...</textarea>
                        <button type="button" class="edit-details-button">Modifica dettagli</button>
                    </form>
                </div>
            </div>

            <div class="password">
                <h2>Modifica Password</h2>
                <form>
                    <label for="current-password">Password Attuale:</label>
                    <input type="password" id="current-password" name="current-password">
                    <label for="new-password">Nuova Password:</label>
                    <input type="password" id="new-password" name="new-password">
                    <label for="confirm-new-password">Conferma Nuova Password:</label>
                    <input type="password" id="confirm-new-password" name="confirm-new-password">
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
        function updateFileName() {
            var fileInput = document.getElementById('fileInput'); // Ottiene l'input del file
            var fileNameDisplay = document.getElementById('fileName'); // Ottiene l'elemento per visualizzare il nome del file
            var fileName = fileInput.files[0].name; // Ottiene il nome del file selezionato

            fileNameDisplay.innerText = fileName; // Aggiorna il testo con il nome del file
            fileNameDisplay.style.display = 'block'; // Mostra l'elemento
        }

        function updateUserLogo() {
            var fileInput = document.getElementById('fileInput');
            var userLogo = document.getElementById('userLogo');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    userLogo.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

    </script>
</body>
</html>
