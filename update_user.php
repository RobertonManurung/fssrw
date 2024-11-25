<?php
include('php/config.php');
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$oldPassword = $_POST['old_password'];  // Password lama
$password = isset($_POST['password']) ? $_POST['password'] : '';  // Password baru
$confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';  // Konfirmasi password baru

// Verifikasi password lama
$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cek apakah password lama cocok
if (!password_verify($oldPassword, $user['password'])) {
    $_SESSION['error_message'] = "Password lama salah.";
    header('Location: edit_profile.php');
    exit;
}

// Menangani gambar profil jika diunggah
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["profile_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Upload file ke folder "uploads"
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
        $profileImage = $fileName;
    } else {
        $profileImage = null; // Jika upload gagal
    }
} else {
    // Jika tidak ada gambar yang diunggah, gunakan gambar profil sebelumnya
    $profileImage = null;
}

// Verifikasi dan update password jika diperlukan
if (!empty($password)) {
    if ($password === $confirmPassword) {
        // Hash password baru sebelum menyimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Jika password tidak cocok
        $_SESSION['error_message'] = "Password dan konfirmasi password tidak cocok.";
        header('Location: edit_profile.php');
        exit;
    }
} else {
    $hashedPassword = null; // Tidak mengubah password jika tidak ada input
}

// Query untuk memperbarui data pengguna
$sql = "UPDATE users SET username = ?, email = ?, profile_image = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $username, $email, $profileImage, $userId);

// Eksekusi query
if ($stmt->execute()) {
    // Jika ada perubahan password, update password juga
    if (!empty($hashedPassword)) {
        $updatePasswordSql = "UPDATE users SET password = ? WHERE id = ?";
        $stmtPassword = $conn->prepare($updatePasswordSql);
        $stmtPassword->bind_param("si", $hashedPassword, $userId);
        $stmtPassword->execute();
    }

    $_SESSION['success_message'] = "Profile updated successfully.";
    header('Location: edit_profile.php');
    exit;
} else {
    $_SESSION['error_message'] = "Error updating profile.";
    header('Location: edit_profile.php');
    exit;
}
?>
