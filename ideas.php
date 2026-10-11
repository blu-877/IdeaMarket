<?php

include "config/database.php";

$sql = "
    SELECT
        ideas.*,
        categories.name AS category_name
    FROM ideas

    LEFT JOIN categories
    ON ideas.category_id = categories.id

    WHERE ideas.status = 'approved'

    ORDER BY ideas.created_at DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>الأفكار</title>

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

        <a href="dashboard.php">
            لوحة التحكم
        </a>

    </nav>

</header>

<section class="ideas">

    <h2>
        الأفكار المتاحة
    </h2>

    <div class="cards">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($idea = $result->fetch_assoc()): ?>

                <div class="card">

                    <h3>
                        <?= htmlspecialchars($idea["title"]) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($idea["description"]) ?>
                    </p>

                    <p>
                        التصنيف:
                        <?= htmlspecialchars($idea["category_name"]) ?>
                    </p>

                    <p class="price">

                        <?= number_format($idea["price"], 2) ?>

                        ريال

                    </p>

                    <a
                        href="idea_details.php?id=<?= $idea["id"] ?>"
                        class="btn"
                    >
                        التفاصيل
                    </a>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p>
                لا توجد أفكار متاحة حاليًا.
            </p>

        <?php endif; ?>

    </div>

</section>

</body>
</html>