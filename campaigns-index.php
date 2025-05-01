<?php
// Врска со базата на податоци
$host = 'localhost'; // или твојот сервер
$dbname = 'hatracker'; // име на базата на податоци
$username = 'root'; // твоето корисничко име за база на податоци
$password = 'usbw'; // твојата лозинка

try {
    // Креирање на нова PDO врска
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Проверка ако е поставен параметар за бришење
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Извршување на SQL за бришење
        $stmt = $pdo->prepare("DELETE FROM campaigns WHERE CampaignID = :campaign_id");
        $stmt->bindParam(':campaign_id', $delete_id);
        $stmt->execute();

        echo 'Кампањата беше успешно избришана. <a href="index.php">Назад на главната страница</a>';
    }

    // SQL прашање за добивање на сите кампањи
    $stmt = $pdo->query("SELECT * FROM campaigns");

    // Проверка ако има кампањи
    if ($stmt->rowCount() > 0) {
        // Почеток на HTML табелата
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>ID</th><th>Име на кампања</th><th>Опис</th><th>Дата на создавање</th><th>Акции</th></tr></thead>';
        echo '<tbody>';

        // Испечати ја секоја кампања
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['CampaignID']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['StartDate']) . '</td>';
            // Линк за бришење кампања
            echo '<td><a href="?delete_id=' . htmlspecialchars($row['CampaignID']) . '" class="btn btn-danger">Избриши</a></td>';
            echo '</tr>';
        }

        // Крај на табелата
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'Нема кампањи во базата на податоци.';
    }
} catch (PDOException $e) {
    // Ако има грешка при поврзување или SQL извршување
    echo 'Грешка: ' . $e->getMessage();
}
?>
