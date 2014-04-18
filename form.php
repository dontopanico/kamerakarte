<?php
// Error Reporting 
// error_reporting(E_ALL  ^ E_NOTICE);
    
/* Funktionen und Einstellungen einbinden */
include('settings.php');
include('functions.php');
include('login_check.php');

/* Login */
if(!login_check()){
    include('login.php');
    exit();
}

/** Datenbank Operationen durchführen
// ====================================
*   Benutzeraktionen in Liste -> LÖSCHEN */
if(isset($_POST['delete_category'])) {
    delete_category($_POST);
} elseif(isset($_POST['delete_entry'])) {
    delete_entry($_POST);
}

/* Verarbeitung der Formulare -> EINTRAGEN, UPDATE*/
if(isset($_POST['form_category_ok'])) {
    form_category($_POST);
} elseif(isset($_POST['form_entry_ok'])) {
    $form_entry = form_entry($_POST);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="de">
   <head>
      <title><?php echo $page_title; ?></title>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<?php include('map_intro.php'); ?>

      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" type="text/css" href="content.css" />
      <link rel="stylesheet" type="text/css" href="wikistyle.css">
      <script type="text/javascript" src="sorttable.js"></script>
      <script type="text/javascript" src="info.js"></script>
      <script type="text/javascript" src="preview.js"></script>
</head>
<body onload="init(); <?php echo "setCenter4326(new OpenLayers.LonLat($mapcenterlon, $mapcenterlat), $mapzoom);"; ?>" >
<form action="form.php" method="post">
<?php
    // Karte anzeigen / verbergen
    $params = array();
    isset($_GET['map']) && $_GET['map'] == 1 ? "" : array_push($params, "map=1");
    $get_keys = array_keys($_GET);
    foreach($get_keys as $param){
        if($param != 'map'){
            array_push($params, "$param={$_GET[$param]}");
        }
    }
    $params = implode("&", $params);
    if(!empty($params)) { $params = "?".$params; }
    
    $link_text = isset($_GET['map']) && $_GET['map'] == 1 ? "Karte verbergen" : "Karte anzeigen";
    echo "<p><a href=\"form.php$params\">$link_text</a>";
    // Logout ?>
    / <input class="buttonlink" type="submit" name="form_logout" value="Logout"></p>
</form>

<?php /* Karte anzeigen */  ?>
<div id="map" class="smallmap"></div>

<?php /* Formular anzeigen */ ?>
<div class="content">
    <? include(get_formular($_POST)); ?>
</div>
</body>
</html>
