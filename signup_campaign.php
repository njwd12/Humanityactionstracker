<?php
require_once('db_connection.php');
require_once('helpers.php');

// Прифатете ја пост барањето
$data = json_decode(file_get_contents('php://input'), true);

// Проверка дали CampaignID е поставен
if (isset($data['campaignID'])) {
    $campaignID = $data['campaignID'];

    // SQL изјава за вметнување на пријава (во зависност од вашата структура на база податоци)
    $sql = "INSERT INTO `campaign_signups` (`CampaignID`, `UserID`) VALUES (?, ?)";

    // Претпоставуваме дека сте го добиле UserID преку сесија или некаде на серверот
    $userID = $_SESSION['user_id']; // Овде треба да го замените со вистинскиот начин на добивање на UserID

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $campaignID, $userID);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['message' => 'Успешно се пријавивте на кампањата.']);
        } else {
            echo json_encode(['message' => 'Грешка при пријавување.']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['message' => 'Грешка при подготовка на SQL изјавата.']);
    }
} else {
    echo json_encode(['message' => 'Не е доставен CampaignID.']);
}
?>
