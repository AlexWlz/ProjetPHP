<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>


<style>
    *{
        margin: 0;
        padding: 0;
        font-family: cusystem-ui;
        list-style: none;
        text-decoration: none;
        box-sizing: border-box;
    }
    html{
        height: 100%;
        width: 100%;
        background-color: black;

        
    }
    body{
        text-align: center;
        background-image: url(fond.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    .box-button{
        background-color: rgba(255, 255, 255, 0.5);
    }
    .all{
        align-items: center;
        width: 100%;
        display: grid;
        justify-content: center;
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
        <div class="all">
        <?php
        $recup_number = "SELECT * FROM `sats` WHERE `number_user`";
        $stmt_recup_number = $pdo->query($recup_number);
        foreach($stmt_recup_number as $a){ ?>
        <?php } ?>
        <div class="graph">
            <canvas id="myChart" style="width:100%;max-width:500px"></canvas>
        </div>

        <script>
            var p = <?php echo json_encode($a['number_user']); ?>;
            var po = <?php echo json_encode($a['number_school']); ?>;

            var xValues = ["Users", "Ecoles"];
            var yValues = [p, po];
            var barColors = ["rgb(255, 30, 132)", "rgb(54, 162, 235)"];

            new Chart("myChart", {
            type: "horizontalBar",
            data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
            },
            options: {
                legend: {display: false},
                title: {
                display: true,
                text: "Nombre d'users et d'écoles"
                },
                scales: {
                xAxes: [{ticks: {min: 1}}]
                }
            }
            });
        </script>

        
        <?php $name=[];
        $number_user_of_school=[];
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { 
            
        array_push($name,$row['name']);
        array_push($number_user_of_school,$row['number_user_of_school']);
        } ?>

        <div class="graph">
            <canvas id="my" style="width:100%;max-width:400px"></canvas>
        </div>
        
        <script>
            var p = <?php echo json_encode($name); ?>;
            var po = <?php echo json_encode($number_user_of_school); ?>;

            var xValues = p;
            var yValues = po;
            var barColors =
            "#318CE7";

            new Chart("my", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                title: {
                display: true,
                text: "Nombre d'user par école :"
                }
            }
            });
        </script>

        <?php
        $username = [];
        $number_intervention = [];
        foreach($stmt as $b){
            $i = $b['id'];
            $number_intervention_user = "SELECT SUM(`number_intervention`)
            FROM `user_school_connector`
            WHERE `id_user` = $i;";
            $stmt_number_intervention_user = $pdo->query($number_intervention_user);
            array_push($username,$b['username']);
        
        foreach($stmt_number_intervention_user as $p){
            $j = $p['SUM(`number_intervention`)'];
            array_push($number_intervention,$j);
        }
        }
        ?>
        <div class="graph">
            <canvas id="graph" style="width:100%;max-width:400px"></canvas>
        </div>
        <script>
            var p = <?php echo json_encode($username); ?>;
            var po = <?php echo json_encode($number_intervention); ?>;


            var xValues = p;
            var yValues = po;
            var barColors = 
            "#E9383F"
            ;

            new Chart("graph", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                title: {
                display: true,
                text: "Nombre d'heure total :"
                }
            }
            });
        </script>
        </div>



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