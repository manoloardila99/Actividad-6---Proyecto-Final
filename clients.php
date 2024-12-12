<?php
// clients.php
require_once 'database.php';

echo "<h1>Clientes recurrentes</h1>";

// Ejemplo de clientes
$query = "SELECT DISTINCT client_name FROM appointments WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($clients as $client) {
    echo "<p>Cliente: {$client['client_name']}</p>";
}
?>
