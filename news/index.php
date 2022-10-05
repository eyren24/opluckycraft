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

$connPosts = mysqli_connect('opluckycraft.it', 'minecraft', '34gAGozv2U0Pq97TCg', 'news');
$posts = mysqli_query($connPosts, "SELECT * FROM posts WHERE removed = 0 order by date desc");
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
    <link href="/css/news.css" rel="stylesheet">
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
                    <a class="nav-link" href="http://localhost/news/">News</a>
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
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-edit"></i> Coming soon !</a></li>
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


<div class="header">
    <h2 class="fw-bold"><span class="text-danger">OP</span><span class="text-warning">LUCKY</span><span
                class="text-success">CRAFT</span> <span class="animate-charcter"> NEWS</span></h2>
</div>

<div class="row">
    <div class="leftcolumn">
        <?php
        while ($post = mysqli_fetch_array($posts)) {
            ?>
            <div class="card mb-5">
                <h2><?php echo $post['title']; ?></h2>
                <h5 class="mt-3 mb-1"><?php echo $post['author']; ?>, <?php echo $post['date']; ?></h5>
                <?php if ($post['img'] != null){ ?>  <img alt="" class="rounded" height="350px" src="uploads/<?php echo $post['img']; ?>" ><?php } ?>
                <mark class="mt-3 rounded"><p><?php echo $post['description']; ?></p></mark>
            </div>


            <?php
        }
        ?>
    </div>
    <div class="rightcolumn">
        <div class="card">
            <h2>About Me</h2>
            <div class="fakeimg" style="height:100px;">Image</div>
            <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
        </div>
        <div class="card">
            <h3>Popular Post</h3>
            <div class="fakeimg">Image</div>
            <br>
            <div class="fakeimg">Image</div>
            <br>
            <div class="fakeimg">Image</div>
        </div>
        <div class="card">
            <h3>Follow Me</h3>
            <p>Some text..</p>
        </div>
    </div>
</div>

<div class="footer">
    <h2>Footer</h2>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
