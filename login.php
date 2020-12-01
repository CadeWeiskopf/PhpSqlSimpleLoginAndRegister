<?php

	$servername = "localhost";
	$user = "root";
	$pw = "";
	$db = 'weiskopfcade-unitygame';
	
	$connect = new mysqli($servername, $user, $pw, $db);
	if (!$connect)
	{
		die('Connection failed. '  . mysqli_connect_error());
	}
	else
	{
		echo('Connection successful.');
	}
	
	//$username = "testing";
	//$password =  "Testing";
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$checkNameQuery = "SELECT username, salt, hash FROM players WHERE username='" . $username . "';";
	$nameCheck = mysqli_query($connect, $checkNameQuery) or die("{ERROR} Name check query failed.");
	if (mysqli_num_rows($nameCheck) == 1)
	{
		// found user with username in players  on database
		$existingInfo = mysqli_fetch_assoc($nameCheck);
		$salt = $existingInfo["salt"];
		$hash = $existingInfo["hash"];
		
		$loginHash = crypt($password, $salt);
		if ($hash != $loginHash)
		{
			// password doesn't hash to match table
			echo("{ERROR} Bad Password.");
			exit();
		}
		
		echo("0\t" . $existingInfo["username"] . " Successful login.");
	}
	else
	{
		die("{ERROR} nameCheck users returned =  " . mysqli_num_rows($nameCheck));
	}
?>