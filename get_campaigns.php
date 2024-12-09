<?php
require_once('db_connection.php');  // Креирај врска со базата
require_once('helpers.php');
require_once('config-tables-columns.php');

// Вклучете пријавување на MySQL грешки
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// SQL изјава за избор на сите кампањи
$sql = "SELECT * FROM `campaigns`";  // Сите кампањи

if ($stmt = mysqli_prepare($conn, $sql)) {
    // Изврши го SQL барањето
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Провери дали има резултати
        if (mysqli_num_rows($result) > 0) {
            $campaigns = array();  // Празен низ за да ги чува податоците

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $campaigns[] = $row;  // Додај секој ред во низата
            }

            // Конвертирај низата во JSON формат
            echo json_encode($campaigns, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["message" => "Нема кампањи."]);
        }
    } else {
        echo json_encode(["message" => "Грешка при извршување на SQL."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["message" => "Грешка при подготовка на SQL statement."]);
}
?>
