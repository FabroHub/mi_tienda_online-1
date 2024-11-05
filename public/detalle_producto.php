<?php
try {
    $nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
    $precio = isset($_GET['precioUnitario']) ? htmlspecialchars($_GET['precioUnitario']) : '';
    $imagen = isset($_GET['imagen']) ? htmlspecialchars($_GET['imagen']) : '';

    if (empty($nombre) || empty($precio) || empty($imagen)) {
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
</head>
<body>
<?php
// Aquí puedes usar las variables $nombre, $precio y $imagen para mostrar los detalles del producto
echo "<div style='background-color:white; width:300px; height:auto; text-align:center;border-radius:30px; border: 2px solid black;'>
        <img src='$imagen' alt='Imagen del producto' style='width:200px; height:150px; margin-top:20px;'>
        <h3 style='color:black;'>$nombre</h3>
        <h3 style='color:black;'> Precio: $precio €</h3>
      </div>";
?>
</body>
</html>