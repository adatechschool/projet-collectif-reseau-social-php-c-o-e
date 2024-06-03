<?php


  $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
      if ($mysqli->connect_errno)
                {
                     echo "<article>";
                    echo("Échec de la connexion : " . $mysqli->connect_error);
                    echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                   echo "</article>";
                  exit();
               }
// function connect (){

//                return $mysqli;
//             }

//   $lesInformations = $mysqli->query($laQuestionEnSql);
//    $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";

//           if ( ! $lesInformations)
//                 {
//                       echo "<article>";
//                     echo("Échec de la requete : " . $mysqli->error);
//                     echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
//                     exit();
//                 }  

//  function info (){ 
//    $mysqli = connect();
//  
//                 return $lesInformations;
//              }



// $laQuestionEnSql = 