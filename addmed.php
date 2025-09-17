<head>
<meta charset="utf-8">
<title>Add Medicine</title>
	<h1 style="text-align: center;color:#004080;font-size: 60px ">MEDSHOP</h1>
</head>
<form action="addmed.php" method="post">
<body>
	
	<link rel="stylesheet" href="admed.css" >
	<center><h2>Update Medicine Status</h2>
	<h4>Medicine Number #&nbsp;&nbsp; <input type="number" id ="t1" name="mnum" required /></h4>	<h4>Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" id ="t1" name="qty" required  /></h4>	<h4>price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" id ="t1" name="pris" required /></h4>
		<h4>Supplier ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" id ="t1" name="supid"  required /></h4>
		<h4>Invoice No #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" id ="t1" name="invno" required /></h4>
	
	
	<input name="submit" type="submit" id ="Register" value="Register"  />
		
	</center>
	
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

    $mnum = $_POST['mnum'];
    $qty = $_POST['qty'];
    $pris = $_POST['pris'];
    $supid = $_POST['supid'];
    $invno = $_POST['invno'];

    $stmt = $conn->prepare("INSERT INTO Medicine (mno, quantity, price, supplier_id, invoice_no) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iiiii", $mnum, $qty, $pris, $supid, $invno);
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
