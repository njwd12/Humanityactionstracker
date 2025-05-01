<?php
require_once 'db_connection.php';

// Проверка дали е испратена форма за плаќање
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Взимање на податоците од формата
    $campaignID = $_POST['campaignID'];
    $donorID = $_POST['donorID'];
    $amount = $_POST['amount'];
    $cardName = trim($_POST['cardName']);
    $cardNumber = $_POST['cardNumber'];
    $expirationDate = $_POST['expirationDate'];
    $cvc = $_POST['cvc'];

    // Валидација на податоците (основна валидација)
    if ($amount <= 0 || empty($cardName) || empty($cardNumber) || empty($cvc)) {
        echo "Погрешни податоци за плаќање.";
        exit;
    }

    // Вметнување на донацијата во базата
    $query = "INSERT INTO donations (CampaignID, DonorID, Amount, DonationDate, CardName, CardNumber, ExpirationDate, CVC)
              VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iidssss", $campaignID, $donorID, $amount, $cardName, $cardNumber, $expirationDate, $cvc);

    if ($stmt->execute()) {
        echo "Плаќањето е успешно! Ви благодариме за вашата донација.";

        // Пренасочување на кампањи по успешно плаќање
        header("Location: campaigns-read.php"); // Пренасочување на кампаниите
        exit; // Важно е да ставите exit тука за да го спречите понатамошното извршување на кодот
    } else {
        echo "Грешка при обработка на плаќањето. Обидете се повторно.";
    }
}

// Взимање на кампања од URL
$campaignID = isset($_GET['campaignID']) ? $_GET['campaignID'] : 1;
$query = "SELECT * FROM campaigns WHERE CampaignID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$result = $stmt->get_result();
$campaign = $result->fetch_assoc();

if (!$campaign) {
    echo "Кампањата не е пронајдена.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Плаќање за Кампања: <?= htmlspecialchars($campaign['Name']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --text-color: #2b2d42;
            --light-gray: #f8f9fa;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        .campaign-info {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }
        
        .campaign-info p {
            margin-bottom: 0.8rem;
        }
        
        .campaign-meta {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }
        
        .meta-item {
            flex: 1;
        }
        
        .meta-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .meta-value {
            font-weight: 500;
        }
        
        form {
            background-color: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .card-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 14px 20px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: var(--secondary-color);
        }
        
        .secure-payment {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }
        
        @media (max-width: 600px) {
            .campaign-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .card-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h1>Плаќање за Кампања: <?= htmlspecialchars($campaign['Name']) ?></h1>
    
    <div class="campaign-info">
        <p><?= nl2br(htmlspecialchars($campaign['Description'])) ?></p>
        
        <div class="campaign-meta">
            <div class="meta-item">
                <span class="meta-label">Целна сума:</span>
                <span class="meta-value">$<?= number_format($campaign['TargetAmount'], 2) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Почеток:</span>
                <span class="meta-value"><?= $campaign['StartDate'] ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Крај:</span>
                <span class="meta-value"><?= $campaign['EndDate'] ?></span>
            </div>
        </div>
    </div>

    <form action="payment.php" method="POST">
        <input type="hidden" name="campaignID" value="<?= $campaignID ?>">
        
        <div class="form-group">
            <label for="donorID">Ваш ID</label>
            <input type="number" id="donorID" name="donorID" required placeholder="Внесете го вашиот ID">
        </div>
        
        <div class="form-group">
            <label for="amount">Износ на донација (MKD)</label>
            <input type="number" id="amount" name="amount" step="0.01" min="1" required placeholder="На пример: 500.00">
        </div>
        
        <div class="form-group">
            <label for="cardName">Име на носител на картичка</label>
            <input type="text" id="cardName" name="cardName" required placeholder="Како што е напишано на картичката">
        </div>
        
        <div class="form-group">
            <label for="cardNumber">Број на картичка</label>
            <input type="text" id="cardNumber" name="cardNumber" required placeholder="1234 5678 9012 3456">
        </div>
        
        <div class="card-details">
            <div class="form-group">
                <label for="expirationDate">Дата на истекување</label>
                <input type="text" id="expirationDate" name="expirationDate" required placeholder="MM/ГГГГ">
            </div>
            <div class="form-group">
                <label for="cvc">CVC код</label>
                <input type="text" id="cvc" name="cvc" required placeholder="123">
            </div>
        </div>
        
        <button type="submit">Потврди плаќање</button>
        <button type="button" onclick="window.location.href='campaigns-read.php'">Врати назад</button>
        
        <div class="secure-payment">
            <span>🔒</span>
            <span>Сигурно плаќање</span>
        </div>
    </form>

</body>
</html>
