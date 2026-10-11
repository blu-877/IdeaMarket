<?php

session_start();

include "config/database.php";

if (!isset($_SESSION["user_id"]) ||
    $_SESSION["user_type"] != "admin") {

    die("غير مصرح لك بالدخول");

}

if (isset($_GET["approve"])) {

    $id = intval($_GET["approve"]);

    $stmt = $conn->prepare(
        "UPDATE ideas
         SET status = 'approved'
         WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_GET["reject"])) {

    $id = intval($_GET["reject"]);

    $stmt = $conn->prepare(
        "UPDATE ideas
         SET status = 'rejected'
         WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$result = $conn->query(
    "SELECT
        ideas.*,
        users.name AS seller_name,
        categories.name AS category_name

     FROM ideas

     JOIN users
     ON ideas.user_id = users.id

     LEFT JOIN categories
     ON ideas.category_id = categories.id

     WHERE ideas.status = 'pending'

     ORDER BY ideas.created_at DESC"
);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>لوحة المدير</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<header>

    <div class="logo">
        💡 لوحة المدير
    </div>

    <nav>

        <a href="index.php">
            الرئيسية
        </a>

        <a href="logout.php">
            تسجيل الخروج
        </a>

    </nav>

</header>

<section class="ideas">

    <h2>
        الأفكار قيد المراجعة
    </h2>

    <div class="cards">

        <?php while ($idea = $result->fetch_assoc()): ?>

            <div class="card">

                <h3>
                    <?= htmlspecialchars($idea["title"]) ?>
                </h3>

                <p>
                    البائع:
                    <?= htmlspecialchars($idea["seller_name"]) ?>
                </p>

                <p>
                    <?= htmlspecialchars($idea["description"]) ?>
                </p>

                <p class="price">

                    <?= number_format($idea["price"], 2) ?>

                    ريال

                </p>

                <a
                    href="admin.php?approve=<?= $idea["id"] ?>"
                    class="btn"
                >
                    قبول
                </a>

                <br><br>

                <a
                    href="admin.php?reject=<?= $idea["id"] ?>"
                    class="btn"
                >
                    رفض
                </a>

            </div>

        <?php endwhile; ?>

    </div>

</section>

</body>
</html>