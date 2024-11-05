<?php
$conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$usuario_id = $_SESSION['id']; // Ensure $usuario_id is set

$categoriaSeleccionada = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

try {
    if ($categoriaSeleccionada === 0) {
        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.nombre,
                p.precioUnitario,
                p.imagen,
                p.stock
            FROM 
                productos p
        ");
    } else {
        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.nombre,
                p.precioUnitario,
                p.imagen,
                p.stock
            FROM 
                productos p
            JOIN 
                procat pc ON p.id = pc.id_producto
            JOIN 
                categorias c ON pc.id_categoria = c.id
            WHERE 
                c.id = :id_categoria
        ");
        $stmt->bindParam(':id_categoria', $categoriaSeleccionada, PDO::PARAM_INT);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch products in the cart
    $stmt = $conn->prepare("
        SELECT id_producto
        FROM carrito
        WHERE id_usuario = :id_usuario
    ");
    $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $carrito = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['detalle_producto'])) {
            header('Location:detalle_producto.php?nombre=<?php echo urlencode($row["nombre"]); ?>&precioUnitario=<?php echo urlencode($row["precioUnitario"]); ?>&imagen=<?php echo urlencode($row["imagen"]); ?>&stock=<?php echo urlencode($row["stock"]); ?>');
            exit;
        }
    }
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .product {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            width: auto;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: auto;
        }

        .product-item {
            background-color: white;
            width: calc(25% - 20px);
            /* 4 items per row with 20px gap */
            height: auto;
            text-align: center;
            border-radius: 30px;
            border: 2px solid black;
            box-shadow: 3px 2px 5px black;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-10px);
        }

        .product-item img {
            width: 200px;
            height: 150px;
            margin-top: 20px;
        }

        .product-item h3 {
            color: black;
        }

        .product-item .price {
            border: 1px solid black;
            align-items: center;
            text-align: center;
            margin-left: 20%;
            margin-right: 20%;
            margin-bottom: 0;
        }

        .product-item .cart-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .product-item .cart-section input[type='button'] {
            background-color: #007BFF; /* Blue color */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-item .cart-section input[type='button']:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .product-item .cart-section .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .product-item .cart-section .checkbox-container input[type='checkbox'] {
            display: none;
        }

        .product-item .cart-section .checkbox-container label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            user-select: none;
        }

        .product-item .cart-section .checkbox-container label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            background-color: white;
            transition: background-color 0.3s ease;
        }

        .product-item .cart-section .checkbox-container input[type='checkbox']:checked + label::before {
            background-color: #007BFF;
        }

        .product-item .cart-section .checkbox-container label::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-item .cart-section .checkbox-container input[type='checkbox']:checked + label::after {
            opacity: 1;
        }

        @media (max-width: 1200px) {
            .product-item {
                width: calc(33.33% - 20px);
                /* 3 items per row */
            }
        }

        @media (max-width: 900px) {
            .product-item {
                width: calc(50% - 20px);
                /* 2 items per row */
            }
        }

        @media (max-width: 600px) {
            .product-item {
                width: calc(100% - 20px);
                /* 1 item per row */
            }
        }
    </style>
    <script>
        function toggleCart(productId, isChecked) {
            console.log("Producto ID: " + productId + ", En carrito: " + isChecked);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../public/carrito.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("producto_id=" + productId + "&cantidad=" + (isChecked ? 1 : 0));
        }
    </script>
</head>

<body>

    <form method="GET" action="" class="categoriasform">
        <select name="categoria" onchange="this.form.submit()">
            <option value="0" <?php if ($categoriaSeleccionada == 0) echo 'selected'; ?>>Todas las categorías</option>
            <option value="1" <?php if ($categoriaSeleccionada == 1) echo 'selected'; ?>>Madera</option>
            <option value="2" <?php if ($categoriaSeleccionada == 2) echo 'selected'; ?>>Herramientas</option>
            <option value="3" <?php if ($categoriaSeleccionada == 3) echo 'selected'; ?>>Ferretería</option>
        </select>
    </form>

    <div class="product">
        <?php foreach ($result as $row): ?>
            <?php $producto_id = (int)$row["id"]; ?>
            <div class="product-item">
                <img src='<?php echo htmlspecialchars($row['imagen']); ?>' alt='Imagen del producto'>
                <h3><?php echo htmlspecialchars($row["nombre"]); ?></h3>
                <h3 class="price"> Precio: <?php echo htmlspecialchars($row["precioUnitario"]); ?> €</h3>
                <div class="cart-section">
                    <input type='button' name='detalle_producto' value="Detalle del Producto" onclick="window.location.href='../public/detalle_producto.php?nombre=<?php echo urlencode($row['nombre']); ?>&precioUnitario=<?php echo urlencode($row['precioUnitario']); ?>&imagen=<?php echo urlencode($row['imagen']); ?>&stock=<?php echo urlencode($row['stock']); ?>'">
                    <div class="checkbox-container">
                        <input type='checkbox' id='checkbox_<?php echo $producto_id; ?>' name='en_carrito' <?php if (in_array($producto_id, $carrito)) echo 'checked'; ?> onchange="toggleCart(<?php echo $producto_id; ?>, this.checked)">
                        <label for='checkbox_<?php echo $producto_id; ?>'>Agregar al carrito</label>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</body>

</html>