<?php
$conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener el valor seleccionado del formulario
$categoriaSeleccionada = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

try {
    if ($categoriaSeleccionada === 0) {
        // Mostrar todos los productos si no se ha seleccionado ninguna categoría
        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.nombre,
                p.precioUnitario,
                p.imagen
            FROM 
                productos p
        ");
    } else {
        // Filtrar productos por la categoría seleccionada
        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.nombre,
                p.precioUnitario,
                p.imagen
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
} catch (Exception $ex) {
    // Manejo de errores
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

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .product-item {
            background-color: white;
            width: calc(25% - 20px);
            /* 4 items per row with 20px gap */
            height: auto;
            text-align: center;
            border-radius: 30px;
            border: 2px solid black;
            box-sizing: border-box;
            cursor: pointer;
            box-shadow: 3px 2px 5px black;
            text-decoration: none;
        }

        .product-item img {
            width: 200px;
            height: 150px;
            margin-top: 20px;
        }
    </style>
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

    <div class="product-grid">
        <?php
        foreach ($result as $row) {
            $nombre = urlencode($row["nombre"]);
            $precio = urlencode($row["precioUnitario"]);
            $imagen = urlencode($row["imagen"]);
            echo "<a href='../public/detalle_producto.php?nombre=$nombre&precioUnitario=$precio&imagen=$imagen' class='product-item'>
            <img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen del producto'>
            <h3 style='color:black;'>" . htmlspecialchars($row["nombre"]) . "</h3>
            <h3 style='color:black;'> Precio: " . htmlspecialchars($row["precioUnitario"]) . " €</h3>
          </a>";
        }
        ?>
    </div>
</body>

</html>