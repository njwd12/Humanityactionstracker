<?php
// Започни сесија
session_start();

// Проверка дали корисникот е најавен
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Почетна</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Стилизација останува иста */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar {
            background-color: #2c3e50;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ecf0f1 !important;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #1abc9c !important;
        }
        .hero {
            background: linear-gradient(to right, #1abc9c, #16a085);
            color: white;
            padding: 120px 20px;
            text-align: center;
            transition: background 0.5s;
            position: relative;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            animation: fadeInUp 1.5s ease-out;
        }
        .hero .btn {
            background-color: #ecf0f1;
            color: #2c3e50;
            border-radius: 30px;
            padding: 12px 25px;
            font-size: 1.1rem;
            text-transform: uppercase;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
        }
        .hero .btn:hover {
            background-color: #16a085;
            transform: translateY(-3px);
        }
        /* Стил и анимации за ID */
        .user-id {
            font-size: 2.5rem;
            color: #ecf0f1;
            background: rgba(0, 0, 0, 0.3);
            padding: 15px 30px;
            border-radius: 10px;
            display: inline-block;
            animation: zoomIn 1s ease-in-out, glow 2s infinite alternate;
        }
        @keyframes zoomIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        @keyframes glow {
            from {
                box-shadow: 0 0 10px #1abc9c;
            }
            to {
                box-shadow: 0 0 20px #16a085;
            }
        }
        .section-title {
            text-align: center;
            margin: 40px 0;
            color: #34495e;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Почетна</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">За нас</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Карактеристики</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Контакт</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Одјави се</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Добредојдовте на Трекер за хуманитарни акции</h1>
            <p>Вашето уникатно ID за креирање на акции и настани е:</p>
            <span class="user-id"><?php echo htmlspecialchars($user_id); ?></span>
            <p>Организирајте ги вашите податоци на лесен и брз начин.</p>
            <a href="actions.php" class="btn">Почнете веднаш</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <h2 class="section-title">За нас</h2>
            <p class="text-center">Нашата апликација е наменета за едноставно и ефикасно управување со вашите податоци. Нудиме сигурност, брзина и модерна технологија која ги задоволува сите ваши потреби.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Карактеристики</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Управување со корисници</h5>
                            <p class="card-text">Додавајте, менувајте и бришете корисници лесно преку нашиот систем.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Организација на кампањи</h5>
                            <p class="card-text">Креирајте и следете кампањи за хуманитарни активности со само неколку клика.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Евиденција на донации</h5>
                            <p class="card-text">Прегледувајте и управувајте ги вашите донации на транспарентен начин.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <h2 class="section-title">Контакт</h2>
        <p class="text-center">Доколку имате прашања, слободно контактирајте не преку формуларот подолу.</p>
        <form action="send_email.php" method="POST" class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="name" class="form-label">Вашето име</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Вашиот email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Вашата порака</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <!-- Add a hidden field with the user's email -->
            <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>">
            <button type="submit" class="btn btn-primary w-100">Испрати порака</button>
        </form>
    </div>
</section>


    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Трекер за хуманитарни акции. Сите права задржани.</p>
    </footer>

</body>
</html>
