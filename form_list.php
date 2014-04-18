<p><a href="#entries">Einträge</a> / <a href="#categories">Kategorien</a></p>

<?php  // Einträge
// ===================== 

// Workaround to show map ... or not
if(!isset($_GET['map'])) {
    if(!isset($no_show_map)) {
	$no_show_map = true;
    }
    $_GET['map'] = !$no_show_map;
}

?>
       
<h1>Einträge</h1>
<?php if(isset($_POST['form_entry_ok']) || isset($_POST['delete_entry'])) {
    $hint = $_POST['form_entry_ok'] ? 'Eintrag gespeichert' : 'Eintrag gelöscht';
    echo "<p class=\"confirm\">$hint</p>";
} ?>
<table id="entries" name="entries" class="sortable">
  <thead>
    <tr>
    <th id="entry_id">ID</th>
    <th id="active">Aktiv</th>
    <th id="creation_timestamp">Erstellungszeit</th>
    <th id="cat_icon">Icon</th>
    <th id="name">Titel</th>
    <th id="description">Beschreibung</th>
    <th id="edit" class="sorttable_nosort"></th>
    <th id="delete" class="sorttable_nosort"></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="8">
                <a href="form.php?map=<?php echo $_GET['map']; ?>&e=new" class="button positive">Neuer Eintrag</a>
        </td>
    </tr>
  </tfoot>
  <tbody>
  <?php
  foreach(get_all_entries() as $entry){
    $description = $entry['description'];
    if(strlen($description) >= 100) {
        $description = substr($description, 0, 100);
        $description .= " ...";
    }
    $description = htmlspecialchars($description);
    
    $title = $entry['title'];
    if(strlen($title) >= 50) {
        $title = substr($title, 0, 50);
        $title .= " ...";
    }
    $title = htmlspecialchars($title);
    $active = ($entry['active'] == 't') ? 'ja' : 'nein';

    /* Check if coordinates are given */
    if(empty($entry['lon']) || empty($entry['lat'])) {
        $coordinates_missing = true;
    } else {
        $coordinates_missing = false;
    }

    /* Check if icon is set */
    if($entry['cat_name'] == '0' || $entry['cat_icon'] == '0') {
	$icon_missing = true;
	$cat_icon = '';
	$cat_name = 'kein Icon';
    } else {
	$icon_missing = false;
	$cat_icon = $entry['cat_icon'];
	$cat_name = $entry['cat_name'];
    }

    if($coordinates_missing == true || $icon_missing == true) {
	$alert_faulty_entry = 'style="background-color: #fed;"';
    } else {
	$alert_faulty_entry = '';
    }



    echo "
    <tr>\n
    <td header=\"entry_id\"><a href=\"index.php?show=ent&e={$entry['id']}\" title=\"Infoseite anschauen\">{$entry['id']}</a></td>
    <td headers=\"active\" $alert_faulty_entry>$active</td>\n
    <td headers=\"creation_timestamp\">{$entry['creation_timest']}</td>\n
    <td headers=\"cat_icon\"><img src=\"$cat_icon\" alt=\"$cat_name\" title=\"$cat_name\" /></td>\n
    <td headers=\"name\">$title</td>\n
    <td headers=\"description\">$description</td>\n
    <td headers=\"description\"><a class=\"button regular\" href=\"form.php?e={$entry['id']}&map={$_GET['map']}\">Bearbeiten</a></td>\n
    <td headers=\"delete\">\n
        <form action=\"form.php?map={$_GET['map']}\" method=\"post\">\n
            <input type=\"hidden\" name =\"entry_id\" value=\"{$entry['id']}\" />\n
            <input type=\"submit\" class=\"button negative\" name=\"delete_entry\" value=\"Löschen\" />\n
        </form>\n
    </td>\n
    </tr>\n";
  }
  ?>
  </tbody>
</table>
<?php // Fehlernotiz: fehlende Koordinaten oder fehlendes Icon
if($coordinates_missing == true || $icon_missing == true) { 
    echo '<p class="failure" style="margin: 0 1em;">* Bei rot markierten Einträgen fehlen Angaben zu den Koordinaten oder zum Icon.</p>'; 
}

// Kategorien
// ===========
?>
<h1>Kategorien</h1>
<?php if(isset($_POST['form_category_ok']) || isset($_POST['delete_category'])) {
    $hint = $_POST['form_category_ok'] ? 'Kategorie gespeichert' : 'Kategorie gelöscht';
    echo "<p class=\"confirm\">$hint</p>";
} ?>
<table id="categories" name="categories" class="sortable">
  <thead>
    <tr>
    <th id="category_id">ID</th>
    <th id="active">Aktiv</th>
    <th id="icon">Icon</th>
    <th id="name">Name</th>
    <th id="description">Beschreibung</th>
    <th id="edit" class="sorttable_nosort"></th>
    <th id="delete" class="sorttable_nosort"></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
        <td colspan="7">
            <a href="form.php?map=<?php echo $_GET['map']; ?>&c=new" class="button positive">Neue Kategorie</a>
        </td>
    </tr>
  </tfoot>
  <tbody>
  <?php
  foreach(get_all_categories() as $category){
    $active = ($category['active'] == 't') ? 'ja' : 'nein';
    echo "
    <tr>\n
    <td header=\"entry_id\"><a href=\"index.php?show=cat&c={$category['id']}\" title=\"Infoseite anschauen\">{$category['id']}</a></td>
    <td headers=\"active\">$active</td>\n
    <td headers=\"icon\"><img src=\"{$category['icon']}\" alt=\"{$category['icon']}\" /></td>\n
    <td headers=\"name\">{$category['name']}</td>\n
    <td headers=\"description\">{$category['description']}</td>\n
    <td headers=\"edit\">
        <a class=\"button regular\" href=\"form.php?c={$category['id']}&map={$_GET['map']}\">Bearbeiten</a>
    </td>\n
    <td headers=\"delete\">
        <form action=\"form.php?map={$_GET['map']}\" method=\"post\">\n
            <input type=\"hidden\" name =\"category_id\" value=\"{$category['id']}\" />
            <input type=\"submit\" class=\"button negative\" name=\"delete_category\" value=\"Löschen\" />
        </form>
    </td>\n
    </tr>\n";
  }
  ?>
  </tbody>
</table>

