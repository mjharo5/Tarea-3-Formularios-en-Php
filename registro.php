<?php
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmar = $_POST['confirmar'];

if ($password != $confirmar) {
    echo "Las contraseñas no coinciden";
    exit;
}

$archivo = fopen("usuarios.txt", "a");
fwrite($archivo, "$usuario|$email|$password\n");
fclose($archivo);

echo "Usuario registrado correctamente <br>";
echo "<a href='index.html'>Volver</a>";
?>

