<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mi_tienda_online");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SESSION['rol'] == "Admin") {
    echo "<div style='width:100%; display:flex; justify-content:space-around;'><a style='background-color:white;' href='../admin/productos.php'>Añadir Productos</a><a style='background-color:white;' href='../admin/editar_productos.php'>Editar Productos</a><a style='background-color:white;' href='../admin/usuarios.php'>Usuarios</a></div>";
    echo "<script>console.log('Eres Admin')</script>";
} elseif ($_SESSION['rol'] == "Usuario") {
    echo "<script>console.log('Eres Usuario')</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precioUnitario = $_POST['precioUnitario'];
    $imagen = $_POST['imagen'];
    $stock = $_POST['stock'];

    $sql = "UPDATE productos SET nombre='$nombre', precioUnitario='$precioUnitario', imagen='$imagen', stock='$stock' WHERE id=$id";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM productos");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
</head>

<body>
    <a style="text-decoration:none; color:white; width:auto;" href='../public/public.php'>
        <h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2>
    </a>
    <h1 style="display:flex; justify-content:center; color:white;">Editar Productos</h1>
    <div style="display:flex; justify-content:center;">
        <table style="background-color:white; padding:20px; border-radius:50px;">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio Unitario</th>
                <th>Imagen</th>
                <th>Stock</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><input type="hidden" name="id" value="<?= $row['id'] ?>"><?= $row['id'] ?></td>
                        <td><input class="celdas" required type="text" name="nombre" value="<?= $row['nombre'] ?>"></td>
                        <td><input class="celdas" required type="text" name="precioUnitario" value="<?= $row['precioUnitario'] ?>"></td>
                        <td><input class="celdas" required type="text" name="imagen" value="<?= trim($row['imagen']) ?>"></td>
                        <td><input class="celdas" required type="text" name="stock" value="<?= $row['stock'] ?>"></td>
                        <td><input class="celdas" type="submit" value="Actualizar"></td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>
<?php $conn->close(); ?>