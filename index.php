<?php

// if (isset($_COOKIE["remember"]) || isset($_COOKIE["logged_in"]) == 'YES'){
if (isset($_COOKIE["logged_in"]) == 'YES'){
    //TODO
    header('Location: /PHP/betting/Upload/bet.php');
    die();
}

$err = "";
$user_name  = " ";
$match_ind = "D" ;

// if(isset($_GET['signup_ok']) == 'Yes') {
//     echo '<script language="javascript">';
//     echo 'alert("Sign Up Successful")';
//     echo '</script>';
// }

if(isset($_POST['uname']) && isset($_POST['pin']) == 'Yes') {

    include 'dbconnect.php';
    $user_name = $_POST["uname"];
    $user_pin = $_POST["pin"];

    $sql = "SELECT `user_id`, `pin` FROM `id8692792_betting`.`login_info` WHERE `user` = '$user_name'";

    $result_count = $conn->query($sql)->num_rows;

    $result_row = $conn->query($sql)->fetch_assoc();
	
   
	if ($result_count > 1) {

        echo "Error more rows.";
    } else {
        $sql_pin = $result_row["pin"];
        if ($sql_pin == $user_pin) {
            // if ($_POST['remember'] == 'Y') {
            //     $cookie_name = "remember";
            //     $cookie_value = "Y";
            //     setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 = 1 Month
            //     $cookie_name = "user_id";
            //     $cookie_value = $result_row["user_id"];
            //     setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            // }
            $cookie_name = "logged_in";
            $cookie_value = "Y";
            setcookie($cookie_name, $cookie_value, time() + 3600); // Expire in 1 hour
            $cookie_name = "user_id";
            $cookie_value = $result_row["user_id"];
            setcookie($cookie_name, $cookie_value, time() + 3600); // Expire in 1 hour
            //TODO
	            header('Location: /PHP/betting/Upload/bet.php') ; 
        } else {
            $err = "Invalid Password";
        }
    }
}
else
{
	if(isset($_POST['suname']) && isset($_POST['spin1']) && isset($_POST['spin2']) ) {

		include 'dbconnect.php';

		$user_name = $_POST["suname"];
		$user_pin1 = $_POST["spin1"];
		$user_pin2 = $_POST["spin2"];
		if ($user_pin1 == $user_pin2) 
		{
			$user_id = rand(000000000,	999999999);

			$sql = "INSERT INTO `id8692792_betting`.`login_info`(`user`, `user_id`, `pin`) 
					VALUES ('$user_name','$user_id','$user_pin1')";

			if ($conn->query($sql) === TRUE) {
				echo 'Signed up succesfully, re-enter to log in' ;
			} else {
				echo "Error: " . "<br>" . $conn->error;
			}
		}
		else
		{
			echo "Error: Passowrd dont match" ;
		}
	}
	
}

include 'index.html'; 

?>