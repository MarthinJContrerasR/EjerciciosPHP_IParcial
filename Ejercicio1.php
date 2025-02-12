<?php
// Marthin Jose Contreras Rodriguez
/* 1. Enlistar las 5 peliculas más rentadas, usando una lista de Bootstrap,
(Mostrar el Nombre de cada pelicula y mostrarla en orden descendente) */

require_once 'Conexion.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta = "SELECT 
                 f.title AS titulo, 
                 COUNT(r.rental_id) AS rentas
                 FROM film f
                 JOIN inventory i 
                 ON f.film_id = i.film_id
                     
                 JOIN rental r 
                 ON i.inventory_id = r.inventory_id
                 
                 GROUP BY f.film_id
                 ORDER BY rentas DESC
                 LIMIT 5";
    $stmt = $conn->query($consulta);
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top 5 Películas Más Rentadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Top 5 Películas Más Rentadas</h1>
    <ul class="list-group">
        <?php foreach ($peliculas as $pelicula): ?>
            <li class="list-group-item">
                <?php echo $pelicula['titulo']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
