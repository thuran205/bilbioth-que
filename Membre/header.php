<?php

if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceuil</title>
    <link rel="stylesheet" href="assets/image/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/sass/main.css">
    <link rel="shortcut icon " href="assets/image/logo mimoz.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head>

<body>
    <header class="header">

        <div class="flex">

            <a class="navbar-brand" href="#">
                <img src="assets/image/logo-mimoza.png " alt="">
            </a>

            <nav class="navbar">

                <a href="home.php">Acceuil</a>
                <a href="livres.php">Livre</a>
                <a href="emprunte.php">Emprunts</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="user-btn" class="fas fa-user"></div>


            </div>

            <div class="profile">
                
                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$membre_id]);

                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <p>
                    <?= $fetch_profile['Nom']; ?>
                </p>
                <a href="../admin/logout.php" class="delete-btn">Se deconnecté</a>
            </div>

        </div>

    </header>

</body>
<script src="assets/js/bootstrap.bundle.js"></script>


</html>