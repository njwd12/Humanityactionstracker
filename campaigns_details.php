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

// Собирање на средствата за кампањата
$donationsQuery = "SELECT SUM(Amount) AS total_donations FROM donations WHERE CampaignID = ?";
$donationsStmt = $conn->prepare($donationsQuery);
$donationsStmt->bind_param("i", $campaignID);
$donationsStmt->execute();
$donationsResult = $donationsStmt->get_result();
$donationsRow = $donationsResult->fetch_assoc();
$totalDonations = $donationsRow['total_donations'] ?: 0;
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($row['Name']) ?> - Детали</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .campaign-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .campaign-info {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }

        /* Стил за описот */
        .campaign-description {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin: 20px 0;
            line-height: 1.6;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .campaign-description p {
            margin-bottom: 10px;
        }

        .campaign-description strong {
            color: #007bff;
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

        .donation-progress {
            height: 20px;
            border-radius: 10px;
            margin: 15px 0;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            background: #28a745;
            height: 100%;
            transition: width 0.6s ease;
        }
    </style>
</head>
<body>
    <div class="campaign-container">
        <h1><?= htmlspecialchars($row['Name']) ?></h1>
        
        <!-- Подобрен дел за опис -->
        <div class="campaign-description">
            <?= nl2br(htmlspecialchars($row['Description'])) ?>
        </div>

        <p class="campaign-info"><strong><i class="fas fa-calendar-alt"></i> Почеток:</strong> <?= htmlspecialchars($row['StartDate']) ?></p>
        <p class="campaign-info"><strong><i class="fas fa-calendar-times"></i> Крај:</strong> <?= htmlspecialchars($row['EndDate']) ?></p>
        <p class="campaign-info"><strong><i class="fas fa-users"></i> Учесници:</strong> <?= intval($row['registered_users']) ?></p>
        
        <!-- Прогрес бар за донации -->
        <div class="campaign-info">
            <strong><i class="fas fa-donate"></i> Собрани средства:</strong> 
            $<?= number_format($totalDonations, 2) ?>
            <div class="donation-progress">
                <div class="progress-bar" style="width: <?= min(100, ($totalDonations / $row['GoalAmount']) * 100) ?>%"></div>
            </div>
            <small>Цел: $<?= number_format($row['GoalAmount'], 2) ?></small>
        </div>

        <a href="campaigns-read.php" class="back-btn"><i class="fas fa-arrow-left"></i> Назад кон кампањи</a>
    </div>
</body>
</html>