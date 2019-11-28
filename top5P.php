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

$sql = "SELECT FOTO, NOMBRE, ENOMBRE, RANKP, ID FROM player, team WHERE RANKP AND EQUIPO = ABBREV ORDER BY RANKP ASC LIMIT 5;";
$result = $con->query($sql);
$teamsTable = array();
$stats = array();

if (mysqli_num_rows($result) > 0) {
  // output data of each row

  //$teamsTable = array('message'=> "Hej Verden!");
  while($row = mysqli_fetch_assoc($result)) {
    array_push($teamsTable, array("Rank"=>$row["RANKP"], "Foto"=>$row["FOTO"], "Nombre"=>$row["NOMBRE"], "Equipo"=>$row["ENOMBRE"], "Clave"=>$row["ID"]));
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