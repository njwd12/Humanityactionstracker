<?php
require_once('db_connection.php');

// Избор на одобрени кампањи
$sql = "SELECT * FROM `campaigns` WHERE `Status` = 'approved'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сите Кампањи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #007bff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: #495057;
            font-weight: bold;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Сите Кампањи</h1>

        <?php
        // Подготовка и извршување на SQL запросот
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                // Ако има резултати, прикажи ги кампањите
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="row gy-4">';
                    
                    // Прикажи секоја кампања во форма на карта
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "
                            <div class='col-md-6 col-lg-4'>
                                <div class='card h-100 shadow-sm'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                                        <p class='card-text'>" . htmlspecialchars($row['Description']) . "</p>
                                        <p><strong>Почеток:</strong> " . htmlspecialchars($row['StartDate']) . "</p>
                                        <p><strong>Крај:</strong> " . htmlspecialchars($row['EndDate']) . "</p>
                                        <p><strong>ID на кампањата:</strong> " . htmlspecialchars($row['CampaignID']) . "</p>
                                    </div>
                                </div>
                            </div>";
                    }
                    
                    echo '</div>';
                } else {
                    echo "<div class='alert alert-info text-center'>Нема одобрени кампањи.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Грешка при извршување на SQL: " . mysqli_error($conn) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Грешка при подготовка на SQL statement.</div>";
        }
        ?>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary btn-lg">Назад на почетната страна</a>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
