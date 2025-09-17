<head>
<title>login</title>
    <h1 style="text-align: center;font-size: 70px ">MEDSHOP</h1>
</head>
<form action="login.php" method="post">
<body>
	 <link rel="stylesheet" href="log.css" >
	
	<center><img src="logpic.png" width="200" height="200" alt=""/> </center>
	<br>
	
	 <div style="text-align:center;"><input type="text" style="font-size:large" name="use" placeholder="username" required></div>
        <br> <br>
        <div style="text-align:center;"><input type="password" style="font-size:large" name="Pas" placeholder="password" required></div>
        <br> <br>
        <div style="text-align:center;"><input type="submit" style="font-size:large" value="Login" id = "submit" name="submit"></div><br><br>
        <br><br>
        <br><br>
        <br><br>

	<footer> 

		</footer> 
		
</body>
</form>
<?php
if (isset($_POST['submit'])) {
    $conn = new mysqli('localhost', 'root', '', 'pharmacy_management_master');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $use = $_POST['use'];
    $pas = $_POST['Pas'];

    $stmt = $conn->prepare("SELECT username FROM Employee WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $use, $pas);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header("Location: main.html");
        exit;
    } else {
        echo "<script type='text/javascript'> alert('TRY AGAIN') </script>";
    }
    $stmt->close();
    $conn->close();
}
?>
?>
