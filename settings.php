<?php
include('php/config.php');
session_start();

// Ambil data pengguna dari database
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header('Location: login.php');
    exit;
}

// Gambar profil pengguna
$profileImage = !empty($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'default-profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="settings.css"> <!-- Tautkan CSS Anda -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">User Info</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profileImage; ?>" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">Settings</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 pt-4">
        <h2 class="text-center">Welcome, <?php echo $user['username']; ?></h2>
        <div class="d-flex justify-content-between mt-4">
            <!-- Tombol Kembali ke Dashboard di sebelah kiri -->
            <a href="index.php" class="btn btn-secondary">Dashboard</a>
            
            <!-- Tombol View Settings di sebelah kanan -->
            <button class="btn btn-primari" data-bs-toggle="modal" data-bs-target="#settingsModal">View Settings</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                    </div>
                    <div class="text-start">
                        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Profile Image:</strong></p>
                        <p><small>You can update your profile image in settings.</small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="edit_profile.php" class="btn btn-primary">Edit Account</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
