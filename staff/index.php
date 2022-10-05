<?php
require '../config/functions.php';
require '../config/AuthMeController.php';
require '../config/Sha256.php';

session_start();

$session = false;
if (isset($_SESSION['id'])) {
    $session = true;
} else {
    $session = false;
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
    <link href="/css/staff.css" rel="stylesheet">
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
                    <li><a class="dropdown-item" href="#">Option 2</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a class="dropdown-item" href="/login/logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                            Logout</a></li>
                </ul>
            </div>
            <?php
        } ?>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>


<div class="container mt-5 bg-white p-4 m-auto shadowbox">
    <div class="text-center pb-4">
        <div class="h1">Staff</div>
        <div class="text-muted">Staff List</div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-6 col-xl-4 pb-3 Fondatore">
            <div class="h4 text-center text-owner pb-2 ">Owner</div>
            <div class="line bg-danger"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                        <img src="https://cravatar.eu/helmavatar/vsMaNu/16.png" loading="lazy" width="16"
                             height="16" alt="_AleMastro_">
                    </div>
                    <div class="d-inline-block username">vsMaNu</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Amministratori">
            <div class="h4 text-center text-admin pb-2 ">Admin</div>
            <div class="line bg-light-danger"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                        <img src="https://cravatar.eu/helmavatar/alessandrobasi/16.png" loading="lazy" width="16"
                             height="16" alt="alessandrobasi">
                    </div>
                    <div class="d-inline-block username">SomeOne</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Sviluppatori">
            <div class="h4 text-center text-developer pb-2 ">Developer</div>
            <div class="line bg-light-primary"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                        <img src="https://cravatar.eu/helmavatar/Eyren24/16.png" loading="lazy" width="16" height="16"
                             alt="Surfy">
                    </div>
                    <div class="d-inline-block username">Eyren2406</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Moderatori">
            <div class="h4 text-center text-mod pb-2 ">Moderators</div>
            <div class="line bg-warning"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">

                    </div>
                    <div class="d-inline-block username">Looking for staff</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Helper">
            <div class="h4 text-center text-helper pb-2 ">Helper</div>
            <div class="line bg-success"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                    </div>
                    <div class="d-inline-block username">Looking for staff</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Builder">
            <div class="h4 text-center text-builder pb-2 ">Builder</div>
            <div class="line bg-primary"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                    </div>
                    <div class="d-inline-block username">Looking for staff</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4 pb-3 Supporter">
            <div class="h4 text-center text-supporter pb-2 ">Supporter</div>
            <div class="line bg-black"></div>
            <div class="row row-cols-lg-2 row-cols-1 justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="d-inline-block pr-1">
                    </div>
                    <div class="d-inline-block username">Looking for staff</div>
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
