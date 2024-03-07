<?php ob_start();
include('../include_db.php'); ?>
<?php include(__DIR__ . "/../../src/components/header.php"); ?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<!-- CSS to adjust the footer position -->
<style>
    body {
        padding-bottom: 50px;
        /* Adjust as needed */
    }
</style>

<script>
    var params = new URLSearchParams(window.location.search);
    //show the message
    var message = params.get('message');

    $(function() {
        if (message) {
            window.popup1("Warning", message);
        }
    });
</script>


<!-- HTML button to open sample csv file to insert into Transactions table -->
<!-- <div id="Buckets">
    <div class="w2ui-buttons">
        <input type="button" value="Bucket Testing" />
    </div>
</div> -->

<!-- <form method="post">
    <input type="hidden" name="action" value="InsertSample">
    <input type="submit" value="Insert Sample Data">
</form> -->

<!-- <input type="button" value="Home" onclick="window.location.href = '/'" /> -->

<!-- <form method="post">
    <input type="hidden" name="action" value="Delete">
    <input type="submit" value="Drop all DB Tables">
</form> -->

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="InsertFile">
    <input type="file" name="csv_file">
    <input type="submit" value="Insert File Data">
</form>

<!-- HTML div to display the pie chart -->
<!-- <div id="chartContainer" style="height: 370px; width: 100%;"></div> -->

<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: /src/user/login.php");
    exit();
}

// require '../../vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\IOFactory;
// Script to run the Insert Sample Data or Drop All Tables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    // If action is to insert sample data
    if ($action == 'InsertSample' || $action == 'InsertFile') {
        if ($action == 'InsertSample') {
            $csv_file = "2023 02.csv";
        } else {
            // Get the temporary filename of the uploaded file
            $csv_file_tmp_name = $_FILES['csv_file']['tmp_name'];

            // Extract the original filename
            $original_filename = $_FILES['csv_file']['name'];

            //get file extension
            $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);

            // Define the destination directory
            $destination_directory = '../files/';
        }
        $count = $db->querySingle("SELECT count(*) from Transactions");




        // Move the uploaded file to the destination directory with the new filename


        // Check file extension to determine the file type
        if ($file_extension == 'csv') {
            // Handle CSV file
            if (($handle = fopen($csv_file_tmp_name, "r")) !== FALSE) {

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    $num = count($data);

                    if ($num != 5) {
                        $message = "Invalid data format";
                        break;
                    }

                    $date = SQLite3::escapeString($data[0]);
                    $TransactionName = SQLite3::escapeString($data[1]);
                    $Expense = SQLite3::escapeString($data[2]);
                    $Revenue = SQLite3::escapeString($data[3]);
                    $NetTotal = SQLite3::escapeString($data[4]);

                    // Logic to find Transactinon Type from Buckets
                    $TransactionType = $db->querySingle("SELECT TransactionType FROM Buckets WHERE substr(Company, 1, instr(Company || ' ', ' ') - 1) = substr('$TransactionName', 1, instr('$TransactionName' || ' ', ' ') - 1)");
                    if (!$TransactionType) {
                        $TransactionType = 'Undetermined';
                    }

                    $SQLinsert = "INSERT INTO Transactions (date, TransactionName, TransactionType, Expense, Revenue, NetTotal)";
                    $SQLinsert .= " VALUES ";
                    $SQLinsert .= " ('$date', '$TransactionName', '$TransactionType', '$Expense', '$Revenue', '$NetTotal')";

                    $db->exec($SQLinsert);
                    $changes = $db->changes();
                }


                // Move the uploaded file to the destination directory with the new filename
                $new_filename = $destination_directory . $original_filename . '.imported';
                if ($message != "Invalid data format") {
                    $message =   "Data insertion sucessful";
                    if (move_uploaded_file($csv_file_tmp_name, $new_filename)) {
                        $message =  "data inserted, File uploaded and renamed successfully.";
                    }
                }
            }
        }
        // elseif (in_array($file_extension, ['xlsx', 'xls'])) {
        //     // Handle XLSX/XLS file

        //     $spreadsheet = IOFactory::load($csv_file_tmp_name);
        //     $worksheet = $spreadsheet->getActiveSheet();
        //     $highestRow = $worksheet->getHighestRow();

        //     for ($row = 1; $row <= $highestRow; $row++) {
        //         $rowData = $worksheet->rangeToArray('A' . $row . ':Z' . $row, NULL, TRUE, FALSE)[0];
        //         if (count($rowData) != 5) {
        //             $message = "Invalid data format";
        //             break;
        //         }
        //         $date = SQLite3::escapeString($rowData[0] ?? '');
        //         $TransactionName = SQLite3::escapeString($rowData[1] ?? '');
        //         $Expense = SQLite3::escapeString($rowData[2] ?? '');
        //         $Revenue = SQLite3::escapeString($rowData[3] ?? '');
        //         $NetTotal = SQLite3::escapeString($rowData[4] ?? '');

        //         // Logic to find Transaction Type from Buckets
        //         $TransactionType = $db->querySingle("SELECT TransactionType FROM Buckets WHERE substr(Company, 1, instr(Company || ' ', ' ') - 1) = substr('$TransactionName', 1, instr('$TransactionName' || ' ', ' ') - 1)");
        //         if (!$TransactionType) {
        //             $TransactionType = 'Undetermined';
        //         }

        //         $SQLinsert = "INSERT INTO Transactions (date, TransactionName, TransactionType, Expense, Revenue, NetTotal)";
        //         $SQLinsert .= " VALUES ";
        //         $SQLinsert .= " ('$date', '$TransactionName', '$TransactionType', '$Expense', '$Revenue', '$NetTotal')";

        //         $db->exec($SQLinsert);

        //         $changes = $db->changes();
        //     }



        //     // Move the uploaded file to the destination directory with the new filename
        //     $new_filename = $destination_directory . $original_filename . '.imported';
        //     if ($message != "Invalid data format") {
        //         if (move_uploaded_file($csv_file_tmp_name, $new_filename)) {
        //             $message =  "File uploaded and renamed successfully.";
        //         } else {
        //             $message =   "Error uploading and renaming file";
        //         }
        //     }
        // } 

        else {
            $message = "Unsupported file type.";
        }

        // If drop all DB Tables action button is clicked
    } else if ($action == 'Delete') {
        $db->exec("DROP TABLE Transactions");
    }

    // Reload page after request method
    header("Location: " . $_SERVER['PHP_SELF'] . '?message=' . urlencode($message));
    exit;
}
?>

