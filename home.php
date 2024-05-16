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

    $query = "SELECT userdata.banner, login.id, login.username FROM login, userdata WHERE login.id = userdata.idUser AND login.email = '$email' AND login.passworld = '$password';";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Estrai la riga risultante come un array associativo
        $row = mysqli_fetch_assoc($result);
        
        // Accesso alla colonna banner dalla riga risultante
        $banner = $row['banner'];

        $id = $row['id'];
        $username = $row['username'];
        
        // Ora puoi usare $banner come URL dell'immagine
        $userLogo = $banner;
    } else {
        // Se non ci sono risultati, puoi assegnare un'immagine predefinita
        $userLogo = 'https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg';
    }

    // Chiudi la connessione
    mysqli_close($con);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-sF72eFcpLnhBoZzCnwNuiSpaMoIdHyfmkch/wV+78hVPGyebjqR0XxdTGsMW0tKYM7T4XMBV3RL/xyxGcS3g/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Imposta l'altezza minima del corpo al 100% della viewport height */
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
            border-radius: 50%;
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
            flex: 1; /* Il contenuto principale espande per riempire lo spazio rimanente */
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .new-post {
            margin-top: 20px;
        }

        .new-post h2 {
            margin-bottom: 10px;
        }

        .new-post input[type="text"],
        .new-post textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-post textarea {
            height: 100px;
        }

        .new-post button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .posts .post {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .posts .post .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .posts .post .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .posts .post .post-content img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .posts .post .post-content p {
            margin-bottom: 10px;
        }

        .posts .post .post-content .comment-button {
            padding: 5px 10px;
            background-color: #28a745;
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

        /* //////// */

        .post-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .post-header {
            display: flex;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .post-header .username {
            font-weight: bold;
        }

        .follow-button {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: auto; /* Spinge il bottone verso destra */
        }

        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
        }

        .follow-button {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .follow-button:hover {
            background-color: #0056b3;
        }

        .post-title {
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
        }

        .post-image {
            width: 100%;
        }

        .post-details {
            padding: 12px;
        }

        .post-description {
            color: #333;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-top: 1px solid #eee;
        }

        .post-actions .likes {
            color: #8e8e8e;
        }

        .like-button button {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .like-button button:hover {
            background-color: #0056b3;
        }

        .like-button button.liked {
            background-color: #ff6347;
        }


        .like-button {
            margin-right: 5px;
        }

        .comments-section {
            padding: 12px;
        }

        .comments-title {
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .comment {
            margin-bottom: 12px;
            padding: 12px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .comment img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment .username {
            font-weight: bold;
        }

        .comment .text {
            color: #333;
        }

        .comment-form {
            position: relative; /* Impostiamo la posizione relativa */
            display: flex; /* Utilizziamo flexbox per allineare gli elementi */
            align-items: center; /* Allineiamo verticalmente gli elementi */
            height: 50px; /* Altezza del contenitore */
        }

        .comment-form textarea {
            width: calc(100% - 50px); /* Larghezza della textarea meno la larghezza del pulsante */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
            height: 45px;
        }

        .comment-form button {
            width: 45px;
            height: 45px; /* Altezza uguale all'altezza della textarea */
            padding: 0; /* Rimuoviamo il padding per far sì che l'icona riempia completamente il pulsante */
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 2px; /* Impostiamo il bordo rotondo per ottenere un pulsante circolare */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .comment-form button:hover {
            background-color: #0056b3;
        }

        .comment-form button i {
            font-size: 18px;
        }

        .nascosto{
            display: none; /* Nasconde la sezione dei commenti per impostazione predefinita */
        }

        .comment-toggle {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }

        .comment-toggle:hover {
            text-decoration: none;
        }



    </style>
</head>
<body>

    <?php include ("header.php")?>

    <main>
        <section class="new-post">
            <h2>Crea un nuovo post</h2>
            <form>
                <input type="text" placeholder="Titolo" required>
                <textarea style="resize: none;" placeholder="Contenuto del post" required></textarea>
                <input type="file" accept="image/*, video*">
                <button type="submit">Pubblica</button>
            </form>
        </section>
        <br><br>

        <h2>Tutti i post</h2>

        <section class="posts">
            <?php echo '
            <div class="post-container">
                <div class="post-header">
                  <img src="'.$userLogo.'" alt="Profile Picture">
                  <div class="username">'.$username.'</div>
                  <button class="follow-button">Segui</button>
                </div>
                <h2 class="post-title">Titolo del Post</h2>
                <img class="post-image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Banana-Single.jpg/872px-Banana-Single.jpg" alt="Post Image">
                <div class="post-details">
                  <p class="post-description">Descrizione del Post Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan turpis euismod diam condimentum, ac fermentum nulla tincidunt.</p>
                </div>
                <div class="post-actions">
                    <div class="like-button">
                        <button id="like-button">Like</button>
                    </div>   
                    <div style="display: inline-flex;">
                        <button id="comment-toggle" onclick="toggleClass()" class="nascosto comment-toggle" style="display: inline-flex;">
                            <img class="fa-solid fa-message" src="message-regular.svg" style="height: 20px;margin-right: 5px;" >
                            <h3 class="comments-title" id="comments-title">Mostra Commenti</h3>
                        </button>
                    
                    </div>                  
                  <div class="likes">120 likes</div>
                </div>
                                
                <div class="comments-section nascosto" id="comments-section">
                    

                    <div class="comment-form" style="margin-top: 10px;margin-bottom: 10px;">
                        <textarea placeholder="Aggiungi un commento..."></textarea>
                        <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </i></button>
                    </div>
                      
                  <div class="post-comments">
                    
                      <div class="comment" id="comment-1"> 
                        <div style="display: flex; align-items: center;"> 
                          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Banana-Single.jpg/872px-Banana-Single.jpg" alt="Friend 1 Profile Picture" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                          <div class="username" style="font-weight: bold;">friend1</div>
                        </div>
                        <div class="text" style="padding: 8px; border-radius: 8px; background-color: #f2f2f2; margin-top: 5px;">Wow, che bella foto!</div>
                      </div>
                      
                      <div class="comment" id="comment-2"> 
                        <div style="display: flex; align-items: center;"> 
                          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Banana-Single.jpg/872px-Banana-Single.jpg" alt="Friend 1 Profile Picture" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                          <div class="username" style="font-weight: bold;">friend2</div>
                        </div>
                        <div class="text" style="padding: 8px; border-radius: 8px; background-color: #f2f2f2; margin-top: 5px;">Adoro le banane!</div>
                      </div>                      
                    <!-- Aggiungi altri commenti temporanei qui -->
                  </div>
                </div>
            </div>

            '?>
              


        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog</p>
    </footer>

    <script>
            
        function toggleClass() {
            debugger
            var elemento = document.getElementById('comments-section');
            if (elemento.classList.contains('nascosto')) {
                elemento.classList.remove('nascosto');
                document.getElementById('comments-title').innerText = "Nascondi Commenti";
            } else {
                elemento.classList.add('nascosto');
                document.getElementById('comments-title').innerHTML = "Mostra Commenti";
            }
        }

   
    </script>

    
</body>
</html>
