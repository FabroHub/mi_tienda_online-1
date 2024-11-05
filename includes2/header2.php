<?php
if ($_SESSION['rol'] == "Admin") {
    echo "<div style='width:100%; display:flex; justify-content:space-around;'><a style='background-color:white;' href='../admin/productos.php'>Añadir Productos</a><a style='background-color:white;' href='../admin/editar_productos.php'>Editar Productos</a><a style='background-color:white;' href='../admin/usuarios.php'>Usuarios</a></div>";
    echo "<script>console.log('Eres Admin')</script>";
} elseif ($_SESSION['rol'] == "Usuario") {
    echo "<script>console.log('Eres Usuario')</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['volver'])) {
        session_destroy();
        $_SESSION = null;
        if ($_SESSION = null) {
            header('Location: ../includes/index.php');
            echo '<script>console.log("Conexión cerrada.")</script>';
        } else {
            session_destroy();
            header('Location: ../includes/index.php');
            echo '<script>console.log("Conexión cerrada (2).")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .header-container {
            margin-left: 20px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            align-items: center;
            height: 100%;
        }

        #logo {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-menu-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .user-menu-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .user-menu-content a:hover {
            background-color: #ddd;
        }

        .user-menu:hover .user-menu-content {
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div id="logo" onclick="location.href='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>';">
                <img src="../assets/images/tec.png" alt="Logo">
                <h1>Todo en Carpintería</h1>
            </div>
            <div style="display:flex; align-items:center; margin-right:20px;">

                <div class="user-menu">
                    <i class="fa-regular fa-user fa-xl" style="color:white; width:50px; height:auto; cursor: pointer;"></i>
                    <div class="user-menu-content">
                        <?php
                        if (isset($_SESSION['nombre'])) {
                            echo htmlspecialchars($_SESSION['nombre']);
                        } else {
                            echo 'Sin nombre';
                        }
                        if (isset($_SESSION['apellidos'])) {
                            echo ' ' . htmlspecialchars($_SESSION['apellidos']);
                        } else {
                            echo ' Sin apellidos';
                        }
                        ?>
                        <a href="../public/carrito.php">Ver Carrito</a>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="margin: 0;">
                            <input name="volver" id="volver" type="submit" style="color: black; height: 30px; width: 100%; border: none; cursor: pointer;" value="Cerrar Sesión">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>