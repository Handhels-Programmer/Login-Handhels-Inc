<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
        <a href="logout.php" class="btn logout">Cerrar sesión</a>
    </div>
</body>
</html>
