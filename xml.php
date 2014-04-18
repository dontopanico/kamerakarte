<?php
include('settings.php');

class xml {
    var $xml;
    
    function __construct() {
        /* TODO: füge encoding='utf-8' hinzu
         */
        header("Content-type: text/xml; charset=UTF-8");
        $header = '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"></feed>';
        $this->xml = new SimpleXMLElement($header);
    }

    function add_line($entry_id, $lon, $lat, $title, $description, $icon, $iconw, $iconh, $iconx, $icony) {
    
        global $host;
        global $path;
        
        $entry = $this->xml->addChild('entry');
        $entry->addChild('title', $title);

	$entry->addChild('description', '<![CDATA['.$description.']]>');

	$link = $entry->addChild('link');
        $link->addAttribute('rel', 'alternate');
        $link->addAttribute('type', 'text/html');
	$link->addAttribute('href', $host.$path.'index.php?show=ent&e='.$entry_id);
	 
        $entry->addChild('geo:long', $lon, 'geo');
        $entry->addChild('geo:lat', $lat, 'geo');
    }

    function write() {
        echo $this->xml->asXML();
        return TRUE;
    }
} /* End of class */

