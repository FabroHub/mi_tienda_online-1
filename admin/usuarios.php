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
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];

    $sql = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email', rol='$rol', dni='$dni', direccion='$direccion', telefono='$telefono', contrasena='$contrasena' WHERE id=$id";
    $conn->query($sql);
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellidos'] = $apellidos;
    $_SESSION['email'] = $email;
    $_SESSION['rol'] = $rol;
    $_SESSION['dni'] = $dni;
    $_SESSION['direccion'] = $direccion;
    $_SESSION['telefono'] = $telefono;
    $_SESSION['contrasena'] = $contrasena;
}

$result = $conn->query("SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
</head>

<body>
    <a style="text-decoration:none; color:white; width:auto;" href='../public/public.php'>
        <h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2>
    </a>
    
    <h1 style="display:flex; justify-content:center; color:white;">Editar Usuarios</h1>
    <div style="display:flex; justify-content:center;">
        <table style=" background-color:white; padding:20px; border-radius:50px;">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th>DNI</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Contraseña</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><input type="hidden" name="id" value="<?= $row['id'] ?>"><?= $row['id'] ?></td>
                        <td><input class="celdas" required type="text" name="nombre" value="<?= $row['nombre'] ?>"></td>
                        <td><input class="celdas" required type="text" name="apellidos" value="<?= $row['apellidos'] ?>"></td>
                        <td><input class="celdas" required type="email" name="email" value="<?= $row['email'] ?>"></td>
                        <td><input class="celdas" required type="text" name="rol" value="<?= $row['rol'] ?>"></td>
                        <td><input class="celdas" required type="text" name="dni" value="<?= $row['dni'] ?>"></td>
                        <td><input class="celdas" required type="text" name="direccion" value="<?= $row['direccion'] ?>"></td>
                        <td><input class="celdas" required type="text" name="telefono" value="<?= $row['telefono'] ?>"></td>
                        <td><input class="celdas" required type="text" name="contrasena" value="<?= $row['contrasena'] ?>"></td>
                        <td><input type="submit" value="Actualizar"></td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>
<?php $conn->close(); ?>