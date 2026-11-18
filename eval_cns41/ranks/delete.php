<?php
require_once '../config/db.php';

// รับเฉพาะ POST: ถ้าเปิดลิงก์ตรง ๆ ให้เด้งกลับ
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

try {
    $stmt = mysqli_prepare($conn, 'DELETE FROM academic_ranks WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: index.php?msg=' . urlencode('ลบวิทยฐานะเรียบร้อย'));
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {   // 1451 = ถูก foreign key อ้างถึง (RESTRICT)
        header('Location: index.php?error=' . urlencode('ลบไม่ได้ เพราะมีบุคลากรหรือแบบประเมินใช้วิทยฐานะนี้อยู่'));
    } else {
        header('Location: index.php?error=' . urlencode('เกิดข้อผิดพลาด: ' . $e->getMessage()));
    }
}
exit;