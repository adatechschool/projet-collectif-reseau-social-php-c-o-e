<?php
session_start();
if (!isset($_SESSION['connected_id'])) {
    header('Location: login.php'); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
};
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title> 
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <header>
        <a href='admin.php'><img src="https://th.bing.com/th/id/R.c6c91eb3ba2b3fecbd487427622873da?rik=Jc8tyCSgFd27Fg&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2f4cb%2foza%2f4cbozaLMi.png&ehk=wM9fAOz4Vv9pjFCSDUEe3qOfn9fml5%2ftrK1Z%2fU2OJh4%3d&risl=&pid=ImgRaw&r=0" alt="Logo de notre réseau social"/></a>
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=<?php echo $_SESSION['connected_id']?>">Mur</a>
            <a href="feed.php?user_id=<?php echo $_SESSION['connected_id']?>">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="#">▾ Profil</a>
            <ul>
                <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id']?>">Paramètres</a></li>
                <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes suiveurs</a></li>
                <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes abonnements</a></li>
            </ul>
        </nav>
    </header>
    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages de
                    tous les utilisatrices du site.</p>
            </section>
        </aside>
        <main>
            <?php
            include "include/connect.php";

            // Incrémentation du nombre de likes si le bouton est cliqué
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
                $postId = $_POST['post_id'];
                $userId = $_SESSION['connected_id'];

                // Vérifier si l'utilisateur a déjà liké ce post
                $checkLikeQuery = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
                $like = $mysqli->prepare($checkLikeQuery);
                $like->bind_param("ii", $postId, $userId);
                $like->execute();
                $result = $like->get_result();

                if ($result->num_rows == 0) {
                    // Ajouter un nouveau like
                    $likeQuery = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
                    $like = $mysqli->prepare($likeQuery);
                    $like->bind_param("ii", $postId, $userId);
                    $like->execute();

                    echo "<p>Le post a été liké.</p>";
                } else {
                    echo "<p>Vous avez déjà liké ce post.</p>";
                }
            }

            // Afficher les posts
            $laQuestionEnSql = "
                SELECT posts.id,
                posts.content,
                posts.created,
                posts.user_id,
                users.alias as author_name,  
                count(likes.id) as like_number,  
                GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                FROM posts
                JOIN users ON  users.id=posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                LEFT JOIN likes      ON likes.post_id  = posts.id 
                GROUP BY posts.id
                ORDER BY posts.created DESC  
                LIMIT 5
            ";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            if (!$lesInformations) {
                echo "<article>";
                echo("Échec de la requête : " . $mysqli->error);
                echo("<p>Indice: Vérifiez la requête SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                echo "</article>";
                exit();
            }

            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <h3>
                        <time><?php echo $post['created'] ?></time>
                    </h3>
                    <address><a href="wall.php?user_id=<?php echo $post['user_id']?>"><?php echo $post['author_name'] ?></a></address>
                    <div>
                        <p><?php echo $post['content'] ?></p>:
                    </div>
                    <footer>
                        <form method="post" action="">
                            <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
                            <button type="submit" id="button">like</button>
                        </form>
                        <small><?php echo "❤️". $post['like_number'] ?></small>
                        <a href=""><?php echo "#". $post['taglist'] ?></a>
                    </footer>
                </article>
                <?php
            }
            ?>
        </main>
    </div>
</body>
</html>
