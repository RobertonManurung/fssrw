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
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="settings.css">
</head>
<body>

<div class="container mt-5">
    <a href="index.php" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h2>Edit Profile</h2>

    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])) : ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>
    
    <!-- Form profile dengan flex layout -->
    <form action="update_user.php" method="POST" enctype="multipart/form-data" class="profile-form">
        <div class="profile-image">
            <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="img-thumbnail">
            <input type="file" name="profile_image" id="profile_image" class="form-control mt-2">
            <small class="form-text text-muted">Leave blank if you do not want to change your profile image.</small>
        </div>
        
        <div class="profile-details">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="old_password" class="form-label">Current Password:</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" name="password" id="password" class="form-control">
                <small class="form-text text-muted">Leave blank if you do not want to change your password.</small>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.js"></script>

</body>
</html>
