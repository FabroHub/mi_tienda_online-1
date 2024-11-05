<?php
//session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=mi_tienda_online", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo "Error de Conexión: " . $e->getMessage();
    exit;
}
//isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"
//$_SERVER["REQUEST_METHOD"] == "POST"
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['crear'])) {
            $nombre = filter_var($_POST["nombre"], FILTER_DEFAULT);
            $apellidos = filter_var($_POST['apellidos'], FILTER_DEFAULT);
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $rol = "Usuario"; //filter_var($_POST["rol"], FILTER_DEFAULT);
            $dni = filter_var($_POST['dni'], FILTER_DEFAULT);
            $direccion = filter_var($_POST['direccion'], FILTER_DEFAULT);
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
            $contrasena = filter_var($_POST["contrasena"], FILTER_DEFAULT);

            if ($nombre != null || $apellidos != null || $email != null || $dni != null || $direccion != null || $telefono != null || $contrasena != null) {
                $sql = "INSERT INTO usuarios (nombre, apellidos, email, rol, dni, direccion, telefono, contrasena) VALUES (:nombre, :apellidos, :email, :rol, :dni, :direccion, :telefono, :contrasena)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nombre", $nombre);
                $stmt->bindParam(":apellidos", $apellidos);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":rol", $rol);
                $stmt->bindParam(":dni", $dni);
                $stmt->bindParam(":direccion", $direccion);
                $stmt->bindParam(":telefono", $telefono);
                $stmt->bindParam(":contrasena", $contrasena);
                $stmt->execute();


                echo "Usuario registrado con éxito";
                $conn == null;
                header('Location: ../includes/index.php');
                echo "<script>console.log('Usuario registrado con éxito.')</script>";
            } else {
                echo 'Por favor, introduza rellene todos los elementos.';
            }
        } else {
            header('Location: ../includes/index.php');
        }
    } else {
    }
} catch (Exception $ex) {
    echo "Usuario existente.";
    echo "<script>console.log('Usuario existente.')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resgistrarse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e805df0a7.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="https://cdn.pixabay.com/photo/2020/04/20/21/18/tree-5069963_960_720.jpg">
</head>

<body style="padding:10px;">
    <a style="text-decoration:none; color:white; width:auto;" href='../includes/index.php'>
        <h2> <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver a la tienda</h2>
    </a>
    <main style="display:flex; justify-content:center; align-items:center;">
        <form style="background-color:white; padding:30px; height:100px; border-radius:50px; height:auto;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div style="display:flex; width:500px; display:flex; justify-content:space-evenly; font-size: 20px; align-items:center;">
            <div>
                <label for="nombre">Nombre:</label><br><br><br>
                <label for="apellidos">Apellidos:</label><br><br><br>
                <label for="email">Email:</label><br><br><br>
                <label for="dni">DNI:</label><br><br><br>
                <label for="direccion">Dirección:</label><br><br><br>
                <label for="telefono">Teléfono:</label><br><br><br>
                <label for="contrasena">Contraseña:</label>
            </div>
            <div>
                <input style="border-radius: 10px; font-size: 20px;" type="text" name="nombre" id="nombre" placeholder="Nombre"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="text" name="apellidos" id="apellidos" placeholder="Apellidos"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="email" name="email" id="email" placeholder="ejemplo@ejemplo.com"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="text" name="dni" id="dni" maxlength="9" placeholder="12345678P" style="text-transform: uppercase;"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="text" name="direccion" id="direccion" placeholder="Calle Cuenca 13"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="text" name="telefono" id="telefono" maxlength="9" placeholder="1234567890"><br><br><br>
                <input style="border-radius: 10px; font-size: 20px;" type="password" name="contrasena" id="contrasena">
            </div>
            </div>
            
            <div style="display:flex; justify-content:space-between; width:100%; margin-top:50px;">
                <input style="border-radius: 50px; height:35px; width:100px;" type="submit" name="crear" value="Enviar">
                <input style="border-radius: 50px; height:35px; width:100px;" type="reset" value="Borrar Datos">
            </div>
        </form>
    </main>

</body>

</html>