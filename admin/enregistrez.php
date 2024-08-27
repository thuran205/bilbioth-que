<?php

include '../modele/config.php';
error_reporting(0);

session_start();


$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: ../login.php');
}

if (isset($_POST['submit'])) {

    $CIN = $_POST['CIN'];
    $CIN = filter_var($CIN, FILTER_SANITIZE_STRING);
    $name = $_POST['Nom'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['Email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


    $select = $conn->prepare("SELECT * FROM `users` WHERE Email = ?");
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $message[] = 'Adresse mail deja utilisez!';
        header('location: enregistrez.php');
    } else {
        if ($pass != $cpass) {
            $message[] = 'Mot de passe ne correspond pas!';
            header('location: enregistrez.php');
        } else {
            $insert = $conn->prepare("INSERT INTO `users`(CIN, Nom, Email, mdp) VALUES(?,?,?,?)");
            $insert->execute([$CIN, $name, $email, $pass]);
            $message[] = 'enregistrez avec succes';


        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrez</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/components.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

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

    <section class="form-container">

        <form action="" enctype="multipart/form-data" method="POST">
            <h3>Enregistrez un Utilisateur</h3>
            <input type="number" name="CIN" class="box" placeholder="Entrez le CIN" required>
            <input type="text" name="Nom" class="box" placeholder="Entrez le nom" required>
            <input type="email" name="Email" class="box" placeholder="Entrez  l'adresse mail" required>
            <input type="password" name="pass" class="box" placeholder="Entrez le mot de passe" required>
            <input type="password" name="cpass" class="box" placeholder="Confirmez le mot de passe" required>
            <div class="flex-btn">
                <input type="submit" value="Enregistrez" class="btn" name="submit">
                <a href="admin_users.php" class="option-btn">retour</a>

            </div>


        </form>

    </section>


</body>

</html>