<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

$method = $_SERVER['REQUEST_METHOD'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "firstbase";

// Create connection
$con = new mysqli($servername, $username, $password, $database);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT team.ENOMBRE, team.LOGO FROM team, teamstats WHERE team.enombre = teamstats.enombre ORDER BY EWINS DESC LIMIT 5;";
$result = $con->query($sql);
$teamsTable = array();
$stats = array();

if (mysqli_num_rows($result) > 0) {
  // output data of each row

  //$teamsTable = array('message'=> "Hej Verden!");
  while($row = mysqli_fetch_assoc($result)) {
    array_push($teamsTable, array("Team"=>$row["ENOMBRE"], "Logo"=>$row["LOGO"]));
  }
} else {
  echo "0 results";
}

//array_push($stats, min($teamsTable));
//echo json_encode($stats);

function growingList($array) {
  for($i=1;$i<count($array);$i++) {
    for($j=0;$j<count($array)-$i;$j++) {
      if($array[$j]>$array[$j+1]) {
        $k=$array[$j+1];
        $array[$j+1]=$array[$j];
        $array[$j]=$k;
      }
    }
  }
  echo json_encode($array);
}

growingList($teamsTable);

$con->close();
?>