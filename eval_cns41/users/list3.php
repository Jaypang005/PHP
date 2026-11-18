<?php
require_once '../config/db.php';

$sql = 'SELECT users.id, users.full_name,
departments.name AS dept_name,
academic_ranks.name AS rank_name
FROM users, departments, academic_ranks
WHERE users.department_id = departments.id
AND users.academic_rank_id = academic_ranks.id
ORDER BY users.id';
$result = $conn->query($sql);

$title = 'ผู้ใช้ แผนก และวิทยฐานะ';
require_once '../includes/header.php';
?>
<h1 class="h3">ผู้ใช้ แผนก และวิทยฐานะ</h1>

<table class="table table-bordered">
<tr>
<th>รหัส</th>
<th>ชื่อ-สกุล</th>
<th>แผนก</th>
<th>วิทยฐานะ</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['dept_name'] ?></td>
<td><?= $row['rank_name'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<?php require_once '../includes/footer.php'; ?>
