<?php
require '../config/functions.php';
require '../config/AuthMeController.php';
require '../config/Sha256.php';
session_start();

if (empty($_SESSION['id'])) {
    header("LOCATION: ../index.php");
}
$conn = mysqli_connect('opluckycraft.it', 'minecraft', '34gAGozv2U0Pq97TCg', 'minecraft');

$userInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from authme where username = '" . $_SESSION['id'] . "'"));
$userRank = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from luckperms_players where username = '" . $userInfo['username'] . "'"));
if (!$userInfo) {
    die(mysqli_error($conn));
}
$userKill = mysqli_query($conn, "SELECT * FROM statz_kills_players WHERE uuid = '" . $userRank['uuid'] . "'");
$userDeath = mysqli_query($conn, "SELECT * FROM statz_deaths WHERE uuid = '" . $userRank['uuid'] . "'");
$userKillCount = 0;
$userDeathCount = 0;

$dataPoints = array();

while ($kill = mysqli_fetch_all($userKill)) {
    echo count($kill);
    $userKillCount ++;
}
while ($death = mysqli_fetch_all($userDeath)) {
    $userDeathCount++;
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Opluckycraft</title>
    <script src="https://kit.fontawesome.com/cc852ff3c8.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/leonardosnt/mc-player-counter/dist/mc-player-counter.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
                text: "K/D"
            },
            axisY: {
                title: "Revenue in USD",
                valueFormatString: "#0,,.",
                suffix: "mn",
                prefix: "$"
            },
            data: [{
                type: "spline",
                markerSize: 5,
                xValueFormatString: "YYYY",
                yValueFormatString: "$#,##0.##",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });

        chart.render();

    }
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Toggle button -->
        <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#navbarCenteredExample"
                aria-controls="navbarCenteredExample"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div
                class="collapse navbar-collapse justify-content-center"
                id="navbarCenteredExample"
        >
            <!-- Left links -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/index.php/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://opluckycraft.tebex.io/">Store</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Vota</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://discord.gg/MXQ8hMeRwc">Discord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ticket/">Tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/staff/">Staff</a>
                </li>
            </ul>
            <!-- Left links -->
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-dark text-white dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded" src="https://minotar.net/helm/<?php echo $_SESSION["id"]; ?>/100.png" alt="Img"
                     width="25" style="margin-right: 10px;">
                <?php echo $_SESSION['id'] ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Option 2</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item" href="/login/logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                        Logout</a></li>
            </ul>
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>

<?php
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'loginRequired':
            ?>
            <div class="alert" style="width: 20%">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Error!</strong> Login required.
            </div>
        <?php
    }
}

?>
    <div class="container p-5 rounded mt-5 bg-light">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <img src="https://minotar.net/helm/<?php echo $_SESSION["id"]; ?>/100.png">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <h1 style="color:#e38809">Player: <?php echo($userInfo['username']); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mt-4">
                    <div class="col">
                        <h1 style="color:#e38809"> Your K/D <?php echo number_format((float)$userKillCount / $userDeathCount, 2, '.', ''); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container mt-5 text-center">

    <div class="row">
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php if (isset($userRank)) {
                if ($userRank['primary_group'] == 'default') {
                    ?><h1 style="color:#e38809">Starter</h1><?php
                } else {
                    ?><h1 style="color:#e38809"><?php echo($userRank['primary_group']); ?></h1><?php
                }
            } ?>
        </div>
    </div>


</div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
