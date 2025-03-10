<?php
$contrasena = "admin123"; // Cambia esto por la contraseña que desees
$hash = password_hash($contrasena, PASSWORD_DEFAULT);
echo "Contraseña: " . $contrasena . "<br>";
echo "Hash: " . $hash;
?>