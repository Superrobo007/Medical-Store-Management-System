<head>
<meta charset="utf-8">
<title>Add Medicine (NEW)</title>
	<h1 style="text-align: center;color:#004080;font-size: 60px ">MEDSHOP</h1>
</head>
<form action="addmednew.php" method="post">
<body>
	
	<link rel="stylesheet" href="admed.css" >
	<center><h2>Update Medicine Status</h2>
	<h4>Medicine Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id ="t1" name="mnam" required /></h4>	<h4>Medicine Formula &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id ="t1" name="mform" required  /></h4>	<h4>Company Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id ="t1" name="compnam" required /></h4>
		<h4>Unit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id ="t1" name="unit" required  /></h4>
		<h4>Batch No #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id ="t1" name="btch" required /></h4>
		<h4>Expiry Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id ="t1" name="edate" placeholder="DD-MMM-YYYY" required /></h4>
	
	
	<input name="submit" type="submit" id ="Register" value="Register"  />
	
</body>
   <center> <A HREF = "http://localhost/project/Inventory.html">Back</A>
<footer>
    <h3 style="font-size:200%;color: Black"> &copy; 2024 CSAI.Amrita Vishwa Vidyapeetham</h3></center>
	</footer>
</form>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $conn = new mysqli('localhost', 'root', '', 'pharmacy_management_master');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mname = $_POST['mnam'];
    $mform = $_POST['mform'];
    $comp = $_POST['compnam'];
    $unit = $_POST['unit'];
    $batch = $_POST['btch'];
    $exp = $_POST['edate'];

    $stmt = $conn->prepare("INSERT INTO Medicine (name, formula, company_name, unit, batch_no, expiry_date) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssis", $mname, $mform, $comp, $unit, $batch, $exp);
        $success = $stmt->execute();
        if ($success) {
            echo "<script type='text/javascript'> alert('Successful!') </script>";
        } else {
            echo "<script type='text/javascript'> alert('Unsuccessful!') </script>";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();
}
?>
