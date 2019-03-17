<?php

if(isset($_POST['suname']) && isset($_POST['spin1']) && isset($_POST['spin2']) ) {

    include 'dbconnect.php';

    $user_name = $_POST["uname"];
    $user_pin1 = $_POST["pin1"];
	$user_pin2 = $_POST["pin2"];
	if ($user_pin1 == $user_pin2) 
	{
		$user_id = rand(1000000000,9999999999);

		$sql = "INSERT INTO `id8692792_betting`.`login_info`(`user`, `user_id`, `pin`) 
				VALUES ('$user_name','$user_id','$user_pin1')";

		if ($conn->query($sql) === TRUE) {
			header('Location: /PHP/betting/Upload/index.php') ;
			echo 'Signed up succesfully, re-enter to log in'
		} else {
			echo "Error: " . "<br>" . $conn->error;
		}
	}
	else
	{
        echo "Error: Passowrd dont match" ;
	}
}
	else
	{
        echo "Enter all details" ;
	}

include 'index.html'		;

?>