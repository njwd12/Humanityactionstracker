<?php
require_once('db_connection.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

// Check existence of id parameter before processing further
$_GET["UserID"] = trim($_GET["UserID"]);
if(isset($_GET["UserID"]) && !empty($_GET["UserID"])){
    // Prepare a select statement
    $sql = "SELECT `users`.* 
            FROM `users` 
            WHERE `users`.`UserID` = ?
            GROUP BY `users`.`UserID`;";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Set parameters
        $param_id = trim($_GET["UserID"]);

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
									// print_r($tables_and_columns_names['users']["columns"]['FullName']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['users']["columns"]['FullName']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['users']["columns"]['FullName']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['FullName']) .'" target="_blank" class="uploaded_file" id="conn_FullName">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>FullName*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["FullName"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['users']["columns"]['Email']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['users']["columns"]['Email']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['users']["columns"]['Email']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Email']) .'" target="_blank" class="uploaded_file" id="conn_Email">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Email*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["Email"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['users']["columns"]['PasswordHash']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['users']["columns"]['PasswordHash']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['users']["columns"]['PasswordHash']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['PasswordHash']) .'" target="_blank" class="uploaded_file" id="conn_PasswordHash">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>PasswordHash*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["PasswordHash"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['users']["columns"]['Role']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['users']["columns"]['Role']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['users']["columns"]['Role']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Role']) .'" target="_blank" class="uploaded_file" id="conn_Role">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Role*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["Role"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['users']["columns"]['CreatedAt']);
									// echo '</pre>';
									$has_conn_file = isset($tables_and_columns_names['users']["columns"]['CreatedAt']['is_file']) ? true : false;
									if ($has_conn_file){
									    $is_file = $tables_and_columns_names['users']["columns"]['CreatedAt']['is_file'];
									    $conn_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['CreatedAt']) .'" target="_blank" class="uploaded_file" id="conn_CreatedAt">' : '';
									    $end_conn_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>CreatedAt*</h4>
									    <?php if ($has_conn_file): ?>
									        <p class="form-control-static"><?php echo $conn_file ?><?php echo htmlspecialchars($row["CreatedAt"] ?? ""); ?><?php echo $end_conn_file ?></p>
									    <?php endif ?>
									</div>
                    <hr>
                    <p>
                        <a href="users-update.php?UserID=<?php echo $_GET["UserID"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="users-delete.php?UserID=<?php echo $_GET["UserID"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                        <a href="users-create.php" class="btn btn-success"><?php translate('Add New Record') ?></a>
                        <a href="users-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                    </p>
                    <?php
                    $html = "";
                    $id = is_numeric($row["UserID"]) ? $row["UserID"] : "'".$row["UserID"]."'";
                    $sql = "SELECT COUNT(*) AS count FROM `campaigns` WHERE `OrganizerID` = ". $id . ";";
                    $number_of_refs = mysqli_fetch_assoc(mysqli_query($conn, $sql))["count"];
                    if ($number_of_refs > 0)
                    {
                        $html .= '<p><a href="campaigns-index.php?OrganizerID='. $row["UserID"].'" class="btn btn-info">' . translate("references_view_btn", false, $number_of_refs, "campaigns", "OrganizerID", $row["UserID"]) .'</a></p></p>';
                    }
                    $id = is_numeric($row["UserID"]) ? $row["UserID"] : "'".$row["UserID"]."'";
                    $sql = "SELECT COUNT(*) AS count FROM `donations` WHERE `DonorID` = ". $id . ";";
                    $number_of_refs = mysqli_fetch_assoc(mysqli_query($conn, $sql))["count"];
                    if ($number_of_refs > 0)
                    {
                        $html .= '<p><a href="donations-index.php?DonorID='. $row["UserID"].'" class="btn btn-info">' . translate("references_view_btn", false, $number_of_refs, "donations", "DonorID", $row["UserID"]) .'</a></p></p>';
                    }
                    $id = is_numeric($row["UserID"]) ? $row["UserID"] : "'".$row["UserID"]."'";
                    $sql = "SELECT COUNT(*) AS count FROM `donations` WHERE `DonorID` = ". $id . ";";
                    $number_of_refs = mysqli_fetch_assoc(mysqli_query($conn, $sql))["count"];
                    if ($number_of_refs > 0)
                    {
                        $html .= '<p><a href="donations-index.php?DonorID='. $row["UserID"].'" class="btn btn-info">' . translate("references_view_btn", false, $number_of_refs, "donations", "DonorID", $row["UserID"]) .'</a></p></p>';
                    }if ($html != "") {echo "<h3>" . translate("references_tables", false, "users") . "</h3>" . $html;}

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