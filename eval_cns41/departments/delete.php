<?php
require_once '../config/db.php';
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
 
$id = (int) ($_POST['id'] ?? 0);
 
try {
    $stmt = mysqli_prepare($conn, 'DELETE FROM departments WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: index.php?msg=' . urlencode('ลบแผนกเรียบร้อย'));
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        header('Location: index.php?error=' . urlencode('ลบไม่ได้ เพราะยังมีบุคลากรอยู่ในแผนกนี้'));
    } else {
        throw $e;
    }
}
exit;
