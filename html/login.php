<?php

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare(query: $query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifica la contraseña
        if (password_verify($password, $user['contraseña'])) {
            echo "Inicio de sesión exitoso";
            // Aquí puedes redirigir al usuario a la página principal o almacenar la sesión
            session_start();
            $_SESSION['username'] = $user['username'];
            header("Location: home.php");
        } else {
            echo $password;
            echo $user['contraseña'];
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}

?>
