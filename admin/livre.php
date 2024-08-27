<?php
@include '../modele/config.php';
error_reporting(0);

session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('loation:../login.php');

}

if (isset($_POST['add_livre'])) {

    $reference = $_POST['Reference'];
    $reference = filter_var($reference, FILTER_SANITIZE_STRING);

    $name = $_POST['Titre'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $auteur = $_POST['Auteur'];
    $auteur = filter_var($auteur, FILTER_SANITIZE_STRING);

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING) .

        $synopsis = $_POST['Synopsis'];
    $synopsis = filter_var($synopsis, FILTER_SANITIZE_STRING);

    $nb = $_POST['nb_livre'];
    $nb = filter_var($nb, FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;


    $select_livre = $conn->prepare("SELECT * FROM `livres` WHERE Titre = ?");
    $select_livre->execute([$name]);

    if ($select_livre->rowCount() > 0) {
        $message[] = 'Livre déja ajoutez !';
    } else {
        $insert_livre = $conn->prepare("INSERT INTO `livres` (Reference,Titre,Auteur,category,Synopsis,nb_livre,image) VALUES(?,?,?,?,?,?,?)");
        $insert_livre->execute([$reference, $name, $auteur, $category, $synopsis, $nb, $image]);

        if ($insert_livre) {
            if ($image_size > 2000000) {
                $message[] = 'image trop grand !';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Nouveau livre ajoutez !';
            }
        }
    }

}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `livres` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    $delete_livre = $conn->prepare("DELETE FROM `livres` WHERE id = ?");
    $delete_livre->execute([$delete_id]);


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout livre</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="add-products">
        <h1 class="title">Ajoutez un livre</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <input type="text" name="Reference" class="box" required placeholder="entrez la reference du livre">
                    <input type="text" name="Titre" class="box" required placeholder="entrez le titre du livre">

                    <select name="category" class="box" required>

                        <option value="" selected desabled>Choisissez une catégorie</option>
                        <option value="fiction">fiction</option>
                        <option value="romans">romans</option>
                    </select>
                </div>

                <div class="inputBox">
                    <input type="number" min="0" name="nb_livre" class="box" required
                        placeholder="entrez le nombre de livre">
                    <input type="text" min="0" name="Auteur" class="box" required
                        placeholder="entrez le nom de l'auteur">
                    <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
                </div>
            </div>
            <textarea name="Synopsis" class="box" required placeholder="entrez la Synopsis" cols="30"
                rows="10"></textarea>
            <input type="submit" class="btn" value="ajouter le livre" name="add_livre">
        </form>

    </section>

    <section class="show-products">

        <h1 class="title">Livres ajoutés</h1>

        <div class="box-container">

            <?php

            $show_livre = $conn->prepare("SELECT * FROM `livres`");
            $show_livre->execute();
            if ($show_livre->rowCount() > 0) {
                while ($fetch_livre = $show_livre->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <img src="../uploaded_img/<?= $fetch_livre['image']; ?>" alt="">
                        <div class="nombre">
                            <h3>Nombre : </h3>
                            <?= $fetch_livre['nb_livre']; ?>
                        </div>
                        <div class="name">
                            <h3>Titre : </h3>
                            <?= $fetch_livre['Titre']; ?>
                        </div>
                        <div class="auteur">
                            <h3>Auteur : </h3>
                            <?= $fetch_livre['Auteur']; ?>
                        </div>
                        <div class="cat">
                            <h3>Catégori : </h3>
                            <?= $fetch_livre['category']; ?>
                        </div>
                        <div class="Synopsis">
                            <h3>Synopsis : </h3>
                            <?= $fetch_livre['Synopsis']; ?>
                        </div>
                        <div class="Synopsis">
                            <h3>Status : </h3>
                            <?= $fetch_livre['status_L']; ?>
                        </div>

                        <div class="flex-btn">
                            <a href="maj_livre.php?update=<?= $fetch_livre['id']; ?>" class="option-btn">Mettre a jour</a>
                            <a href="livre.php?delete=<?= $fetch_livre['id']; ?>" class="delete-btn"
                                onclick="return confirm('Supprimer ce livre?');">Supprimer</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">pas encore de livres ajoutez!</p>';
            }
            ?>


        </div>
    </section>

    <script src="../assets/js/script.js"></script>

</body>

</html>