<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$usuario_id = $_SESSION['id']; // Asegúrate de que $usuario_id esté configurado

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = (int)$_POST['producto_id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1; // Obtener la cantidad del POST, por defecto 1
    if ($cantidad > 0) {
        // Verifica si el producto ya está en el carrito
        $stmt = $conn->prepare("SELECT * FROM carrito WHERE id_producto = :id_producto AND id_usuario = :id_usuario");
        $stmt->bindParam(':id_producto', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("UPDATE carrito SET cantidad = :cantidad WHERE id_producto = :id_producto AND id_usuario = :id_usuario");
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Si no está en el carrito, lo agrega
            $stmt = $conn->prepare("INSERT INTO carrito (id_producto, id_usuario, cantidad) VALUES (:id_producto, :id_usuario, :cantidad)");
            $stmt->bindParam(':id_producto', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->execute();
        }
    } else {
        // Si la cantidad es 0, eliminar el producto del carrito
        $stmt = $conn->prepare("DELETE FROM carrito WHERE id_producto = :id_producto AND id_usuario = :id_usuario");
        $stmt->bindParam(':id_producto', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

$stmt = $conn->prepare("
    SELECT p.id, p.nombre, p.precioUnitario, p.imagen, c.cantidad
    FROM carrito c
    JOIN productos p ON c.id_producto = p.id
    WHERE c.id_usuario = :id_usuario
");
$stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular el precio total de todos los productos en el carrito
$totalPrecio = 0;
foreach ($carrito as $producto) {
    $totalPrecio += $producto['precioUnitario'] * $producto['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
    <script>
        function updateTotal() {
            const items = document.querySelectorAll('.li-productos');
            let total = 0;
            items.forEach(item => {
                const price = parseFloat(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity').value);
                total += price * quantity;
            });
            document.getElementById('totalPrice').innerText = total.toFixed(2) + ' €';
        }
    </script>
</head>

<body>
    <?php include '../includes2/header2.php'; ?>
    <a style="text-decoration:none; color:white; width:auto;" href='../public/public.php'><h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2></a>
    <h1 style="display:flex; justify-content:center; color:#ffffff;">Carrito de Compras</h1>
    
    <ul>
        <?php foreach ($carrito as $producto): ?>
            <li class="li-productos" data-price="<?php echo htmlspecialchars($producto['precioUnitario']); ?>">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="200" height="150">
                <div style="width:500px; margin-left:20px;">
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                </div>
                <div style="margin-right:20px;">
                    <?php echo htmlspecialchars($producto['precioUnitario']); ?> €
                </div>
                <form method="POST" style="display:inline;">
                    <input type="number" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" min="1" max="30" class="quantity" style="width: 50px; font-size:20px;" onchange="updateTotal()" oninput="updateTotal()">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <input type="hidden" name="en_carrito" value="1">
                    <input type="hidden" name="cantidad" value="0">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="justify-content: end; display: flex; margin-right: 50px;">
        <h2 class="precioTotal">Total: <span id="totalPrice"><?php echo htmlspecialchars($totalPrecio); ?> €</span></h2>
    </div>
</body>

</html>