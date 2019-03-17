<?php

if (!isset($_COOKIE["logged_in"]) == 'N'){
    header('Location: /PHP/betting/Upload/index.php');
    die();
}

include 'dbconnect.php';
	
$user_id = $_COOKIE["user_id"];
$user_name = $_COOKIE["user_name"];
$db = "'id8692792_betting'" ;
$match_info = "id8692792_betting.match_info" ;
$bet_info = "id8692792_betting.bet_info" ;
$login_info = "id8692792_betting.login_info" ;
if(isset($_POST['select_data']) == 'Yes') 

{

    $temp = explode("%", $_POST["select_data"]);
    $match_id = $temp[0];
    $team_id = str_replace("_", " ", $temp[1]);
 
    if ($user_id  == 1334567342 ) 

    {$sql = "UPDATE $match_info set team_win_id = '$team_id' WHERE  match_id = '$match_id'";
      if ($conn->query($sql) === TRUE) {
          // echo "Deleted";
         } else {
            echo "Error while updating: " . $sql . "<br>" . $conn->error;
         }
     }

    else 

     {

		$sql = "SELECT a.match_id from $match_info a	
				where match_id = '$match_id' 
			      and a.time - '0:30:00' > now()  ";

		$result_match = $conn->query($sql);
		$result_match_count = $result_match->num_rows;
        
		if ( $result_match_count > 0) 
		{

				$sql = "DELETE FROM $bet_info WHERE user_id = '$user_id' AND match_id = '$match_id'";
				if ($conn->query($sql) === TRUE) {
					// echo "Deleted";
				} else {
					echo "Error while deleting: " . $sql . "<br>" . $conn->error;
				}
				$sql = "select user from $login_info where user_id = '$user_id'" ;
				$result_match = $conn->query($sql);

				$row = $result_match->fetch_assoc() ;
				$user = $row["user"] ;
				
				if ( $result_match_count > 0)  
				{
					$sql = "INSERT INTO $bet_info (user_id, user, match_id, team_id )
							VALUES ('$user_id', '$user', '$match_id','$team_id')";

					if ($conn->query($sql) === TRUE) {
						//echo "Success";
					} else {
						echo "Error while inserting: " . $sql . "<br>" . $conn->error;
					}
				}
				ELSE
				{
					echo "Invalid User : " . $sql . "<br>" . $conn->error;
				}

		}
		else {
			echo "Error: <<<<<<<<< TIME IS UP FOR THE MATCH YOU WANTED TO BET ON, YOUR SELECTION IS VOID  >>>>>>>>>>>>>>>" ;
			die();
			}
			
    }
}


if ($user_id  == 1334567342 ) 
{
	$sql = "SELECT a.match_id, a.team1, a.team2, a.time, a.team_win_id as team_id, a.team_win_id, a.bet_amount FROM $match_info a
	   where a.time - '0:30:00' <= now() order by  a.team_win_id, a.time";

	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;

	if ($result_match_count > 0)
	{
	include 'Admin.html';
	}
}
else
{	 

$allbet_sql = "select allbet.*
                  ,case when team1 = team_id and team_id = team_win_id
                   then team1winshare
				   when team2 = team_id and team_id = team_win_id
				   then team2winshare
				   else loss_amt
                   end as win_loss_amt
              from
			 (		 
			 select bets.*
			  ,case when team1cnt is null then 0
			   else team1cnt
			   end as team1cnt
			  ,case when team2cnt is null then 0
			   else team2cnt
			   end as team2cnt
			 ,case when team1cnt is null or team2cnt is null
				   then 0     
				   else (team2cnt * bet_amount) / (team1cnt * bet_amount)  
			  end as team1winshare
			 ,case when team1cnt is null or team2cnt is null
				   then 0     
				   else (team1cnt * bet_amount) / (team2cnt * bet_amount)  
			  end as team2winshare		   
			 ,case when team1cnt is null or team2cnt is null
				   then 0     
				   else bet_amount  * -1
			  end as loss_amt		  
			   from 
				(SELECT a.match_id, a.team1, a.team2, a.time, b.team_id, a.team_win_id, a.bet_amount 
						   ,c.user 
						   FROM $match_info a inner join $bet_info b inner join $login_info c
							where a.match_id = b.match_id 
							  and b.user_id = c.user_id
							  and a.time - '0:30:00' <= now() 
				) bets
				left JOIN
				(select a.match_id, team_id, COUNT(*) as team1cnt
				   from $bet_info a
					 group by match_id, team_id
				) team1cnt
				on bets.match_id = team1cnt.match_id
				and bets.team1 = team1cnt.team_id
				left JOIN
				(select a.match_id, team_id, COUNT(*) team2cnt
				   from $bet_info a
					 group by match_id, team_id
				) team2cnt
				on bets.match_id = team2cnt.match_id
				and bets.team2 = team2cnt.team_id
				) allbet " ;
      
	$sql = "select user
		   ,sum(win_loss_amt) as tot_win_loss_amt
            from ($allbet_sql)user_total
			where team_win_id <> ''
			group by user
			order by tot_win_loss_amt desc";
			
	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;
	if ($result_match_count > 0)
	{ include 'DashboardIPL.html'; }


	$sql = "$allbet_sql
			where team_win_id <> ''
			  and user = '$user_name' 
			  order by match_id" ;

	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;
	if ($result_match_count > 0)
	{ include 'Dashboarduser.html'; }


	$sql = "$allbet_sql
			where team_win_id = ''
		    order by match_id " ;

	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;
	if ($result_match_count > 0)
	{ include 'betdetail.html'; }

	$sql = "SELECT a.match_id, a.team1, a.team2, a.time, b.team_id, a.team_win_id, a.bet_amount FROM $match_info a left join $bet_info b
			on a.match_id = b.match_id 
		   and b.user_id = $user_id
		   where a.time - '0:30:00' > now()  ";

	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;
	if ($result_match_count > 0)
	{ include 'bet.html'; }

	$sql = "$allbet_sql
			where team_win_id <> ''
		    order by match_id" ;

	$result_match = $conn->query($sql);
	$result_match_count = $result_match->num_rows;

	if ($result_match_count > 0)
	{ include 'completedbet.html'; }
}

include 'logout.html';
?>