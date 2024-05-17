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
        if($banner != null || $banner != "")
            $userLogo = $banner;
        else
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

        .text {cursor: text;}

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
        }

        .delite-post-button{
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }

        .modify-post-button{
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 10px;
        }

        .data-post{
            margin-left: auto;
            margin-right: 10px;
        }

        .data-commento{
            margin-left: auto;
            margin-right: 10px;
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
            /* margin-top: 20px; */
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

        .video-container {
            width: 90%;
            margin: 0 auto; /* Centra orizzontalmente */
            border-radius: 10px; /* Rendi gli angoli rotondi */
            overflow: hidden; /* Assicura che il video non esca dai bordi arrotondati */
        }

        .video-container video {
            width: 100%; /* Rendi il video larghezza al 100% del suo contenitore */
            display: block; /* Assicura che il video occupi l'intera larghezza del suo contenitore */
        }



    </style>
</head>
<body>

    <?php include ("header.php")?>

    <main>
        <section class="new-post">
            <h2>Crea un nuovo post</h2>
            <form class="post-form" action="crea_post.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idUtentePost" value="<?php echo $id?>">

                <input type="text" name="titolo" id="titolo" style="cursor: text;" placeholder="Titolo" required>
                <textarea style="resize: none; cursor: text;" id="descrizione" name="descrizione" placeholder="Contenuto del post"></textarea>
                <input type="file" name="media" accept="image/*, video/*">
                <button type="submit">Pubblica</button>
            </form>

        </section>
        <br><br>

        <h2>Tutti i post</h2>

        <!-- INSERT INTO `post` (`id`, `titolo`, `descrizione`, `media`, `id_utente`) VALUES (NULL, 'froid', 'mclin', 'da sosa', '3'); -->

        <!-- INSERT INTO `commenti` (`id`, `testo`, `id_post`) VALUES (NULL, 'bella bannanna bro', '3'); -->
        <section class="posts" id="posts">
            <br>
            <?php 
                $con = mysqli_connect($host, $usernam, $passwor, $dbname);

                if (!$con) {
                    die("Connessione al database fallita: " . mysqli_connect_error());
                }

                $get_post = "SELECT * FROM `post` ORDER BY `post`.`data_post` DESC;";

                $post_respost = mysqli_query($con, $get_post);

                if (mysqli_num_rows($post_respost) > 0) {
                    // Estrai la riga risultante come un array associativo
                    while($post = mysqli_fetch_assoc($post_respost)){
                        $id_post = $post['id'];
                        $get_user_by_post = "SELECT login.id, login.username, userdata.banner FROM login, userdata, post WHERE login.id = userdata.idUser AND post.id_utente = login.id AND post.id = $id_post;";

                        $get_user_by_post_result = mysqli_query($con, $get_user_by_post);

                        if (mysqli_num_rows($get_user_by_post_result) > 0) {
                            // Estrai la riga risultante come un array associativo
                            while($postUser = mysqli_fetch_assoc($get_user_by_post_result)){

                            if($postUser['banner'] != null || $postUser['banner'] != "")
                                $userLogo = $postUser['banner'];
                            else
                                $userLogo = 'https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg';

                            echo '
                                <div class="post-container" id="post-'.$id_post.'">
                                    <div class="post-header">
                                    <img src="'.$userLogo.'" alt="Profile Picture">
                                    <div class="username">'.$postUser['username'].'</div>
                                    <div class="data-post">'.date("Y-m-d H:i", strtotime($post['data_post'])).'</div>
                                    ';

                                    if($postUser['id'] != $id){
                                        echo '
                                            <button class="follow-button">Segui</button>';
                                    }else{
                                        echo '
                                            <button class="modify-post-button" id="modify-post-button" onclick="modify_post('.$id_post.');"><i class="fa fa-pencil" aria-hidden="true" style="font-size:20px"></i></button>
                                            <button class="delite-post-button" id="delite-post-button" onclick="del_post('.$id_post.');"><i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px"></i></button>';
                                    }


                                    echo '
                                    </div>
                                    <h2 class="post-title">'.$post['titolo'].'</h2>
                                    <div id="media-post-'.$post['id'].'">
                                    ';

                                        $media_url = $post['media'];
                                        if (!empty($media_url)) {
                                            $extension = pathinfo($media_url, PATHINFO_EXTENSION);

                                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'wmv', 'flv', '3gp', 'webm']))
                                                echo '
                                                    <div class="curved-line" style="width: auto;">
                                                        <svg width="100%" height="20">
                                                            <path d="M0 10 Q182 5 600 10" stroke="#ccc" stroke-width="1" fill="none"></path>
                                                        </svg>
                                                    </div>';

                                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                echo '<img class="post-image" style="border-radius: 10px;" src="'.$post['media'].'" alt="Post Image">';
                                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', '3gp', 'webm'])) {
                                                echo '<div class="video-container"><video controls>';
                                                echo "<source src='$media_url' type='video/mp4'>";
                                                echo "Il tuo browser non supporta il tag video.";
                                                echo "</video></div>";
                                            }
                
                                        }
                                        
                                        // <img class="post-image" src="'.$post['media'].'" alt="Post Image">
                                        
                                    echo '
                                    
                                    </div>
                                    '; 
                                    
                                    if (!empty($post['descrizione']))
                                                echo '
                                                    <div class="curved-line" style="transform: rotate(180deg); width: auto;">
                                                        <svg width="100%" height="20">
                                                            <path d="M0 10 Q182 5 600 10" stroke="#ccc" stroke-width="1" fill="none"></path>
                                                        </svg>
                                                    </div>';

                                    echo '
                                    <div class="post-details">
                                    <p class="post-description">'.$post['descrizione'].'</p>
                                    </div>
                                    <div class="post-actions">
                                        <div class="like-button">
                                            <button id="like-button">Like</button>
                                        </div>   
                                        <div style="display: inline-flex;">
                                            <button id="comment-toggle" onclick="toggleClass('.$id_post.')" class="nascosto comment-toggle" style="display: inline-flex;">
                                                <img class="fa-solid fa-message" src="message-regular.svg" style="height: 20px;margin-right: 5px;" >
                                                <h3 class="comments-title" id="comments-title-'.$id_post.'">Mostra Commenti</h3>
                                            </button>
                                        
                                        </div>                  
                                    <div class="likes">120 likes</div>
                                    </div>
                                                    
                                    <div class="comments-section nascosto" id="comments-section-'.$id_post.'">
                                        

                                        <div style="margin-top: 10px;margin-bottom: 10px;">
                                            <form class="comment-form" action="crea_commento.php" method="POST">
                                                <input type="hidden" name="id_post" value="'.$id_post.'">
                                                <input type="hidden" name="id_user" value="'.$id.'">
                                                
                                                <textarea id="commento-text" name="commento-text" required placeholder="Aggiungi un commento..."></textarea>
                                                <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                
                                            </form>
                                        </div>
                                        
                                    <div class="post-comments">

                                    ';  
                                        
                                    $get_commenti = "SELECT commenti.* FROM commenti, post WHERE commenti.id_post = post.id AND post.id = $id_post ORDER BY commenti.data_commento DESC;";

                                    $get_commenti_result = mysqli_query($con, $get_commenti);
        
                                    if (mysqli_num_rows($get_commenti_result) > 0) {
                                        while($commento = mysqli_fetch_assoc($get_commenti_result)){
                                            $testo = $commento['testo'];
                                            $data_commento = $commento['data_commento'];

                                            $idCommento = $commento['id'];

                                            $get_dati_utente_commento = "SELECT login.username, userdata.banner FROM commenti, post, login, userdata WHERE commenti.id_post = post.id AND post.id = $id_post AND commenti.id_utente = login.id AND commenti.id_utente = userdata.idUser AND commenti.id = $idCommento;";

                                            $get_dati_utente_commento_result = mysqli_query($con, $get_dati_utente_commento);

                                            if (mysqli_num_rows($get_dati_utente_commento_result) > 0) {
                                                $datiUtenteCommento = mysqli_fetch_assoc($get_dati_utente_commento_result);

                                                $bannerCommento = $datiUtenteCommento['banner'];
                                            }else{
                                                $bannerCommento = "banner/20201213175850n562a.jpg";
                                            }
                                            
                                            echo '
                                                    <div class="comment" id="comment-'.$commento['id'].'"> 
                                                        <div style="display: flex; align-items: center;"> 
                                                            <img src="'.$bannerCommento.'" alt="'.$datiUtenteCommento['username'].' Profile Picture" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                                                            <div class="username" style="font-weight: bold;">'.$datiUtenteCommento['username'].'</div>
                                                            <div class="data-commento">'.date("Y-m-d H:i", strtotime($commento['data_commento'])).'</div>
                                                        '; 
                                                        
                                                        if($commento['id_utente'] == $id){
                                                            echo '
                                                                <button class="modify-post-button" id="modify-comment-button" onclick="modify_commento('.$idCommento.','.$testo.');"><i class="fa fa-pencil" aria-hidden="true" style="font-size:15px"></i></button>
                                                                <button class="delite-post-button" id="delite-comment-button" onclick="del_commento('.$idCommento.');"><i class="fa fa-trash-o" aria-hidden="true" style="font-size:15px"></i></button>';
                                                        }
                                                        
                                                        echo '
                                                        </div>
                                                        <div id="commento-text-'.$commento['id'].'" class="text" style="padding: 8px; border-radius: 8px; background-color: #f2f2f2; margin-top: 5px;">'.$testo.'</div>
                                                    </div>
                                                ';

                                        }
                                    }else{
                                        echo '<h3 style="text-align: center;">non ci sono commenti</h3>';
                                    }
                                    
                                    echo '
                                        
                                        
                                    </div>
                                    </div>
                                </div>
                                <br>

                            ';}
                        }
                    }
                }

                mysqli_close($con);
                ?>
              


        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog</p>
    </footer>

    <script>

        function modify_commento(id_commento, testo){
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "http://localhost/socialMedia/testo_commento.php?testo=" + testo + "&_idCommento=" + id_commento);
            xhr.send();
            xhr.responseType = "json";
            xhr.onload = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                const data = xhr.response;

                } else {
                console.log(`Error: ${xhr.status}`);
                }
            };
        }

        function del_post(id_post) {
            debugger
            const xhr = new XMLHttpRequest();
            xhr.open("DELETE", "http://localhost/socialMedia/del_post.php?id_post=" + id_post);
            xhr.send();
            xhr.responseType = "json";
            xhr.onload = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    // Memorizza l'ID del post in un cookie
                    document.cookie = "lastPostId=" + id_post + "; path=/";
                    // Ricarica la pagina
                    window.location.reload();
                } else {
                    console.log(`Error: ${xhr.status}`);
                }
            };
        }

        function scrollToPost() {
            // Cerca il cookie lastPostId
            let postId = document.cookie.split('; ').find(row => row.startsWith('lastPostId='));
            if (postId) {
                postId = postId.split('=')[1];
                // Trova l'elemento del post e scorri fino ad esso
                let postElement = document.getElementById("post-" + postId);
                if (postElement) {
                    postElement.scrollIntoView();
                }
            }
        }

        // Chiama la funzione scrollToPost dopo il caricamento della pagina
        window.onload = scrollToPost;

        function del_commento(id_commento) {
            debugger
            const xhr = new XMLHttpRequest();
            xhr.open("DELETE", "http://localhost/socialMedia/del_commento.php?id_commento=" + id_commento);
            xhr.send();
            xhr.responseType = "json";
            xhr.onload = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    // Memorizza l'ID del post in un cookie
                    document.cookie = "lastCommentoId=" + id_commento + "; path=/";
                    // Ricarica la pagina
                    window.location.reload();
                } else {
                    console.log(`Error: ${xhr.status}`);
                }
            };
        }

        function scrollToCommento() {
            // Cerca il cookie lastPostId
            let commentoId = document.cookie.split('; ').find(row => row.startsWith('lastCommentoId='));
            if (commentoId) {
                commentoId = commentoId.split('=')[1];
                // Trova l'elemento del post e scorri fino ad esso
                let CommentoElement = document.getElementById("comment-" + commentoId);
                if (CommentoElement) {
                    CommentoElement.scrollIntoView();
                }
            }
        }

        // Chiama la funzione scrollToPost dopo il caricamento della pagina
        window.onload = scrollToCommento;
            
        function toggleClass(id_post) {
            debugger
            var elemento = document.getElementById('comments-section-' + id_post);
            if (elemento.classList.contains('nascosto')) {
                elemento.classList.remove('nascosto');
                document.getElementById('comments-title-' + id_post).innerText = "Nascondi Commenti";
            } else {
                elemento.classList.add('nascosto');
                document.getElementById('comments-title-' + id_post).innerHTML = "Mostra Commenti";
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
