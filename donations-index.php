<?php

require_once('db_connection.php');
require_once('config-tables-columns.php');
require_once('helpers.php');

// Check if it's an export request
$isCsvExport = isset($_GET['export']) && $_GET['export'] == 'csv';


//Get current URL and parameters for correct pagination
$script   = $_SERVER['SCRIPT_NAME'];
$parameters   = $_GET ? $_SERVER['QUERY_STRING'] : "" ;
$currenturl = $domain. $script . '?' . $parameters;

//Pagination
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

//$no_of_records_per_page is set on the index page. Default is 10.
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM `donations`";
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

//Column sorting on column name
$columns = array('DonationID', 'CampaignID', 'DonorID', 'Amount', 'DonationDate');
// Order by primary key on default
$order = 'DonationID';
if (isset($_GET['order']) && in_array($_GET['order'], $columns)) {
    $order = $_GET['order'];
}

//Column sort order
$sortBy = array('asc', 'desc'); $sort = 'asc';
if (isset($_GET['sort']) && in_array($_GET['sort'], $sortBy)) {
        if($_GET['sort']=='asc') {
        $sort='asc';
        }
else {
    $sort='desc';
    }
}

//Generate WHERE statements for param
$where_columns = array_intersect_key($_GET, array_flip($columns));
$get_param = "";
$where_statement = " WHERE 1=1 ";
foreach ( $where_columns as $key => $val ) {
    $where_statement .= " AND `$key` = '" . mysqli_real_escape_string($conn, $val) . "' ";
    $get_param .= "&$key=$val";
}

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    if (strpos('`donations`.`DonationID`, `donations`.`CampaignID`, `donations`.`DonorID`, `donations`.`Amount`, `donations`.`DonationDate`', ',')) {
        $where_statement .= " AND CONCAT_WS (`donations`.`DonationID`, `donations`.`CampaignID`, `donations`.`DonorID`, `donations`.`Amount`, `donations`.`DonationDate`) LIKE '%$search%'";
    } else {
        $where_statement .= " AND `donations`.`DonationID`, `donations`.`CampaignID`, `donations`.`DonorID`, `donations`.`Amount`, `donations`.`DonationDate` LIKE '%$search%'";
    }

} else {
    $search = "";
}

$order_clause = !empty($order) ? "ORDER BY `$order` $sort" : '';
$group_clause = !empty($order) && $order == 'DonationID' ? "GROUP BY `donations`.`$order`" : '';

// Prepare SQL queries
$sql = "SELECT `donations`.* 
        FROM `donations` 
			LEFT JOIN `campaigns` AS `CampaignIDcampaigns` ON `CampaignIDcampaigns`.`CampaignID` = `donations`.`CampaignID`
			LEFT JOIN `users` AS `DonorIDusers` ON `DonorIDusers`.`UserID` = `donations`.`DonorID`
        $where_statement
        $group_clause
        $order_clause";

// Add pagination only if it's not a CSV export
if (!$isCsvExport) {
    $sql .= " LIMIT $offset, $no_of_records_per_page";
}

// Execute the main query
$result = mysqli_query($conn, $sql);

// Stop further rendering for CSV export
if ($isCsvExport) {
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    exportAsCSV($data, $db_name, $tables_and_columns_names, 'donations', $conn, false);
    exit;
}

