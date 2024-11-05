<?php
session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo "Error de Conexión: " . $e->getMessage();
    exit;
}

if ($_SESSION['rol'] == "Admin") {
    echo "<div style='width:100%; display:flex; justify-content:space-around;'><a style='background-color:white;' href='../admin/productos.php'>Añadir Productos</a><a style='background-color:white;' href='../admin/editar_productos.php'>Editar Productos</a><a style='background-color:white;' href='../admin/usuarios.php'>Usuarios</a></div>";
    echo "<script>console.log('Eres Admin')</script>";
} elseif ($_SESSION['rol'] == "Usuario") {
    echo "<script>console.log('Eres Usuario')</script>";
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['crear'])) {
            $nombre = filter_var($_POST["nombre"], FILTER_DEFAULT);
            $precioUnitario = filter_var($_POST['precioUnitario'], FILTER_DEFAULT);
            $imagen = filter_var($_POST["imagen"], FILTER_DEFAULT);
            $id_categoria = filter_var($_POST['id_categoria'], FILTER_DEFAULT);
            $stock = filter_var($_POST['stock'], FILTER_DEFAULT);

            if ($nombre != null && $precioUnitario != null && $imagen != null && $stock != null) {
                $sql = "INSERT INTO productos (nombre, precioUnitario, imagen, stock) VALUES (:nombre, :precioUnitario, :imagen, :stock)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nombre", $nombre);
                $stmt->bindParam(":precioUnitario", $precioUnitario);
                $stmt->bindParam(":imagen", $imagen);
                $stmt->bindParam(":stock", $stock);
                $stmt->execute();

                // Obtener el ID del producto recién creado
                $id_producto = $conn->lastInsertId();

                // Insertar en la tabla procat
                $sql2 = "INSERT INTO procat (id_producto, id_categoria) VALUES (:id_producto, :id_categoria)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bindParam(":id_producto", $id_producto);
                $stmt2->bindParam(":id_categoria", $id_categoria);
                $stmt2->execute();

                echo "Producto registrado con éxito";
                $conn == null;
                //header('Location: ../includes/index.php');
                echo "<script>console.log('Usuario registrado con éxito.')</script>";
            } else {
                echo 'Por favor, introduza rellene todos los elementos.';
            }
        } else {
            header('Location: ../public/public.php');
        }
    } else {
    }
} catch (Exception $ex) {
    echo "Usuario existente.";
    echo  $ex->getMessage();

    echo "<script>console.log('Usuario existente.')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Productos</title>
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
    <h1 style="display:flex; justify-content:center; color:white;">Añadir Productos</h1>
    <main>
        <div style="display:flex; justify-content: center; width:auto; font-size: 20px;">
            <form style="background-color:white; padding:30px; height:100px; border-radius:50px; height:auto;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label style="margin-right:20px;">Categoría: </label>
                    <select style="font-size:20px;" name="id_categoria" id="id_categoria">
                        <option id="1" name="1" value="1" <?php echo (isset($_POST['id_categoria']) && $_POST['id_categoria'] == '1') ? 'selected' : ''; ?>>Madera</option>
                        <option id="2" name="2" value="2" <?php echo (isset($_POST['id_categoria']) && $_POST['id_categoria'] == '2') ? 'selected' : ''; ?>>Herramientas</option>
                        <option id="3" name="3" value="3" <?php echo (isset($_POST['id_categoria']) && $_POST['id_categoria'] == '3') ? 'selected' : ''; ?>>Ferretería</option>
                    </select>
                </div>
                <br>
                <div style="display:flex; display:flex; justify-content:space-evenly; font-size: 20px; align-items:center;">
                    <div>
                        <label for="nombre">Nombre:</label><br><br>
                        <label for="apellidos">Apellidos:</label><br><br>
                        <label for="image">Url de la imagen: </label><br><br>
                        <label for="stock">Stock: </label>
                    </div>
                    <div>
                        <input style="border-radius: 10px; font-size: 20px;" type="text" name="nombre" id="nombre" placeholder="Nombre del producto" required><br><br>
                        <input style="border-radius: 10px; font-size: 20px;" type="text" name="precioUnitario" id="precioUnitario" placeholder="Precio" required><br><br>
                        <input style="border-radius: 10px; font-size: 20px;" type="text" name="imagen" id="imagen" placeholder="url de la imagen" required><br><br>
                        <input style="border-radius: 10px; font-size: 20px;" type="text" name="stock" id="stock" placeholder="Stock" required>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; width:100%; margin-top:50px;">
                    <input style="border-radius: 50px; height:35px; width:100px;" type="submit" name="crear" value="Enviar">
                    <input style="border-radius: 50px; height:35px; width:100px;" type="reset" value="Borrar Datos">
                </div>
            </form>
        </div>
    </main>
</body>

</html>