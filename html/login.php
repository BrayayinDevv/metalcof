<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifica la contraseña
        if (password_verify($password, $user['contraseña'])) {
            // Inicio de sesion exitoso guarda el nombre del usuario en la sesion
            session_start();
            $_SESSION['nombre_usuario'] = $user['nombre_usuario']; // Almacena el nombre del usuario en la sesion
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.html?error=1"); // Contraseña incorrecta
            exit();
        }
    } else {
        header("Location: index.html?error=1"); // Usuario no encontrado
        exit();
    }


}
?>