<?php
include('php/config.php');
session_start();

// Cek apakah form registrasi disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan pengguna baru
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        header('Location: login.php'); // Redirect ke halaman login setelah registrasi berhasil
        exit;
    } else {
        $error = "Terjadi kesalahan saat registrasi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" type="text/css" href="login.css"> <!-- Tambahkan ini -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
    <div class="form-container">
        <h2>Registrasi Pengguna</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" required placeholder="Masukkan username">
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" required placeholder="Masukkan email">
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
            </div>
            <input type="submit" value="Registrasi">
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
    </div>
</body>
</html>