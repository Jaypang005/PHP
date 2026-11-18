<?php
require_once '../config/db.php';

$sql = 'SELECT * FROM users ORDER BY id';
$result = $conn->query($sql);

$title = 'ผู้ใช้';
require_once '../includes/header.php';
?>
<h1 class="h3">ผู้ใช้</h1>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-success"><?= $_GET['msg'] ?></div>
<?php endif; ?>

<a href="create.php" class="btn btn-primary mb-3">+ เพิ่มผู้ใช้</a>

<table class="table table-bordered">
<tr>
<th>รหัส</th>
<th>ชื่อ-สกุล</th>
<th>อีเมล</th>
<th>บทบาท</th>
<th>ตำแหน่ง</th>
<th>จัดการ</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['role'] ?></td>
<td><?= $row['position'] ?></td>
<td>
<a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
<a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<?php require_once '../includes/footer.php'; ?>
