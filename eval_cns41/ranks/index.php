<?php
require_once '../config/db.php';

// นับบุคลากรของแต่ละวิทยฐานะ: LEFT JOIN เพื่อให้วิทยฐานะที่ไม่มีคนใช้ยังแสดง (นับเป็น 0)
$sql = 'SELECT r.id, r.name, r.sort_order, COUNT(u.id) AS user_count
        FROM academic_ranks r
        LEFT JOIN users u ON u.academic_rank_id = r.id
        GROUP BY r.id, r.name, r.sort_order
        ORDER BY r.sort_order, r.id';
$result = mysqli_query($conn, $sql);

$title = 'วิทยฐานะ';
require_once '../includes/header.php';
?>
<h1 class="h3">วิทยฐานะ</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<a href="create.php" class="btn btn-primary mb-3">+ เพิ่มวิทยฐานะ</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อวิทยฐานะ</th>
            <th>จำนวนบุคลากร</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['sort_order'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['user_count'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                <form method="post" action="delete.php" class="d-inline"
                      onsubmit="return confirm('ยืนยันการลบวิทยฐานะนี้?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php require_once '../includes/footer.php'; ?>