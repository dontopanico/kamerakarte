<?php
if(!defined('FUNCTIONS')) {
    define('FUNCTIONS', 1);
    include('db.php');
    include('login_check.php');
    include('settings.php');

    function get_formular() {
        if(is_guest()) {
            /* Login from Captcha */
            $form = 'form_entry.php';
        } elseif(is_admin()) {
            /* Login as admin/user/... */
            // Standart
            $form = 'form_list.php';
            // Variationen
            if(isset($_POST['form_back'])) {
                $form = 'form_list.php';
            } elseif(isset($_GET['c'])){
                $form = 'form_category.php';
            } elseif(isset($_GET['e'])) {
                $form = 'form_entry.php';
            }
        } else {
            return 0;
        }
        return $form;
    }


    /*****                             *****/
    /***** Functions to manage Entries *****/
    /*****                             *****/
    function count_active_entries() {
        return count_entries(true);
    }

    function count_entries($activeonly = false) {
        $link = connect_db();
        $query = "select count(*)\n";
        $query .= "from poi\n";

        if($activeonly == true) {
            $query .= "where active = 'true';";
        } else {
            $query .= ";";
        }

        $res = db_query($query);
        $ret = db_fetch_row($res);
        return $ret[0];
    }

    function get_entry($id) {
        return get_entries($id);
    }
    
    function get_active_entry($id) {
        return get_entries($id, "", true);
    }

    function get_all_entries() {
        return get_entries();
    }
    
    function get_all_active_entries() {
        return get_entries(null, null, true);
    }
    
    function get_entries_by_category($category_id) {
        return get_entries(null, $category_id);
    }
    
    function get_active_entries_by_category($category_id) {
        return get_entries(null, $category_id, true);
    }

    function get_entries($id=null, $category_id=null, $activeonly=null) {
        $link = connect_db();

	$id = db_escape_string($id);
	$category_id =  db_escape_string($category_id);

        //$query = "SELECT p.id, p.active, p.category_id, p.title, p.description, p.location_text, round(st_y(p.location)::numeric, 4) lat, round(st_x(p.location)::numeric, 4) lon,\n";
        $query = "SELECT p.id, p.active, p.creation_timest, p.category_id, p.title, p.description, p.location_text, st_y(p.location) lat, st_x(p.location) lon,\n";
        $query .= "c.name as cat_name, c.icon as cat_icon\n";
        $query .= "FROM POI p, POI_category c\n";
        $query .= "WHERE p.category_id = c.id\n";
        $query .= $activeonly!=null ? "AND p.active = true\n" : "";
        if($id != null){
            $query .= "AND p.id='$id' LIMIT 1";
        }
        elseif($category_id != null) {
            $query .= "AND p.category_id = '$category_id'\n";
        }
        $query .= $id != null ? ";" : "ORDER BY c.name, p.title;";

        $res = db_query($query) or die(db_error());
        $array = array();
        while($row = db_fetch_assoc($res)){
            array_push($array, $row);    
        }

	if($id != null || $activeonly == null) {
	    //$query = "SELECT p.id, p.active, p.category_id, p.title, p.description, p.location_text, round(st_y(p.location)::numeric, 4) lat, round(st_y(p.location)::numeric, 4) lon\n";
	    $query = "SELECT p.id, p.active, p.creation_timest, p.category_id, p.title, p.description, p.location_text, st_y(p.location) lat, st_y(p.location) lon\n";
	    $query .= "FROM POI as p\n";
	    $query .= "WHERE p.category_id = 0\n";
	    if($id != null){
		$query .= "AND p.id='$id' LIMIT 1";
	    }
	    $query .= $id != null ? ";" : "ORDER BY p.title;";

	    $res = db_query($query) or die(db_error());
	    while($row = db_fetch_assoc($res)){
		$row['cat_name'] = '0';
		$row['cat_icon'] = '0';
		array_push($array, $row);
	    }
	}

        close_db($link);

        return $array;
    }

    function form_entry($array) {
        array_walk($array, 'walk_db_escape_string');

        if($array['form_entry_edit'] == "1") {
            /* edit one entry */
            return edit_entry($array);
        } elseif($array['form_entry_edit'] == "0") {
            /* add a new entry */
            return add_entry($array);
        }
    }

    function add_entry() {
        $link = connect_db();

        if(!is_numeric($_POST['category_id']) || (empty($_POST['title']) || empty($_POST['lon']) || empty($_POST['lat'])) && is_guest()) {
            /* title, lon and lat could be clear if user is admin
             * guest have to enter everything 
             * both have to insert a valid category_id */
            return false;
        }
	if(is_guest() || empty($_POST['active'])) {
	    $active = 'false';
	} else {
	    $active = 'true';
	}
        $query = "INSERT INTO POI (active, category_id, location_text, location, title, description)\n";
        $query .= "VALUES ($active,\n";
        $query .= "{$_POST['category_id']},\n";
        $query .= "'{$_POST['location']}',\n";
	$query .= "ST_SetSRID(ST_Point({$_POST['lon']}, {$_POST['lat']}), 4326),\n";
        $query .= "'{$_POST['title']}',\n";
        $query .= "'{$_POST['description']}')\n";
	$query .= "returning id";

	$res = db_query($query);
        if(!$res) {
            print(db_error());
            close_db($link);
            return false;
        }
	$row = db_fetch_row($res);
	$entry_id = $row[0];
        
        /** Sende Mail bei Eintrag durch Gast
            @mail_to: settings.php - mailadress
	    Achte auf globale Variablen. settings.php ist erstmal nicht global angelegt.
        */
	global $mail_to, $page_title;

        if(is_guest() && !is_admin()) {
            $mail_subject = '['.$page_title.'] Neuer Eintrag';
            $mail_message = 'Schau doch mal rein!!';
            if(!mail($mail_to, '['.$page_title.'] Neuer Eintrag', "Entry-ID: {$entry_id}\n\nTitle:\n{$_POST['title']}\n\nDescription:\n{$_POST['description']}")){
                echo "Mail not sent to $mail_to.";
            }
        }
	/* TODO: Das close_db funktioniert hier nicht !?!?
	close_db($link);
	 */
        return true;
    }

    function edit_entry() {
        $link = connect_db();

	$active = isset($_POST['active']) ? 'true' : 'false';
        $query = "UPDATE poi SET\n";
        $query .= "active = '$active',\n";
        $query .= "category_id = '{$_POST['category_id']}',\n";
        $query .= "location_text = '{$_POST['location']}',\n";
	$query .= "location = ST_SetSRID(ST_Point({$_POST['lon']}, {$_POST['lat']}), 4326),\n";
        $query .= "title = '{$_POST['title']}',\n";
        $query .= "description = '{$_POST['description']}'\n";
        $query .= "WHERE id = '{$_POST['entry_id']}';";

        if(!db_query($query)) {
            print(db_error());
            close_db($link);
            return false;
        }
        return true;
        close_db($link);
    }

    function delete_entry($array) {
        $link = connect_db();
        array_walk($array, 'walk_db_escape_string');
        $query = "DELETE FROM POI WHERE id = '{$array['entry_id']}';";
        if(!db_query($query)) {
            print(db_error());
            close_db($link);
            return false;
        }
        return true;
        close_db($link);

    }




    /*****                                *****/
    /***** Functions to manage Categories *****/
    /*****                                *****/
    function get_icon_files($icon_dirs) {
        /* $icon_dirs: array of strings (directories) */
        $array = array();
	$file_exts = array('png', 'jpg', 'jpeg', 'gif');

        foreach($icon_dirs as $icon_dir) {
            if(is_dir($icon_dir)){
		if(false == ($dirhandle = opendir($icon_dir)))
		    continue;
		while (false !== ($filename = readdir($dirhandle))) {
		    $fileformat = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		    if(in_array($fileformat, $file_exts))
			array_push($array, $icon_dir.'/'.$filename);
		}
		closedir($dirhandle);
            }
        }
        return $array;
    }
    
    function count_active_categories() {
        return count_categories(true);
    }
    
    function count_categories($activeonly = false) {
        $link = connect_db();
        $query = "select count(*) from poi_category\n";
        $query .= $activeonly == true ? "where active = 'true'" : "";
        $query .= ";";
        $res = db_query($query);
        $count = db_fetch_row($res);
        $count = $count[0];
        close_db($link);
        return $count;
    }
    
    function count_active_entries_by_category() {
        return count_entries_by_category(true);
    }

/*
** 300ms
SELECT a.id, a.name, a.icon, b.counts
  FROM POI_category AS a
  left join (
    select category_id, count(id) as counts 
    from poi 
    where active = 'true' 
    group by category_id) 
    as b on a.id = b.category_id

** 110ms
SELECT a.id, a.name, a.icon, b.counts
  FROM POI_category AS a
  left join (
    select category_id, count(id) as counts 
    from poi 
    where active = 'true' 
    group by category_id) 
  as b on a.id = b.category_id
  where a.active = 'true'

** 190ms
select a.category_id, count(a.category_id)
  from poi as a
  left join (
    select id 
    from poi_category
    where active = 'true') as b on a.category_id = b.id
  where a.active = 'true'
group by a.category_id
*/
    function count_entries_by_category($activeonly = false) {
        $link = connect_db();
        $array = array();
        
        $query  = "select a.id, a.name, a.icon, coalesce(b.counts, 0) as counts\n";
        $query .= "from poi_category as a\n";
        $query .= "left join (\n";
        $query .= "select category_id, count(id) as counts\n";
        $query .= "from poi\n";
        $query .= $activeonly == true ? "where active = 'true'\n" : "";
        $query .= "group by category_id)\n";
        $query .= "as b on a.id = b.category_id\n";
        $query .= $activeonly == true ? "where a.active = 'true'\n" : "";
        $query .= ";\n";

        $res = db_query($query);
        while($row = db_fetch_assoc($res)) {
            array_push($array, $row);
        }
        return $array;
        close_db($link);
    }

    function get_active_categories() {
        return get_categories(true);
    }

    function get_all_categories(){
        return get_categories(false);
    }

    function get_category($id) {
        return get_categories(false, $id);
    }
    
    function get_active_category($id) {
        return get_categories(true, $id);
    }

    function get_categories($activeOnly = false, $id = null) {
        $link = connect_db();
        $id = db_escape_string($id);
        $query = "select active, id, name, icon, iconw, iconh, iconx, icony, display_order, description, multi_icon, multi_iconw, multi_iconh, multi_iconx, multi_icony\n";
        $query .= "from poi_category\n";
        if($activeOnly == true or $id != null) {
            $query .= "where\n";
            $array = array();
            if($activeOnly == true)
                array_push($array, "active = true");
            if($id != null)
                array_push($array, "id = $id");
            $query .= implode(" and ", $array)."\n";
        }
        $query .= "order by name\n";   
        if(!empty($id)) {
            $query .= "limit 1;";
        } else {
            $query .= ";";
        }

        $res = db_query($query);
        $array = array();
        while($row = db_fetch_assoc($res)) {
            array_push($array, $row);
        }
        close_db($link);

        return $array;
    }

    function form_category() {
        array_walk($_POST, 'walk_db_escape_string');

        if($_POST['form_category_edit'] == "1") {
            /* edit one category */
            return edit_category($_POST);
        } elseif($_POST['form_category_edit'] == "0") {
            /* add a new category */
            return add_category($_POST);
        }
    }
    
    function set_imagesize () {
        if((empty($_POST['iconw']) || empty($_POST['iconh'])) && !empty($_POST['icon'])) {
            if(file_exists($_POST['icon'])) {
                $size = getimagesize($_POST['icon']);
                $_POST['iconw'] = $size[0];
                $_POST['iconh'] = $size[1];
            }
        }
        if((empty($_POST['multi_iconw']) || empty($_POST['multi_iconh'])) && !empty($_POST['multi_icon'])) {
            if(file_exists($_POST['multi_icon'])) {
                $size = getimagesize($_POST['multi_icon']);
                $_POST['multi_iconw'] = $size[0];
                $_POST['multi_iconh'] = $size[1];
            }
        }
    }

    function add_category() {
        $link = connect_db();
        set_imagesize($_POST);
        $query = "INSERT INTO POI_category (active, name, description, icon, iconw, iconh, iconx, icony, multi_icon, multi_iconw, multi_iconh, multi_iconx, multi_icony, display_order) VALUES ('{$_POST['active']}', '{$_POST['name']}', '{$_POST['description']}', '{$_POST['icon']}', '{$_POST['iconw']}', '{$_POST['iconh']}', '{$_POST['iconx']}', '{$_POST['icony']}', '{$_POST['display_order']}')";
        if(!db_query($query)) {
            print(db_error());
            close_db($link);
            return false;
        }
        close_db($link);
        return true;
    }

    function edit_category() {
        $link = connect_db();
        set_imagesize($_POST);
	$active = isset($_POST['active']) ? 'true' : 'false';
        $query = "UPDATE POI_category SET active = '$active', name = '{$_POST['name']}', description = '{$_POST['description']}', icon =  '{$_POST['icon']}', iconw = '{$_POST['iconw']}', iconh = '{$_POST['iconh']}', iconx = '{$_POST['iconx']}', icony = '{$_POST['icony']}', multi_icon = '{$_POST['multi_icon']}', multi_iconw = '{$_POST['multi_iconw']}', multi_iconh = '{$_POST['multi_iconh']}', multi_iconx = '{$_POST['multi_iconx']}', multi_icony = '{$_POST['multi_icony']}', display_order = '{$_POST['display_order']}' WHERE id = {$_POST['category_id']};";
	if(!db_query($query)) {
            print(db_error());
            close_db($link);
            return false;
        }
        return true;
        close_db($link);
    }
    
    function delete_category() {
        $link = connect_db();
        array_walk($_POST, 'walk_db_escape_string');
        $query = "DELETE FROM POI_category WHERE id = '{$_POST['category_id']}';";
        if(!db_query($query)) {
            print(db_error());
            close_db($link);
            return false;
        }
        return true;
        close_db($link);

    }
}
?>
