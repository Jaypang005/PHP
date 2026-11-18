<?php
require_once '../config/db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $position = $_POST['position'];

    $stmt = $conn->prepare('UPDATE users SET full_name = ?, email = ?, role = ?, position = ? WHERE id = ?');
    $stmt->bind_param('ssssi', $full_name, $email, $role, $position, $id);
    $stmt->execute();

    header('Location: index.php?msg=แก้ไขผู้ใช้เรียบร้อย');
    exit;
}

$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$title = 'แก้ไขผู้ใช้';
require_once '../includes/header.php';
?>
<h1 class="h3">แก้ไขผู้ใช้</h1>

<form method="post">
<p>ชื่อ-สกุล <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?>" required></p>
<p>อีเมล <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required></p>
<p>บทบาท
<select name="role" class="form-select">
<option value="<?= $user['role'] ?>"><?= $user['role'] ?> (ค่าเดิม)</option>
<option value="evaluatee">evaluatee (ผู้รับการประเมิน)</option>
<option value="evaluator">evaluator (กรรมการ)</option>
<option value="admin">admin (ฝ่ายบริหาร)</option>
</select>
</p>
<p>ตำแหน่ง <input type="text" name="position" class="form-control" value="<?= $user['position'] ?>"></p>
<button type="submit" class="btn btn-primary">บันทึก</button>
<a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>

<?php require_once '../includes/footer.php'; ?>
