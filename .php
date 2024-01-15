<?php
include 'db.php';




session_start();

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Procesar el inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tu código de verificación de inicio de sesión aquí
    // ...

    // Si las credenciales son válidas, inicia sesión y redirige al usuario
    session_start();
    $_SESSION['username'] = $username; // Usa el nombre de usuario real aquí
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Encabezado de tu página -->
</head>
<body>
    <h1>Bienvenido a la página de inicio de sesión</h1>
    
    <form method="post" action="login.php">
        <label for="username">Apodo:</label>
        <input type="text" name="username" required>
        <br>
        <label for="age">Edad:</label>
        <input type="number" name="age" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a>.</p>
</body>
</html>
