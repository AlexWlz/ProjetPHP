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
        <title>Ecoles</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        session_start();
        require('config.php');
        if (isset($_REQUEST['creerecole'])){
            // récupérer le nom d'école et supprimer les antislashes ajoutés par le formulaire et mettre en minuscule
            $school = stripslashes($_REQUEST['name']);
            $school = mysqli_real_escape_string($conn, $school);
            
            //requéte SQL
            $query = "INSERT INTO `school`(`name`, `number_user_of_school`) VALUES ('$school','0')";
            // Exécuter la requête sur la base de données
            $res = mysqli_query($conn, $query);
            if($res){
                header('Location: schools.php');
            }
            }else{
                $admin = $_SESSION['admin'];
                if($admin=="oui"){
        ?>
        <a href="index.php">Acceuil</a>
        <a href="schools.php">Liste des écoles</a>
        <a href="logout.php">Déconnexion</a>
        <form class="box" action="" method="post">
            <h1 class="box-title">Créer une école</h1>
            <h2>Ecole :</h2>
            <input type="text"  name="name" placeholder="Nom de l'école" required />
            <br><br>
            <input type="submit" class="box-button" name="creerecole" value="Créer"/>
            <br><br>
        </form>
        <?php
        }else{
           ?>
           <a href="index.php">Acceuil</a>
           <a href="logout.php">Déconnexion</a>
           <br><br>
           <?php
            echo "Vous n'avez pas accès à cette page";
            }} ?>
    </body>
</html>