<?php

include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];

    if (empty($name) || empty($email) || empty($password)) {

        $message = "يرجى تعبئة جميع الحقول";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "البريد الإلكتروني غير صحيح";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "البريد الإلكتروني مستخدم مسبقًا";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users
                (name, email, password, user_type)
                VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashed_password,
                $user_type
            );

            if ($stmt->execute()) {

                $message = "تم إنشاء الحساب بنجاح ✅";

            } else {

                $message = "حدث خطأ أثناء إنشاء الحساب";

            }

            $stmt->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>إنشاء حساب</title>

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

        <a href="login.php">
            تسجيل الدخول
        </a>

    </nav>

</header>

<section class="form-section">

    <div class="form-box">

        <h2>إنشاء حساب</h2>

        <?php if ($message != ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <label>الاسم</label>

            <input
                type="text"
                name="name"
                required
            >

            <label>البريد الإلكتروني</label>

            <input
                type="email"
                name="email"
                required
            >

            <label>كلمة المرور</label>

            <input
                type="password"
                name="password"
                required
            >

            <label>نوع الحساب</label>

            <select name="user_type">

                <option value="buyer">
                    مشتري أفكار
                </option>

                <option value="seller">
                    بائع أفكار
                </option>

            </select>

            <button type="submit">
                إنشاء الحساب
            </button>

        </form>

    </div>

</section>

</body>
</html>