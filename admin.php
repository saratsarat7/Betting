<?php

if (!isset($_COOKIE["logged_in"]) == 'N'){
    header('Location: /PHP/betting/Upload/index.php');
    die();
}

include 'dbconnect.php';
	
$user_id = $_COOKIE["user_id"];
$db = "'id8692792_betting'" ;
$match_info = "id8692792_betting.match_info" ;
$bet_info = "id8692792_betting.bet_info" ;
$login_info = "id8692792_betting.login_info" ;

	if(isset($_POST['select_data']) == 'Yes') {

    $temp = explode("%", $_POST["select_data"]);
    $match_id = $temp[0];
    $team_id = str_replace("_", " ", $temp[1]);
    $team_id = str_replace("_", " ", $temp[1]);

    $sql = "UPDATE $bet_info set `team_win_id` = '$team_id' WHERE  `match_id` = '$match_id'";
    if ($conn->query($sql) === TRUE) {
        // echo "Deleted";
    } else {
        echo "Error while updating: " . $sql . "<br>" . $conn->error;
    }
    
}

$sql = "SELECT a.match_id, a.team1, a.team2, a.time, a.team_win_id as team_id, a.team_win_id, a.bet_amount FROM $match_info a
	   where a.time - '0:30:00' <= now() ";

$result_match = $conn->query($sql);
$result_match_count = $result_match->num_rows;
$match_ind  = "A" ;

if ($result_match_count > 0)
{
    include 'bet.html';
}
   
	include 'logout.html';

?>