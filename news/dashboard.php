<?php
require '../config/functions.php';
require '../config/AuthMeController.php';
require '../config/Sha256.php';

$conn = mysqli_connect('opluckycraft.it', 'minecraft', '34gAGozv2U0Pq97TCg', 'minecraft');

session_start();

$session = false;
if (isset($_SESSION['id'])) {
    $session = true;
} else {
    $session = false;
}

if (empty($_SESSION['id'])) {
    header("location: http://localhost/?error=loginRequired");
}

$userInfo = mysqli_fetch_array(mysqli_query($conn, "SELECT * from authme where username = '" . $_SESSION['id'] . "'"));
$userRank = mysqli_fetch_array(mysqli_query($conn, "SELECT * from luckperms_players where username = '" . $userInfo['username'] . "'"));

if ($userRank['primary_group'] != "owner") {
    header("location: http://localhost/?error=permissiondenied");
}

mysqli_close($conn);

$connPosts = mysqli_connect('opluckycraft.it', 'minecraft', '34gAGozv2U0Pq97TCg', 'news');
$posts = mysqli_query($connPosts, "SELECT * FROM posts WHERE removed = 0 order by date desc");

$targetDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    $title = test_input($_POST['title']);
    $desc = test_input($_POST['description']);

    $fileName = basename($_FILES["img"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $connPosts->query("INSERT INTO posts (title, img, author, description) VALUES ('" . $title . "', '". $fileName ."', '" . $_SESSION['id'] . "', '" . $desc . "')");
            header('Location: '.$_SERVER['REQUEST_URI']);
            if($insert){
                echo ("The file ".$fileName. " has been uploaded successfully.");
            }else{
                echo "File upload failed, please try again.";
            }
        }else{
            echo "Sorry, there was an error uploading your file.";
        }
    }else{
        echo 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link href="../css/news-dashboard.css" rel="stylesheet">
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


<div id="creaPostCollapses" class="mt-5">
    <div class="container bg-light shadow rounded p-2">

        <div class="collapse show" id="creaPostButton" data-parent="#creaPostCollapses">
            <div class="card-body row">
                <div class="col-sm live-title">
                    <i class="fa fa-pencil text-danger"></i>&nbsp;
                    <?php if (empty($_SESSION['id'])) {
                        echo 'Invia un tuo post';
                    } ?>
                </div>
                <div class="col-sm">
                    <button class="float-end btn btn-danger" data-bs-toggle="collapse" data-bs-target="#creaPostForm"><i
                                class="fa fa-plus"></i> Crea un post
                    </button>
                </div>
            </div>
        </div>

        <div class="container collapse hide" id="creaPostForm" data-parent="#creaPostCollapses">
            <div class="row">
                <div class="col">
                    <h4 class="float-start"><i class="fa fa-plus"></i> Crea post</h4>
                </div>
            </div>
            <hr>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="titolo" class="form-label">Title </label>
                            <input type="text" class="form-control" id="titolo" name="title" placeholder="Title"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image </label>
                            <input type="file" class="form-control" name="img" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description </label>
                            <textarea cols="30" rows="10" class="form-control" name="description"
                                      id="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger m-3"><i class="fa fa-send"></i> Pubblica
                        </button>

                        <a href="http://localhost/">
                            <button type="button" class="btn btn-secondary m-3" data-toggle="collapse"
                                    data-target="#creaPostButton"><i class="fa fa-close"></i> Annulla
                            </button>
                        </a>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>

    <h1 class="text-center mt-3 fw-bold">ALL POSTS</h1>

    <div class="container">
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
    </div>
</body>
</html>
