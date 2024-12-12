<?php
// agenda.php
require_once 'database.php';

echo "<h1>Agenda</h1>";
echo "<p>Aquí puedes gestionar tus citas con clientes y servicios.</p>";

// Ejemplo de listado de citas
$query = "SELECT * FROM appointments WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($appointments as $appointment) {
    echo "<p>Cita con: {$appointment['client_name']} el {$appointment['date']}</p>";
}
?>
