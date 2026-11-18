<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'ระบบประเมินบุคลากร') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/eval/">ระบบประเมินบุคลากร</a>
        <div>
            <a class="text-white me-3" href="/eval/departments/">แผนกวิชา</a>
            <a class="text-white" href="/eval_cns41/ranks/">วิทยฐานะ</a>
        </div>
    </div>
</nav>
<div class="container">
