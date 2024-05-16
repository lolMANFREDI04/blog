<?php
    include('connection.php');
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['pass'];

        $sql = "select * from login where email = '$email' and passworld = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($count == 1){
            // Utente trovato
            session_start();
            $_SESSION['email'] = $email; // Salva l'email dell'utente in sessione
            $_SESSION['password'] = $password;
            // Se l'utente ha selezionato Ricordami, salva l'email come cookie per un mese
            setcookie('email', $email, time() + (30 * 24 * 60 * 60), '/');
            setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');


            header("Location: /socialMedia/home.php");
        }  
        else{  
            echo  '<script>
                        window.location.href = "index.html";
                        alert("Login failed. Invalid email or password!!")
                    </script>';
        }     
    }
    ?>