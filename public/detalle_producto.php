<?php
try {
    $nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
    $precio = isset($_GET['precioUnitario']) ? htmlspecialchars($_GET['precioUnitario']) : '';
    $imagen = isset($_GET['imagen']) ? htmlspecialchars($_GET['imagen']) : '';
    $stock = isset($_GET['stock']) ? htmlspecialchars($_GET['stock']) : '';

    // Log the values to check if they are being passed correctly
    error_log("Nombre: $nombre, Precio: $precio, Imagen: $imagen, Stock: $stock");

    if (empty($nombre) || empty($precio) || empty($imagen) || empty($stock)) {
        throw new Exception("Datos del producto incompletos.");
    }
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
</head>

<body>
<a style="text-decoration:none; color:white; width:auto;" href='../public/public.php'>
        <h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2>
    </a>

    <h1 style="display:flex; justify-content:center; color:white;">Detalle del Producto</h1>

    <div style="display:flex; justify-content:center;">
    <div style='background-color:white; width:300px; height:auto; text-align:center;border-radius:30px; border: 2px solid black;'>
        <img src='<?php echo $imagen; ?>' alt='Imagen del producto' style='width:200px; height:150px; margin-top:20px;'>
        <h3 style='color:black;'><?php echo $nombre; ?></h3>
        <h3 style='color:black;'> Precio: <?php echo $precio; ?> €</h3>
        <h3 style='color:black;'> Stock: <?php echo $stock; ?></h3>
    </div>
    </div>

</body>

</html>