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
        <title>Connexion</title>
    </head>
        <body>
        <?php
        require('config.php');
        session_start();

        if (isset($_POST['username'])){
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($conn, $password);
            $query = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='".hash('sha256', $password)."'";
            $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
            $rows = mysqli_num_rows($result);
            if($rows === 1){
                while($user = mysqli_fetch_assoc($result)) {
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['password'] = $user['password'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['admin'] = $user['admin'];
                }
                header("Location: index.php");
            }else{
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            }
        }
        ?>
        <form action="" method="post" name="login">
          <h1>Connexion</h1>
            <input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
            <input type="password" class="box-input" name="password" placeholder="Mot de passe">
            <input type="submit" value="Connexion " name="submit" class="box-button">
            <?php if (! empty($message)) { ?>
            <p><?php echo $message; ?></p>
            <?php } ?>
        </form>
    </body>
</html>