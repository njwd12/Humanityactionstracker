<?php
require_once('db_connection.php');

// Ажурирање на статусот на кампањите (завршени ако EndDate е поминат)
$sql_update_status = "UPDATE campaigns 
                      SET Status = 'completed' 
                      WHERE EndDate < CURDATE() AND Status != 'completed'";
$conn->query($sql_update_status);

// Избор на активни и завршени кампањи
$sql_active = "SELECT * FROM `campaigns` WHERE `Status` = 'approved'";
$sql_completed = "SELECT * FROM `campaigns` WHERE `Status` = 'completed'";

$result_active = $conn->query($sql_active);
$result_completed = $conn->query($sql_completed);
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сите Кампањи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            font-family: 'Poppins', sans-serif;
        }

        h1 {
            color: #007bff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .campaign-card {
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .campaign-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary, .btn-danger {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover, .btn-danger:hover {
            transform: translateY(-3px);
        }

        .no-campaigns {
            font-size: 1.2rem;
            color: #6c757d;
            text-align: center;
            padding: 20px;
        }

        .toggle-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.2rem;
            color: #dc3545;
            transition: color 0.3s ease;
        }

        .toggle-section:hover {
            color: #c82333;
        }

        .toggle-btn {
            font-size: 1.5rem;
            color: #dc3545;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .completed-campaigns {
            display: none;
            transition: max-height 0.5s ease-in-out;
        }

        .campaign-id {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Сите Кампањи</h1>

        <!-- АКТИВНИ КАМПАЊИ -->
        <h2 class="text-success text-center">Во тек</h2>
        <?php if ($result_active->num_rows > 0): ?>
            <div class="row gy-4">
                <?php while ($row = $result_active->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card campaign-card h-100 shadow-sm">
                            <div class="card-body">
                                <p class="campaign-id">📌 ID: <?= htmlspecialchars($row['CampaignID']) ?></p>
                                <h5 class="card-title"><?= htmlspecialchars($row['Name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['Description']) ?></p>
                                <p><strong>Почеток:</strong> <?= htmlspecialchars($row['StartDate']) ?></p>
                                <p><strong>Крај:</strong> <?= htmlspecialchars($row['EndDate']) ?></p>
                                <p><strong>Регистрирани учесници:</strong> <?= intval($row['registered_users']) ?></p>
                                <a href="campaigns_details.php?campaign_id=<?= $row['CampaignID'] ?>" class="btn btn-primary mt-3">Детали</a>
                                <a href="donate.php?campaign_id=<?= $row['CampaignID'] ?>" class="btn btn-danger mt-3">Донирај</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-campaigns">🚀 Моментално нема активни кампањи.</p>
        <?php endif; ?>

        <!-- ЗАВРШЕНИ КАМПАЊИ DROPDOWN -->
        <div class="mt-5 text-center">
            <div class="toggle-section" onclick="toggleCompleted()">
                <span>Завршени кампањи</span>
                <i id="toggleIcon" class="fas fa-plus-circle toggle-btn"></i>
            </div>
            <div id="completedCampaigns" class="completed-campaigns">
                <div class="row gy-4">
                    <?php if ($result_completed->num_rows > 0): ?>
                        <?php while ($row = $result_completed->fetch_assoc()): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card campaign-card h-100 shadow-sm border-danger">
                                    <div class="card-body">
                                        <p class="campaign-id">📌 ID: <?= htmlspecialchars($row['CampaignID']) ?></p>
                                        <h5 class="card-title text-danger"><?= htmlspecialchars($row['Name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($row['Description']) ?></p>
                                        <p><strong>Почеток:</strong> <?= htmlspecialchars($row['StartDate']) ?></p>
                                        <p><strong>Крај:</strong> <?= htmlspecialchars($row['EndDate']) ?></p>
                                        <p><strong>Регистрирани учесници:</strong> <?= intval($row['registered_users']) ?></p>
                                        <a href="campaigns_details.php?campaign_id=<?= $row['CampaignID'] ?>" class="btn btn-secondary mt-3">Детали</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="no-campaigns">❌ Нема завршени кампањи.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary btn-lg">Назад на почетната страна</a>
        </div>
    </div>

    <script>
        function toggleCompleted() {
            let section = document.getElementById("completedCampaigns");
            let icon = document.getElementById("toggleIcon");

            if (section.style.display === "none" || section.style.display === "") {
                section.style.display = "block";
                icon.classList.remove("fa-plus-circle");
                icon.classList.add("fa-minus-circle");
            } else {
                section.style.display = "none";
                icon.classList.remove("fa-minus-circle");
                icon.classList.add("fa-plus-circle");
            }
        }
    </script>
</body>
</html>
