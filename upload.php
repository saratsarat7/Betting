<?php

require('dbconnect.php');

$user_id = $_COOKIE["user_id"];
$match_info = "id8692792_betting.match_info" ;

/* TODO
 This will be the ID of the user, when we change to name we can use Admin validation here
*/
if($user_id != "1334567342") {
  echo "You Dont Have Access";
  exit();
}

// echo $_FILES["file"]["tmp_name"];

// if(isset($_POST['user'])){

//   $uploadFilePath = '/storage/ssd1/792/8692792/public_html/PHP/betting/files/'.basename($_FILES['file']['name']);
  
//   move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

//   $file = fopen($uploadFilePath, "r");
//   $count = 0;
//   while (($csvData = fgetcsv($file, 10000, ",")) !== FALSE)
//   {
//       // print_r($csvData);
//       // exit();
//       $count++;

//       if($count>1){
//         // echo $count;
//         // echo "<br>";
//         $sql = "INSERT INTO `id8692792_betting`.`login_info`(`user`, `user_id`, `pin`, `email`)
//             VALUES ('$csvData[0]',$csvData[1],'$csvData[2]','$csvData[3]')";

//         if ($conn->query($sql) === TRUE) {
//             echo "Success <br>";
//         } else {
//             echo "Error while inserting: " . $sql . "<br>" . $conn->error . "<br>";
//         }
//       }
//   }
// }

if(isset($_POST['match'])){

  $uploadFilePath = '/storage/ssd1/792/8692792/public_html/PHP/betting/files/'.basename($_FILES['file']['name']);
  // $uploadFilePath = '/mnt/D8C2BF9DC2BF7DF6/Development/PHP/betting/files/'.basename($_FILES['file']['name']);
  
  move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

  $file = fopen($uploadFilePath, "r");
  $count = 0;
  while (($csvData = fgetcsv($file, 10000, ",")) !== FALSE)
  {
      // print_r($csvData);
      // exit();
      $count++;

      if($count>1){
        // echo $count;
        // echo "<br>";
        // STR_TO_DATE('2019-04-23 20:00:00', '%Y-%m-%d %H:%i:%s')
        $sql = "INSERT INTO $match_info (`match_id`, `team1`, `team2`, `time`, `bet_amount`, `team_win_id`)
            VALUES ('$csvData[0]','$csvData[1]','$csvData[2]',STR_TO_DATE('$csvData[3]', '%Y-%m-%d %H:%i:%s'),$csvData[4],'')";

        if ($conn->query($sql) === TRUE) {
            echo "Success <br>";
        } else {
            echo "Error while inserting: " . $sql . "<br>" . $conn->error . "<br>";
        }
      }
  }
}

?>