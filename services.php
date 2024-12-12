<?php
// services.php
require_once 'database.php';

echo "<h1>Servicios</h1>";
echo "<p>Lista de servicios que puedes ofrecer.</p>";

// Ejemplo de servicios
$query = "SELECT * FROM services WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($services as $service) {
    echo "<p>{$service['name']} - {$service['price']} EUR</p>";
}
?>
