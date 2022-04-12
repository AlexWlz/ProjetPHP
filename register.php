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
        <title>Ajouter un membre</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        session_start();
        require('config.php');
        $admin = $_SESSION['admin'];
        if($admin=="oui"){
        if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['admin'])){
            // récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire et mettre en minuscule
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $username = strtolower($username);
            // récupérer l'email et supprimer les antislashes ajoutés par le formulaire
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($conn, $email);
            // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($conn, $password);
            // récupérer l'info admin et supprimer les antislashes ajoutés par le formulaire et mettre en minuscule
            $admin = stripslashes($_REQUEST['admin']);
            $admin = mysqli_real_escape_string($conn, $admin);
            $admin = strtolower($admin);
            //requéte SQL + mot de passe crypté
            $query = "INSERT into `users` (username, email, password, admin)
            VALUES ('$username', '$email', '".hash('sha256', $password)."', '$admin')";
            // Exécuter la requête sur la base de données
            $res = mysqli_query($conn, $query);
            if($res){
                header('Location: members.php');
            }
            }else{
        ?>
        <a href="index.php">Acceuil</a>
        <a href="members.php">Afficher les membres</a>
        <a href="logout.php">Déconnexion</a>
        <form class="box" action="" method="post">
            <h1 class="box-title">Ajouter un membre</h1>
            <h2>Pseudo :</h2>
            <input type="text"  name="username" placeholder="Nom d'utilisateur" required />
            <h2>Adresse mail :</h2>
            <input type="text"  name="email" placeholder="Email" required />
            <h2>Mot de passe :</h2>
            <input type="password"  name="password" placeholder="Mot de passe" required />
            <h2>Droit admin :</h2>
            <input type="text"  name="admin" placeholder="Oui ou non" required />
            <br><br>
            <input type="submit" name="submit" class="box-button" value="S'inscrire"/>
            <br><br>
        </form>
        <?php }
        }else{
           ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        <br><br>
        <?php
        echo "Vous n'avez pas accès à cette page";
        } ?>
    </body>
</html>