$count_pages = "SELECT COUNT(*) AS count
                FROM `donations` 
			LEFT JOIN `campaigns` AS `CampaignIDcampaigns` ON `CampaignIDcampaigns`.`CampaignID` = `donations`.`CampaignID`
			LEFT JOIN `users` AS `DonorIDusers` ON `DonorIDusers`.`UserID` = `donations`.`DonorID`
                $where_statement";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Admin</title>
    <link el="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6b773fe9e4.js" crossorigin="anonymous"></script>
    <style type="text/css">
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 5px;
        }
        body {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php require_once('navbar.php'); ?>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <?php
                        // Prevent crash if $str contains single quotes
                        $str = <<<'EOD'
                        donations
                        EOD;
                        ?>
                        <h2 class="float-left"><?php translate('%s Details', true, $str) ?></h2>
                        <a href="donations-create.php" class="btn btn-success float-right"><?php translate('Add New Record') ?></a>
                        <a href="donations-index.php" class="btn btn-info float-right mr-2"><?php translate('Reset View') ?></a>
                        <a href="donations-index.php?export=csv" class="btn btn-primary float-right mr-2"><?php translate('Export as CSV') ?></a>
                        <a href="javascript:history.back()" class="btn btn-secondary float-right mr-2"><?php translate('Back') ?></a>
                    </div>

                    <div class="form-row">
                        <form action="donations-index.php" method="get">
                            <div class="col"> <input type="text" class="form-control" placeholder="<?php translate('Search this table') ?>" name="search"></div>
                        </form>
                        <br>


                        <?php
                        if($result) :
                            if(mysqli_num_rows($result) > 0) :
                                $number_of_results = mysqli_fetch_assoc(mysqli_query($conn, $count_pages))['count'];
                                $total_pages = ceil($number_of_results / $no_of_records_per_page);
                                translate('total_results', true, $number_of_results, $pageno, $total_pages);
                                ?>

                                <table class='table table-bordered table-striped'>
                                    <thead class='thead-light'>
                                        <tr>
                                            <?php 									$columnname = "DonationID";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "asc" ? "desc" : "asc";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "desc" ? "asc" : $sort_conn;
									echo "<th><a href=?search=$search&order=DonationID&sort=".$sort_conn.">DonationID</a></th>";
									$columnname = "CampaignID";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "asc" ? "desc" : "asc";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "desc" ? "asc" : $sort_conn;
									echo "<th><a href=?search=$search&order=CampaignID&sort=".$sort_conn.">CampaignID</a></th>";
									$columnname = "DonorID";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "asc" ? "desc" : "asc";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "desc" ? "asc" : $sort_conn;
									echo "<th><a href=?search=$search&order=DonorID&sort=".$sort_conn.">DonorID</a></th>";
									$columnname = "Amount";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "asc" ? "desc" : "asc";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "desc" ? "asc" : $sort_conn;
									echo "<th><a href=?search=$search&order=Amount&sort=".$sort_conn.">Amount</a></th>";
									$columnname = "DonationDate";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "asc" ? "desc" : "asc";
									$sort_link= isset($_GET["order"]) && $_GET["order"] == $columnname && $_GET["sort"] == "desc" ? "asc" : $sort_conn;
									echo "<th><a href=?search=$search&order=DonationDate&sort=".$sort_conn.">DonationDate</a></th>";
 ?>
                                            <th><?php translate('Actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = mysqli_fetch_array($result)): ?>
                                            <tr>
                                                <?php echo "<td>" . htmlspecialchars($row['DonationID'] ?? "") . "</td>";
										echo "<td>" . get_fk_url($row["CampaignID"], "campaigns", "CampaignID", $row["CampaignIDcampaignsCampaignID"], 1, true) . "</td>";
											echo "<td>" . get_fk_url($row["DonorID"], "users", "UserID", $row["DonorIDusersUserID"], 1, true) . "</td>";
											echo "<td>" . htmlspecialchars($row['Amount'] ?? "") . "</td>";
										echo "<td>" . htmlspecialchars($row['DonationDate'] ?? "") . "</td>";
										 ?>
                                                <td>
                                                    <?php
                                                    $column_id = 'DonationID';
                                                    if (!empty($column_id)): ?>
                                                        <a id='read-<?php echo $row['DonationID']; ?>' href='donations-read.php?DonationID=<?php echo $row['DonationID']; ?>' title='<?php echo addslashes(translate('View Record', false)); ?>' data-toggle='tooltip' class='btn btn-sm btn-info'><i class='far fa-eye'></i></a>
                                                        <a id='update-<?php echo $row['DonationID']; ?>' href='donations-update.php?DonationID=<?php echo $row['DonationID']; ?>' title='<?php echo addslashes(translate('Update Record', false)); ?>' data-toggle='tooltip' class='btn btn-sm btn-warning'><i class='far fa-edit'></i></a>
                                                        <a id='delete-<?php echo $row['DonationID']; ?>' href='donations-delete.php?DonationID=<?php echo $row['DonationID']; ?>' title='<?php echo addslashes(translate('Delete Record', false)); ?>' data-toggle='tooltip' class='btn btn-sm btn-danger'><i class='far fa-trash-alt'></i></a>
                                                    <?php else: ?>
                                                        <?php echo addslashes(translate('unsupported_no_pk')); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>


                                <ul class="pagination" align-right>
                                <?php
                                    $new_url = preg_replace('/&?pageno=[^&]*/', '', $currenturl);
                                    ?>
                                    <li class="page-item"><a class="page-conn" href="<?php echo $new_url .'&pageno=1' ?>"><?php translate('First') ?></a></li>
                                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                        <a class="page-conn" href="<?php if($pageno <= 1){ echo '#'; } else { echo $new_url ."&pageno=".($pageno - 1); } ?>"><?php translate('Prev') ?></a>
                                    </li>
                                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                        <a class="page-conn" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo $new_url . "&pageno=".($pageno + 1); } ?>"><?php translate('Next') ?></a>
                                    </li>
                                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                        <a class="page-item"><a class="page-conn" href="<?php echo $new_url .'&pageno=' . $total_pages; ?>"><?php translate('Last') ?></a>
                                    </li>
                                </ul>

                                <?php mysqli_free_result($result); ?>
                            <?php else: ?>
                            <p class='lead'><em><?php translate('No records were found.') ?></em></p>
                        <?php endif ?>

                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            ERROR: Could not able to execute <?php echo $sql. " " . mysqli_error($conn); ?>
                        </div>
                    <?php endif ?>

                    <?php mysqli_close($conn) ?>
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
