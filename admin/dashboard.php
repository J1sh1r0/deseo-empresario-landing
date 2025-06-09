<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "deseo_empresario";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Filtros
$filtro_empresa = $_GET['empresa'] ?? '';
$filtro_fecha = $_GET['fecha'] ?? '';

$sql = "SELECT * FROM visitas WHERE 1=1";

if (!empty($filtro_empresa)) {
    $empresa = $conn->real_escape_string($filtro_empresa);
    $sql .= " AND empresa LIKE '%$empresa%'";
}

if (!empty($filtro_fecha)) {
    $fecha = $conn->real_escape_string($filtro_fecha);
    $sql .= " AND fecha = '$fecha'";
}

$sql .= " ORDER BY creado_en DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel de Visitas - Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <style>
    .dashboard-container {
      padding: 80px 20px;
      max-width: 1100px;
      margin: auto;
    }

    h1 {
      text-align: center;
      color: #38bdf8;
    }

    form {
      margin-top: 30px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    form input, form button, form a {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #334155;
      font-size: 1rem;
    }

    form button {
      background-color: #38bdf8;
      color: #0f172a;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    form a {
      background-color: #64748b;
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background-color: #1e293b;
      color: #f1f5f9;
      border: 1px solid #334155;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #334155;
    }

    th {
      background-color: #0f172a;
      color: #38bdf8;
    }

    tr:hover {
      background-color: #273549;
    }

    .volver {
      margin-top: 30px;
      display: inline-block;
      background-color: #38bdf8;
      color: #0f172a;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s ease;
    }

    .volver:hover {
      background-color: #0ea5e9;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h1>Visitas Agendadas</h1>

    <!-- Filtros -->
    <form method="GET">
      <input type="text" name="empresa" placeholder="Buscar empresa..." value="<?= htmlspecialchars($filtro_empresa) ?>" />
      <input type="date" name="fecha" value="<?= htmlspecialchars($filtro_fecha) ?>" />
      <button type="submit">Filtrar</button>
      <a href="dashboard.php">Limpiar</a>
    </form>

    <!-- Tabla -->
    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Empresa</th>
        <th>Fecha</th>
        <th>Mensaje</th>
        <th>Creado</th>
      </tr>

      <?php if ($resultado->num_rows > 0): ?>
        <?php while($row = $resultado->fetch_assoc()): ?>
          <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["nombre"]) ?></td>
            <td><?= htmlspecialchars($row["correo"]) ?></td>
            <td><?= htmlspecialchars($row["empresa"]) ?></td>
            <td><?= $row["fecha"] ?></td>
            <td><?= nl2br(htmlspecialchars($row["mensaje"])) ?></td>
            <td><?= $row["creado_en"] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">No hay visitas registradas.</td></tr>
      <?php endif; ?>
    </table>

    <a href="../index.html" class="volver">← Volver al inicio</a>
  </div>
</body>
</html>

<?php $conn->close(); ?>
