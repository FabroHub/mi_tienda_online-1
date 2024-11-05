<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
    if ($conn != null) {
        echo "<script>console.log('Conexión establecida correctamente.')</script>";
    } else {
        echo "<script>console.log('Error de Conexión.')</script>";
    }
    
    $conn = null;
    if ($conn == null) {
        echo "<script>console.log('Conexión cerrada correctamente.')</script>";
    }
} catch (Exception $ex) {
    $conn = null;
    if ($conn == null) {
        echo "<script>console.log('Conexión cerrada correctamente.')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2014/04/03/11/58/needle-312738_1280.png">
</head>
<body>
    <main>
        
    </main>
</body>
</html>