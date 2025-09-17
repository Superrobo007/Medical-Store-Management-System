<!DOCTYPE html>
<html>
<head>
    <title>Sale</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        .form-section, .table-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        input[type="text"], input[type="number"], input[type="submit"], input[type="button"] {
            padding: 10px;
            margin: 5px;
        }
    </style>
    <script>
        function calctotal() {
            var t1 = parseFloat(document.getElementById('total').value);
            var t2 = parseFloat(document.getElementById('disc').value);
            var t3 = parseFloat(document.getElementById('cash').value);
            var t4 = t1 - (t2 * t1 / 100);
            if (t3 === 0 || t3 < t4) {
                alert("Please insert amount or add more");
                return false;
            }
            t4 = Math.round(t4);
            document.getElementById('net').value = t4;
            document.getElementById('bal').value = t3 - t4;
        }
    </script>
</head>
<body>
<div class="container">
    <form action="sales.php" method="post" class="form-section">
        Customer Name: <input type="text" name="cname" id="cname" value="<?php echo isset($_POST['cname']) ? $_POST['cname'] : ''; ?>" />
        <input type="submit" value="New Customer" name="newcust" />
        <br/><br/>
        <fieldset>
            <legend>Medicines:</legend>
            Medicine Name: <input type="text" name="mname" id="mname" value="<?php echo isset($_POST['mname']) ? $_POST['mname'] : ''; ?>" />
            Medicine ID: <input type="text" name="mid" id="mid" value="<?php echo isset($_POST['mid']) ? $_POST['mid'] : ''; ?>" />
            Quantity: <input type="number" name="mquantity" id="mquantity" value="<?php echo isset($_POST['mquantity']) ? $_POST['mquantity'] : 0; ?>" />
            Price: <input type="number" name="mprice" id="mprice" value="<?php echo isset($_POST['mprice']) ? $_POST['mprice'] : 0; ?>" /><br/><br/>
            <input type="submit" value="Search" name="search"></input>
            <input type="submit" value="Show All" name="all" ></input><br/><br/>
            <input type="submit" value="Add" name="addtotable" ></input><br/><br/>
        </fieldset>
        <fieldset>
            <legend>Payment:</legend>
            Total: <input type="number" name="total" id="total" value="<?php echo isset($_POST['total']) ? $_POST['total'] : 0; ?>" /><br>
            Discount%: <input type="number" name="disc" id="disc" value="<?php echo isset($_POST['disc']) ? $_POST['disc'] : 0; ?>" />
            Net Total: <input type="number" name="net" id="net" /><br>
            Cash: <input type="number" name="cash" id="cash" value="<?php echo isset($_POST['cash']) ? $_POST['cash'] : 0; ?>" /><br>
            Balance: <input type="number" name="bal" id="bal" /><br>
            <input type="button" value="Calculate" onclick="calctotal();"></input><br/><br/><br/>
        </fieldset>
        <input type="submit" value="Print" name='receipt' ></input>
    </form>
    <div class="table-section">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pharmacy_management_master";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['newcust'])) {
            $sql = "INSERT INTO Orders (customer_name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_POST['cname']);
            $stmt->execute();
            $stmt->close();
        }

        if (isset($_POST['search'])) {
            $sql = "SELECT * FROM Medicine WHERE mno = ? OR name LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $_POST['mid'], $_POST['mname']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "<table class='top'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['mno'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No medicines found.";
            }
            $stmt->close();
        }

        if (isset($_POST['all'])) {
            $sql = "SELECT * FROM Medicine";
            $result = $conn->query($sql);
            echo "<table class='top'>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['name'] . "</td><td>" . $row['mno'] . "</td></tr>";
            }
            echo "</table>";
        }

        if (isset($_POST['addtotable'])) {
            // Check if the medicine ID exists in the Medicine table
            $checkSql = "SELECT mno FROM Medicine WHERE mno = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("i", $_POST['mid']);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            if ($result->num_rows == 0) {
                echo "Error: Medicine ID does not exist.";
            } else {
                // Medicine ID exists, proceed with inserting the order and contains data
                $sqlOrder = "INSERT INTO Orders (customer_name, total_amount, discount, net_total, cash_received, balance) VALUES (?, ?, ?, ?, ?, ?)";
                $stmtOrder = $conn->prepare($sqlOrder);
                $stmtOrder->bind_param("sddddd", $_POST['cname'], $_POST['total'], $_POST['disc'], $_POST['net'], $_POST['cash'], $_POST['bal']);
                $stmtOrder->execute();
                $orderNo = $stmtOrder->insert_id;
                $stmtOrder->close();

                $sqlContains = "INSERT INTO Contains (order_no, medno, quantity) VALUES (?, ?, ?)";
                $stmtContains = $conn->prepare($sqlContains);
                $stmtContains->bind_param("iii", $orderNo, $_POST['mid'], $_POST['mquantity']);
                $stmtContains->execute();
                $stmtContains->close();

                // Fetch and display the medicine details
                $sqlFetch = "SELECT Medicine.name, Contains.quantity FROM Contains JOIN Medicine ON Contains.medno = Medicine.mno WHERE Contains.order_no = ?";
                $stmtFetch = $conn->prepare($sqlFetch);
                $stmtFetch->bind_param("i", $orderNo);
                $stmtFetch->execute();
                $resultFetch = $stmtFetch->get_result();
                if ($resultFetch->num_rows > 0) {
                    echo "<table><tr><th>Medicine Name</th><th>Quantity</th></tr>";
                    while ($row = $resultFetch->fetch_assoc()) {
                        echo "<tr><td>" . $row['name'] . "</td><td>" . $row['quantity'] . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No medicines found in the order.";
                }
                $stmtFetch->close();
            }
            $checkStmt->close();
        }

        if (isset($_POST['receipt'])) {
            echo "Customer Name: " . $_POST['cname'] . "<br>";
            echo "Total: " . $_POST['total'] . "<br>";
            echo "Discount: " . $_POST['disc'] . "<br>";
            echo "Cash: " . $_POST['cash'] . "<br>";
            echo "Net Total: " . $_POST['net'] . "<br>";
            echo "Balance: " . $_POST['bal'] . "<br>";

            // Fetching the details of the medicines added to the order
            $sql = "SELECT m.name, c.quantity FROM Medicine m JOIN Contains c ON m.mno = c.medno WHERE c.order_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $orderNo); // Assuming $orderNo is the ID of the latest order
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "<table class='top'>";
                echo "<tr><th>Medicine Name</th><th>Quantity</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['quantity'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No medicines found in the order.<br>";
            }
            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
