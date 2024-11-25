<?php
include('php/config.php');

// Query untuk mengambil data level api
$SQL = "SELECT * FROM `sensor_box_01` ORDER BY `Record_Date` DESC, `Record_Time` DESC LIMIT 100;"; // Mengambil data dari tabel sensor
$stmt = $conn->prepare($SQL);
$stmt->execute();
$flame_data = $stmt->get_result();
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
                <h1 class="mt-4">Pemantauan Api</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemantauan Api</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        DataTable Pemantauan Api
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Record Date</th>
                                    <th>Record Time</th>
                                    <th>Flame Status</th>
                                    <th>Smoke Level</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Record Date</th>
                                    <th>Record Time</th>
                                    <th>Flame Status</th>
                                    <th>Smoke Level</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php while ($row = $flame_data->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['Record_ID']; ?></td>
                                        <td><?php echo $row['Record_Date']; ?></td>
                                        <td><?php echo $row['Record_Time']; ?></td>
                                        <td><?php echo $row['Flame_Status'] ? 'Terbakar' : 'Tidak Terbakar'; ?></td>
                                        <td><?php echo $row['Smoke_Level']; ?> %</td>
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
