<!DOCTYPE html>
<html>
    

<style>
    html{
        width: 100%;
        height: 100%;
        text-align: center;
    }
    body{
        background-image: url(fond.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        padding: 0;
    }
    .box-button{
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>

    <head>
        <title>Statistiques</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        session_start();
        require('config.php');
        require('configPDO.php');
        $admin = $_SESSION['admin'];
        if($admin=="oui"){
        ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        
        <h1>Liste des écoles</h1>
        
        <?php
        $requetAdd = "SELECT *
        FROM `school` AS `a`
        LEFT JOIN `user_school_connector` AS `b`
        ON `a`.`id` = `b`.`id_school`
        WHERE `a`.`id` != 1 AND `a`.`number_user_of_school` != 0;";
                
        $requete = $pdo->query($requetAdd);

        foreach($requete as $p){
            echo $p['name'];

            echo '<br>';
        }


        }else{
            ?>
         <a href="index.php">Acceuil</a>
         <a href="logout.php">Déconnexion</a>
         <br><br>
         <?php
         echo "Vous n'avez pas accès à cette page";
         }?>
    </body>
</html>