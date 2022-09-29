<?php
require '../config/functions.php';
require '../config/AuthMeController.php';
require '../config/Sha256.php';
session_start();
$authme_controller = new Sha256();
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
    <link href="/css/store.css" rel="stylesheet">
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
                    <a class="nav-link" aria-current="page" href="/index.php/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/store/">Store</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Vota</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Discord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacts</a>
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

<div class="container store text-center mt-5">
    <div class="row">
        <div class="col">
            STORE
        </div>
    </div>
</div>

<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card text-black">
                    <img src="/img/vip1.png"
                         class="card-img-top" alt="VIP1" />
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">VIP 1</h5>
                            <p class="text-muted mb-4">Other thing</p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between">
                                <span>Rewards 1</span><span> <i class="text-success fa-sharp fa-solid fa-check"></i></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Rewards 2</span><span> <i class="text-danger fa-solid fa-xmark"></i></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Rewards 3</span><span> <i class="text-danger fa-solid fa-xmark"></i></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between total font-weight-bold mt-4">
                            <span>Total</span><span>$7,197.00</span>
                        </div>
                        <?php if ($session) {
                            ?><button type="button" class="mt-5 btn btn-outline-info" style="width: 100%">Buy</button><?php
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>

