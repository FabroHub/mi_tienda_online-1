<?php
session_start();
echo "Bienvenido " . $_SESSION['email'] . "<br>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2014/04/03/11/58/needle-312738_1280.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
</head>

<body>
    
    <!--<video playsinline="" autoplay="" muted="" loop="" poster="cake.jpg">
        <source src="res/background.mp4" type="video/mp4">
      </video>-->
    <?php include __DIR__ . '/header.php'; ?>
    <?php include __DIR__ . '/navbar.php'; ?>
    <main>
        <?php include __DIR__ .  '/main.php'; ?>
    </main>
    <?php include __DIR__ . '/footer.php'; ?>
</body>

</html>