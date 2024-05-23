<?php
session_start();

// Check if user is logged in via session or cookies
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
} elseif (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
} else {
    header("Location: login/index.html");
    exit();
}

$host = "localhost";
$usernam = "root";
$passwor = "";
$dbname = "blog";

$con = mysqli_connect($host, $usernam, $passwor, $dbname);

if (!$con) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Correct the password column name from 'passworld' to 'password'
$query = "SELECT login.id FROM login WHERE login.email = '$email' AND login.passworld = '$password';";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Errore nella query: " . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
} else {
    die("Nessun utente trovato con le credenziali fornite.");
}

$query = $_GET['query'];
$escaped_query = mysqli_real_escape_string($con, $query);

$post_search_query = "SELECT * FROM post JOIN login ON post.id_utente = login.id WHERE post.titolo LIKE '%$escaped_query%'";
$user_search_query = "SELECT username FROM login WHERE username LIKE '%$escaped_query%'";

$post_respost = mysqli_query($con, $post_search_query);
if (!$post_respost) {
    die("Errore nella query dei post: " . mysqli_error($con));
}

$user_results = mysqli_query($con, $user_search_query);
if (!$user_results) {
    die("Errore nella query degli utenti: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati ricerca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-sF72eFcpLnhBoZzCnwNuiSpaMoIdHyfmkch/wV+78hVPGyebjqR0XxdTGsMW0tKYM7T4XMBV3RL/xyxGcS3g/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* styles.css */
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
            flex: 1;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .results-container {
            display: flex;
            justify-content: space-between;
        }

        .posts, .users {
            flex: 1;
            margin: 10px;
        }

        .posts .post, .users .user {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .posts .post .user-info, .users .user {
            display: flex;
            align-items: center;
        }

        .posts .post .user-info img, .users .user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
        }

        <?php include("styles_home.css"); ?>
    </style>
</head>
<body>

    <?php include ("header.php")?>

    <main>
        <section class="posts" id="posts">
            <h2 style="width: 1178.7px;">Risultati ricerca</h2>

            <?php
            $num_posts = mysqli_num_rows($post_respost);
            $num_users = mysqli_num_rows($user_results);

            // Verifica se ci sono post o utenti
            if ($num_posts > 0 || $num_users > 0) {
                echo '<div class="search-menu">';
                echo '<button id="showPostsBtn">Mostra Post (' . $num_posts . ')</button>';
                echo '<button id="showUsersBtn">Mostra Utenti (' . $num_users . ')</button>';
                echo '</div>';
            }

            // Mostra i post trovati
            if ($num_posts > 0) {
                while($post = mysqli_fetch_assoc($post_respost)){
                    $id_post = $post['id'];
                    $get_user_by_post = "SELECT login.id, login.username, userdata.banner FROM login, userdata, post WHERE login.id = userdata.idUser AND post.id_utente = login.id AND post.id = $id_post;";

                    $get_user_by_post_result = mysqli_query($con, $get_user_by_post);

                    if (mysqli_num_rows($get_user_by_post_result) > 0) {
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
                                                $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                                $media_extension = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                                                if (in_array($media_extension, $image_extensions)) {
                                                    echo '<img id="newPostImg-'.$id_post.'" src="' . $post['media'] . '" alt="Current Image">';
                                                } else {
                                                    echo '<video controls id="newPostVideo-'.$id_post.'">';
                                                    echo '<source src="' . $post['media'] . '" type="video/mp4">';
                                                    echo 'Your browser does not support the video tag.';
                                                    echo '</video>';
                                                }
                                            } else {
                                                echo 'Nessun media presente.';
                                            }

                                            echo '</div>
                                            <label for="newPostImg-'.$id_post.'">Sostituisci media</label>
                                            <input type="file" id="newPostImgInput-'.$id_post.'" name="newPostImg" accept="image/*, video/*">
                                            <div id="preview-newPostImg-'.$id_post.'" style="max-width: 100px; max-height: 100px;"></div>
                                            <textarea id="editPostContent-'.$id_post.'">'.$post['contenuto'].'</textarea>
                                            <button onclick="savePostChanges('.$id_post.')">Salva Modifiche</button>
                                        </div>
                                    </div>
                                    <button class="modify-button" onclick="modifyPost('.$id_post.')"><i class="fa fa-pencil"></i></button>
                                    <button class="delete-button" onclick="deletePost('.$id_post.')"><i class="fa fa-trash"></i></button>';
                                }

                                echo'
                                </div>
                                <h2>'.$post['titolo'].'</h2>
                                <p>'.$post['contenuto'].'</p>';
                                if($post['media'] != null){
                                    $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                    $media_extension = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                                    if (in_array($media_extension, $image_extensions)) {
                                        echo '<img class="post-media" src="' . $post['media'] . '" alt="Post Image">';
                                    } else {
                                        echo '<video controls class="post-media">';
                                        echo '<source src="' . $post['media'] . '" type="video/mp4">';
                                        echo 'Your browser does not support the video tag.';
                                        echo '</video>';
                                    }
                                }
                                echo'
                            </div>';
                        }
                    }
                }
            } else {
                echo '<p>Nessun risultato trovato per i post.</p>';
            }
            ?>
        </section>
        <section class="users" id="users">
            <h2 style="width: 1178.7px;">Risultati ricerca Utenti</h2>
            <?php
            if ($num_users > 0) {
                while ($user = mysqli_fetch_assoc($user_results)) {
                    echo '<div class="user">';
                    echo '<div class="user-info">';
                    echo '<img src="https://via.placeholder.com/40" alt="Profile Picture">';
                    echo '<div class="username">' . $user['username'] . '</div>';
                    echo '</div>';
                    echo '<button class="follow-button">Segui</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nessun risultato trovato per gli utenti.</p>';
            }
            ?>
        </section>
    </main>
    
    <?php include ("footer.php")?>
    <script>
        document.getElementById("showPostsBtn").addEventListener("click", function() {
            document.getElementById("posts").style.display = "block";
            document.getElementById("users").style.display = "none";
        });

        document.getElementById("showUsersBtn").addEventListener("click", function() {
            document.getElementById("posts").style.display = "none";
            document.getElementById("users").style.display = "block";
        });
    </script>
</body>
</html>

<?php
mysqli_close($con);
?>
