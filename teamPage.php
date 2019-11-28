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

$sql = "SELECT *, team.ENOMBRE, LOGO, WEB, ESTADIO, LIGA, ERANKH, ERANKP, ERANKF, ROUND(100*((POWER(ERUNS,1.81))/(POWER(ERUNS,1.81)+POWER(ERUNSALLOWED,1.81))), 2) AS WINNING_PERCENTAGE, ENUMJUEGOS, EAVGHITS FROM team, teamstats WHERE team.ENOMBRE = teamstats.ENOMBRE";
$result = $con->query($sql);
$playerTable = array();
$stats = array();
if (mysqli_num_rows($result) > 0) {
  // output data of each row

  //$teamsTable = array('message'=> "Hej Verden!");
  while($row = mysqli_fetch_assoc($result)) {
    array_push($playerTable, array("ID"=>$row["ENOMBRE"], "Nombre"=>$row["ENOMBRE"], "Logo"=>$row["LOGO"], "Web"=>$row["WEB"], "Estadio"=>$row["ESTADIO"], "Liga"=>$row["LIGA"], "RankH"=>$row["ERANKH"], "RankP"=>$row["ERANKP"], "RankF"=>$row["ERANKF"], "WinPCT"=>$row["WINNING_PERCENTAGE"], "Juegos"=>$row["ENUMJUEGOS"], "AvgHits"=>$row["EAVGHITS"], "AtBat"=>$row["EATBAT"], "Runs"=>$row["ERUNS"], "Hits"=>$row["EHITS"], "HomeRuns"=>$row["EHR"], "Wins"=>$row["EWINS"], "Losses"=>$row["ELOSSES"], "Opor"=>$row["EOPORTUNIDADES"], "Putout"=>$row["EPUTOUT"], "Asist"=>$row["EASISTENCIAS"], "Errores"=>$row["EERRORES"], "AvgErrores"=>$row["EAVGERRORES"]));
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

growingList($playerTable);

$con->close();
?>