<?php
session_start();
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
    <title>Трекер за хуманитарни акции</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #7209b7;
            --bg-light: #f8f9fa;
            --text-light: #212529;
            --bg-dark: #121212;
            --text-dark: #e0e0e0;
            --card-dark: #1e1e1e;
            --border-dark: #333;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light);
            overflow-x: hidden;
            transition: all 0.3s ease;
        }
        
        body.dark-mode {
            background-color: var(--bg-dark) !important;
            color: var(--text-dark) !important;
        }
        
        /* Dark mode adaptations */
        .dark-mode .navbar {
            background: rgba(30, 30, 30, 0.95) !important;
        }
        
        .dark-mode .card,
        .dark-mode .stat-box,
        .dark-mode .feature-card,
        .dark-mode .contact-form {
            background-color: var(--card-dark) !important;
            border-color: var(--border-dark) !important;
        }
        
        .dark-mode .form-control {
            background-color: #2a2a2a;
            color: var(--text-dark);
            border-color: #444;
        }
        
        /* Modern Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .dark-mode .navbar {
            background: rgba(30, 30, 30, 0.95) !important;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            position: relative;
            padding: 0.5rem 0;
        }
        
        .dark-mode .nav-link {
            color: var(--text-dark) !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8rem 0 6rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
        }
        
        .hero h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .hero-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .user-id {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-block;
            margin: 0.5rem 0;
        }
        
        /* 3D Heart Animation */
        .heart-3d {
            width: 100px;
            height: 100px;
            position: relative;
            transform-style: preserve-3d;
            animation: float-rotate 8s ease-in-out infinite;
            margin: 0 auto;
        }
        
        .heart-3d:before, .heart-3d:after {
            content: "";
            position: absolute;
            top: 0;
            width: 50px;
            height: 80px;
            background: #ff3e3e;
            border-radius: 50px 50px 0 0;
            transform: rotate(-45deg);
            transform-origin: 0 100%;
        }
        
        .heart-3d:after {
            left: 50px;
            transform: rotate(45deg);
            transform-origin: 100% 100%;
        }
        
        @keyframes float-rotate {
            0% { transform: rotateY(0) translateY(0) scale(1); }
            25% { transform: rotateY(90deg) translateY(-10px) scale(1.1); }
            50% { transform: rotateY(180deg) translateY(0) scale(1); }
            75% { transform: rotateY(270deg) translateY(-10px) scale(1.1); }
            100% { transform: rotateY(360deg) translateY(0) scale(1); }
        }
        
        /* Stats Section */
        .stats {
            padding: 5rem 0;
        }
        
        .stat-box {
            text-align: center;
            padding: 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .dark-mode .stat-box {
            background: var(--card-dark);
        }
        
        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .stat-box i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .stat-box h2 {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
            background: var(--light);
        }
        
        .dark-mode .features {
            background: #1a1a1a;
        }
        
        .section-title {
            font-weight: 800;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            bottom: -10px;
            left: 0;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 2px;
        }
        
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }
        
        .feature-card h3 {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        /* About Section */
        .about {
            padding: 6rem 0;
        }
        
        .about-img {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        /* Contact Section */
        .contact {
            padding: 6rem 0;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        
        .dark-mode .contact {
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
        }
        
        .contact-form {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 1.5rem;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Custom Logo Styles */
        .custom-logo {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .custom-logo:hover {
            transform: rotate(15deg) scale(1.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .heart-3d {
                width: 70px;
                height: 70px;
            }
            
            .heart-3d:before, .heart-3d:after {
                width: 35px;
                height: 56px;
            }
            
            .heart-3d:after {
                left: 35px;
            }
        }
    </style>
</head>
<body>
    <!-- Modern Navbar with Dark Mode Toggle -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSIjNDM2MWVlIiBkPSJNMjU2IDQ0OGMtMTA2IDAtMTkyLTg2LTE5Mi0xOTJTMTUwIDY0IDI1NiA2NHMxOTIgODYgMTkyIDE5Mi04NiAxOTItMTkyIDE5MnpNMTI4IDI1NmMwIDcwLjcgNTcuMyAxMjggMTI4IDEyOHMxMjgtNTcuMyAxMjgtMTI4LTU3LjMtMTI4LTEyOC0xMjgtMTI4IDU3LjMtMTI4IDEyOHptOTYtNDBjLTE3LjcgMC0zMiAxNC4zLTMyIDMydjY0YzAgMTcuNyAxNC4zIDMyIDMyIDMyaDY0YzE3LjcgMCAzMi0xNC4zIDMyLTMydi02NGMwLTE3LjctMTQuMy0zMi0zMi0zMmgtNjR6Ii8+PC9zdmc+" 
                     alt="Custom Logo" class="custom-logo">
                Хуманитарни Акции
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Почетна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Функции</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">За нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Контакт</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-moon"></i> Тема
                        </button>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="logout.php">Одјави се</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="animate__animated animate__fadeInDown">Управувајте ги вашите хуманитарни акции</h1>
                    <p class="animate__animated animate__fadeIn animate__delay-1s">Нашата платформа ви овозможува лесно следење и управување со сите ваши хуманитарни иницијативи на едно место.</p>
                    <a href="actions.php" class="btn btn-light btn-lg animate__animated animate__fadeIn animate__delay-2s">
                        Започнете сега <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="hero-card animate__animated animate__fadeIn animate__delay-1s">
                        <h3>Вашето корисничко ID</h3>
                        <div class="user-id animate__animated animate__pulse animate__infinite animate__slow"><?php echo htmlspecialchars($user_id); ?></div>
                        <p class="mt-3">Ова ID го користите за пристап до сите функции на платформата.</p>
                        
                        <!-- 3D Heart Animation -->
                        <div class="heart-3d mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Stats Section -->
<section class="stats">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-box animate__animated animate__fadeInUp">
                    <i class="fas fa-hands-helping"></i>
                    <h2 id="campaigns"><?php
                        require_once 'db_connection.php';
                        $query = "SELECT COUNT(*) as count FROM campaigns";  // Сите кампањи (не само активни)
                        $result = $conn->query($query);
                        if ($result && $result->num_rows > 0) {
                            echo $result->fetch_row()[0] . "+";
                        } else {
                            echo "0+ (Error: " . $conn->error . ")";
                        }
                    ?></h2>
                    <p>Креирани кампањи</p>  <!-- Променет текст -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box animate__animated animate__fadeInUp animate__delay-1s">
                    <i class="fas fa-users"></i>
                    <h2 id="users"><?php
                        $query = "SELECT COUNT(*) as count FROM users";  // Сите корисници
                        $result = $conn->query($query);
                        if ($result && $result->num_rows > 0) {
                            echo $result->fetch_row()[0] . "+";
                        } else {
                            echo "0+ (Error: " . $conn->error . ")";
                        }
                    ?></h2>
                    <p>Регистрирани корисници</p>  <!-- Променет текст -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box animate__animated animate__fadeInUp animate__delay-2s">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h2 id="donations"><?php
                        $query = "SELECT SUM(amount) as total FROM donations";  // Сите донации (не само completed)
                        $result = $conn->query($query);
                        if ($result && $result->num_rows > 0) {
                            $total = $result->fetch_row()[0];
                            echo number_format($total ? $total : 0) . " МКД";
                        } else {
                            echo "0 МКД (Error: " . $conn->error . ")";
                        }
                    ?></h2>
                    <p>Вкупно донирани средства</p>  <!-- Променет текст -->
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title text-center">Нашите функции</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-tachometer-alt"></i>
                        <h3>Контролен панел</h3>
                        <p>Интуитивен контролен панел што ви дава преглед на сите ваши активности и статистики.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Управување со настани</h3>
                        <p>Креирајте и организирајте хуманитарни настани со детали за локација, време и потреби.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-donate"></i>
                        <h3>Следење донации</h3>
                        <p>Транспарентен систем за следење на донациите и нивната распределба.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-chart-line"></i>
                        <h3>Детални аналитики</h3>
                        <p>Генерирајте извештаи и анализирајте ги вашите хуманитарни активности.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-bullhorn"></i>
                        <h3>Промоција</h3>
                        <p>Алатки за промовирање на вашите кампањи преку социјални мрежи.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Безбедност</h3>
                        <p>Напредни безбедносни мерки за заштита на вашите податоци.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">За нашата платформа</h2>
                    <p>Нашата мисија е да го поедноставиме процесот на организација на хуманитарни акции и да ја зголемиме транспарентноста во собирањето и распределбата на донациите.</p>
                    <p>Со користење на најновите технологии, создадовме решение што им помага на организациите да фокусираат на она што е навистина важно - помагањето на оние кои најмногу ни требаат.</p>
                    <div class="mt-4">
                        <a href="#contact" class="btn btn-primary me-2">Контактирајте не</a>
                        <a href="#" class="btn btn-outline-primary">Дознајте повеќе</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="about-img floating">
                        <img src="https://images.unsplash.com/photo-1521791055366-0d553872125f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Team working" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Contact Section -->
<section class="contact" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="section-title text-center">Контактирајте не</h2>
                <div class="contact-form">
                    <form action="send_email.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Вашето име</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Вашата е-пошта</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Вашата порака</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <!-- Optional hidden field -->
                        <!-- <input type="hidden" name="user_email" value="..."> -->
                        <button type="submit" class="btn btn-primary w-100">Испрати порака</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3 class="text-white mb-4">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSJ3aGl0ZSIgZD0iTTI1NiA0NDhjLTEwNiAwLTE5Mi04Ni0xOTItMTkyUzE1MCA2NCAyNTYgNjRzMTkyIDg2IDE5MiAxOTItODYgMTkyLTE5MiAxOTJ6TTEyOCAyNTZjMCA3MC43IDU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOC01Ny4zLTEyOC0xMjgtMTI4LTEyOCA1Ny4zLTEyOCAxMjh6bTk2LTQwYy0xNy43IDAtMzIgMTQuMy0zMiAzMnY2NGMwIDE3LjcgMTQuMyAzMiAzMiAzMmg2NGMxNy43IDAgMzItMTQuMyAzMi0zMnYtNjRjMC0xNy43LTE0LjMtMzItMzItMzJoLTY0eiIvPjwvc3ZnPg==" 
                             alt="Custom Logo" class="custom-logo" style="filter: brightness(0) invert(1);">
                        Хуманитарни Акции
                    </h3>
                    <p>Платформа за управување со хуманитарни акции и донации.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="text-white mb-4">Брзи линкови</h4>
                    <div class="footer-links">
                        <a href="#home">Почетна</a>
                        <a href="#features">Функции</a>
                        <a href="#about">За нас</a>
                        <a href="#contact">Контакт</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="text-white mb-4">Социјални мрежи</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2024 Хуманитарни Акции. Сите права задржани.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Дизајнирано со <i class="fas fa-heart text-danger"></i> од нашиот тим</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            
            // Update icon
            const icon = darkModeToggle.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            const icon = darkModeToggle.querySelector('i');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
        document.addEventListener('DOMContentLoaded', function() {
    // Функција за анимација на броење
    function animateValue(id, start, end, duration, suffix = '', isCurrency = false) {
        const obj = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            let value = Math.floor(progress * (end - start) + start);
            
            if (isCurrency) {
                obj.innerHTML = numberFormat(value) + ' ' + suffix;
            } else {
                obj.innerHTML = value + suffix;
            }
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Функција за форматирање на број (1,000,000)
    function numberFormat(number) {
        return new Intl.NumberFormat('mk-MK').format(number);
    }

    // Податоци од базата (заменети со вистинските вредности)
    <?php
    require_once 'db_connection.php';
    
    // Земи ги вредностите од базата
    $campaigns = $conn->query("SELECT COUNT(*) as count FROM campaigns")->fetch_row()[0] ?? 0;
    $users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_row()[0] ?? 0;
    $donations = $conn->query("SELECT SUM(amount) as total FROM donations")->fetch_row()[0] ?? 0;
    ?>

    // Стартувај ги анимациите
    animateValue('campaigns', 0, <?php echo $campaigns; ?>, 2000, '+');
    animateValue('users', 0, <?php echo $users; ?>, 2000, '+');
    animateValue('donations', 0, <?php echo $donations; ?>, 2000, 'МКД', true);
});
    </script>
</body>
</html>