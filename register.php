<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = password_hash($_POST['password'], PASSWORD_BCRYPT); // Cifrado seguro de contraseña

    // Verificar si el usuario ya existe
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el usuario ya existe, redirigir de nuevo al formulario de registro con un mensaje de error
        header("Location: register.html?error=exists");
    } else {
        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $inputUsername, $inputPassword);
        
        if ($stmt->execute()) {
            // Registro exitoso, redirigir al login
            header("Location: index.html?registered=success");
            exit();
        } else {
            // Error en la inserción
            echo "<p class='error-message'>Error al registrar el usuario. Inténtalo nuevamente.</p>";
        }
    }

    $stmt->close();
}

$conn->close();
?>

