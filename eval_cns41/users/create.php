<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $position = $_POST['position'];

    $stmt = $conn->prepare('INSERT INTO users (full_name, email, password_hash, role, position) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $full_name, $email, $password, $role, $position);
    $stmt->execute();

    header('Location: index.php?msg=เพิ่มผู้ใช้เรียบร้อย');
    exit;
}

$title = 'เพิ่มผู้ใช้';
require_once '../includes/header.php';
?>
<h1 class="h3">เพิ่มผู้ใช้</h1>

<form method="post">
<p>ชื่อ-สกุล <input type="text" name="full_name" class="form-control" required></p>
<p>อีเมล <input type="email" name="email" class="form-control" required></p>
<p>รหัสผ่าน <input type="password" name="password" class="form-control" required></p>
<p>บทบาท
<select name="role" class="form-select">
<option value="evaluatee">evaluatee (ผู้รับการประเมิน)</option>
<option value="evaluator">evaluator (กรรมการ)</option>
<option value="admin">admin (ฝ่ายบริหาร)</option>
</select>
</p>
<p>ตำแหน่ง <input type="text" name="position" class="form-control"></p>
<button type="submit" class="btn btn-primary">บันทึก</button>
<a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>

<?php require_once '../includes/footer.php'; ?>
