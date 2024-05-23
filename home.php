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
        <?php include("styles_home.css"); ?>

    </style>
</head>
<body>

    <?php include ("header.php")?>

    <main>
        <section class="search-section" style="text-align:center">
            <h2>Ricerca</h2>
            <form action="ricerca.php" method="get">
                <input type="text" name="query" id="search-input" placeholder="Cerca per titolo o username">
                <button type="submit">Cerca</button>
            </form>
        </section>

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

        <h2 style="width: 1178.7px;">Tutti i post</h2>

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
                                    <img class="post-header-img" src="'.$userLogo.'" alt="Profile Picture">
                                    <div class="username">'.$postUser['username'].'</div>
                                    <div class="data-post">'.date("Y-m-d H:i", strtotime($post['data_post'])).'</div>
                                    ';

                                    if($postUser['id'] != $id){
                                        echo '
                                            <button class="follow-button">Segui</button>';
                                    }else{
                                        echo '
                                        <!-- Modale per la modifica del post -->
                                        <div id="modifyPostModal-'.$id_post.'" class="modal" onclick="closeModalOnOutsideClick(event, '.$id_post.')">
                                            <div class="modal-content" id="modalContent-'.$id_post.'">
                                                <span class="close" onclick="closeModal('.$id_post.')">&times;</span>
                                                <div class="current-media-preview" id="current-media-preview-'.$id_post.'">';

                                                if ($post['media'] != null) {
                                                    // Verifica se il media è un\'immagine
                                                    $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                                    $media_extension = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                                                    if (in_array($media_extension, $image_extensions)) {
                                                        echo '<img id="newPostImg-'.$id_post.'" src="' . $post['media'] . '" alt="Current Image">';
                                                    } else {
                                                        // Se non è un\'immagine, potrebbe essere un video
                                                        echo '<video controls id="newPostVideo-'.$id_post.'">';
                                                        echo '<source src="' . $post['media'] . '" type="video/mp4">';
                                                        echo 'Your browser does not support the video tag.';
                                                        echo '</video>';
                                                    }
                                                } else {
                                                    // Nessun media presente, mostra un placeholder
                                                    echo '<div class="placeholder">Nessun media</div>';
                                                }

                                                echo '
                                                </div>
                                                <!-- Form di modifica del post -->
                                                <form id="modifyPostForm-'.$id_post.'" class="modifyPostForm" action="update_post.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" id="id_post" name="id_post" value="'.$id_post.'">
                                                    <!-- Campi del form per la modifica del post -->
                                                    <!-- Titolo -->
                                                    <input type="text" id="postTitle" name="postTitle" required ' . ($post['titolo'] != null ? 'value="'.$post['titolo'].'"' : 'placeholder="Inserisci un titolo"') . '>
                                                    <!-- Descrizione -->
                                                    <textarea id="postDescription" style="resize: none;" name="postDescription" ' . ($post['descrizione'] == null ? 'placeholder="Inserisci una descrizione"' : '') . '>'.($post['descrizione'] != null ? $post['descrizione'] : ''). '</textarea>
                                                    <!-- Carica nuovo media -->
                                                    <div class="media-container">
                                                        <input type="file" class="media" id="media-'.$id_post.'" name="media" accept="image/*, video/*" onchange="updatePostImg('.$id_post.')">
                                                        <p class="checkbox-label">nessun media</p>
                                                        <input type="checkbox" class="styled-checkbox" id="nessunMedia-'.$id_post.'" name="nessunMedia">
                                                    </div>
                                                    <button type="submit">Salva</button>
                                                </form>
                                            </div>
                                        </div>

                                        <button class="modify-post-button" id="modify-post-button" onclick="openModal('.$id_post.');"><i class="fa fa-pencil" aria-hidden="true" style="font-size:20px"></i></button>
                                        <button class="delite-post-button" id="delite-post-button" onclick="del_post(' . $id_post . ');"><i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px"></i></button>';
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
                                                            <path d="M0 10 Q182 5 1000 10" stroke="#ccc" stroke-width="1" fill="none"></path>
                                                        </svg>
                                                    </div>';

                                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                echo '<div style="text-align:center;" class="video-container"><img class="post-image" style="max-width:80%; border-radius: 10px;" src="'.$post['media'].'" alt="Post Image"></div>';
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
                                                            <path d="M0 10 Q182 5 1000 10" stroke="#ccc" stroke-width="1" fill="none"></path>
                                                        </svg>
                                                    </div>';

                                    echo '
                                    <div class="post-details">
                                    <p class="post-description">'.$post['descrizione'].'</p>
                                    </div>
                                    <div class="post-actions">
                                        <div class="like-button">
                                            ';

                                            $get_likes = "SELECT likes.id FROM likes WHERE likes.id_utente = $id AND likes.id_post = $id_post;";

                                            $likes_respost = mysqli_query($con, $get_likes);

                                            if (mysqli_num_rows($likes_respost) > 0) {
                                                // Estrai la riga risultante come un array associativo
                                                $likes = mysqli_fetch_assoc($likes_respost);

                                                if($likes['id']){
                                                    echo '<button class="liked" id="like-button-'.$id_post.'" onclick="like('.$likes['id'].',null,null)">Like</button>';
                                                }
                                                
                                            }else{
                                                echo '<button class="like-disattivo" id="like-button-'.$id_post.'" onclick="like(null, '.$id_post.', '.$id.')">Like</button>';
                                            }

                                            $get_number_of_likes = "SELECT COUNT(likes.id) AS NumberOfLikes FROM likes WHERE likes.id_post = $id_post";

                                            $likes_number_respost = mysqli_query($con, $get_number_of_likes);

                                            if (mysqli_num_rows($likes_number_respost) > 0) {
                                                // Estrai la riga risultante come un array associativo
                                                $just_likes_number = mysqli_fetch_assoc($likes_number_respost);

                                                $likes_number = $just_likes_number['NumberOfLikes'];
                                            }

                                        echo '
                                        </div>   
                                        <div style="display: inline-flex;">
                                            <button id="comment-toggle" onclick="toggleClass('.$id_post.')" class="nascosto comment-toggle" style="display: inline-flex;">
                                                <img class="fa-solid fa-message" src="message-regular.svg" style="height: 20px;margin-right: 5px;" >
                                                <h3 class="comments-title" id="comments-title-'.$id_post.'">Mostra Commenti</h3>
                                            </button>
                                        
                                        </div>                  
                                    <div class="likes">'.$likes_number.' likes</div>
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
                debugger
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

        function like(like, id_post, id_utente){
            debugger

            if(like != null){
                
                del_like(like, id_post);
            }else{

                addLike(id_post, id_utente);
            }
            
        }

        function del_like(like, id_post){
            debugger
            const xhr = new XMLHttpRequest();
            xhr.open("DELETE", "http://localhost/socialMedia/del_like.php?id_like=" + like);
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

        function addLike(id_post, id_utente){
            debugger;
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost/socialMedia/add_like.php';
            const params = JSON.stringify({ id_utente: id_utente, id_post: id_post });

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/json');

            xhr.onreadystatechange = function () {
                debugger
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(response);

                    // Memorizza l'ID del post in un cookie
                    document.cookie = 'lastPostId=' + id_post + '; path=/';
                    // Ricarica la pagina
                    window.location.reload();
                } else if (xhr.readyState == 4 && xhr.status != 200) {
                    console.error('Errore:', xhr.status);
                }
            };

            xhr.send(params);
        }

        // Funzione per aprire la modale
        function openModal(id_post) {
            document.getElementById("modifyPostModal-"+id_post).style.display = "block";
            document.body.classList.add("modal-open"); // Aggiungi la classe per bloccare lo scorrimento della pagina
        }

        // Funzione per chiudere la modale
        function closeModal(id_post) {
            document.getElementById("modifyPostModal-"+id_post).style.display = "none";
            document.body.classList.remove("modal-open"); // Rimuovi la classe per sbloccare lo scorrimento della pagina
        }


        // Funzione per chiudere la modale quando si clicca fuori di essa
        function closeModalOnOutsideClick(event, postId) {
            var modal = document.getElementById('modifyPostModal-' + postId);
            var modalContent = document.getElementById('modalContent-' + postId);
            
            if (event.target === modal) {
                modal.style.display = 'none';
                closeModal(postId);
            }
        }

        function updatePostImg(postId) {
            var fileInput = document.getElementById('media-' + postId);
            var previewContainer = document.getElementById('current-media-preview-' + postId);
            var checkbox = document.getElementById('nessunMedia-' + postId);

            // Clear existing media preview
            previewContainer.innerHTML = '';

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                var file = fileInput.files[0];
                var fileType = file.type;

                reader.onload = function(e) {
                    if (fileType.startsWith('image/')) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'New Image';
                        previewContainer.appendChild(img);
                    } else if (fileType.startsWith('video/')) {
                        var video = document.createElement('video');
                        video.controls = true;
                        var source = document.createElement('source');
                        source.src = e.target.result;
                        source.type = fileType;
                        video.appendChild(source);
                        previewContainer.appendChild(video);
                    }
                };

                reader.readAsDataURL(file);
            }

            // Check if "nessunMedia" checkbox is checked
            if (checkbox.checked) {
                previewContainer.innerHTML = '<div class="placeholder">Nessun media</div>';
            }
        }

        function stop_recherge() {
            // Previene il comportamento predefinito del submit del form
            event.preventDefault();

            // Memorizza l'ID del post in un cookie
            document.cookie = "lastPostId=" + id_post + "; path=/";

            // Chiudi la modale dopo l'aggiornamento

            // Chiudi la modale dopo l'aggiornamento
            closeModal(id_post);
        }

   
    </script>

    
</body>
</html>
