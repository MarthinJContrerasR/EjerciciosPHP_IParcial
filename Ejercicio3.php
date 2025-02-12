<?php
// Marthin Jose Contreras Rodriguez
/* 3. Mostrar en una Card El Nombre y Apellido del Usuario de Staff y la Cantidad Total de peliculas rentadas por
cada uno de esos usuarios (Ej. si hay 4 usuarios en Staff, se mostraria en total 4 card, una por cada usuario) */

require_once 'Conexion.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener el nombre, apellido y la cantidad de películas rentadas por cada usuario de Staff
    $consulta = "SELECT 
                 s.first_name AS Nombre, 
                 s.last_name AS Apellido, 
                 COUNT(r.rental_id) AS TOTAL_RENTADAS
                 FROM staff s
                 LEFT JOIN rental r 
                 ON s.staff_id = r.staff_id
                 GROUP BY s.staff_id";
    $stmt = $conn->query($consulta);
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff y Películas Rentadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Staff y Películas Rentadas</h1>
    <div class="row">
        <?php foreach ($staff as $usuario): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <?php echo ($usuario['Nombre'] . ' ' . $usuario['Apellido']); ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>Total de películas rentadas:</p>
                            <footer class="blockquote-footer">
                                <?php echo ($usuario['TOTAL_RENTADAS']); ?>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
