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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
    <style>
        .back-button {
            color: white; /* Changed color to white */
            text-decoration: none;
        }

        .back-button:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <a href='../public/public.php' class="back-button">
        <h2><i class="fa-solid fa-left-long"></i> Volver a la tienda</h2>
    </a>

    <h1 class="product-title">Detalle del Producto</h1>

    <div class="product-detail">
        <div class="product-card">
            <img src='<?php echo $imagen; ?>' alt='Imagen del producto'>
            <h3><?php echo $nombre; ?></h3>
            <h3>Precio: <?php echo $precio; ?> €</h3>
            <h3>Stock: <?php echo $stock; ?></h3>
        </div>
    </div>
</body>

</html>