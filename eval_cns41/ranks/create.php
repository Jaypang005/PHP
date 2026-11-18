<?php
require_once '../config/db.php';

$errors = [];
$name = '';
$sort_order = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    // ตรวจข้อมูลก่อน INSERT
    if ($name === '') {
        $errors[] = 'กรุณากรอกชื่อวิทยฐานะ';
    }
    if ($sort_order < 1) {
        $errors[] = 'ลำดับต้องเป็นตัวเลขตั้งแต่ 1 ขึ้นไป';
    }

    if (!$errors) {
        try {
            $stmt = mysqli_prepare($conn, 'INSERT INTO academic_ranks (name, sort_order) VALUES (?, ?)');
            mysqli_stmt_bind_param($stmt, 'si', $name, $sort_order);
            mysqli_stmt_execute($stmt);
            // Post/Redirect/Get: กัน F5 แล้วบันทึกซ้ำ
            header('Location: index.php?msg=' . urlencode('เพิ่มวิทยฐานะเรียบร้อย'));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {            // 1062 = ค่าซ้ำในคอลัมน์ UNIQUE
                $errors[] = 'ชื่อวิทยฐานะนี้มีอยู่แล้ว';
            } else {
                $errors[] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
            }
        }
    }
}

$title = 'เพิ่มวิทยฐานะ';
require_once '../includes/header.php';
?>
<h1 class="h3">เพิ่มวิทยฐานะ</h1>

<?php foreach ($errors as $err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endforeach; ?>

<form method="post">
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