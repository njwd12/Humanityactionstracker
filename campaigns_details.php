<?php
require_once('db_connection.php');

if (!isset($_GET['campaign_id'])) {
    die("Недостасува ID на кампања.");
}

$campaignID = intval($_GET['campaign_id']);
$sql = "SELECT * FROM campaigns WHERE CampaignID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Кампањата не е пронајдена.");
}

$row = $result->fetch_assoc();
?>




<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($row['Name']) ?> - Детали</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .campaign-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .campaign-info {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.2s;
        }

        .back-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="campaign-container">
        <h1><?= htmlspecialchars($row['Name']) ?></h1>
        <p class="campaign-info"><strong>Опис:</strong> <?= htmlspecialchars($row['Description']) ?></p>
        <p class="campaign-info"><strong>Почеток:</strong> <?= htmlspecialchars($row['StartDate']) ?></p>
        <p class="campaign-info"><strong>Крај:</strong> <?= htmlspecialchars($row['EndDate']) ?></p>
        <p class="campaign-info"><strong>Регистрирани учесници:</strong> <?= intval($row['registered_users']) ?></p>
        <a href="campaigns-read.php" class="back-btn">Назад</a>
    </div>
</body>
</html>
