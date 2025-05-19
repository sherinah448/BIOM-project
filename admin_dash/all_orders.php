<?php
include '../db_config.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update status
    if (isset($_POST['update_status'])) {
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['status'];

        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();
        $stmt->close();
    }

    // Delete order
    if (isset($_POST['delete_order'])) {
        $orderId = $_POST['order_id'];
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect after action
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>All Orders</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'slider.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">All Orders</h1>
                    <p class="mb-4">Manage, update, and delete order records.</p>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Order List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                            <th>Order No.</th>
                                            <th>Total Price</th>
                                            <th>Status (Inline)</th>
                                            <th>Date</th>
                                            <th>Update (Extra)</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                                <td><?= htmlspecialchars($row['customer_address']) ?></td>
                                                <td><?= $row['order_number'] ?></td>
                                                <td>UGX <?= number_format($row['total_amount']) ?></td>
                                                
                                                <!-- Inline Update -->
                                                <td>
                                                    <form method="POST">
                                                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                                        <div class="input-group">
                                                            <select name="status" class="custom-select">
                                                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                <option value="paid" <?= $row['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                                                <option value="confirmed" <?= $row['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>

                                                <td><?= $row['created_at'] ?></td>

                                                <!-- Separate Update -->
                                                <td>
                                                    <form method="POST">
                                                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                                        <select name="status" class="form-control mb-2">
                                                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="paid" <?= $row['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                                            <option value="confirmed" <?= $row['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        </select>
                                                        <button type="submit" name="update_status" class="btn btn-sm btn-success">Apply</button>
                                                    </form>
                                                </td>

                                                <!-- Delete Button -->
                                                <td>
                                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                                        <button type="submit" name="delete_order" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto text-center">
                    <span>Copyright &copy; Your Website 2025</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
