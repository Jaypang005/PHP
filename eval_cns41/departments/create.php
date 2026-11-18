<?php
require_once '../config/db.php';
 
$name = '';
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
 
    if ($name === '') {
        $error = 'กรุณากรอกชื่อแผนก';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM departments WHERE name = ?');
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        $found = mysqli_stmt_get_result($stmt);
 
        if (mysqli_num_rows($found) > 0) {
            $error = 'มีแผนกชื่อนี้อยู่แล้ว';
        } else {
            $stmt = mysqli_prepare($conn, 'INSERT INTO departments (name) VALUES (?)');
            mysqli_stmt_bind_param($stmt, 's', $name);
            mysqli_stmt_execute($stmt);
            header('Location: index.php?msg=' . urlencode('เพิ่มแผนกเรียบร้อย'));
            exit;
        }
    }
}
 
$title = 'เพิ่มแผนก';
require_once '../includes/header.php';
?>
<h1 class="h3">เพิ่มแผนก</h1>
 
<?php if ($error !== ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
 
<form method="post">
    <div class="mb-3">
        <label class="form-label">ชื่อแผนก</label>
        <input type="text" name="name" class="form-control"
               value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
    <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>
 
<?php require_once '../includes/footer.php'; ?>