<?php
// Creates the Transactions table if not exists
$SQLite_create_transactions = "CREATE TABLE IF NOT EXISTS Transactions (
        TransactionID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        Date DATE, -- This is incoming as M/D/Y from CSV, stores as Y/M/D in sqlite
        TransactionName VARCHAR(100),
        Expense DOUBLE,
        Revenue DOUBLE,
        NetTotal DOUBLE,
        TransactionType VARCHAR(50),
        FOREIGN KEY (TransactionType) REFERENCES buckets(TransactionType)
    );";

$db->exec($SQLite_create_transactions);

// Checks if the bucket table exists
$bucket_table_exists = False;
$res = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
while ($row = $res->fetchArray(SQLITE3_NUM)) {
    if ($row[0] == "Buckets") {
        $bucket_table_exists = True;
    };
}

// Creates the Buckets table if not exists and insert common buckets
if ($bucket_table_exists == False) {
    $SQLite_create_buckets = "CREATE TABLE IF NOT EXISTS Buckets (
            id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            TransactionType VARCHAR(50),
            Company VARCHAR(50)
        );";

    $db->exec($SQLite_create_buckets);

    $SQL_bucket_insert = "INSERT INTO buckets (TransactionType, Company) 
        VALUES 
        ('Entertainment', 'ST JAMES RESTAURAT'),
        ('Communication', 'ROGERS MOBILE'),
        ('Groceries', 'SAFEWAY'),
        ('Donations', 'RED CROSS'),
        ('Entertainment', 'PUR & SIMPLE RESTAR'),
        ('Groceries', 'REAL CDN SUPERS'),
        ('Car Insurance', 'ICBC'),
        ('Gas Heating', 'FORTISBC');";

    $db->exec($SQL_bucket_insert);
}

echo '<p><a href="/src/database/transactions/create.php" class="btn btn-small btn-success">Add Transaction</a></p>';

// Displays the Transactions table, Just used for testing...
$res = $db->query('SELECT * FROM Transactions');

echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th>TransactionID</th>" .
    "<th>Date</th>" .
    "<th>Transaction Name</th>" .
    "<th>Expense</th>" .
    "<th>Revenue</th>" .
    "<th>Net Total</th>" .
    "<th>Transaction Type</th>" .
    "<th>Features</th>" .
    "<th>&nbsp;</th></tr>\n";
while ($row = $res->fetchArray()) {
    echo "<tr><td>{$row['0']}</td>";
    echo "<td>{$row['1']}</td>";
    echo "<td>{$row['2']}</td>";
    echo "<td>{$row['3']}</td>";
    echo "<td>{$row['4']}</td>";
    echo "<td>{$row['5']}</td>";
    echo "<td>{$row['6']}</td>";
    echo "<td>";
    echo "<a class='btn btn-small btn-warning' href='/src/database/transactions/edit.php?transaction_id={$row['0']}'>update</a>";
    echo "&nbsp;";
    echo "<a class='btn btn-small btn-danger' href='/src/database/transactions/delete.php?transaction_id={$row['0']}'>delete</a>";
    echo "</td></tr>\n";
};

// Displays the expense table by Transaction Type
$res = $db->query('SELECT TransactionType, SUM(Expense) as TotalExpense FROM Transactions GROUP BY TransactionType');

echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th>Transaction Type</th>" .
    "<th>Total Expense</th></tr>\n";

$dataPoints = [];

while ($row = $res->fetchArray()) {
    echo "<tr><td>{$row['TransactionType']}</td>";
    echo "<td>{$row['TotalExpense']}</td></tr>";

    // Prepare data for the pie chart
    $arrayItem = array("label" => $row['TransactionType'], "y" => $row['TotalExpense']);
    array_push($dataPoints, $arrayItem);
};
echo "</table>";

$db->close();
?>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>


<!-- Scripts for the pie chart -->
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Expenses by Transaction Type"
            },
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>

<!-- Redirect to bucket testing page -->
<script>
    $(function() {
        $('#Buckets').click(function() {
            location.href = "/src/database/bucket/buckets.php";
        });
    });
</script>

<?php
// Issues with footer when table is displayed
include(__DIR__ . "/../../src/components/footer.php");
ob_end_flush(); ?>