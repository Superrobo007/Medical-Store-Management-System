<head>

<title>Update Employee</title>
	<h1 style="text-align: center;color:#004080;font-size: 60px ">MEDSHOP</h1>
</head>
<form action="updtemp.php" method="post">
<body>
	<link rel="stylesheet" href="updtem.css" >
	<center><h2>Update Employee Data</h2></center>
	<center><h4>Please Enter Employee Number #</h4><input type="number" id ="t1" name="eno" required /><br>
		<h4>Select The Value You Want To Update</h4>
		<select name="action" id="t1" required>
			<option>Name</option>
			<option>Date of Birth</option>
			<option>Phone #</option>
			<option>Address</option>
			<option>Salary #</option>
			<option>Duty</option>
			<option>Username</option>
			<option>Password</option>
			</select>
		<center><h4>Please Enter The value #</h4><input type="text" id ="t1" name="val" required /><br><br>
		<input name="submit" type="submit" id ="t1" value="Update"  />
	
</body>
<center> <A HREF = "http://localhost/project/emp.html">Back</A>
<footer>
    <h3 style="font-size:200%;color: white"> &copy;2024 CSAI.Amrita Vishwa Vidyapeetham</h3></center>
	</footer>

</form>

<?php
if (isset($_POST['submit'])) {
    $conn = new mysqli('localhost', 'root', '', 'pharmacy_management_master');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $enum = (int)$_POST['eno'];
    $action = $_POST['action'];
    $val = $_POST['val'];

    $fieldMap = [
        "Name" => "ename",
        "Date of Birth" => "dob",
        "Phone #" => "ephone",
        "Address" => "eaddress",
        "Salary #" => "esal",
        "Duty" => "duty",
        "Username" => "username",
        "Password" => "password"
    ];

    if (array_key_exists($action, $fieldMap)) {
        $field = $fieldMap[$action];
        $stmt = $conn->prepare("UPDATE Employee SET $field = ? WHERE eno = ?");
        $stmt->bind_param("si", $val, $enum);
        $success = $stmt->execute();

        if ($success) {
            echo "<script type='text/javascript'> alert('Successful!') </script>";
            $stmt->close();
	} else {
            echo "<script type='text/javascript'> alert('Unsuccessful!') </script>";
        }$conn->close();
    }

    
}
?>

