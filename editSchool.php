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
        <title>Modifier école</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        session_start();
        require('config.php');
        require('configPDO.php');

        $admin = $_SESSION['admin'];
        if($admin=="oui"){

        $schoolId = NULL;

        
        try {
            $schoolId = intval($_GET['id']);
        } catch (Exception $e) {
            echo 'Invalid school ID';
            exit(1);
        }
        
        if ($schoolId === 0 || $schoolId < 1) {
            echo 'Invalid school ID';
            exit(1);
        }
        
        $azerty = "SELECT * FROM `user_school_connector` WHERE `id_user`=5;";
        $rezt = $pdo->query($azerty);

    
        if(isset($_POST['submit'])) {
            $name=$_POST['name'];

            $modif= "UPDATE school SET
            name='$name'
            WHERE id='$schoolId'";

            $res = mysqli_query($conn, $modif);

            if(!$res) {
                die('Erreur modif SQL !'.$modif.'<br />');
            }
            else {
                echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
            }
        }
        if(isset($_POST['add_intervention'])) {
            $memberId = $_POST['idmem3'];

            $initial = "SELECT * FROM `user_school_connector` WHERE `id_user`= $memberId;";
            $rezt = $pdo->query($initial);

            foreach($rezt as $po){
                $pi = $po['number_intervention'];
            }

            $number_intervention = $_POST['number_intervention'] + $pi;

            $modif_intervention = "UPDATE user_school_connector SET
            number_intervention = $number_intervention
            WHERE id_user = $memberId AND id_school = $schoolId";

            $res = mysqli_query($conn, $modif_intervention);

            if(!$res) {
                die('Erreur modif SQL !'.$modif_intervention.'<br />');
            }
            else {
                echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
            }

        }
        if(isset($_POST['delete_intervention'])) {
            $memberId = $_POST['idmem4'];

            $initial = "SELECT * FROM `user_school_connector` WHERE `id_user`= $memberId;";
            $rezt = $pdo->query($initial);

            foreach($rezt as $po){
                $pi = $po['number_intervention'];
            }

            $number_intervention = $pi - $_POST['number_intervention'];

            if($number_intervention < 0){
                $number_intervention = 0;
            }

            $modif_intervention = "UPDATE user_school_connector SET
            number_intervention = $number_intervention
            WHERE id_user = $memberId AND id_school = $schoolId";

            $res = mysqli_query($conn, $modif_intervention);

            if(!$res) {
                die('Erreur modif SQL !'.$modif_intervention.'<br />');
            }
            else {
                echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
            }

        }
        if(isset($_POST['delete'])){
            $delete = mysqli_prepare($conn, "DELETE FROM school WHERE `id`=?");
            /* Lecture des marqueurs */
            mysqli_stmt_bind_param($delete, "i", $schoolId);
        
            /* Exécution de la requête */
            mysqli_stmt_execute($delete);
            header('Location: schools.php');
        }


        // SQL de récupération des données du membre n°$schoolId.
        // Attention aux injections :P
        $query = "SELECT `name` FROM `school` WHERE `id`={$schoolId}";
        //$res = mysqli_query($conn, $query);
        $schoolInfo = mysqli_fetch_assoc(mysqli_query($conn, $query));

        if(isset($_POST['addschool'])){
            $memberId = $_POST['idmem'];
            $addschool = "INSERT INTO `user_school_connector`(`id_user`, `id_school`, `number_intervention` ) VALUES ('$memberId','$schoolId', 0)";
    

            if (mysqli_query($conn, $addschool)) {
                echo "Membre ajouté !";
              } else {
                  if(mysqli_errno($conn) != 1062){
                    echo "Error: " . $addschool . "<br>" . mysqli_error($conn). "<br>";
                  }
              }
        }

        if(isset($_POST['deleteSchool'])){
            $memberId = $_POST['idmem1'];
            $deleteSchool = "DELETE FROM `user_school_connector` WHERE id_user=$memberId AND id_school=$schoolId";

            if (mysqli_query($conn, $deleteSchool)) {
                echo "Membre Supprimé !";
              } else {
                $error = $conn->error;
                echo "Error: " . $deleteSchool . "<br>" . mysqli_error($conn). "<br>";
                echo $error;
              }
        }


        ?>
        <a href="index.php">Acceuil</a>
        <a href="schools.php">Afficher les écoles</a>
        <a href="logout.php">Déconnexion</a>

        <form action="" method="post">
            <h1><?php echo $schoolInfo['name'];?></h1>
            <h2>Ecole :</h2>
            <input type="text"  name="name" placeholder="Nom de l'école"  />
            <br><br>
            <input type="submit" name="submit" class="box-button" value="Modifier"/>
            <input type="submit" name="delete" class="box-button" value="Supprimer l'école"/>
        </form>
        <form action="" method="post">
            <h2>Ajouter un membre à cette école :</h2>
            <select name="idmem">
                <?php

// SELECT `a`.`id`, `a`.`username` FROM `users` AS `a` LEFT JOIN `user_school_connector` AS `b` ON `a`.`id` = `b`.`id_user` RIGHT JOIN `user_school_connector` AS `c` ON `a`.`id` = `c`.`id_user` WHERE `b`.`id_school` = 3 AND `c`.`id_school` <> 3 OR `c`.`id_school` IS NULL;

                
                $requetAdd = "SELECT DISTINCT `a`.`id`, `a`.`username`
                FROM `users` AS `a`
                LEFT JOIN `user_school_connector` AS `b`
                ON `a`.`id` = `b`.`id_user`
                WHERE `b`.`id_school` <> $schoolId OR `b`.`id_school` IS NULL";
                
                $requete = $pdo->query($requetAdd);

                $o = 0;
                foreach($requete as $a){
                    echo '<option class="az" value="'.$a['id'].'">'.$a['username'].'</option>';
                    $o = $o + 1;
                }
                if($o == 0){
                    echo '<option class="az" value="">Personne à ajoutée</option>';

                }
                
    
                ?>
            </select>
            <input type="submit" name="addschool" value="Ajouter"class="box-button"/>
        </form>
        
    
        <form action="" method="post">
            <h2>Supprimer un membre à cette école :</h2>
            <select name="idmem1">
                <?php
                
                $requetAdd = "SELECT DISTINCT `a`.`id`, `a`.`username`
                FROM `users` AS `a`
                LEFT JOIN `user_school_connector` AS `b`
                ON `a`.`id` = `b`.`id_user`
                WHERE `b`.`id_school` = $schoolId";
                
                $requete = $pdo->query($requetAdd);

                $m = 0;
                foreach($requete as $a){
                    echo '<option class="az" value="'.$a['id'].'">'.$a['username'].'</option>';
                    $m = $m + 1;
                    

                }
                if($m == 0){
                    echo '<option class="az" value="">Personne à supprimer</option>';

                }
                $add_number_user_of_school = "UPDATE `school` SET `number_user_of_school`= $m WHERE `id`= $schoolId";
                $number_user_of_school = $pdo->query($add_number_user_of_school);
                ?>
            </select>
            <input type="submit" name="deleteSchool" value="Supprimer"class="box-button"/>
        </form>
        
        <?php 
        if($m != 0){
        ?>
        <form action="" method="post" >
        <h2>Ajouter une intervention :</h2>
            <select name="idmem3">
                <?php
                $requetAdd = "SELECT *
                FROM `users` AS `a`
                LEFT JOIN `user_school_connector` AS `b`
                ON `a`.`id` = `b`.`id_user`
                WHERE `b`.`id_school` = $schoolId";
                
                $requete = $pdo->query($requetAdd);

                $p = 0;
                foreach($requete as $a){
                    echo '<option class="az" value="'.$a['id'].'">'.$a['username'].'</option>';
                    $p = $p + 1;
                    

                }
                if($p == 0){
                    echo "<option>Personne dans l'école</option>";

                }
                ?>
            </select>
            <input type="number" name="number_intervention" placeholder="Nombre d'heure">
            <input type="submit" name="add_intervention" value="Ajouter"class="box-button"/>
        </form>

        <form action="" method="post" >
        <h2>Supprimer une intervention :</h2>
            <select name="idmem4">
                <?php
                $requetAdd = "SELECT *
                FROM `users` AS `a`
                LEFT JOIN `user_school_connector` AS `b`
                ON `a`.`id` = `b`.`id_user`
                WHERE `b`.`id_school` = $schoolId";
                
                $requete = $pdo->query($requetAdd);

                $p = 0;
                foreach($requete as $a){
                    echo '<option class="az" value="'.$a['id'].'">'.$a['username'].'</option>';
                    $p = $p + 1;
                    

                }
                if($p == 0){
                    echo "<option>Personne dans l'école</option>";

                }
                ?>
            </select>
            <input type="number" name="number_intervention" placeholder="Nombre d'heure">
            <input type="submit" name="delete_intervention" value="Supprimer"class="box-button"/>
        </form>
        <?php
        }}else{
           ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        <br><br>
        <?php
        echo "Vous n'avez pas accès à cette page";
        } ?>
    </body>
</html>