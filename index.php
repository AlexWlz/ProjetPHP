<?php
require('config.php');
require('configPDO.php');
// Initialiser la session
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
}
$memberId = $_SESSION['id'];
?>

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
        <title>Acceuil</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        $admin = $_SESSION['admin'];
        if($admin=="oui"){
        ?>
        <a href="members.php">Liste des membres</a>
        <a href="schools.php">Liste des écoles</a>
        <a href="intervention.php">Intervention</a>
        <a href="stats.php">Statistiques</a>
        <?php } ?>
        <a href="edit.php">Modifier votre profil</a>
        <a href="logout.php">Déconnexion</a>
        <h1><?php echo $_SESSION['username'] . '' ; ?></h1>
        <p>Acceuil</p>
        <h3>Voici vos écoles :</h3>
        <table>
            <tbody>
                <?php
                $i = 0;
                while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){;
                        if($row3['id_school'] == $row2['id'] && $row3['id_user'] == $memberId){
                            $i = $i + 1;
                ?>
                    <td><?php echo htmlspecialchars($row2['name']); ?></td>
                <?php    
                }}}
                if($i == 0){
                    ?>
                    <p> Vous n'avez pas d'école associer</p>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </body>
</html>        