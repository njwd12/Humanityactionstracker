<?php
require_once('db_connection.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

// Check existence of id parameter before processing further
$_GET["ExpenseID"] = trim($_GET["ExpenseID"]);
if(isset($_GET["ExpenseID"]) && !empty($_GET["ExpenseID"])){
    // Prepare a select statement
    $sql = "SELECT `expenses`.* 
            FROM `expenses` 
			LEFT JOIN `campaigns` AS `CampaignIDcampaigns` ON `CampaignIDcampaigns`.`CampaignID` = `expenses`.`CampaignID`
            WHERE `expenses`.`ExpenseID` = ?
            GROUP BY `expenses`.`ExpenseID`;";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Set parameters
        $param_id = trim($_GET["ExpenseID"]);

        // Bind variables to the prepared statement as parameters
		if (is_int($param_id)) $__vartype = "i";
		elseif (is_string($param_id)) $__vartype = "s";
		elseif (is_numeric($param_id)) $__vartype = "d";
		else $__vartype = "b"; // blob
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo translate('stmt_error') . "<br>".$stmt->error;
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php translate('View Record') ?></title>
    <link el="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="page-header">
                        <h1><?php translate('View Record') ?></h1>
                    </div>

                    									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['expenses']["columns"]['CampaignID']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['expenses']["columns"]['CampaignID']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['expenses']["columns"]['CampaignID']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['CampaignID']) .'" target="_blank" class="uploaded_file" id="conn_CampaignID">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>CampaignID*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo get_fk_url($row["CampaignID"], "campaigns", "CampaignID", $row["CampaignIDcampaignsCampaignID"], 1, false); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['expenses']["columns"]['Description']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['expenses']["columns"]['Description']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['expenses']["columns"]['Description']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Description']) .'" target="_blank" class="uploaded_file" id="conn_Description">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Description*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo nl2br(htmlspecialchars($row["Description"] ?? "")); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['expenses']["columns"]['Amount']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['expenses']["columns"]['Amount']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['expenses']["columns"]['Amount']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Amount']) .'" target="_blank" class="uploaded_file" id="conn_Amount">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Amount*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["Amount"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['expenses']["columns"]['ExpenseDate']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['expenses']["columns"]['ExpenseDate']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['expenses']["columns"]['ExpenseDate']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['ExpenseDate']) .'" target="_blank" class="uploaded_file" id="conn_ExpenseDate">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>ExpenseDate*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo convert_date($row["ExpenseDate"]); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>
                    <hr>
                    <p>
                        <a href="expenses-update.php?ExpenseID=<?php echo $_GET["ExpenseID"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="expenses-delete.php?ExpenseID=<?php echo $_GET["ExpenseID"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                        <a href="expenses-create.php" class="btn btn-success"><?php translate('Add New Record') ?></a>
                        <a href="expenses-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                    </p>
                    <?php
                    

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>