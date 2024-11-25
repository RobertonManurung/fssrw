<?php
include('php/config.php');

// Query untuk mengambil data akses log
$SQL = "SELECT * FROM `access_log` ORDER BY `Record_Time` DESC LIMIT 100;"; // Pastikan tabel 'access_log' sudah ada
$stmt = $conn->prepare($SQL);
$stmt->execute();
$access_data = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'assets/components/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include 'assets/components/navbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Access Log</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Access Log</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        DataTable Access Log
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>User ID</th>
                                    <th>Access Type</th> <!-- Masukkan apakah "Masuk" atau "Keluar" -->
                                    <th>Record Date</th>
                                    <th>Record Time</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Record ID</th>
                                    <th>User ID</th>
                                    <th>Access Type</th>
                                    <th>Record Date</th>
                                    <th>Record Time</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php while ($row = $access_data->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['Record_ID']; ?></td>
                                        <td><?php echo $row['User_ID']; ?></td> <!-- Pastikan kolom ini ada dalam tabel -->
                                        <td><?php echo $row['Access_Type']; ?></td> <!-- "Masuk" atau "Keluar" -->
                                        <td><?php echo $row['Record_Date']; ?></td>
                                        <td><?php echo $row['Record_Time']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include 'assets/components/footer.php'; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
