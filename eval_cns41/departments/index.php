<?php
require_once '../config/db.php';
 
$sql = 'SELECT d.id, d.name, COUNT(u.id) AS user_count
        FROM departments d
        LEFT JOIN users u ON u.department_id = d.id
        GROUP BY d.id, d.name
        ORDER BY d.id';
$result = mysqli_query($conn, $sql);
 
$title = 'แผนกวิชา';
require_once '../includes/header.php';
?>
<h1 class="h3">แผนกวิชา</h1>
 
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>
 
<a href="create.php" class="btn btn-primary mb-3">+ เพิ่มแผนก</a>
 
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>รหัส</th>
            <th>ชื่อแผนก</th>
            <th>จำนวนบุคลากร</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['user_count'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="delete.php" method="post" class="d-inline"
                      onsubmit="return confirm('ยืนยันการลบแผนกนี้?')">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<p>ทั้งหมด <?= mysqli_num_rows($result) ?> แผนก</p>
 
<?php require_once '../includes/footer.php'; ?>
