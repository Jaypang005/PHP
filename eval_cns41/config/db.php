<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'eval_cns41';
 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 
try {
    $conn = mysqli_connect($host, $username, $password, $dbname);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('เชื่อมต่อฐานข้อมูลไม่สำเร็จ: ' . $e->getMessage());
}
    