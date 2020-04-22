<?php  
    session_start();
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.css' rel='stylesheet'/>

    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">

    <title>Homegrown Map</title>
</head>
<body>
    
    <div id="mapContainer" class="mapContainer"></div>
    
    <?php include_once("footer.inc.php"); ?>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="js/map.js"></script>
</body>
</html>