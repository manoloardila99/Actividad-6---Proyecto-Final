<?php
// status.php
require_once 'database.php';

echo "<h1>Ponerme en línea</h1>";
echo "<p>Cambia tu estado a disponible o no disponible.</p>";
?>
<!-- Ejemplo de formulario -->
<form method="POST">
    <button type="submit" name="status" value="online">Disponible</button>
    <button type="submit" name="status" value="offline">No disponible</button>
</form>
