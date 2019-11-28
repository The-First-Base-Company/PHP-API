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

$sql = "SELECT * FROM player, playerstats, team WHERE EQUIPO = ABBREV AND player.ID = playerstats.ID;";
$result = $con->query($sql);
$playerTable = array();
$stats = array();
if (mysqli_num_rows($result) > 0) {
  // output data of each row

  //$teamsTable = array('message'=> "Hej Verden!");
  while($row = mysqli_fetch_assoc($result)) {
    array_push($playerTable, array("ID"=>$row["ID"], "Nombre"=>$row["NOMBRE"], "Foto"=>$row["FOTO"], "Nickname"=>$row["APODO"], "Nacimiento"=>$row["NACIMIENTO"], "DraftYear"=>$row["DRAFT_YEAR"], "DraftTeam"=>$row["DRAFT_EQUIPO"], "DraftRound"=>$row["DRAFT_RONDA"], "Debut"=>$row["DEBUT"], "Juegos"=>$row["NUMJUEGOS"], "Wins"=>$row["WINS"], "Losses"=>$row["LOSSES"], "Runs"=>$row["RUNS"], "Hits"=>$row["HITS"], "HomeRuns"=>$row["HR"], "AvgHits"=>$row["AVGHITS"], "AvgErrores"=>$row["AVGERRORES"]));
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