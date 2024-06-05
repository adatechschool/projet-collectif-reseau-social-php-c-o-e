<?php
<<<<<<< HEAD
session_start();
=======
>>>>>>> 021d76576b65aee8e8eb09a0f6394830ffd91759
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="https://th.bing.com/th/id/R.c6c91eb3ba2b3fecbd487427622873da?rik=Jc8tyCSgFd27Fg&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2f4cb%2foza%2f4cbozaLMi.png&ehk=wM9fAOz4Vv9pjFCSDUEe3qOfn9fml5%2ftrK1Z%2fU2OJh4%3d&risl=&pid=ImgRaw&r=0" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?php echo $_SESSION['connected_id']?>">Mur</a>
                <a href="feed.php?user_id=<?php echo $_SESSION['connected_id']?>">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id']?>">Paramètres</a></li>
                    <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes abonnements</a></li>
                </ul>

            </nav>
        </header>
        <div id="wrapper">
            <?php
            $userId =intval($_GET['user_id']);
            ?>
            <?php
<<<<<<< HEAD
            /**
             * Etape 2: se connecter à la base de donnée
             */
=======
>>>>>>> 021d76576b65aee8e8eb09a0f6394830ffd91759
          include "include/connect.php";
            ?>

            <aside>
                <?php
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
<<<<<<< HEAD
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                // echo "<pre>" . print_r($user, 1) . "</pre>";
=======
>>>>>>> 021d76576b65aee8e8eb09a0f6394830ffd91759
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
                <?php
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo $post['author_name'] ?></address>
                        <div>
                            <!-- <p><?php echo $post['content'] ?></p>
                            <p><?php echo $post['content'] ?></p> -->
                            <p><?php echo $post['content'] ?></p>
                        </div>                                            
                        <footer>
<<<<<<< HEAD
                            <?php
                             

    // Initialiser la variable de session si elle n'existe pas
            if (!isset($_SESSION['incremented'])) {
            $_SESSION['incremented'] = false;
        }

    // Vérifier si le formulaire a été soumis et si la variable de session permet l'incrémentation
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$_SESSION['incremented']) {
            $_SESSION['incremented'] = true;
            echo "<p>Le bouton a été cliqué et la variable a été incrémentée.</p>";
        }       elseif ($_SESSION['incremented']) {
            echo "<p>Le bouton a déjà été cliqué une fois.</p>";
        }
    ?>
                            
        <form method="post" id="incrementForm">
                <button type="submit" id="incrementButton">like</button>
        </form>                            
                            <small>❤️ <?php echo $post['like_number'] ?></small>
                            <a href="">#<?php echo $post['taglist'] ?></a>
=======
                            <small>❤️ <?php echo $post['like_number'] ?></small>
                            <a href="">#<?php echo $post['taglist'] ?></a>,
>>>>>>> 021d76576b65aee8e8eb09a0f6394830ffd91759
                            <!-- <a href="">#<?php echo $post['taglist'] ?></a>, -->
                        </footer>
                    </article>
                <?php } ?>
                        <dl>
                            <dt><label for='message'>Message</label></dt>
                            <dd><textarea name='message'></textarea></dd>
                        </dl>

            </main>
        </div>
    </body>
</html>
