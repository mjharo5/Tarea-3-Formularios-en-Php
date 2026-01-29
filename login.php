<?php
$usuario = $_POST['usuario'];
$password = $_POST['password'];

$usuarios = file("usuarios.txt");

$encontrado = false;

foreach ($usuarios as $linea) {
    list($user, $email, $pass) = explode("|", trim($linea));

    if ($usuario == $user && $password == $pass) {
        $encontrado = true;
        break;
    }
}

if ($encontrado) {
    echo "Bienvenido, $usuario 🎉";
} else {
    echo "Usuario o contraseña incorrectos ❌";
}

echo "<br><a href='index.html'>Volver</a>";
?>
