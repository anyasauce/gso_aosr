<?php
require_once '../config/init.php';

if (isset($_POST['update_status'])) {
        $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    $stmt = $conn->prepare("UPDATE requests SET status = ?, remarks = ? WHERE id = ?");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssi", $status, $remarks, $request_id);

    if ($stmt->execute()) {
        ?>
        <script>
            alert("Status updated successfully!");
            window.location.href = "../views/admin/capitol.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Error updating status: <?= $stmt->error ?>");
            window.history.back();
        </script>
        <?php
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../views/admin/index.php");
    exit();
}