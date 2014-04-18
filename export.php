<?php
//header("Content-type: text/plain; charset=UTF-8");
include('xml.php');
include('txt.php');
include('db.php');
include('wikistyle.php');

function fetch_poi($query, $output) {
    // echo $query;
    $res = @db_query($query);

    if (@db_num_rows($res) > 0) {
        while ($row = db_fetch_array ($res)) {
            $description = str_replace("\n", "", $row["description"]);
            $description = str_replace("\r", "", $description);
            $description = parse_wikistyle($description, false);
            $description = str_replace("\n", "", $description);
            $output->add_line($row['entry_id'], $row["lon"], $row["lat"], $row["title"], $description, $row["icon"], $row["iconw"], $row["iconh"], $row["iconx"], $row["icony"]);
        }
    }
    db_free_result($res);
}

function validate_requests($get) {
    // $get["format"]: format
    // $get["groups"]: groups 

    array_walk($get, 'walk_db_escape_string');

    if(!isset($get["format"]) or
        !isset($get["groups"]) or 
        !isset($get['bbox'])) {
        return 0;
    }

    //bbox = tllon,tllat,brlon,brlat
    $bbox = explode(',', $get['bbox']);
    $left = $bbox[0];
    $top = $bbox[1];
    $right = $bbox[2];
    $bottom = $bbox[3];

    if ($left > $right) {
        $temp = $left;
        $left = $right;
        $right = $temp;
    }
    if ($bottom > $top) {
        $temp = $bottom;
        $bottom = $top;
        $top = $temp;
    }

    return array('format' => $get["format"],
        'top' => $top,
        'bottom' => $bottom,
        'left' => $left,
        'right' => $right,
        'groups' => $get["groups"],
    );
}

$myarray = validate_requests($_GET);
if(empty($myarray))
    die("Not all necessary arguments given");

$format = $myarray['format'];
$top = $myarray['top'];
$bottom = $myarray['bottom'];
$left = $myarray['left'];
$right = $myarray['right'];
$groups = $myarray['groups'];

if($format == 'xml') {
    $output = new xml();
} else if($format == 'txt') {
    $output = new txt();
} else {
    die('Neither xml- nor txt-format given');
}

if(strlen($groups) > 0) {
    $categories = explode(";", $groups);
    $link = connect_db();

    if(is_array($categories) and count($categories)>0)
        foreach($categories as $cat_item) {
            $category[] = "a.category_id = $cat_item ";
        }

    /*
     * lat, lon, icon, iconSize, iconOffset, title, description
select entry_id, st_x(location), st_y(location) from poi
where
    st_geomfromewkt('srid=4326;LINESTRING(0 0, 51.94 8)') ~ location;

     */
    if (is_array($category) AND count($category)>0) {
        $category = implode(" or ", $category);
	$query  = "select a.id entry_id, st_x(location) as lon, st_y(location) as lat, a.title, a.description, b.icon, b.iconw, b.iconh, b.iconx, b.icony\n";
	$query .= "from poi as a\n";
	$query .= "left join poi_category as b on a.category_id = b.id\n";
	$query .= "where st_geomfromtext('LINESTRING($left $top, $right $bottom)', 4326) ~ location\n";
        $query .= "and ($category);\n";

        fetch_poi($query."\n", $output);
        if(!($output->write()))
            die("Cannot output file.");
    }

    close_db($link);
} //end strlen($groups)
?>
