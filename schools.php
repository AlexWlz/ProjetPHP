
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
        <title>Liste des écoles</title>
    </head>
    <body>
    <?php
    session_start();
    require('configPDO.php');
    $admin = $_SESSION['admin'];
    if($admin=="oui"){
    ?>
        <a href="index.php">Acceuil</a>
        <a href="addSchool.php">Ajouter une école</a>
        <a href="logout.php">Déconnexion</a>
        <h1>Liste des écoles</h1>
        <table>
            <thead>
                <tr>
                    <th>ID :</th>
                    <th>Name :</th>
                </tr>
            </thead>
            <tbody>
                <?php $number_school = 0;
                while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { 
                    
                    ?>
                <tr>
                    
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><a href="editSchool.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></a></td>
                    <?php $number_school = $number_school + 1; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        $add_number_school = "UPDATE `sats` SET `number_school`= $number_school WHERE 1";
        $stmt_number_school = $pdo->query($add_number_school);
        
        echo $number_school; 
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