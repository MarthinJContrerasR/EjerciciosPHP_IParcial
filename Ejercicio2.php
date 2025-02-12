<?php
// Marthin Jose Contreras Rodriguez
/* 2. En una tabla de Bootstrap mostrar la cantidad de peliculas disponible
por cada Categoría existente.(Ej. Terror / 340, Comedia / 290) */

require_once 'Conexion.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta corregida
    $consulta = "SELECT 
                 c.name AS NOMBRE, 
                 COUNT(fc.film_id) AS CANTIDAD
                 FROM category c
                 INNER JOIN film_category fc ON c.category_id = fc.category_id
                 GROUP BY c.name
                 ORDER BY CANTIDAD DESC";
    $stmt = $conn->query($consulta);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cantidad de Películas por Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Cantidad de Películas por Categoría</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Categoría de Película</th>
            <th scope="col">Cantidad</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?php echo $categoria['NOMBRE']; ?></td>
                <td><?php echo $categoria['CANTIDAD']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>