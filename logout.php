<?php
session_start();
// terminar la sesion
session_destroy();

// Salir a index con mensaje de sesion cerrada
header('Location: index.php?alert=2');
?>