<head>
<meta charset="utf-8">
<title>Remove Employee</title>
	<h1 style="text-align: center;color:#004080;font-size: 60px ">MEDSHOP</h1>
</head>

<form action="removemp.php" method="post">

<body>
		<link rel="stylesheet" href="rmovem.css" >
	<center><h2>Remove Employee</h2></center>
	<center><h4>Please Enter Employee Number #</h4><input type="number" id ="t1" name="fno"  required/><br><br>
		<input name="submit" type="submit" id ="t2" value="Remove"  /><br><br>
		
		

</body>
<center>  <A HREF = "http://localhost/project/emp.html">Back</A><br><br><br><br><br><br><br><br><br>
		<footer>
    <center><h3 style="font-size:200%;color:#004080"> &copy;2024 CSAI.Amrita Vishwa Vidyapeetham</h3></center>
	</footer>
</form>

<?php
if (isset($_POST['submit'])) {
    $conn = new mysqli('localhost', 'root', '', 'pharmacy_management_master');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fnum = (int)$_POST['fno'];

    $stmt = $conn->prepare("DELETE FROM Employee WHERE eno = ?");
    $stmt->bind_param("i", $fnum);
    $success = $stmt->execute();

    if ($success) {
        echo "<script type='text/javascript'> alert('Successful!') </script>";
    } else {
        echo "<script type='text/javascript'> alert('Unsuccessful!') </script>";
    }
    $stmt->close();
    $conn->close();
}
?>

