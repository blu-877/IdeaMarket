<?php

session_start();

include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, name, email, password, user_type
         FROM users
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_type"] = $user["user_type"];

            header("Location: dashboard.php");
            exit;

        } else {

            $message = "كلمة المرور غير صحيحة";

        }

    } else {

        $message = "البريد الإلكتروني غير موجود";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>تسجيل الدخول</title>

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

        <a href="register.php">
            إنشاء حساب
        </a>

    </nav>

</header>

<section class="form-section">

    <div class="form-box">

        <h2>تسجيل الدخول</h2>

        <?php if ($message != ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <label>
                البريد الإلكتروني
            </label>

            <input
                type="email"
                name="email"
                required
            >

            <label>
                كلمة المرور
            </label>

            <input
                type="password"
                name="password"
                required
            >

            <button type="submit">
                تسجيل الدخول
            </button>

        </form>

    </div>

</section>

</body>
</html>