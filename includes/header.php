<?php
//session_start();
try {
    // Conectar a la base de datos
    $conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Comprobación de conexión (opcional)
    echo "<script>console.log('Conexión exitosa')</script>";

    $categoriaSeleccionada = "";

    // Manejo del formulario
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['iniciar'])) {
            header('Location: ../public/login.php');
            exit;
        } elseif (isset($_POST['registrarse'])) {
            header('Location: ../public/registro.php');
            exit;
        } elseif (isset($_POST['categoria'])) {
            $categoriaSeleccionada = $_POST['categoria'];
        }
    }

    // Filtrar resultados basados en la categoría seleccionada
    if (!empty($categoriaSeleccionada)) {
        $stmt = $conn->prepare("SELECT * FROM productos WHERE id_categoria = ?");
        $stmt->execute([$categoriaSeleccionada]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM productos");
        $stmt->execute();
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    echo "Error: " . htmlspecialchars($ex->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo en Carpintería</title>
</head>

<body>
    <header>
        <div style="margin-left:20px; display:flex; justify-content:space-between; text-align:center; align-items:center; height:100%;">
            <div id="logo" style="display:flex; align-items:center; cursor:pointer;" onclick="location.href='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>';">
                <img src="../assets/images/tec.png" alt="Logo">
                <h1>Todo en Carpintería</h1>
            </div>
            <div style="width:300px; display:flex; align-items:center; margin-right:20px; justify-content:center;">
                <form style="width:200px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input name="iniciar" type="submit" style="background-color: rgba(255, 255, 255, 0); color: wheat;" value="Iniciar Sesión">
                </form>
                <form style="width:200px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input name="registrarse" type="submit" style="color: black;" value="Registrarse">
                </form>
            </div>
        </div>
    </header>