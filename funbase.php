<?php
    function getTeamID($conn, $team_name) {
        $replaced_team = str_replace(" ", "_", $team_name);
        return $replaced_team;
    }
    
    function decideButton($conn, $user_team, $table_team) {
        if ($user_team == $table_team) {
            echo "btnselected";
			return true;
        } else {
            echo "0";
			return false;
        }
    }
	
    function decideButtoncomplete($conn, $user_team, $table_team) {
        if ($user_team == $table_team) {
            echo "btnselectedcomplete";
			return true;			
        } else {
            echo "buttoncomplete";
			return false;			
        }
    }
?>