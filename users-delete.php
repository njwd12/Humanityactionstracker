<?php
require_once('db_connection.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

// Process delete operation after confirmation
if(isset($_POST["UserID"]) && !empty($_POST["UserID"])){


    // Find uploaded files references for deletion
    $fileColumns = [];
    if (isset($tables_and_columns_names['users']['columns'])) {
        foreach ($tables_and_columns_names['users']['columns'] as $columnName => $columnDetails) {
            if (isset($columnDetails['is_file']) && $columnDetails['is_file'] == 1) {
                $fileColumns[] = $columnName;
            }
        }
    }

    if (!empty($fileColumns)) {
        foreach ($fileColumns as $columnName) {

            $sql = "SELECT `" . $columnName . "`
                    FROM `users`
                    WHERE `UserID` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Set parameters
                $param_id = trim($_POST["UserID"]);

                // Bind variables
                if (is_int($param_id)) $__vartype = "i";
                elseif (is_string($param_id)) $__vartype = "s";
                elseif (is_numeric($param_id)) $__vartype = "d";
                else $__vartype = "b"; // blob
                mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) == 1) {
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $fileToDelete = "$upload_target_dir" . $row[$columnName];
                        if (file_exists($fileToDelete)) {
                            // echo "Delete $columnName: " . $row[$columnName];
                            unconn($fileToDelete);
                        }
                    }
                    else {
                        // URL doesn't contain valid id parameter. Redirect to error page
                        header("location: error.php");
                        exit();
                    }

                }
                else {
                    echo translate('stmt_error') . "<br>" . $stmt->error;
                }
            }
        }
    }



    // Prepare a delete statement
    $sql = "DELETE FROM `users` WHERE `UserID` = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Set parameters
        $param_id = trim($_POST["UserID"]);

        // Bind variables to the prepared statement as parameters
		if (is_int($param_id)) $__vartype = "i";
		elseif (is_string($param_id)) $__vartype = "s";
		elseif (is_numeric($param_id)) $__vartype = "d";
		else $__vartype = "b"; // blob
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        try {
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = $e->getMessage();
        }

        if (!isset($error)){
            // Records deleted successfully. Redirect to landing page
            header("location: users-index.php");
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
	$_GET["UserID"] = trim($_GET["UserID"]);
    if(empty($_GET["UserID"])){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php translate ('Delete Record') ?></title>
    <link el="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h1><?php translate ('Delete Record') ?></h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?UserID=" . $_GET["UserID"]; ?>" method="post">
                    <?php print_error_if_exists(@$error); ?>
                        <div class="alert alert-danger fade-in">
                            <input type="hidden" name="UserID" value="<?php echo trim($_GET["UserID"]); ?>"/>
                            <p><?php translate('delete_record_confirm') ?></p><br>
                            <p>
                                <input type="submit" value="<?php translate('Yes') ?>" class="btn btn-danger">
                                <a href="javascript:history.back()" class="btn btn-secondary"><?php translate('No') ?></a>
                            </p>
                        </div>
                    </form>
                    <hr>
                    <p>
                        <a href="users-read.php?UserID=<?php echo $_GET["UserID"];?>" class="btn btn-info"><?php translate('View Record') ?></a>
                        <a href="users-update.php?UserID=<?php echo $_GET["UserID"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="javascript:history.back()" class="btn btn-primary"><?php translate('Back') ?></a>
                    </p>
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