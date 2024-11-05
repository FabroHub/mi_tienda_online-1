<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$usuario_id = $_SESSION['id']; // Asegúrate de que $usuario_id esté configurado

try {
    // Obtener los productos en el carrito
    $stmt = $conn->prepare("
        SELECT p.id, p.nombre, p.precioUnitario, p.stock, c.cantidad
        FROM carrito c
        JOIN productos p ON c.id_producto = p.id
        WHERE c.id_usuario = :id_usuario
    ");
    $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Simular el pago
    $totalPrecio = 0;
    foreach ($carrito as $producto) {
        $totalPrecio += $producto['precioUnitario'] * $producto['cantidad'];
    }

    // Actualizar el stock de los productos
    foreach ($carrito as $producto) {
        $nuevoStock = $producto['stock'] - $producto['cantidad'];
        if ($nuevoStock < 0) {
            throw new Exception("Stock insuficiente para el producto: " . $producto['nombre']);
        }
        $stmt = $conn->prepare("UPDATE productos SET stock = :stock WHERE id = :id");
        $stmt->bindParam(':stock', $nuevoStock, PDO::PARAM_INT);
        $stmt->bindParam(':id', $producto['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    // Vaciar el carrito
    $stmt = $conn->prepare("DELETE FROM carrito WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    
} catch (Exception $ex) {
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/styles3.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2014/04/03/11/58/needle-312738_1280.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
</head>
<body>

    <div style="display: flex; justify-content:center;">
        <div>
            <h1>Checkout</h1>
            <h2>Resumen de la compra</h2>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
                <?php foreach ($carrito as $producto): ?>
                    <tr>
                        <td><?= $producto['nombre'] ?></td>
                        <td><?= $producto['precioUnitario'] ?> €</td>
                        <td><?= $producto['cantidad'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <h3>Total: <?= $totalPrecio ?> €</h3>
        </div>
    </div>
<div style="display:flex; justify-content:center; align-items:center; width:auto;">
<a href="public.php">Volver a la tienda</a>
</div>
    
</body>
</html>
