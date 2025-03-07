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
    <div class="container text-center">
        <h1>Добредојдовте на Трекер за хуманитарни акции</h1>
        <p class="lead">Платформа која овозможува лесно управување и следење на вашите хуманитарни иницијативи.</p>

        <div class="row mt-4">
            <div class="col-md-6 mx-auto">
                <div class="hero-card p-4">
                    <h3>Вашето уникатно корисничко ID:</h3>
                    <span class="user-id"><?php echo htmlspecialchars($user_id); ?></span>
                    <p class="mt-3">Со ова ID можете да креирате, следите и организирате настани и донации на едноставен начин.</p>
                    <a href="actions.php" class="btn">Почнете веднаш</a>
                </div>
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col-md-4">
                <div class="stat-box">
                    <h2>500+</h2>
                    <p>Хуманитарни акции поддржани</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h2>10,000+</h2>
                    <p>Корисници кои помагаат</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h2>1М+</h2>
                    <p>Донирани средства</p>
                </div>
            </div>
        </div>

        <div class="hero-features mt-5">
            <h3>Нашите главни предности:</h3>
            <ul class="list-unstyled">
                <li><i class="fas fa-check-circle"></i> Лесно управување со настани и акции</li>
                <li><i class="fas fa-check-circle"></i> Транспарентен систем за донации</li>
                <li><i class="fas fa-check-circle"></i> Брза комуникација со донатори и волонтери</li>
            </ul>
        </div>
    </div>
</section>

<style>
    .hero {
        background: linear-gradient(to right, #1abc9c, #16a085);
        color: white;
        padding: 100px 20px;
        text-align: center;
        position: relative;
    }
    .hero-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .stat-box {
        background: rgba(255, 255, 255, 0.15);
        padding: 20px;
        border-radius: 10px;
        font-size: 1.2rem;
        font-weight: bold;
    }
    .hero-features ul {
        margin-top: 20px;
        font-size: 1.2rem;
    }
    .hero-features i {
        color: #2ecc71;
        margin-right: 10px;
    }
</style>


    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <h2 class="section-title">За нас</h2>
            <p class="text-center">Оваа апликација е дело на Ненад Јовановски, студент и софтверски инженер со страст за развивање модерни и корисни технолошки решенија. Воден од желбата да придонесе за општеството, Ненад ја креираше оваа платформа за да им помогне на организациите, волонтерите и донаторите да имаат јасен и деталeн преглед на сите тековни и завршени хуманитарни акции.

Нашата мисија е јасна – да ги поврземе луѓето кои сакаат да помогнат со оние на кои им е најпотребно. Веруваме дека технологијата може да биде клучен фактор во унапредувањето на хуманитарните процеси, а преку оваа апликација сакаме да внесеме поголема ефикасност, доверба и сигурност во добротворните иницијативи.

Што ја прави оваа апликација уникатна?
✅ Прва ваква платформа во државата – Досега, управувањето со хуманитарни акции главно се правеше рачно, преку различни таблици, документи и социјални мрежи. Оваа апликација го централизира целиот процес и го прави многу поефикасен.
✅ Целосна транспарентност – Организаторите можат да внесуваат податоци за собрани средства, дистрибуирани донации и број на засегнати лица, со што се зголемува довербата кај донаторите.
✅ Брзо и лесно управување со акции – Со само неколку кликови, можете да креирате нова акција, да ги следите нејзините текови и да добиете аналитика за досегашниот успех.
✅ Интерактивен интерфејс – Модерниот и интуитивен дизајн овозможува секој корисник лесно да се снајде, без разлика дали е искусен корисник на технологии или не.
✅ Сигурност и заштита на податоци – Вградените безбедносни механизми осигуруваат дека сите кориснички податоци се заштитени, а пристапот до платформата е строго контролирана.

Нашата визија за иднината
Нашата цел е оваа платформа да се прошири и надвор од границите на државата, правејќи ја достапна за меѓународни хуманитарни организации. Веруваме дека преку соработка со различни невладини организации, фондации и индивидуални донатори, ќе можеме да создадеме подобро и поорганизирано општество, каде што секој чин на добрина ќе биде забележан и поддржан.

🚀 Ова е само почеток! Продолжуваме со континуирани подобрувања и нови функционалности, со цел да го олесниме процесот на помагање и да ја направиме секоја донација што поефикасна. Секој ваш предлог е добредојден – заедно можеме да изградиме подобро општество!

Благодариме што сте дел од оваа иницијатива! 💙</p>
        </div>
    </section>

       <!-- Features Section -->
       <section id="features" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-4">Карактеристики</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Управување со корисници</h5>
                            <p class="card-text">Додавајте, менувајте и бришете корисници лесно преку нашиот систем. Управувајте со различни улоги и пристапи.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-bullhorn fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Организација на кампањи</h5>
                            <p class="card-text">Креирајте и следете кампањи за хуманитарни активности со само неколку клика. Поставете цели, споделувајте ажурирања и следете го напредокот.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-hand-holding-heart fa-3x text-danger mb-3"></i>
                            <h5 class="card-title">Евиденција на донации</h5>
                            <p class="card-text">Прегледувајте и управувајте ги вашите донации на транспарентен начин. Видете кој донирал, колку и каде се трошат средствата.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Напредна аналитика</h5>
                            <p class="card-text">Следете детални статистики за донациите и активностите преку интерактивни графици и извештаи.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-3x text-dark mb-3"></i>
                            <h5 class="card-title">Висока безбедност</h5>
                            <p class="card-text">Вашите податоци се заштитени со највисоки стандарди на енкрипција и безбедносни протоколи.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-users-cog fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Поддршка и заедница</h5>
                            <p class="card-text">Нашиот тим е секогаш тука да ви помогне со било какви прашања. Поврзете се со други организации и волонтери.</p>
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
