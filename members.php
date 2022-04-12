
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
        <title>Membres</title>
    </head>
    <body>
    <?php
    session_start();
    require('configPDO.php');
    $admin = $_SESSION['admin'];
    if($admin=="oui"){
    ?>
        <a href="index.php">Acceuil</a>
        <a href="register.php">Ajouter un membre</a>
        <a href="logout.php">Déconnexion</a>
        <h1>Liste des utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID :</th>
                    <th>Name :</th>
                    <th>Email :</th>
                    <th>Admin :</th>
                </tr>
            </thead>
            <tbody>
                <?php $number_user = 0;
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                ?>
                <tr>
                    
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><a href="editMembers.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['username']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['admin']); ?></td>
                    <?php $number_user = $number_user + 1; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        $add_number_user = "UPDATE `sats` SET `number_user`= $number_user WHERE 1";
        $stmt_number_user = $pdo->query($add_number_user);
        
        echo $number_user; 
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