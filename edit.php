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
        <title>Modifier le profil</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        session_start();
        require('config.php');
        $id = $_SESSION['id'];

        if(isset($_POST['submit'])) {
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            $modif= "UPDATE users SET
            username='$username',
            email='$email',
            password='".hash('sha256', $password)."'
            WHERE id='$id'";

            $res = mysqli_query($conn, $modif);

            if(!$res) {
                die('Erreur SQL !'.$modif.'<br />');
            }
            else {
                header('Location: logout.php');
            }
        }
        $admin = $_SESSION['admin'];
        if($admin=="oui"){
        ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        <form action="" method="post">
            <h1 class="box-title">Modification du profil</h1>
            <h2>Pseudo :</h2>
            <input type="text"  name="username" placeholder="Nom d'utilisateur" required />
            <h2>Adresse mail :</h2>
            <input type="text"  name="email" placeholder="Email" required />
            <h2>Mot de passe :</h2>
            <input type="password"  name="password" placeholder="Mot de passe" required />
            <br><br>
            <input type="submit" name="submit" class="box-button" value="Modifier"/>
        </form>
        <?php 
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