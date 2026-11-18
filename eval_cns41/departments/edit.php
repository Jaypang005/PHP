<?php
require_once '../config/db.php';
 
$id = (int) ($_GET['id'] ?? 0);
 
$stmt = mysqli_prepare($conn, 'SELECT * FROM departments WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$department = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
 
if (!$department) {
    header('Location: index.php?error=' . urlencode('ไม่พบแผนกที่ต้องการแก้ไข'));
    exit;
}
 
$name = $department['name'];
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
 
    if ($name === '') {
        $error = 'กรุณากรอกชื่อแผนก';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM departments WHERE name = ? AND id <> ?');
        mysqli_stmt_bind_param($stmt, 'si', $name, $id);
        mysqli_stmt_execute($stmt);
        $found = mysqli_stmt_get_result($stmt);
 
        if (mysqli_num_rows($found) > 0) {
            $error = 'มีแผนกชื่อนี้อยู่แล้ว';
        } else {
            $stmt = mysqli_prepare($conn, 'UPDATE departments SET name = ? WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'si', $name, $id);
            mysqli_stmt_execute($stmt);
            header('Location: index.php?msg=' . urlencode('แก้ไขแผนกเรียบร้อย'));
            exit;
        }
    }
}
 
$title = 'แก้ไขแผนก';
require_once '../includes/header.php';
?>
<h1 class="h3">แก้ไขแผนก</h1>
 
<?php if ($error !== ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
 
<form method="post">
    <div class="mb-3">
        <label class="form-label">ชื่อแผนก</label>
        <input type="text" name="name" class="form-control"
               value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
    <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>
 
<?php require_once '../includes/footer.php'; ?>
