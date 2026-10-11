<?php

session_start();

include "config/database.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;

}

if (!isset($_GET["id"])) {

    header("Location: ideas.php");
    exit;

}

$idea_id = intval($_GET["id"]);
$buyer_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, title, price
     FROM ideas
     WHERE id = ?
     AND status = 'approved'"
);

$stmt->bind_param("i", $idea_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    die("الفكرة غير موجودة");

}

$idea = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check = $conn->prepare(
        "SELECT id
         FROM purchases
         WHERE buyer_id = ?
         AND idea_id = ?"
    );

    $check->bind_param(
        "ii",
        $buyer_id,
        $idea_id
    );

    $check->execute();

    $already = $check->get_result();

    if ($already->num_rows > 0) {

        $message = "أنت اشتريت هذه الفكرة مسبقًا";

    } else {

        $insert = $conn->prepare(
            "INSERT INTO purchases
            (buyer_id, idea_id, price)
            VALUES (?, ?, ?)"
        );

        $insert->bind_param(
            "iid",
            $buyer_id,
            $idea_id,
            $idea["price"]
        );

        if ($insert->execute()) {

            $message = "تم شراء الفكرة بنجاح ✅";

        } else {

            $message = "حدث خطأ أثناء عملية الشراء";

        }

        $insert->close();
    }

    $check->close();
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>شراء الفكرة</title>

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

    </nav>

</header>

<section class="form-section">

    <div class="form-box">

        <h2>
            شراء الفكرة
        </h2>

        <p>
            اسم الفكرة:
            <?= htmlspecialchars($idea["title"]) ?>
        </p>

        <br>

        <p class="price">

            السعر:

            <?= number_format($idea["price"], 2) ?>

            ريال

        </p>

        <?php if ($message != ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php else: ?>

            <form method="POST">

                <button type="submit">
                    تأكيد الشراء التجريبي
                </button>

            </form>

        <?php endif; ?>

    </div>

</section>

</body>
</html>