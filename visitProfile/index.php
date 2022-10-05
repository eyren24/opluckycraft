<?php
if (empty($_GET['username'])) {
    header("LOCATION: http://localhost?error=usernameNotFound");
}

session_start();

$session = false;
if (isset($_SESSION['id'])) {
    $session = true;
} else {
    $session = false;
}

$username = $_GET['username'];

$conn = mysqli_connect('opluckycraft.it', 'minecraft', '34gAGozv2U0Pq97TCg', 'minecraft');

$userInfo = mysqli_fetch_array(mysqli_query($conn, "SELECT * from authme where username = '" . $username . "'"));
if (!$userInfo) {
    header("LOCATION: http://localhost?error=usernameNotFound");
}
$userRank = mysqli_fetch_array(mysqli_query($conn, "SELECT * from luckperms_players where username = '" . $userInfo['username'] . "'"));


$userKill = mysqli_query($conn, "SELECT * FROM statz_kills_players WHERE uuid = '" . $userRank['uuid'] . "'");
$userDeath = mysqli_query($conn, "SELECT * FROM statz_deaths WHERE uuid = '" . $userRank['uuid'] . "'");
$userTime = mysqli_query($conn, "SELECT * FROM statz_time_played WHERE uuid = '" . $userRank['uuid'] . "'");

$userKillCount = 0;
$userDeathCount = 0;
$userTimeCount = 0;
$playerKilled = array();

while ($kill = mysqli_fetch_array($userKill)) {
    array_push($playerKilled, $kill['playerKilled']);
    $userKillCount += $kill['value'];
}
while ($time = mysqli_fetch_array($userTime)) {
    $userTimeCount += $time['value'];
}
while ($death = mysqli_fetch_array($userDeath)) {
    $userDeathCount += $death['value'];
} ?>


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
    <link href="/css/visitprofile.css" rel="stylesheet">
</head>
<body>

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
        <?php
        if ($session == false) {
            ?><a href="/login/">
                <button type="button" class="btn btn-outline-danger">Login</button>
            </a><?php
        } else {
            ?>
            <div class="dropdown">
                <button class="btn btn-outline-dark text-white dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded" src="https://minotar.net/helm/<?php echo $_SESSION["id"]; ?>/100.png" alt="Img"
                         width="25" style="margin-right: 10px;">
                    <?php echo $_SESSION['id'] ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="/dashboard/"><i class="fa-solid fa-user"></i> Dashboard</a></li>
                    <?php
                    if ($userRank['primary_group'] == "owner") {
                        ?>
                        <li><a class="dropdown-item" href="http://localhost/news/dashboard.php"><i
                                        class="fa-solid fa-bars-progress"></i> News manager</a></li> <?php
                    } else {
                        ?>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-edit"></i> Coming soon !</a>
                        </li> <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <li><a class="dropdown-item" href="/login/logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                            Logout</a></li>
                </ul>
            </div>
            <?php
        } ?>
        <!-- Collapsible wrapper -->
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
        <div class="col-sm-3">
            <div class="row">
                <div class="col">
                    <img src="https://minotar.net/helm/<?php echo $userInfo['username']; ?>/100.png">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h5 style="color:#1b1e21">Player: <span
                                style="color: red"><?php echo($userInfo['username']); ?></span></h5>
                    <h5 style="color:#1b1e21">Rank: <span
                                style="color: red"><?php if ($userRank['primary_group'] == 'default') echo('starter'); else echo($userRank['primary_group']); ?></span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <h1 style="color: #1b1e21">Stats</h1>
                    <h5 style="color:#1b1e21"> K/D: <span
                                style="color: red"><?php echo number_format((float)$userKillCount / $userDeathCount, 2, '.', ''); ?></span>
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5 style="color: #1b1e21"> Last login: <span
                                style="color: red"><?php echo date('H:i:s', $userInfo['lastlogin']) ?></span></h5>
                    <h5 style="color: #1b1e21"> Time played: <span
                                style="color: red;"><?php echo date('H:i:s', $userTimeCount) ?></span></h5>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="row">
                <div class="col text-center">
                    <nav class="navscroll float-end">
                        <h5>Player Killed</h5>
                        <ul>
                            <?php
                            for ($i = 0; $i < count($playerKilled); $i++) {
                                ?>
                                <li><a href="http://localhost/visitprofile/?username=<?php echo $playerKilled[$i] ?>">
                                        <button type="button"
                                                class="btn text-danger mt-3"><?php echo $playerKilled[$i] ?></button>
                                    </a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
