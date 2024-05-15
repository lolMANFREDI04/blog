<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include ("header.php")?>

    <main>
        <section class="new-post">
            <h2>Crea un nuovo post</h2>
            <form>
                <input type="text" placeholder="Titolo" required>
                <textarea placeholder="Contenuto del post" required></textarea>
                <input type="file" accept="image/*">
                <button type="submit">Pubblica</button>
            </form>
        </section>
        <br><br>

        <h2>Tutti i post</h2>

        <section class="posts">
            <div class="post">
                <div class="user-info">
                    <img src="https://thestatestimes.com/storage/post_display/20201213175850n562a.jpg" alt="Avatar">
                    <div class="user-actions">
                        <button class="follow-button">Segui</button>
                    </div>
                </div>
                <div class="post-content">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Banana-Single.jpg/872px-Banana-Single.jpg" alt="Post Image">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan turpis euismod diam condimentum, ac fermentum nulla tincidunt.</p>
                    <button class="comment-button">Commenta</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog</p>
    </footer>
    
    <script src="api.js"></script>
</body>
</html>