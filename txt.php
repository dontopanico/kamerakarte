<?php
include('settings.php');

/* 
Test-URL
http://localhost/openstreetmap/export.php?format=txt&groups=1&bbox=7.603087343751,51.955330288044,7.647032656249,51.968869456368
*/

class txt {
    var $txt;

    function __construct() {
        header("Content-type: text/plain; charset=UTF-8");
        $this->txt .= "lat\tlon\ticon\ticonSize\ticonOffset\ttitle\tdescription\n";
        //echo $txt;

    }

    function add_line($entry_id, $lon, $lat, $title, $description, $icon, $iconw, $iconh, $iconx, $icony) {
        $this->txt .= "$lat\t";
        $this->txt .= "$lon\t";
        $this->txt .= "$icon\t";
        $this->txt .= $iconw . "," . $iconh . "\t";                     // iconSize
        $this->txt .= $iconx . "," . $icony . "\t";                     // iconOffset
        $this->txt .= "<nobr>" . $title . "</nobr>\t";                  // title
        $this->txt .= $description . "<br/>";                           // description
        $this->txt .= "<a href=\"index.php?show=ent&e=$entry_id\" class=\"infolink\">Mehr Info</a><br/>";   //link zur Info-Seite
        $this->txt .= "\t\n";
    }

    function write() {
        echo $this->txt;
        return TRUE;
    }

}
