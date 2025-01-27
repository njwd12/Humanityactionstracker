<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Платформа</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Глобални стилови */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .campaign {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }

        .campaign:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .btn {
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-success:hover, .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Анимации */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        /* Респонсивен дизајн */
        @media (max-width: 768px) {
            h2 {
                font-size: 2rem;
            }

            .campaign {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <div class="container fade-in">
        <h2>Админ Панел - Чекачки Кампањи</h2>
        <?php
        require_once('db_connection.php');

        // Избор на кампањи со статус 'pending'
        $sql = "SELECT * FROM campaigns WHERE Status = 'pending'";
        $result = $conn->query($sql);

        // Преглед на сите кампањи на чекање
        while ($row = $result->fetch_assoc()) {
            echo "<div class='campaign'>
                    <h5>" . htmlspecialchars($row['Name']) . "</h5>
                    <p>" . htmlspecialchars($row['Description']) . "</p>
                    <form method='POST' action='approve_campaign.php'>
                        <input type='hidden' name='CampaignID' value='" . $row['CampaignID'] . "'>
                        <button type='submit' class='btn btn-success'>Одобри</button>
                    </form>
                    <form method='POST' action='reject_campaign.php'>
                        <input type='hidden' name='CampaignID' value='" . $row['CampaignID'] . "'>
                        <button type='submit' class='btn btn-danger'>Одбие</button>
                    </form>
                </div>";
        }
        ?>
        <!-- Ако нема кампањи за одобрување -->
        <?php if ($result->num_rows == 0) : ?>
            <p>Нема нови кампањи за одобрување.</p>
        <?php endif; ?>
    </div>

    <!-- Копче за одјава -->
    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-warning">Одјава</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
