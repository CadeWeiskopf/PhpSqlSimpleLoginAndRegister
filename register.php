<?php
	$servername = "localhost";
	$user = "root";
	$pw = "";
	$db = 'weiskopfcade-unitygame';
	
	$connect = new mysqli($servername, $user, $pw, $db);
	if (!$connect)
	{
		die('{ERROR} Connection failed. ' . mysqli_connect_error());
	}
	else
	{
		echo "Connection successful.";
	}
	
	//$username = "testing";
	//$password = "Testing";
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$checkNameQuery = "SELECT username FROM players WHERE username='" . $username . "';";
	$nameCheck = mysqli_query($connect, $checkNameQuery) or die("{ERROR} nameCheck query failed");
	if (mysqli_num_rows($nameCheck) > 0)
	{
		die("{ERROR} Username is taken.");
	}
		
	$salt = "\$5\$rounds=5000\$" . "XXX" . $username .  "\$";
	$hash = crypt($password, $salt);
	
	$queryIds = mysqli_query($connect, "SELECT id FROM players");
	$newUserId = mysqli_num_rows($queryIds);
	
	echo "newUserId === " . $newUserId . "  hash".$hash." salt".$salt;
	
	$newUserQuery = "INSERT INTO players (id, username, hash, salt) VALUES ('" . $newUserId . "', '". $username . "', '" . $hash . "', '" . $salt . "');";
	if ($connect->query($newUserQuery) === TRUE)
	{
	  echo "New record created successfully";
	}
	else
	{
		echo "{ERROR} " . $newUserQuery . "<br>" . $connect->error;
	}

	echo '0';
?>