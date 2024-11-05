<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
    if ($conn != null) {
        echo  "<script>console.log(Conexión establecida correctamente.)</script>";
    } else {
        echo "<script>console.log(Error de Conexión.)</script>";
    }
} catch (Exception $ex) {
    //echo "Error: " . $ex->getMessage();
    //echo "Error2: " . $ex->getLine();
    $conn = null;
    if ($conn == null) {
        echo "Conexión cerrada. <br>";
    }
}
try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['enviar'])) {
            $email = $_POST['email'];
            $contraseña = $_POST['contrasena'];
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND contrasena = :contrasena");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":contrasena", $contraseña);
            $stmt->execute();
            $resultado = $stmt->fetch();
            print_r($resultado);
            if ($resultado) {
                session_start();
                $id = $resultado['id']; // Fix assignment
                $rol = $resultado['rol'];
                $nombre = $resultado['nombre'];
                $apellidos = $resultado['apellidos'];
                $_SESSION['id'] = $id; // Ensure id is set in session
                $_SESSION['email'] = $email;
                $_SESSION['rol'] = $rol;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellidos'] = $apellidos;

                header('Location: public.php');
                exit;
            } else {
                echo "Email o contraseña incorrectos";
            }
        }
        if (isset($_POST['volver'])) {
            header('Location: ../includes/index.php');
        }
    }
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
    echo "Error2: " . $ex->getLine();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
</head>

<body style="padding:10px;">
<a style="text-decoration:none; color:white; width:auto;" href='../includes/index.php'><h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2></a>
    <h1 style="display:flex; justify-content:center; align-items:center; width:100%; color:white;">Inicio de Sesión</h1>
    <div style="display:flex; justify-content:center; align-items:center;">
    <form style="background-color:white; padding:30px; height:100px; border-radius:50px; height:auto;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div style="display:flex; width:500px; display:flex; justify-content:space-evenly; font-size:25px; align-items:center;">
            <div>
                <label class="" for="email">Email:</label><br><br><br>
                <label for="contrasena">Contraseña:</label>
            </div>

            <div>
                <input style="border-radius: 10px; font-size:25px;" class="" type="email" name="email" id="email"><br><br><br>
                <input style="border-radius: 10px; font-size:25px;" type="password" name="contrasena" id="contrasena">
            </div>
        </div>
        <div>
            <div style="display:flex; justify-content:space-between; width:100%; margin-top:50px;">
                <input style="border-radius: 50px; height:35px; width:100px;" type="submit" id="enviar" name="enviar" value="Enviar">
                <input style="border-radius: 50px; height:35px; width:100px;" type="reset" value="Borrar Datos">
            </div>
    </form>
    </div>
    
</body>

</html>