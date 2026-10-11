<?php
include "config/database.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>منصة فكرة</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- رأس الصفحة -->
    <header>

        <div class="logo">
            💡 منصة فكرة
        </div>

        <nav>
            <a href="index.php">الرئيسية</a>
            <a href="ideas.php">الأفكار</a>
            <a href="add_idea.php">أضف فكرة</a>
            <a href="login.php">تسجيل الدخول</a>
            <a href="register.php">إنشاء حساب</a>
        </nav>

    </header>


    <!-- القسم الرئيسي -->
    <section class="hero">

        <h1>
            حوّل فكرتك إلى قيمة 💡
        </h1>

        <p>
            منصة لبيع وشراء الأفكار المبتكرة
        </p>

        <a href="ideas.php" class="btn">
            تصفح الأفكار
        </a>

    </section>


    <!-- قسم أحدث الأفكار -->
    <section class="ideas">

        <h2>
            أحدث الأفكار
        </h2>

        <div class="cards">


            <!-- الفكرة الأولى -->
            <div class="card">

                <h3>
                    تطبيق توصيل
                </h3>

                <p>
                    فكرة تطبيق يساعد المتاجر المحلية
                    على توصيل منتجاتها للعملاء.
                </p>

                <p class="price">
                    السعر: 500 ريال
                </p>

                <a href="ideas.php" class="btn">
                    عرض الأفكار
                </a>

            </div>


            <!-- الفكرة الثانية -->
            <div class="card">

                <h3>
                    منصة تعليمية
                </h3>

                <p>
                    منصة تربط الطلاب بالمدربين
                    بطريقة مبتكرة وسهلة.
                </p>

                <p class="price">
                    السعر: 750 ريال
                </p>

                <a href="ideas.php" class="btn">
                    عرض الأفكار
                </a>

            </div>


            <!-- الفكرة الثالثة -->
            <div class="card">

                <h3>
                    متجر إلكتروني
                </h3>

                <p>
                    فكرة متجر متخصص في بيع
                    المنتجات المحلية.
                </p>

                <p class="price">
                    السعر: 1000 ريال
                </p>

                <a href="ideas.php" class="btn">
                    عرض الأفكار
                </a>

            </div>


        </div>

    </section>


    <!-- التذييل -->
    <footer>

        <p>
            جميع الحقوق محفوظة © 2026 - منصة فكرة
        </p>

    </footer>

</body>

</html>