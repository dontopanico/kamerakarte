<?php
include('db.php');
header("Content-type: text/plain; charset=UTF-8");

array_walk($_GET, 'walk_db_escape_string');
$link = connect_db();
if(isset($_GET['type']) && $_GET['type'] == 'poi') {
  $query = "select id, category_id, location_text, title, description, creation_timest created, modified_timest modified, st_asewkt(location) as location from poi where active = 'true';";
  $res = db_query($query);
  while($row = db_fetch_assoc($res)) {
    echo json_encode($row)."\n";
  }
} elseif(isset($_GET['type']) && $_GET['type'] == 'category') {
  $query = "select id, name, description, creation_timest as created from poi_category where active = 'true';";
  $res = db_query($query);
  while($row = db_fetch_assoc($res)) {
    echo json_encode($row)."\n";
  }
} else {
  echo "Ask for 'category' or 'poi' in field type.\nexchange.php?type=<type>";
}
?>
