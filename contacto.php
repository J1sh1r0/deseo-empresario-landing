<?php
// Configuración de la conexión
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "deseo_empresario";

// Conectar a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $empresa = $_POST["empresa"];
    $fecha = $_POST["fecha"];
    $mensaje = $_POST["mensaje"];

    // Insertar en la base de datos
    $sql = "INSERT INTO visitas (nombre, correo, empresa, fecha, mensaje)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $correo, $empresa, $fecha, $mensaje);

    if ($stmt->execute()) {
        header("Location: gracias.html");
        exit();
    } else {
        echo "Error al agendar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
