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
        require('configPDO.php');
        $id = $_SESSION['id'];
        $admin = $_SESSION['admin'];
        if($admin=="oui"){

        $memberId = NULL;

        try {
            $memberId = intval($_GET['id']);
        } catch (Exception $e) {
            echo 'Invalid member ID';
            exit(1);
        }

        if ($memberId === 0 || $memberId < 1 || $memberId === 1) {
            echo 'Invalid member ID';
            exit(1);
        }

        if(isset($_POST['submit'])) {
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            $modif= "UPDATE users SET
                username='$username',
                email='$email',
                password='".hash('sha256', $password)."'
                WHERE id='$memberId'";

            $res = mysqli_query($conn, $modif);

            if(!$res) {
                die('Erreur modif SQL !'.$modif.'<br />');
            }
            else {
                echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
            }
        }
        if(isset($_POST['delete'])){
            $delete = mysqli_prepare($conn, "DELETE FROM users WHERE `id`=?");
            /* Lecture des marqueurs */
            mysqli_stmt_bind_param($delete, "i", $memberId);

            /* Exécution de la requête */
            mysqli_stmt_execute($delete);
            header('Location: members.php');
        }


        // SQL de récupération des données du membre n°$memberId.
        // Attention aux injections :P
        $query = "SELECT `username` FROM `users` WHERE `id`={$memberId}";
        //$res = mysqli_query($conn, $query);
        $memberInfo = mysqli_fetch_assoc(mysqli_query($conn, $query));


        ?>
        <a href="index.php">Acceuil</a>
        <a href="members.php">Afficher les membres</a>
        <a href="logout.php">Déconnexion</a>
        <form action="" method="post">
            <h1>Modification du profil de <?php echo $memberInfo['username']; ?></h1>
            <h2>Pseudo :</h2>
            <input type="text"  name="username" placeholder="Nom d'utilisateur"  />
            <h2>Adresse mail :</h2>
            <input type="text"  name="email" placeholder="Email"  />
            <h2>Mot de passe :</h2>
            <input type="password"  name="password" placeholder="Mot de passe"  />
            <h2>Droit admin :</h2>
            <input type="text"  name="admin" placeholder="Oui ou non"  />
            <br><br>
            <input type="submit" name="submit" class="box-button" value="Modifier"/>
            <input type="submit" name="delete" class="box-button" value="Supprimer le compte"/>
        </form>

        <?php }else{
           ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        <br><br>
        <?php
        echo "Vous n'avez pas accès à cette page";
        } ?>
    </body>
</html>