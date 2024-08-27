<?php
@include '../modele/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: ../login.php');
}

if (isset($_POST['maj_livre'])) {


    $pid = $_POST['pid'];

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
    $old_image = $_POST['old_image'];


    $update_product = $conn->prepare("UPDATE `livres` SET Titre = ?, Auteur = ?, category = ?, Synopsis = ?, nb_livre= ? WHERE id = ?");
    $update_product->execute([$name, $auteur, $category, $synopsis, $nb, $pid]);
    $message[] = 'Livre mis a jour !';

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'image trop grand!';
        } else {

            $update_image = $conn->prepare("UPDATE `livres` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);

            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/' . $old_image);
                $message[] = 'image mis a jour !';
            }
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
    <title>Mettre a jour le livre</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/admin_style.css">

</head>

<body>
    <?php include 'admin_header.php'; ?>

    <section class="update-product">

        <h1 class="title">Mettre a jour le livre</h1>

        <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `livres` WHERE id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">

                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">

                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">

                    <input type="text" name="Titre" placeholder="enter Le titre" required class="box"
                        value="<?= $fetch_products['Titre']; ?>">

                    <input type="text" name="Auteur" placeholder="enter Le nom de l'auteur" required class="box"
                        value="<?= $fetch_products['Auteur']; ?>">


                    <input type="number" name="nb_livre" min="0" placeholder="enter le nombre" required class="box"
                        value="<?= $fetch_products['nb_livre']; ?>">

                    <select name="category" class="box" required>
                        <option selected>
                            <?= $fetch_products['category']; ?>
                        </option>
                        <option value="fiction">fiction</option>
                        <option value="roman">roman</option>

                    </select>
                    <textarea name="Synopsis" required placeholder="entrer la synopsis" class="box" cols="30"
                        rows="10"><?= $fetch_products['Synopsis']; ?></textarea>
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                    <div class="flex-btn">
                        <input type="submit" class="btn" value="maj livre" name="maj_livre">
                        <a href="livre.php" class="option-btn">retour</a>
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">no products found!</p>';
        }
        ?>

</body>