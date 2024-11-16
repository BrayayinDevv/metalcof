<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar caracteres especiales para evitar problemas
    $username = htmlspecialchars(string: $_POST['username']);
    $email = htmlspecialchars(string: $_POST['email']);
    $password = $_POST['password'];
    
    // Encripta la contraseña
    $hashedPassword = password_hash(password: $password, algo: PASSWORD_DEFAULT);
    
    // Verifica si el usuario o correo ya existen
    $checkQuery = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR email = ?";
    $stmt = $conn->prepare(query: $checkQuery);

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "El usuario o correo ya existen.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        $query = "INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        
        
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }
    }

    // Cerrar la declaración y conexión
    $stmt->close();
    $conn->close();
}



?>