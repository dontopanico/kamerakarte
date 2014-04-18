<?php
include('settings.php');
// Funktionen einbinden
include('functions.php');
include('wikistyle.php');
define('INDEX_PAGE', 1);

// Kategorien mit Eintragsanzahl auslesen
$cat_nav = count_active_entries_by_category();

// Map-Variablen
if(isset($_GET['map']) && $_GET['map']=='1') {
    // Variablen setzen
    $mapstatus = "";
    $buttontext = "- Karte verbergen";
    $map = "<div id=\"map\" class=\"smallmap\"></div><br />";
} else {
    $mapstatus = "1";
    $buttontext = "+ Karte anzeigen";
    $map = "";    
}

// Set page content
/* show category */
if(isset($_GET['show']) && $_GET['show'] == 'cat' &&
    isset($_GET['c']) && is_numeric($_GET['c'])) {
    $curr_content = 'info_category.php';
}

/* show single entry */
elseif(isset($_GET['show']) && $_GET['show'] == 'ent' &&
    isset($_GET['e']) && is_numeric($_GET['e'])) {
    $curr_content = 'info_entry.php';
}

/* show all entries */
elseif(isset($_GET['show']) && $_GET['show'] == 'alle') {
    $curr_content = 'info_entrylist.php';
}

/* show impressum */
elseif(isset($_GET['show']) && $_GET['show'] == 'con') {
    $curr_content = 'contact.php';
}

/* show FAQ */
elseif(isset($_GET['show']) && $_GET['show'] == 'faq') {
    $curr_content = 'faq.php';
}

/* show main page */
else {
    $curr_content = 'content.php';
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- ### If you are interested in this sourcecode write an email to "<?php echo $mail_to_shown;?>". We try to help you. ### -->
        <title><?php echo $page_title; ?></title>
        <link rel="shortcut icon" href="icons/cctv.png" type="image/x-icon" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="content.css" />
        <link rel="stylesheet" type="text/css" href="wikistyle.css" />
        
        <script type="text/javascript" src="info.js"></script>
        <script type="text/javascript" src="sorttable.js"></script>
        <?php include('map_intro.php'); ?>
        
    </head>
    <body onload="init(); <?php echo "setCenter4326(new OpenLayers.LonLat($mapcenterlon, $mapcenterlat), $mapzoom);"; ?>" >
        <!-- Headline -->
        <div class="infotop">
	    <h1 class="infoheadline"><a href="<?php echo basename(__FILE__); ?>"><?php echo $page_title; ?></a></h1>
        </div>
        <!-- Navigation -->
        <?php // TODO: merken, welche navi-box offen war und welche nicht?!? aber dazu bräuchte man cookies... auch blöd ?>
        <div class="navi">
	    <!-- 
	    <h2>
	    Herzlich willkommen in der schönen, neuen Welt der Überwachung.
	    </h2>
	    -->
            <!-- Kategorien -->
            <h2 class="hovertitel">
                <a href="#" onclick="return changeVisibilty('list_categories', 'show_categories');">
                    <span id="show_categories" title="anzeigen/verbergen">-</span>
                </a> 
	    Kategorien <?php /* <a class="hovertext" href="form.php?c=new">Hinzufügen</a> */ ?>
            </h2>
            <div id="list_categories">
                <div class="navi_box">
                    <?php
                    foreach($cat_nav as $cat){
                        echo "<p><img src=\"{$cat['icon']}\" width=\"15px\"> ";
                        echo "<a href=\"".basename(__FILE__)."?show=cat&c={$cat['id']}\">{$cat['name']} ({$cat['counts']})</a></p>"; 
                    }
                    ?>
                </div>
            </div>
            <!-- Einträge -->        
            <h2 class="hovertitel">
                <a href="#" onclick="return changeVisibilty('list_entries', 'show_entries');">
                    <span id="show_entries" title="anzeigen/verbergen">-</span>
                </a> 
		Einträge <?php /* <a class="hovertext" href="form.php?e=new">Hinzufügen</a> */ ?>
            </h2>
            <div id="list_entries">
                <div class="navi_box">
		    <p><a href="<?php echo basename(__FILE__); ?>?show=alle">Liste aller Einträge</a></p>
                </div>
            </div>
            <!-- Statistik -->
            <h2>
                <a href="#" onclick="return changeVisibilty('list_statistics', 'show_statistics');">
                    <span id="show_statistics" title="anzeigen/verbergen">-</span>
                </a> Kleinststatistik
            </h2>
            <div id="list_statistics">
                <div class="navi_box">
                    <p>Kategorien: <?php echo count_active_categories(); ?></p>
                    <p>Einträge: <?php echo count_active_entries(); ?></p>        
                </div>
            </div>
            <hr />
            <p><a href="form.php" class="int">Eintrag hinzufügen</a></p>
            <hr />
            <p><a href="<?php echo basename(__FILE__); ?>?show=faq" class="int">FAQ</a></p>
            <p><a href="<?php echo basename(__FILE__); ?>?show=con" class="int">Kontakt</a></p>
	    <p><a href="<?php echo basename(__FILE__); ?>" class="int">zur Karte</a></p>
        	<p><a href="http://wiki.vorratsdatenspeicherung.de/Ortsgruppen/M%C3%BCnster"><img style="width: 12em;" src="wiki_images/taeubchen.png" title="Don't Panic!" alt="Don't Panic!" /></a></p>
        </div>
    
        <!-- Content -->
        <div id="content" style="margin-left: 17em;">
            <?php include($curr_content); ?>
        </div>
    
    </body>
</html>
