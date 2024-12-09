<?php
require_once('db_connection.php');
require_once('helpers.php');

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Checking for upload fields
    $upload_results = array();
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $value) {
            // Check if the file was actually uploaded
            if ($value['error'] != UPLOAD_ERR_NO_FILE) {
                // echo "Field " . $key . " is a file upload.\n";
                $this_upload = handleFileUpload($_FILES[$key]);
                $upload_results[] = $this_upload;
                // Put the filename in the POST data to save it in DB
                if (!in_array(true, array_column($this_upload, 'error')) && !array_key_exists('error', $this_upload)) {
                    $_POST[$key] = $this_upload['success'];
                }
            }
        }
    }

    $upload_errors = array();
    foreach ($upload_results as $result) {
        if (isset($result['error'])) {
            $upload_errors[] = $result['error'];
        }
    }

    // Check for regular fields
    if (!in_array(true, array_column($upload_results, 'error'))) {

        $FullName = trim($_POST["FullName"]);
		$ContactInfo = $_POST["ContactInfo"] == "" ? null : trim($_POST["ContactInfo"]);
		$Address = $_POST["Address"] == "" ? null : trim($_POST["Address"]);
		$Description = trim($_POST["Description"]);
		$CreatedAt = trim($_POST["CreatedAt"]);
		


        $stmt = $conn->prepare("INSERT INTO `beneficiaries` (`FullName`, `ContactInfo`, `Address`, `Description`, `CreatedAt`) VALUES (?, ?, ?, ?, ?)");

        try {
            $stmt->execute([ $FullName, $ContactInfo, $Address, $Description, $CreatedAt ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = $e->getMessage();
        }

        if (!isset($error)){
            $new_id = mysqli_insert_id($conn);
            header("location: beneficiaries-read.php?BeneficiaryID=$new_id");
        } else {
            $uploaded_files = array();
            foreach ($upload_results as $result) {
                if (isset($result['success'])) {
                    // Delete the uploaded files if there were any error while saving postdata in DB
                    unconn($upload_target_dir . $result['success']);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php translate('Add New Record') ?></title>
    <link el="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2><?php translate('Add New Record') ?></h2>
                    </div>
                    <?php print_error_if_exists(@$upload_errors); ?>
                    <?php print_error_if_exists(@$error); ?>
                    <p><?php translate('add_new_record_instructions') ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                                            <label for="FullName">FullName*</label>
                                            <input type="text" name="FullName" id="FullName" maxlength="100" class="form-control" value="<?php echo @$FullName; ?>">
                                        </div>
						<div class="form-group">
                                            <label for="ContactInfo">ContactInfo</label>
                                            <input type="text" name="ContactInfo" id="ContactInfo" maxlength="150" class="form-control" value="<?php echo @$ContactInfo; ?>">
                                        </div>
						<div class="form-group">
                                            <label for="Address">Address</label>
                                            <input type="text" name="Address" id="Address" maxlength="255" class="form-control" value="<?php echo @$Address; ?>">
                                        </div>
						<div class="form-group">
                                            <label for="Description">Description*</label>
                                            <textarea name="Description" id="Description" class="form-control"><?php echo @$Description; ?></textarea>
                                        </div>
						<div class="form-group">
                                            <label for="CreatedAt">CreatedAt*</label>
                                            <input type="text" name="CreatedAt" id="CreatedAt" class="form-control" value="<?php echo @$CreatedAt; ?>">
                                        </div>

                        <input type="submit" class="btn btn-primary" value="<?php translate('Create') ?>">
                        <a href="beneficiaries-index.php" class="btn btn-secondary"><?php translate('Cancel') ?></a>
                    </form>
                    <p><small><?php translate('required_fiels_instructions') ?></small></p>
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