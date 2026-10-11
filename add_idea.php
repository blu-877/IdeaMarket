<?php

session_start();

include "config/database.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;

}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $category_id = $_POST["category_id"];
    $price = $_POST["price"];

    if (
        empty($title) ||
        empty($description) ||
        empty($category_id) ||
        empty($price)
    ) {

        $message = "يرجى تعبئة جميع البيانات";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO ideas
            (user_id, title, description, category_id, price, status)
            VALUES (?, ?, ?, ?, ?, 'pending')"
        );

        $stmt->bind_param(
            "issid",
            $_SESSION["user_id"],
            $title,
            $description,
            $category_id,
            $price
        );

        if ($stmt->execute()) {

            $message = "تم إرسال الفكرة للمراجعة ✅";

        } else {

            $message = "حدث خطأ";

        }

        $stmt->close();
    }
}

$categories = $conn->query(
    "SELECT * FROM categories ORDER BY name"
);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>إضافة فكرة</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<header>

    <div class="logo">
        💡 منصة فكرة
    </div>

    <nav>

        <a href="index.php">الرئيسية</a>
        <a href="ideas.php">الأفكار</a>
        <a href="dashboard.php">لوحة التحكم</a>

    </nav>

</header>

<section class="form-section">

    <div class="form-box">

        <h2>
            إضافة فكرة جديدة
        </h2>

        <?php if ($message != ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <label>
                اسم الفكرة
            </label>

            <input
                type="text"
                name="title"
                required
            >

            <label>
                التصنيف
            </label>

            <select name="category_id" required>

                <option value="">
                    اختر التصنيف
                </option>

                <?php while ($category = $categories->fetch_assoc()): ?>

                    <option value="<?= $category["id"] ?>">

                        <?= htmlspecialchars($category["name"]) ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <label>
                وصف الفكرة
            </label>

            <textarea
                name="description"
                required
            ></textarea>

            <label>
                السعر بالريال
            </label>

            <input
                type="number"
                name="price"
                min="1"
                step="0.01"
                required
            >

            <button type="submit">
                إرسال الفكرة
            </button>

        </form>

    </div>

</section>

</body>
</html>