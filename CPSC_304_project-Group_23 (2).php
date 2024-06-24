<!-- CPSC 304 Project Group 23
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  Modified by Jason Hall (23-09-20)
  Modified by Sameer Shankar, Yash Mali, Damien Fung
  This file is modified from and inspired by the "PHP Introduction" tutorial script "oracle-test.php"
-->

<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_fungd2";			// change "cwl" to your own CWL
$config["dbpassword"] = "a45489804";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
?>

<!-- FRONT END edit the HTML script here -->
<!DOCTYPE html>
<html lang="en">
<style>
    /* CSS styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    h2 {
        color: #333;
    }
    p {
        color: #666;
    }
    form {
        margin-bottom: 20px;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<head>
    <title>CPSC 304 project: Group 23</title>
</head>

<body>
<h2>Reset</h2>
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

<form method="POST" action="CPSC_304_project-Group_23.php">
    <!-- "action" specifies the file or page that will receive the form data for processing. As with this example, it can be this same file. -->
    <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
    <p><input type="submit" value="Reset" name="reset"></p>
</form>

<hr />

<h2>Delete Values in Farm</h2>
<form method="POST" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">

    <!-- FRONT END edit this for value types -->
    fid: <input type="text" name="fid"> <br /><br />

    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>

<hr />

<h2>Insert Values into Farmer</h2>
<form method="POST" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    <!-- FRONT END edit this for value types -->
    sin: <input type="text" name="sin"> <br /><br />
    name: <input type="text" name="name"> <br /><br />
    phone: <input type="text" name="phone"> <br /><br />
    age: <input type="text" name="age"> <br /><br />
    address:  <input type="text" name="address"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr />

<h2>Update Name in DemoTable</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
    <!-- FRONT END edit this for value types -->
    SIN: <input type="text" name="sin"> <br /><br />
    Age: <input type="text" name="newAge"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr />

<!-- FRONT END edit these following forms accordingly -->
<h2>Join Tables</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="joinRequest" name="joinRequest">
    <input type="submit" name="joinRequest" value="Join Farmer and Owns"></p>
</form>

<hr />

<h2>Filter farmers based on their data.</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="selectTuplesRequest" name="selectTuplesRequest">

    <label for="sin">SIN:</label>
    <input type="text" id="sin" name="sin" maxlength="9" pattern="[0-9]{9}" title="SIN must be a 9-digit number">
    <br><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name">
    <br><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" pattern="[0-9]+" title="Phone must be a number">
    <br><br>

    <label for="age">Age:</label>
    <input type="text" id="age" name="age" pattern="[0-9]+" title="Age must be a number">
    <br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address">
    <br><br>

    <label for="match_all">Match All:</label>
    <input type="radio" id="match_all" name="operator" value="AND" checked>
    <label for="match_any">Match Any:</label>
    <input type="radio" id="match_any" name="operator" value="OR">
    <br><br>

    <input type="submit" name="selectTuples">

</form>

<hr />

<h2>Projection - Any Table and Attribute</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="projectTuplesRequest" name="projectTuplesRequest">
    <label for="table">Select a Table:</label>
    <select name="table" id="table">
        <option value="farm">Farm</option>
        <option value="farmAddress">Farm Address</option>
        <option value="farmProvince">Farm Province</option>
        <option value="owns">Owns</option>
        <option value="farmer">Farmer</option>
        <option value="commercial_farmer">Commercial Farmer</option>
        <option value="commercial_farmer_nc">Commercial Farmer NC</option>
        <option value="commercial_farmer_a">Commercial Farmer A</option>
        <option value="sells_to">Sells To</option>
        <option value="sells_to_sale_price">Sells To Sale Price</option>
        <option value="sells_to_sale_quantity">Sells To Sale Quantity</option>
        <option value="trades_with">Trades With</option>
        <option value="trades_with_sale_date">Trades With Sale Date</option>
        <option value="trades_with_quantity">Trades With Quantity</option>
        <option value="grows_crop">Grows Crop</option>
        <option value="grows_crop_type">Grows Crop Type</option>
        <option value="grows_crop_time">Grows Crop Time</option>
        <option value="has_plots_location">Has Plots Location</option>
        <option value="has_plots_type">Has Plots Type</option>
        <option value="has_plots">Has Plots</option>
        <option value="personal_farmer">Personal Farmer</option>
        <option value="personal_farmer_family_size_sc">Personal Farmer Family Size SC</option>
        <option value="personal_farmer_family_size_qs">Personal Farmer Family Size QS</option>
        <option value="works_on">Works On</option>
        <option value="works_on_num_h_fc">Works On Num H FC</option>
        <option value="works_on_num_h_ec">Works On Num H EC</option>
        <option value="machine">Machine</option>
        <option value="machine_type">Machine Type</option>
        <option value="machine_yos">Machine YOS</option>
        <option value="AgencyLocation">Agency Location</option>
        <option value="Agency">Agency</option>
        <option value="Regulates">Regulates</option>
        <option value="WholesaleLocation">Wholesale Location</option>
        <option value="Wholesale">Wholesale</option>
        <option value="Distributes">Distributes</option>
        <option value="GroceryLocation">Grocery Location</option>
        <option value="Grocery">Grocery</option>
    </select>
    <br>
    <br>

    <label for="attributes">Select Attribute(s):</label>
    <select name="attributes[]" id="attributes" multiple>
        <!-- Options will be dynamically added based on the selected table -->
    </select>
    <br>
    <br>

    <input type="submit" name="projectTuples">
</form>

<script>
    document.getElementById('table').addEventListener('change', function() {
        var table = this.value;
        var attributesSelect = document.getElementById('attributes');
        attributesSelect.innerHTML = ''; // Clear previous options

        // Define attributes for each table
        var attributesMap = {
            'farm': ['id', 'address'],
            'farmAddress': ['address', 'postal_code'],
            'farmProvince': ['province', 'postal_code'],
            'owns': ['id', 'sin'],
            'farmer': ['sin', 'name', 'age', 'address'],
            'commercial_farmer': ['sin', 'name', 'age', 'address'],
            'commercial_farmer_nc': ['name', 'phone#', 'company'],
            'commercial_farmer_a': ['address', 'company'],
            'sells_to': ['sale_date', 'wid', 'sin', 'cid'],
            'sells_to_sale_price': ['sale_price', 'sale_date'],
            'sells_to_sale_quantity': ['quantity', 'sale_price'],
            'trades_with': ['sale_date', 'cid', 'farm_trader_A_SIN', 'farm_trader_B_SIN'],
            'trades_with_sale_date': ['sale_date', 'quantity'],
            'trades_with_quantity': ['quantity', 'sale_price'],
            'grows_crop': ['cid', 'name', 'type', 'time_to_yield', 'pid', 'fid'],
            'grows_crop_type': ['price', 'type'],
            'grows_crop_time': ['price', 'time_to_yield'],
            'has_plots_location': ['size', 'price', 'location'],
            'has_plots_type': ['plot_type', 'location'],
            'has_plots': ['pid', 'fid', 'plot_type'],
            'personal_farmer': ['sin', 'name', 'phone#', 'age', 'address', 'family_size'],
            'personal_farmer_family_size_sc': ['family_size', 'self_consumption'],
            'personal_farmer_family_size_qs': ['family_size', 'quantity_sold'],
            'works_on': ['mid', 'pid', 'fid', 'num_hours'],
            'works_on_num_h_fc': ['num_hours', 'fuel_consumption'],
            'works_on_num_h_ec': ['num_hours', 'electricity_consumption'],
            'machine': ['mid', 'type', 'years_of_service'],
            'machine_type': ['type', 'price'],
            'machine_yos': ['years_of_service', 'needs_repair'],
            'AgencyLocation': ['name', 'province', 'director'],
            'Agency': ['aid', 'name', 'province'],
            'Regulates': ['aid', 'fid', 'sin'],
            'WholesaleLocation': ['province', 'postal_code'],
            'Wholesale': ['wid', 'Address', 'Name', 'postal_code'],
            'Distributes': ['wid', 'gid'],
            'GroceryLocation': ['province', 'postal_code'],
            'Grocery': ['gid', 'Address', 'Name', 'postal_code']
        };

        // Populate attributes based on the selected table
        attributesMap[table].forEach(function(attribute) {
            var option = document.createElement('option');
            option.value = attribute;
            option.text = attribute;
            attributesSelect.appendChild(option);
        });
    });
</script>

<hr />

<h2>Select Statistic from Crop.</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="aggregateGroupByTuplesRequest" name="aggregateGroupByTuplesRequest">

    <label for="aggregationType">Select Statistic Type:</label>
    <select name="aggregationType" id="aggregationType">
        <option value="AVG">Average</option>
        <option value="MIN">Minimum</option>
        <option value="MAX">Maximum</option>
    </select>
    <br>
    <h4>Grouping by crop type.</h4>
    <input type="submit" name="aggregateGroupByTuples" value="Get Statistics">
</form>

<hr />

<h2>Select Statistic from Crops Having Some Price.</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="aggregateHavingTuplesRequest" name="aggregateHavingTuplesRequest">

    <label for="aggregationTypeHaving">Select Statistic Type:</label>
    <select name="aggregationTypeHaving" id="aggregationTypeHaving">
        <option value="AVG">Average</option>
        <option value="MIN">Minimum</option>
        <option value="MAX">Maximum</option>
    </select>
    <br>
    <br>
    <label for="operator">Select Comparison:</label>
    <select name="operator" id="operator">
        <option value=">">Greater Than</option>
        <option value="<">Less Than</option>
        <option value=">=">Greater Than or Equal To</option>
        <option value="<=">Less Than or Equal To</option>
        <option value="=">Equal To</option>
    </select>
    <br>
    <br>

    <label for="value">Enter Value:</label>
    <input type="number" name="number" id="number" required>
    <br>

    <h4>Grouping by crop type.</h4>
    <input type="submit" name="aggregateHavingTuples" value="Get Statistics">
</form>

<hr />

<h2>Find Maximum/Minimum average price of a crop type.</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="nestedAggregateGroupByTuplesRequest" name="nestedAggregateGroupByTuplesRequest">
    <label for="aggregationTypeNested">Select Aggregation Function:</label>
    <select name="aggregationTypeNested" id="aggregationTypeNested">
        <option value="MIN">Minimum</option>
        <option value="MAX">Maximum</option>
    </select>
    <br>
    <br>

    <input type="submit" name="nestedAggregateGroupByTuples" value="Get Result">
</form>
<br>
<br>

<hr />

<h2>Farms with addresses in all postal code.</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="submit" name="divideTuples"></p>
</form>

<hr />

<h2>Display Tuples in Farmer</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
    <input type="submit" name="displayTuples"></p>
</form>

<hr />

<h2>Display Tuples in Crop</h2>
<form method="GET" action="CPSC_304_project-Group_23.php">
    <input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
    <input type="submit" name="displayCrop"></p>
</form>

<hr />

<!-- END FRONT END EDITING-->

<?php
// The following code will be parsed as PHP

function debugAlertMessage($message)
{
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}



function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
    //echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;

    $statement = oci_parse($db_conn, $cmdstr);
    //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = oci_execute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For oci_execute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    }

    return $statement;
}

function executeBoundSQL($cmdstr, $list)
{
    /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

    global $db_conn, $success;
    $statement = oci_parse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            //echo $val;
            //echo "<br>".$bind."<br>";
            oci_bind_by_name($statement, $bind, $val);
            unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
        }

        $r = oci_execute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    }
}

function printResult($result)
{ //prints results from a select statement
    echo "<br>Retrieved data from table:<br>";

    $numColumns = oci_num_fields($result);
    $columnNames = array();
    for ($i = 1; $i <= $numColumns; $i++) {
        $columnNames[] = oci_field_name($result, $i);
    }
    echo "<table><tr>";
    foreach ($columnNames as $columnName) {
        echo "<th>$columnName</th>";
    }
    echo "</tr>";
    while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            echo "  <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
}

function connectToDB()
{
    global $db_conn;
    global $config;

    // Your username is ora_(CWL_ID) and the password is a(student number). For example,
    // ora_platypus is the username and a12345678 is the password.
    // $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
    $db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

    if ($db_conn) {
        debugAlertMessage("Database is Connected");
        return true;
    } else {
        debugAlertMessage("Cannot connect to Database");
        $e = OCI_Error(); // For oci_connect errors pass no handle
        echo htmlentities($e['message']);
        return false;
    }
}

function disconnectFromDB()
{
    global $db_conn;

    debugAlertMessage("Disconnect from Database");
    oci_close($db_conn);
}


function handleUpdateRequest()
{
    global $db_conn;

    $sin = $_POST['sin'];
    $new_age = $_POST['newAge'];

    // you need the wrap the old name and new name values with single quotations
    executePlainSQL("UPDATE farmer SET age = " . $new_age . " WHERE sin = '" . $sin . "'");
    oci_commit($db_conn);
}

function handleInsertRequest()
{
    global $db_conn;

    $sin = $_POST['sin'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    // you need the wrap the old name and new name values with single quotations
    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('" . $sin . "', '" . $name . "', " . $phone . ", " . $age . ", '" . $address . "')");
    oci_commit($db_conn);
}

function handleDeleteRequest()
{
    global $db_conn;

    $fid = $_POST['fid'];

    // you need the wrap the old name and new name values with single quotations
    executePlainSQL("DELETE FROM farm WHERE fid = '" . $fid . "'");
    oci_commit($db_conn);
}

function handleJoinRequest()
{
    global $db_conn;

    $result = executePlainSQL("
        SELECT *
        FROM farmProvince fp
        INNER JOIN farmAddress fa ON fp.postal_code = fa.postal_code
    ");

    printResult($result);
}

function handleProjectionRequest()
{
    global $db_conn;

    $table = $_GET['table'];
    $attributes = implode(", ", $_GET['attributes']);

    $result = executePlainSQL("SELECT " . $attributes . " FROM " . $table ."");

    printResult($result);
}

function handleAggregationWithGroupByRequest()
{
    global $db_conn;

    $aggregationType = substr($_GET['aggregationType'], 0, 3); // Get only the first 3 characters

    $result = executePlainSQL("SELECT " . $aggregationType . "(price), type FROM grows_crop_type c GROUP BY c.type");

    printResult($result);
}

function handleAggregationWithHavingRequest()
{
    global $db_conn;

    $aggregationTypeHaving = $_GET['aggregationTypeHaving'] ?? "";
    $operator = $_GET["operator"] ?? "";
    $number = $_GET["number"] ?? "";

    $query = "SELECT TYPE, $aggregationTypeHaving(PRICE) AS AggregationResult FROM grows_crop_type GROUP BY TYPE HAVING $aggregationTypeHaving(PRICE) $operator $number";

    $result = executePlainSQL($query);

    printResult($result);
}

function handleNestedAggregationWithGroupByRequest()
{
    global $db_conn;

    $aggregationTypeNested = $_GET["aggregationTypeNested"] ?? "";

    $query = "
    SELECT $aggregationTypeNested(avg_price) AS aggregated_avg_price
    FROM (
        SELECT AVG(price) AS avg_price
        FROM grows_crop_type
        GROUP BY type
    ) subquery";

    $result = executePlainSQL($query);

    printResult($result);
}


function handleDivisionRequest()
{
    global $db_conn;

    $query = "SELECT DISTINCT f.fid
    FROM farm f
    WHERE NOT EXISTS (
        SELECT pa.postal_code
        FROM farmProvince pa
        WHERE NOT EXISTS (
            SELECT *
            FROM farmAddress fa
            WHERE fa.address = f.address AND fa.postal_code = pa.postal_code
        )
    )";

    $result = executePlainSQL($query);

    printResult($result);
}

function handleSelectRequest()
{
    global $db_conn;

    $conditions = [];

    if (!empty($_GET['sin'])) {
        $conditions[] = "sin = '" . $_GET['sin'] . "'";
    }
    if (!empty($_GET['name'])) {
        $conditions[] = "name = '" . $_GET['name'] . "'";
    }
    if (!empty($_GET['phone'])) {
        $conditions[] = "phone = '" . $_GET['phone'] . "'";
    }
    if (!empty($_GET['age'])) {
        $conditions[] = "age = " . $_GET['age'];
    }
    if (!empty($_GET['address'])) {
        $conditions[] = "address = '" . $_GET['address'] . "'";
    }

    $whereClause = "";
    if (!empty($conditions)) {
        $operator = isset($_GET['operator']) && ($_GET['operator'] == 'OR') ? ' OR ' : ' AND ';
        $whereClause = "WHERE " . implode($operator, $conditions);
    }

    $query = "SELECT * FROM farmer $whereClause";

    $result = executePlainSQL($query);
    printResult($result);
}


function handleDisplayRequest()
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM farmer");
    printResult($result);
}

function handleDisplayCrop()
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM grows_crop_type");
    printResult($result);
}

// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePOSTRequest()
{
    if (connectToDB()) {
        if (array_key_exists('resetTablesRequest', $_POST)) {
            handleResetRequest();
        } else if (array_key_exists('updateQueryRequest', $_POST)) {
            handleUpdateRequest();
        } else if (array_key_exists('insertQueryRequest', $_POST)) {
            handleInsertRequest();
        } else if (array_key_exists('deleteQueryRequest', $_POST)) {
            handleDeleteRequest();
        }

        disconnectFromDB();
    }
}

// HANDLE ALL GET ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handleGETRequest()
{
    if (connectToDB()) {
        if (array_key_exists('joinRequest', $_GET)) {
            handleJoinRequest();
        } elseif (array_key_exists('selectTuples', $_GET)) {
            handleSelectRequest();
        } elseif (array_key_exists('projectTuples', $_GET)) {
            handleProjectionRequest();
        } elseif (array_key_exists('displayTuples', $_GET)) {
            handleDisplayRequest();
        } elseif (array_key_exists('aggregateGroupByTuples', $_GET)) {
            handleAggregationWithGroupByRequest();
        } elseif (array_key_exists('aggregateHavingTuples', $_GET)) {
            handleAggregationWithHavingRequest();
        } elseif (array_key_exists('nestedAggregateGroupByTuples', $_GET)) {
            handleNestedAggregationWithGroupByRequest();
        } elseif (array_key_exists('selectTuples', $_GET)) {
            handleSelectRequest();
        } elseif (array_key_exists('divideTuples', $_GET)) {
            handleDivisionRequest();
        }elseif (array_key_exists('displayCrop', $_GET)) {
            handleDisplayCrop();
        }

        disconnectFromDB();
    }
}

if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
    handlePOSTRequest();
} else if (isset($_GET['joinRequest']) || isset($_GET['selectTuplesRequest']) ||
    isset($_GET['displayTuplesRequest']) || isset($_GET['projectTuplesRequest']) ||
    isset($_GET['aggregateGroupByTuplesRequest']) || isset($_GET['aggregateHavingTuplesRequest'])
    || isset($_GET['nestedAggregateGroupByTuplesRequest']) || isset($_GET['divideTuples']) ||  // Corrected here
    isset($_GET['displayCrop'])) {
    handleGETRequest();
}


function handleResetRequest()
{
    global $db_conn;
    // Drop old table

    // executePlainSQL("DROP TABLE demoTable");

    // Create new table
    // echo "<br> creating new table <br>";

    //executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))"); // This is an example.

    // executePlainSQL("DROP TABLE Regulates");
    // executePlainSQL("DROP TABLE Distributes");
    // executePlainSQL("DROP TABLE Grocery");
    // executePlainSQL("DROP TABLE GroceryLocation");
    // executePlainSQL("DROP TABLE Agency");
    // executePlainSQL("DROP TABLE AgencyLocation");
    // executePlainSQL("DROP TABLE works_on");
    // executePlainSQL("DROP TABLE works_on_num_h_ec")
    // executePlainSQL("DROP TABLE works_on_num_h_fc")
    // executePlainSQL("DROP TABLE machine");
    // executePlainSQL("DROP TABLE machine_yos");
    // executePlainSQL("DROP TABLE machine_type");
    // executePlainSQL("DROP TABLE trades_with");
    // executePlainSQL("DROP TABLE trades_with_sale_date");
    // executePlainSQL("DROP TABLE trades_with_quantity");
    // executePlainSQL("DROP TABLE personal_farmer");
    // executePlainSQL("DROP TABLE personal_farmer_family_size_qs");
    // executePlainSQL("DROP TABLE personal_farmer_family_size_sc");
    // executePlainSQL("DROP TABLE sells_to");
    // executePlainSQL("DROP TABLE sells_to_sale_date");
    // executePlainSQL("DROP TABLE sells_to_sale_quantity");
    // executePlainSQL("DROP TABLE grows_crop");
    // executePlainSQL("DROP TABLE grows_crop_time");
    executePlainSQL("DROP TABLE grows_crop_type");
    // executePlainSQL("DROP TABLE has_plots");
    // executePlainSQL("DROP TABLE has_plots_type");
    // executePlainSQL("DROP TABLE has_plots_location");
    // executePlainSQL("DROP TABLE Wholesale");
    // executePlainSQL("DROP TABLE WholesaleLocation");

    // executePlainSQL("DROP TABLE commercial_farmer");
    // executePlainSQL("DROP TABLE commercial_farmer_a");
    // executePlainSQL("DROP TABLE commercial_farmer_nc");
    executePlainSQL("DROP TABLE owns");
    executePlainSQL("DROP TABLE farmer");
    executePlainSQL("DROP TABLE farm");
    executePlainSQL("DROP TABLE farmAddress");
    executePlainSQL("DROP TABLE farmProvince");

    executePlainSQL("CREATE TABLE farmProvince(
			province CHAR(2),
			postal_code CHAR(7),
			PRIMARY KEY (postal_code))");

    executePlainSQL("CREATE TABLE farmAddress(
			address VARCHAR(30), 
			postal_code CHAR(7) NOT NULL, 
			PRIMARY KEY (address), 
			FOREIGN KEY (postal_code) REFERENCES farmProvince(postal_code))");

    executePlainSQL("CREATE TABLE farm(
			fid VARCHAR(20), 
			address VARCHAR(30) NOT NULL, 
			PRIMARY KEY (fid), 
			FOREIGN KEY (address) REFERENCES farmAddress(address))");

    executePlainSQL("CREATE TABLE farmer(
			sin CHAR(9),
			name VARCHAR(20),
			phone INTEGER,
			age INTEGER,
			address VARCHAR(30),
			PRIMARY KEY (sin))");

    executePlainSQL("CREATE TABLE owns(
    		fid VARCHAR(20) NOT NULL,
    		sin CHAR(9) NOT NULL,
    		PRIMARY KEY (fid, sin),
    		FOREIGN KEY (fid) REFERENCES farm
			ON DELETE CASCADE,
    		FOREIGN KEY (sin) REFERENCES farmer 
			ON DELETE CASCADE)");

    // executePlainSQL("CREATE TABLE commercial_farmer_nc (
    // 		name VARCHAR(20),
    // 		phone INTEGER,
    // 		company VARCHAR(20),
    // 		PRIMARY KEY (name, company))");

    // executePlainSQL("CREATE TABLE commercial_farmer_a (
    // 		address VARCHAR(30),
    // 		company VARCHAR(20) NOT NULL,
    // 		PRIMARY KEY (address),
    // 		FOREIGN KEY (company) REFERENCES commercial_farmer_nc(company))");

    // executePlainSQL("CREATE TABLE commercial_farmer (
    // 		sin CHAR(9) NOT NULL,
    // 		name VARCHAR(20) NOT NULL,
    // 		age INTEGER,
    // 		address VARCHAR(30) NOT NULL,
    // 		PRIMARY KEY (sin),
    // 		FOREIGN KEY (sin) REFERENCES farmer
    // 			ON DELETE CASCADE,
    // 		FOREIGN KEY (name) REFERENCES commercial_farmer_nc(name),
    // 		FOREIGN KEY (address) REFERENCES commercial_farmer_a(address))");

    // executePlainSQL("CREATE TABLE WholesaleLocation (
    // 	province CHAR(2),
    // 	postal_code CHAR(7),
    // 	PRIMARY KEY (postal_code)
    // )");

    // executePlainSQL("CREATE TABLE Wholesale (
    // 	wid VARCHAR(20),
    // 	address VARCHAR(30),
    // 	name VARCHAR(20),
    // 	postal_code CHAR(7) NOT NULL,
    // 	PRIMARY KEY (wid),
    // 	FOREIGN KEY (postal_code) REFERENCES WholesaleLocation)");

    // executePlainSQL("CREATE TABLE has_plots_location (
    // 	size VARCHAR(20),
    // 	price REAL,
    // 	location VARCHAR(20),
    // 	PRIMARY KEY (location)
    // )");

    // executePlainSQL("CREATE TABLE has_plots_type (
    // 	plot_type VARCHAR(20),
    // 	location VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (plot_type),
    // 	FOREIGN KEY (location) REFERENCES has_plots_location)");

    // executePlainSQL("CREATE TABLE has_plots (
    // 	pid VARCHAR(20),
    // 	fid VARCHAR(20) NOT NULL,
    // 	plot_type VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (pid, fid),
    // 	FOREIGN KEY (fid) REFERENCES farm
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (plot_type) REFERENCES has_plots_type
    // )");

    executePlainSQL("CREATE TABLE grows_crop_type (
    	price REAL,
    	type VARCHAR(20),
    	PRIMARY KEY (type, price)
    )");

    // executePlainSQL("CREATE TABLE grows_crop_time (
    // 	price REAL,
    // 	time_to_yield REAL,
    // 	PRIMARY KEY (time_to_yield)
    // )");

    // executePlainSQL("CREATE TABLE grows_crop (
    // 	cid VARCHAR(20),
    // 	name VARCHAR(20),
    // 	type VARCHAR(20) NOT NULL,
    // 	time_to_yield REAL NOT NULL,
    // 	pid VARCHAR(20) NOT NULL,
    // 	fid VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (cid),
    // 	FOREIGN KEY (pid, fid) REFERENCES has_plots
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (type) REFERENCES grows_crop_type,
    // 	FOREIGN KEY (time_to_yield) REFERENCES grows_crop_time
    // )");

    // executePlainSQL("CREATE TABLE sells_to_sale_quantity (
    // 	quantity INTEGER,
    // 	sale_price REAL,
    // 	PRIMARY KEY (quantity)
    // )");

    // executePlainSQL("CREATE TABLE sells_to_sale_date (
    // 	sale_date DATE,
    // 	quantity INTEGER NOT NULL,
    // 	PRIMARY KEY (sale_date),
    // 	FOREIGN KEY (quantity) REFERENCES sells_to_sale_quantity
    // )");

    // executePlainSQL("CREATE TABLE sells_to (
    // 	sale_date DATE NOT NULL,
    // 	wid VARCHAR(20) NOT NULL,
    // 	sin CHAR(9) NOT NULL,
    // 	cid VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (wid, sin, cid),
    // 	FOREIGN KEY (wid) REFERENCES Wholesale
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (sin) REFERENCES farmer
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (cid) REFERENCES grows_crop
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (sale_date) REFERENCES sells_to_sale_date
    // )");

    // executePlainSQL("CREATE TABLE personal_farmer_family_size_sc (
    // 	family_size INTEGER,
    // 	self_consumption INTEGER,
    // 	PRIMARY KEY (family_size)
    // )");

    // executePlainSQL("CREATE TABLE personal_farmer_family_size_qs (
    // 	family_size INTEGER,
    // 	quantity_sold INTEGER,
    // 	PRIMARY KEY (family_size)
    // )");

    // executePlainSQL("CREATE TABLE personal_farmer (
    // 	sin CHAR(9) NOT NULL,
    // 	name VARCHAR(20),
    // 	phone INTEGER,
    // 	age INTEGER,
    // 	address VARCHAR(30),
    // 	family_size INTEGER NOT NULL,
    // 	PRIMARY KEY (sin),
    // 	FOREIGN KEY (sin) REFERENCES farmer
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (family_size) REFERENCES personal_farmer_family_size_sc,
    // 	FOREIGN KEY (family_size) REFERENCES personal_farmer_family_size_qs)");

    // executePlainSQL("CREATE TABLE trades_with_quantity (
    // 	quantity INTEGER,
    // 	sale_price REAL,
    // 	PRIMARY KEY (quantity)
    // )");

    // executePlainSQL("CREATE TABLE trades_with_sale_date (
    // 	sale_date DATE,
    // 	quantity INTEGER NOT NULL,
    // 	PRIMARY KEY (sale_date),
    // 	FOREIGN KEY (quantity) REFERENCES trades_with_quantity
    // )");

    // executePlainSQL("CREATE TABLE trades_with (
    // 	sale_date DATE NOT NULL,
    // 	cid VARCHAR(20) NOT NULL,
    // 	farm_trader_A_SIN CHAR(9) NOT NULL,
    // 	farm_trader_B_SIN CHAR(9) NOT NULL,
    // 	PRIMARY KEY (cid, farm_trader_A_SIN, farm_trader_B_SIN),
    // 	FOREIGN KEY (cid) REFERENCES grows_crop
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (farm_trader_A_SIN) REFERENCES personal_farmer(sin)
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (farm_trader_B_SIN) REFERENCES personal_farmer(sin)
    // 		ON DELETE CASCADE
    // 	FOREIGN KEY (sale_date) REFERENCES trades_with_sale_date
    // )");

    // executePlainSQL("CREATE TABLE machine_type (
    // 	type VARCHAR(20),
    // 	price REAL,
    // 	PRIMARY KEY (type)
    // )");

    // executePlainSQL("CREATE TABLE machine_yos (
    // 	years_of_service INTEGER,
    // 	needs_repair BOOL,
    // 	PRIMARY KEY (years_of_service)
    // )");

    // executePlainSQL("CREATE TABLE machine (
    // 	mid VARCHAR(20),
    // 	type VARCHAR(20) NOT NULL,
    // 	years_of_service INTEGER NOT NULL,
    // 	PRIMARY KEY (mid),
    // 	FOREIGN KEY (type) REFERENCES machine_type,
    // 	FOREIGN KEY (years_of_service) REFERENCES machine_yos
    // )");

    // executePlainSQL("CREATE TABLE works_on_num_h_fc (
    // 	num_hours REAL,
    // 	fuel_consumption REAL,
    // 	PRIMARY KEY (num_hours)
    // );");

    // executePlainSQL("CREATE TABLE works_on_num_h_ec (
    // 	num_hours REAL,
    // 	electricity_consumption REAL,
    // 	PRIMARY KEY (num_hours)
    // )");

    // executePlainSQL("CREATE TABLE works_on (
    // 	mid VARCHAR(20) NOT NULL,
    // 	pid VARCHAR(20) NOT NULL,
    // 	fid VARCHAR(20) NOT NULL,
    // 	num_hours REAL NOT NULL,
    // 	PRIMARY KEY (mid, pid, fid),
    // 	FOREIGN KEY (pid, fid) REFERENCES has_plots
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (mid) REFERENCES machine
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (num_hours) REFERENCES works_on_num_h_fc,
    // 	FOREIGN KEY (num_hours) REFERENCES works_on_num_h_ec
    // )");

    // executePlainSQL("CREATE TABLE AgencyLocation (
    // 	name VARCHAR(20),
    // 	province CHAR(2),
    // 	director VARCHAR(20),
    // 	PRIMARY KEY (name, province),
    // 	UNIQUE (director, province)
    // )");

    // executePlainSQL("CREATE TABLE Agency (
    // 	aid VARCHAR(20),
    // 	name VARCHAR(20) NOT NULL,
    // 	province CHAR(2) NOT NULL,
    // 	PRIMARY KEY (aid),
    // 	FOREIGN KEY (name, province) REFERENCES AgencyLocation
    // )");

    // executePlainSQL("CREATE TABLE Regulates (
    // 	aid VARCHAR(20) NOT NULL,
    // 	fid VARCHAR(20) NOT NULL,
    // 	sin VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (aid, sin, fid),
    // 	FOREIGN KEY (aid) REFERENCES Agency
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (sin) REFERENCES farmer
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (fid) REFERENCES farm
    // 		ON DELETE CASCADE
    // )");

    // executePlainSQL("CREATE TABLE Distributes (
    // 	wid VARCHAR(20) NOT NULL,
    // 	gid VARCHAR(20) NOT NULL,
    // 	PRIMARY KEY (wid, gid),
    // 	FOREIGN KEY (wid) REFERENCES Wholesale
    // 		ON DELETE CASCADE,
    // 	FOREIGN KEY (gid) REFERENCES Grocery
    // 		ON DELETE CASCADE
    // )");

    // executePlainSQL("CREATE TABLE GroceryLocation (
    // 	province CHAR(2),
    // 	postal_code CHAR(7),
    // 	PRIMARY KEY (postal_code)
    // )");

    // executePlainSQL("CREATE TABLE Grocery (
    // 	gid VARCHAR(20),
    // 	address VARCHAR(30),
    // 	name VARCHAR(20),
    // 	postal_code CHAR(7) NOT NULL,
    // 	PRIMARY KEY (gid),
    // 	FOREIGN KEY (postal_code) REFERENCES GroceryLocation
    // )");

    // Insertion examples for grows_crop_type
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (10.00, 'Corn')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Corn')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (20.00, 'Tomato')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Tomato')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Potato')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (40.00, 'Carrot')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Lettuce')");
    executePlainSQL("INSERT INTO grows_crop_type (price, type) VALUES (90.00, 'Lettuce')");

    executePlainSQL("INSERT INTO farmProvince (province, postal_code) VALUES ('ON', 'M5V 2T6')");
    executePlainSQL("INSERT INTO farmProvince (province, postal_code) VALUES ('QC', 'H2X 1Y4')");
    executePlainSQL("INSERT INTO farmProvince (province, postal_code) VALUES ('SK', 'S4P 3Y2')");
    executePlainSQL("INSERT INTO farmProvince (province, postal_code) VALUES ('NS', 'B3H 1W5')");
    executePlainSQL("INSERT INTO farmProvince (province, postal_code) VALUES ('PE', 'C1A 9L9')");

    executePlainSQL("INSERT INTO farmAddress (address, postal_code) VALUES ('345 Dairy Lane', 'M5V 2T6')");
    executePlainSQL("INSERT INTO farmAddress (address, postal_code) VALUES ('678 Barnyard Road', 'H2X 1Y4')");
    executePlainSQL("INSERT INTO farmAddress (address, postal_code) VALUES ('910 Poultry Place', 'S4P 3Y2')");
    executePlainSQL("INSERT INTO farmAddress (address, postal_code) VALUES ('111 Orchard Street', 'B3H 1W5')");
    executePlainSQL("INSERT INTO farmAddress (address, postal_code) VALUES ('222 Greenhouse Avenue', 'C1A 9L9')");

    executePlainSQL("INSERT INTO farm (fid, address) VALUES ('F006', '345 Dairy Lane')");
    executePlainSQL("INSERT INTO farm (fid, address) VALUES ('F007', '678 Barnyard Road')");
    executePlainSQL("INSERT INTO farm (fid, address) VALUES ('F008', '910 Poultry Place')");
    executePlainSQL("INSERT INTO farm (fid, address) VALUES ('F009', '111 Orchard Street')");
    executePlainSQL("INSERT INTO farm (fid, address) VALUES ('F010', '222 Greenhouse Avenue')");

    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('123456789', 'John Doe', 1234567890, 35, '345 Dairy Lane')");
    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('234567890', 'Jane Smith', 2345678901, 42, '678 Barnyard Road')");
    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('345678901', 'Alice Johnson', 3456789012, 28, '910 Poultry Place')");
    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('456789012', 'Bob Brown', 4567890123, 55, '111 Orchard Street')");
    executePlainSQL("INSERT INTO farmer (sin, name, phone, age, address) VALUES ('567890123', 'Eve Wilson', 5678901234, 48, '222 Greenhouse Avenue')");

    // Insertion examples for owns
    executePlainSQL("INSERT INTO owns (fid, sin) VALUES ('F006', '123456789')");
    executePlainSQL("INSERT INTO owns (fid, sin) VALUES ('F007', '234567890')");
    executePlainSQL("INSERT INTO owns (fid, sin) VALUES ('F008', '345678901')");
    executePlainSQL("INSERT INTO owns (fid, sin) VALUES ('F009', '456789012')");
    executePlainSQL("INSERT INTO owns (fid, sin) VALUES ('F010', '567890123')");

    // // Insertion examples for commercial_farmer_nc
    // executePlainSQL("INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Mark Johnson', 1112223333, 'FarmersCo')");
    // executePlainSQL("INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Emily Davis', 4445556666, 'AgroTech')");
    // executePlainSQL("INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Michael Wilson', 7778889999, 'GreenFields')");
    // executePlainSQL("INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Sarah Brown', 1011121314, 'NatureFresh')");
    // executePlainSQL("INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('David Smith', 1516171819, 'BioFarms')");

    // // Insertion examples for commercial_farmer_a
    // executePlainSQL("INSERT INTO commercial_farmer_a (address, company) VALUES ('345 Agro Way', 'FarmersCo')");
    // executePlainSQL("INSERT INTO commercial_farmer_a (address, company) VALUES ('678 Tech Blvd', 'AgroTech')");
    // executePlainSQL("INSERT INTO commercial_farmer_a (address, company) VALUES ('910 Green St', 'GreenFields')");
    // executePlainSQL("INSERT INTO commercial_farmer_a (address, company) VALUES ('111 Nature Drive', 'NatureFresh')");
    // executePlainSQL("INSERT INTO commercial_farmer_a (address, company) VALUES ('222 Bio Court', 'BioFarms')");

    // // Insertion examples for commercial_farmer
    // executePlainSQL("INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('123456789', 'Mark Johnson', 35, '345 Agro Way')");
    // executePlainSQL("INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('234567890', 'Emily Davis', 40, '678 Tech Blvd')");
    // executePlainSQL("INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('345678901', 'Michael Wilson', 30, '910 Green St')");
    // executePlainSQL("INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('456789012', 'Sarah Brown', 45, '111 Nature Drive')");
    // executePlainSQL("INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('567890123', 'David Smith', 50, '222 Bio Court')");

    // // Insertion examples for WholesaleLocation
    // executePlainSQL("INSERT INTO WholesaleLocation (province, postal_code) VALUES ('SK', 'S7K 3J8')");
    // executePlainSQL("INSERT INTO WholesaleLocation (province, postal_code) VALUES ('NS', 'B3H 1W5')");
    // executePlainSQL("INSERT INTO WholesaleLocation (province, postal_code) VALUES ('AB', 'T5J 2N3')");
    // executePlainSQL("INSERT INTO WholesaleLocation (province, postal_code) VALUES ('QC', 'H2Y 1L6')");
    // executePlainSQL("INSERT INTO WholesaleLocation (province, postal_code) VALUES ('ON', 'M5V 2T6')");

    // // Insertion examples for Wholesale
    // executePlainSQL("INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W001', '345 Distribution St', 'FoodMart', 'S7K 3J8')");
    // executePlainSQL("INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W002', '678 Wholesome Rd', 'GroceryWorld', 'B3H 1W5')");
    // executePlainSQL("INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W003', '910 Wholesale Ave', 'FreshFoods', 'T5J 2N3')");
    // executePlainSQL("INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W004', '111 Bulk St', 'FarmersBazaar', 'H2Y 1L6')");
    // executePlainSQL("INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W005', '222 Bulk Warehouse', 'GreenGrocers', 'M5V 2T6')");

    // // Insertion examples for has_plots_location
    // executePlainSQL("INSERT INTO has_plots_location (size, price, location) VALUES ('Small', 1000.00, 'Plot_A')");
    // executePlainSQL("INSERT INTO has_plots_location (size, price, location) VALUES ('Medium', 2000.00, 'Plot_B')");
    // executePlainSQL("INSERT INTO has_plots_location (size, price, location) VALUES ('Large', 3000.00, 'Plot_C')");
    // executePlainSQL("INSERT INTO has_plots_location (size, price, location) VALUES ('Extra Large', 4000.00, 'Plot_D')");
    // executePlainSQL("INSERT INTO has_plots_location (size, price, location) VALUES ('Giant', 5000.00, 'Plot_E')");

    // // Insertion examples for has_plots_type
    // executePlainSQL("INSERT INTO has_plots_type (plot_type, location) VALUES ('Corn', 'Plot_A')");
    // executePlainSQL("INSERT INTO has_plots_type (plot_type, location) VALUES ('Tomato', 'Plot_B')");
    // executePlainSQL("INSERT INTO has_plots_type (plot_type, location) VALUES ('Potato', 'Plot_C')");
    // executePlainSQL("INSERT INTO has_plots_type (plot_type, location) VALUES ('Carrot', 'Plot_D')");
    // executePlainSQL("INSERT INTO has_plots_type (plot_type, location) VALUES ('Lettuce', 'Plot_E')");

    // // Insertion examples for has_plots
    // executePlainSQL("INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P001', 'F006', 'Corn')");
    // executePlainSQL("INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P002', 'F007', 'Tomato')");
    // executePlainSQL("INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P003', 'F008', 'Potato')");
    // executePlainSQL("INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P004', 'F009', 'Carrot')");
    // executePlainSQL("INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P005', 'F010', 'Lettuce')");


    // // Insertion examples for grows_crop_time
    // executePlainSQL("INSERT INTO grows_crop_time (price, time_to_yield) VALUES (10.00, 90.0)");
    // executePlainSQL("INSERT INTO grows_crop_time (price, time_to_yield) VALUES (20.00, 120.0)");
    // executePlainSQL("INSERT INTO grows_crop_time (price, time_to_yield) VALUES (30.00, 150.0)");
    // executePlainSQL("INSERT INTO grows_crop_time (price, time_to_yield) VALUES (40.00, 180.0)");
    // executePlainSQL("INSERT INTO grows_crop_time (price, time_to_yield) VALUES (50.00, 210.0)");

    // // Insertion examples for grows_crop
    // executePlainSQL("INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C001', 'Cornfield', 'Corn', 90.0, 'P001', 'F006')");
    // executePlainSQL("INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C002', 'Tomatoland', 'Tomato', 120.0, 'P002', 'F007')");
    // executePlainSQL("INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C003', 'Potato Patch', 'Potato', 150.0, 'P003', 'F008')");
    // executePlainSQL("INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C004', 'Carrot Corner', 'Carrot', 180.0, 'P004', 'F009')");
    // executePlainSQL("INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C005', 'Lettuce Lane', 'Lettuce', 210.0, 'P005', 'F010')");

    // // Insertion examples for sells_to_sale_quantity
    // executePlainSQL("INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (100, 1000.00)");
    // executePlainSQL("INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (200, 2000.00)");
    // executePlainSQL("INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (300, 3000.00)");
    // executePlainSQL("INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (400, 4000.00)");
    // executePlainSQL("INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (500, 5000.00)");

    // // Insertion examples for sells_to_sale_date
    // executePlainSQL("INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-01', 100)");
    // executePlainSQL("INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-02', 200)");
    // executePlainSQL("INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-03', 300)");
    // executePlainSQL("INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-04', 400)");
    // executePlainSQL("INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-05', 500)");

    // // Insertion examples for sells_to
    // executePlainSQL("INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-01', 'W001', '123456789', 'C001')");
    // executePlainSQL("INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-02', 'W002', '234567890', 'C002')");
    // executePlainSQL("INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-03', 'W003', '345678901', 'C003')");
    // executePlainSQL("INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-04', 'W004', '456789012', 'C004')");
    // executePlainSQL("INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-05', 'W005', '567890123', 'C005')");

    // // Insertion examples for personal_farmer_family_size_sc
    // executePlainSQL("INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (1, 50)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (2, 100)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (3, 150)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (4, 200)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (5, 250)");

    // // Insertion examples for personal_farmer_family_size_qs
    // executePlainSQL("INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (1, 25)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (2, 50)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (3, 75)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (4, 100)");
    // executePlainSQL("INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (5, 125)");

    // // Insertion examples for personal_farmer
    // executePlainSQL("INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('123456789', 'John Doe', 1234567890, 35, '345 Dairy Lane', 1)");
    // executePlainSQL("INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('234567890', 'Jane Smith', 2345678901, 42, '678 Barnyard Road', 2)");
    // executePlainSQL("INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('345678901', 'Alice Johnson', 3456789012, 28, '910 Poultry Place', 3)");
    // executePlainSQL("INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('456789012', 'Bob Brown', 4567890123, 55, '111 Orchard Street', 4)");
    // executePlainSQL("INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('567890123', 'Eve Wilson', 5678901234, 48, '222 Greenhouse Avenue', 5)");

    // // Insertion examples for trades_with_quantity
    // executePlainSQL("INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (50, 500.00)");
    // executePlainSQL("INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (100, 1000.00)");
    // executePlainSQL("INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (150, 1500.00)");
    // executePlainSQL("INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (200, 2000.00)");
    // executePlainSQL("INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (250, 2500.00)");

    // // Insertion examples for trades_with_sale_date
    // executePlainSQL("INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-01', 50)");
    // executePlainSQL("INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-02', 100)");
    // executePlainSQL("INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-03', 150)");
    // executePlainSQL("INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-04', 200)");
    // executePlainSQL("INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-05', 250)");

    // // Insertion examples for trades_with
    // executePlainSQL("INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-01', 'C001', '123456789', '234567890')");
    // executePlainSQL("INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-02', 'C002', '234567890', '345678901')");
    // executePlainSQL("INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-03', 'C003', '345678901', '456789012')");
    // executePlainSQL("INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-04', 'C004', '456789012', '567890123')");
    // executePlainSQL("INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-05', 'C005', '567890123', '123456789')");

    // // Insertion examples for machine_type
    // executePlainSQL("INSERT INTO machine_type (type, price) VALUES ('Tractor', 10000.00)");
    // executePlainSQL("INSERT INTO machine_type (type, price) VALUES ('Harvester', 20000.00)");
    // executePlainSQL("INSERT INTO machine_type (type, price) VALUES ('Seeder', 30000.00)");
    // executePlainSQL("INSERT INTO machine_type (type, price) VALUES ('Plough', 40000.00)");
    // executePlainSQL("INSERT INTO machine_type (type, price) VALUES ('Sprayer', 50000.00)");

    // // Insertion examples for machine_yos
    // executePlainSQL("INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (1, FALSE)");
    // executePlainSQL("INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (2, FALSE)");
    // executePlainSQL("INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (3, TRUE)");
    // executePlainSQL("INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (4, TRUE)");
    // executePlainSQL("INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (5, TRUE)");

    // // Insertion examples for machine
    // executePlainSQL("INSERT INTO machine (mid, type, years_of_service) VALUES ('M001', 'Tractor', 1)");
    // executePlainSQL("INSERT INTO machine (mid, type, years_of_service) VALUES ('M002', 'Harvester', 2)");
    // executePlainSQL("INSERT INTO machine (mid, type, years_of_service) VALUES ('M003', 'Seeder', 3)");
    // executePlainSQL("INSERT INTO machine (mid, type, years_of_service) VALUES ('M004', 'Plough', 4)");
    // executePlainSQL("INSERT INTO machine (mid, type, years_of_service) VALUES ('M005', 'Sprayer', 5)");

    // // Insertion examples for works_on_num_h_fc
    // executePlainSQL("INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (1.0, 10.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (2.0, 20.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (3.0, 30.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (4.0, 40.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (5.0, 50.00)");

    // // Insertion examples for works_on_num_h_ec
    // executePlainSQL("INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (1.0, 100.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (2.0, 200.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (3.0, 300.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (4.0, 400.00)");
    // executePlainSQL("INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (5.0, 500.00)");

    // // Insertion examples for works_on
    // executePlainSQL("INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M001', 'P001', 'F006', 1.0)");
    // executePlainSQL("INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M002', 'P002', 'F007', 2.0)");
    // executePlainSQL("INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M003', 'P003', 'F008', 3.0)");
    // executePlainSQL("INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M004', 'P004', 'F009', 4.0)");
    // executePlainSQL("INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M005', 'P005', 'F010', 5.0)");

    // // Insertion examples for AgencyLocation
    // executePlainSQL("INSERT INTO AgencyLocation (name, province, director) VALUES ('AgroCare', 'ON', 'John Smith')");
    // executePlainSQL("INSERT INTO AgencyLocation (name, province, director) VALUES ('FarmSolutions', 'AB', 'Jane Doe')");
    // executePlainSQL("INSERT INTO AgencyLocation (name, province, director) VALUES ('GrowersHub', 'BC', 'Alice Johnson')");
    // executePlainSQL("INSERT INTO AgencyLocation (name, province, director) VALUES ('AgriTech', 'QC', 'Bob Brown')");
    // executePlainSQL("INSERT INTO AgencyLocation (name, province, director) VALUES ('HarvestFirst', 'NS', 'Eve Wilson')");

    // // Insertion examples for Agency
    // executePlainSQL("INSERT INTO Agency (aid, name, province) VALUES ('A001', 'AgroCare', 'ON')");
    // executePlainSQL("INSERT INTO Agency (aid, name, province) VALUES ('A002', 'FarmSolutions', 'AB')");
    // executePlainSQL("INSERT INTO Agency (aid, name, province) VALUES ('A003', 'GrowersHub', 'BC')");
    // executePlainSQL("INSERT INTO Agency (aid, name, province) VALUES ('A004', 'AgriTech', 'QC')");
    // executePlainSQL("INSERT INTO Agency (aid, name, province) VALUES ('A005', 'HarvestFirst', 'NS')");

    // // Insertion examples for Regulates
    // executePlainSQL("INSERT INTO Regulates (aid, fid, sin) VALUES ('A001', 'F001', '123456789')");
    // executePlainSQL("INSERT INTO Regulates (aid, fid, sin) VALUES ('A002', 'F002', '234567890')");
    // executePlainSQL("INSERT INTO Regulates (aid, fid, sin) VALUES ('A003', 'F003', '345678901')");
    // executePlainSQL("INSERT INTO Regulates (aid, fid, sin) VALUES ('A004', 'F004', '456789012')");
    // executePlainSQL("INSERT INTO Regulates (aid, fid, sin) VALUES ('A005', 'F005', '567890123')");

    // // Insertion examples for Distributes
    // executePlainSQL("INSERT INTO Distributes (wid, gid) VALUES ('W001', 'G001')");
    // executePlainSQL("INSERT INTO Distributes (wid, gid) VALUES ('W002', 'G002')");
    // executePlainSQL("INSERT INTO Distributes (wid, gid) VALUES ('W003', 'G003')");
    // executePlainSQL("INSERT INTO Distributes (wid, gid) VALUES ('W004', 'G004')");
    // executePlainSQL("INSERT INTO Distributes (wid, gid) VALUES ('W005', 'G005')");

    // // Insertion examples for GroceryLocation
    // executePlainSQL("INSERT INTO GroceryLocation (province, postal_code) VALUES ('ON', 'L1V 1N6')");
    // executePlainSQL("INSERT INTO GroceryLocation (province, postal_code) VALUES ('AB', 'T2P 2G8')");
    // executePlainSQL("INSERT INTO GroceryLocation (province, postal_code) VALUES ('BC', 'V6C 1S4')");
    // executePlainSQL("INSERT INTO GroceryLocation (province, postal_code) VALUES ('QC', 'H2Y 1C6')");
    // executePlainSQL("INSERT INTO GroceryLocation (province, postal_code) VALUES ('NS', 'B3J 3S9')");

    // // Insertion examples for Grocery
    // executePlainSQL("INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G001', '123 Market Street', 'FreshMart', 'L1V 1N6')");
    // executePlainSQL("INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G002', '456 Farm Road', 'OrganicGrocer', 'T2P 2G8')");
    // executePlainSQL("INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G003', '789 Orchard Avenue', 'HealthyHarvest', 'V6C 1S4')");
    // executePlainSQL("INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G004', '101 Supermarket Lane', 'GreenGrocery', 'H2Y 1C6')");
    // executePlainSQL("INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G005', '202 Fresh Plaza', 'Nature\'sBest', 'B3J 3S9')");

    // //TODO

    oci_commit($db_conn);
}

// End PHP parsing and send the rest of the HTML content
?>
</body>

</html>