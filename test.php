
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

    .graph{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: space-around;
        color:
    }
</style>

    <head>
        <title>Test</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    </head>
    <body>
    <?php
    session_start();
    $p = 27;
    $po = 10;
    ?>
        <a href="index.php">Acceuil</a>
        <a href="logout.php">Déconnexion</a>
        <h1>Test</h1>

        <div class="graph">
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        </div>

        <script>
            var p = <?php echo json_encode($p); ?>;
            var po = <?php echo json_encode($po); ?>;

            var xValues = ["Users", "Ecoles"];
            var yValues = [p, po];
            var barColors = ["red", "green"];

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
                },
                scales: {
                xAxes: [{ticks: {min: 1}}]
                }
            }
            });
        </script>

        
        

    </body>
</html>