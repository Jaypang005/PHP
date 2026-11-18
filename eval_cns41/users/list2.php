<?php
require_once '../config/db.php';

$sql = 'SELECT users.id, users.full_name, departments.name
FROM users, departments
WHERE users.department_id = departments.id
ORDER BY users.id';
$result = $conn->query($sql);

$title = 'ผู้ใช้และแผนก';
require_once '../includes/header.php';
?>
<h1 class="h3">ผู้ใช้และแผนก</h1>

<table class="table table-bordered">
<tr>
<th>รหัส</th>
<th>ชื่อ-สกุล</th>
<th>แผนก</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['name'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<?php require_once '../includes/footer.php'; ?>
