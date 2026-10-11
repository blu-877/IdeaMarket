<?php

session_start();

include "config/database.php";

if (!isset($_GET["id"])) {

    header("Location: ideas.php");
    exit;

}

$id = intval($_GET["id"]);

$stmt = $conn->prepare(
    "SELECT
        ideas.*,
        categories.name AS category_name
     FROM ideas
     LEFT JOIN categories
     ON ideas.category_id = categories.id
     WHERE ideas.id = ?
     AND ideas.status = 'approved'"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    die("الفكرة غير موجودة");

}

$idea = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($idea["title"]) ?>
    </title>

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

    </nav>

</header>

<section class="form-section">

    <div class="form-box">

        <h2>
            <?= htmlspecialchars($idea["title"]) ?>
        </h2>

        <p>
            التصنيف:
            <?= htmlspecialchars($idea["category_name"]) ?>
        </p>

        <br>

        <p>
            <?= nl2br(htmlspecialchars($idea["description"])) ?>
        </p>

        <br>

        <p class="price">

            السعر:

            <?= number_format($idea["price"], 2) ?>

            ريال

        </p>

        <br>

        <?php if (isset($_SESSION["user_id"])): ?>

            <a
                href="buy.php?id=<?= $idea["id"] ?>"
                class="btn"
            >
                شراء الفكرة
            </a>

        <?php else: ?>

            <a
                href="login.php"
                class="btn"
            >
                سجل الدخول للشراء
            </a>

        <?php endif; ?>

    </div>

</section>

</body>
</html>