<?php
require_once '../config/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($name === '') {
        $errors[] = 'กรุณากรอกชื่อวิทยฐานะ';
    }
    if ($sort_order < 1) {
        $errors[] = 'ลำดับต้องเป็นตัวเลขตั้งแต่ 1 ขึ้นไป';
    }

    if (!$errors) {
        try {
            $stmt = mysqli_prepare($conn, 'UPDATE academic_ranks SET name = ?, sort_order = ? WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'sii', $name, $sort_order, $id);
            mysqli_stmt_execute($stmt);
            header('Location: index.php?msg=' . urlencode('แก้ไขวิทยฐานะเรียบร้อย'));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $errors[] = 'ชื่อวิทยฐานะนี้มีอยู่แล้ว';
            } else {
                $errors[] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
            }
        }
    }
} else {
    // GET: ดึงข้อมูลเดิมมาใส่ฟอร์ม
    $id = (int)($_GET['id'] ?? 0);
    $stmt = mysqli_prepare($conn, 'SELECT name, sort_order FROM academic_ranks WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$row) {
        header('Location: index.php?error=' . urlencode('ไม่พบวิทยฐานะที่ต้องการแก้ไข'));
        exit;
    }
    $name = $row['name'];
    $sort_order = (int)$row['sort_order'];
}

$title = 'แก้ไขวิทยฐานะ';
require_once '../includes/header.php';
?>
<h1 class="h3">แก้ไขวิทยฐานะ</h1>

<?php foreach ($errors as $err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endforeach; ?>

<form method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="mb-3">
        <label class="form-label">ชื่อวิทยฐานะ</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">ลำดับการแสดงผล</label>
        <input type="number" name="sort_order" min="1" class="form-control" value="<?= $sort_order ?>">
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
    <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>
<?php require_once '../includes/footer.php'; ?>