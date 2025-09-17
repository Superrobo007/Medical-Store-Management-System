<head>
<meta charset="utf-8">
<title>Add Employee</title>
	<h1 style="text-align: center;color:#004080;font-size: 60px ">MEDSHOP</h1>
</head>
<form action="addemp.php" method="post">
<body>
<link rel="stylesheet" href="addemp.css" >
	<center>
		<h4>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="text" id ="t1" name="nam" required /></h4>
		<h4>Date of Birth&nbsp;&nbsp;&nbsp;<input type="text" id ="t1" name="dob" placeholder="DD-MMM-YYYY" required/></h4>
		<h4>Phone #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" id ="t1" name="pho"  required/></h4>
		<h4>Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id ="t1" name="addres" required /></h4>
		<h4>Salary #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" id ="t1" name="sal" required /></h4>
		<h4>Duty&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id ="t1" name="dutyshift" required  /></h4>
		<h4>Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id ="t1" name="usr" required /></h4>
		<h4>Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<input type="password" id ="t1" name="pswd"  required /></h4>

	<input name="submit" type="submit" id ="Register" value="Register"  /><br>
		
	</center>
	
</body>
<center> <A HREF = "http://localhost/project/emp.html">Back</A>
<footer>
    <h3 style="font-size:200%;color: white"> &copy; 2024 CSAI.Amrita Vishwa Vidyapeetham</h3></center>
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

    $name = $_POST['nam'];
    $dateb = $_POST['dob'];
    $fone = (int)$_POST['pho'];
    $adres = $_POST['addres'];
    $salry = (int)$_POST['sal'];
    $ds = $_POST['dutyshift'];
    $use = $_POST['usr'];
    $pas = $_POST['pswd'];
    $dateb_formatted = date('Y-m-d', strtotime($dateb));
    $stmt = $conn->prepare("INSERT INTO Employee (ename, dob, ephone, eaddress, esal, duty, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssisssss", $name, $dateb_formatted, $fone, $adres, $salry, $ds, $use, $pas);
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
