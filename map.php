<?php
// map.php
echo "<h1>Mapa de servicios</h1>";
echo "<p>Aquí puedes ver los servicios cerca de ti.</p>";
?>
<!-- Ejemplo de integración con Google Maps -->
<div id="map" style="height: 400px; width: 100%;"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script>
    function initMap() {
        var location = { lat: -34.397, lng: 150.644 };
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 8,
            center: location,
        });
    }
    window.onload = initMap;
</script>
