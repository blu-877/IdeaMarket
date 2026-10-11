<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>لوحة التحكم</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<header>

    <div class="logo">
        💡 منصة فكرة
    </div>

    <nav>

        <a href="index.php">
            الرئيسية
        </a>

        <a href="ideas.php">
            الأفكار
        </a>

        <a href="add_idea.php">
            إضافة فكرة
        </a>

        <a href="logout.php">
            تسجيل الخروج
        </a>

    </nav>

</header>

<section class="hero">

    <h1>
        أهلاً <?= htmlspecialchars($_SESSION["user_name"]) ?> 👋
    </h1>

    <p>
        نوع الحساب:
        <?= htmlspecialchars($_SESSION["user_type"]) ?>
    </p>

    <br>

    <a href="add_idea.php" class="btn">
        إضافة فكرة
    </a>

    <a href="ideas.php" class="btn">
        تصفح الأفكار
    </a>

</section>

</body>
</html>