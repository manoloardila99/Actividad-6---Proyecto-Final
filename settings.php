<?php
// settings.php
require_once 'database.php';

echo "<h1>Configuración</h1>";
echo "<p>Actualiza tu perfil.</p>";

// Ejemplo de formulario de actualización
echo '<form method="POST">
    <input type="text" name="name" placeholder="Nuevo nombre">
    <input type="email" name="email" placeholder="Nuevo email">
    <button type="submit" name="update">Actualizar</button>
</form>';
?>
