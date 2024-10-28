<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($inputPassword, $hashedPassword)) {
            $_SESSION["username"] = $inputUsername;
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: index.html?error=1");
        }
    } else {
        header("Location: index.html?error=1");
    }

    $stmt->close();
}

$conn->close();
?>
