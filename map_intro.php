<?php
if((!isset($no_show_map) || $no_show_map == false) &&
    (!isset($_GET['map']) || (isset($_GET['map']) && $_GET['map'] == 1))) {
	include("settings.php");
	echo "<script src=\"http://openlayers.org/api/OpenLayers.js\"></script>";
	echo "<script src=\"http://openstreetmap.org/openlayers/OpenStreetMap.js\"></script>";
	echo "<script src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>\n";
	echo "<script src=\"map.js\"></script>\n";
	// echo "<script type=\"text/javascript\" src=\"map.js.php?center=$mapcenterlon,$mapcenterlat&zoom=$mapzoom\"></script>";
    } else { 
	echo "<script type=\"text/javascript\"><!-- function init(){ return false;} // --> </script>\n";
    }
?>
