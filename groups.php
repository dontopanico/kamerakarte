<?php
include("functions.php");
header("Content-type: text/json; charset=UTF-8");
echo json_encode(get_active_categories());
?>
