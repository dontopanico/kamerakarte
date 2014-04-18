<?php
// TODO: Erstellungszeit beachten
include('wikistyle.php');

// Verbessern bei falschen/fehlenden Angaben (Gast)
if(isset($_POST['form_entry_ok']) && $form_entry == false) {
    $form_entry_array[0] = $_POST;
}
// Normales Bearbeiten
elseif (isset($_GET['e']) && is_numeric($_GET['e'])) {
    $form_entry_array = get_entry($_GET['e']);
}

// Werte setzen
if(isset($form_entry_array) && !empty($form_entry_array)) {
    $form_entry_id = $form_entry_array[0]['id'];
    $form_entry_active = $form_entry_array[0]['active'];
    $form_entry_creation_timest = $form_entry_array[0]['creation_timest'];
    $form_entry_title = stripslashes($form_entry_array[0]['title']);
    $form_entry_category_id = $form_entry_array[0]['category_id'];
    $form_entry_description = stripslashes($form_entry_array[0]['description']);
    $form_entry_location = stripslashes($form_entry_array[0]['location']);
    $form_entry_lat = $form_entry_array[0]['lat'];
    $form_entry_lon = $form_entry_array[0]['lon'];
} else {
    $form_entry_id = "";
    $form_entry_active = "";
    $form_entry_creation_timest = "";
    $form_entry_title = "";
    $form_entry_category_id = "";
    $form_entry_description = "";
    $form_entry_location = "";
    $form_entry_lat = "";
    $form_entry_lon = "";
}

// Infotext unter der Karte
$infotext = ($_GET['map'] == 1) ? 'Auf die Karte drücken um Koordinaten zu setzen.<br /><i>Sollte der neue Punkt durch Icons verdeckt sein,<br />kann der Layer auf der rechten Seite (+) ausgeschaltet werden.</i>' : 'Um Koordinaten automatisch setzen zu können Karte anzeigen.';
echo sprintf("<p class=\"info\">%s</p>", $infotext);

// Anzeige Formular 
// ================ 
?>
<h1>Einträge -> <?php echo is_numeric($form_entry_id) ? "Bearbeiten (ID: {$form_entry_id})" : "Eintragen"; ?></h1>
<?php if(isset($_POST['form_entry_ok']) && $form_entry != false) {
    echo "<p class=\"confirm\">Vielen Dank für deinen Beitrag. 
        Dieser ist zunächst <strong>inaktiv</strong>, aber wir lauern schon hinter den Kulissen.</p>";
} elseif(isset($_POST['form_entry_ok'])) {
    echo "<p class=\"failure\">Titel, Longitude oder Latitude fehlt. Oder es wurde keine gültige Kategorie angegeben. Versuchs nochmal...</p>";
} ?>
<form action="form.php?map=<?php echo $_GET['map']; ?>" method="post" name="form_entry">
  <fieldset>
    <table>
        <tfoot>
            <tr>
                <td colspan="2">
                    <?php
                    // Hidden Felder und Submits
                    // ========================= 
                    ?>
                    <input type="hidden" name="form_entry_edit" value="<?php echo is_numeric($form_entry_id) ? 1 : 0; ?>" />
                    <input type="hidden" name="entry_id" id="entry_id" value="<?php echo $form_entry_id; ?>" />
                    <input class="button positive" name="form_entry_ok" type="submit" value="OK" />
                    <input class="button regular" onclick="return showPreview();" type="submit" value="Vorschau" />
                    <?php if(is_admin() && !is_guest()) { ?>
                    <input class="button negative" type="submit" name="form_back" value="Zurück" />
                    <?php } ?>
                </td>
            </tr>
        </tfoot>
        <?php if(is_admin() && !is_guest()) { ?>
        <tr>
            <td><label for="active">Aktiv</label></td>
            <td><input name="active" type="checkbox" value="1" <?php echo $form_entry_active == 't' ? "checked=\"checked\"" : ""; ?> /></td>
        </tr>
        <?php } ?>
        <tr>
            <td><label for="category">Kategorie</label></td>
            <td>
                <select name="category_id" size="1">
		    <option>-- Bitte wählen --</option>
<?php 
foreach(get_all_categories() as $category){
    echo "<option value=\"{$category['id']}\" ";
    echo $form_entry_category_id == $category['id'] ? "selected=\"selected\"" : "";
    echo ">{$category['name']}</option>\n";

}
?>
                </select>
            </td>
        </tr>
	<tr>
	    <td><label for="creation_timestamp">Erstellungszeit</label></td>
	    <td><?php echo empty($form_entry_creation_timest) ? "Wird wohl grad erst erstellt" : $form_entry_creation_timest; ?></td>
	</tr>
        <tr>
            <td><label for="title">Titel</label></td>
            <td><textarea name="title" rows="2" cols="40" id="title"><?php echo $form_entry_title; ?></textarea></td>
        </tr>
        <tr>
	    <td><label for="description">Beschreibung</label></td>
	    <td>
		<textarea name="description" rows="10" cols="40" id="description"><?php echo $form_entry_description; ?></textarea><br />
		<a href="#" onclick="return showWikihelp('wikihelp', 'show_wikihelp');"><span id="show_wikihelp">+</span> Syntax-Hilfe</a>
		<div id="wikihelp" style="text-align: left; display:none;"><?php echo wikihelp_short(); ?></div>
	    </td>
        </tr>
        <tr>
            <td><label for="location">Standortbeschreibung</label></td>
            <td><textarea name="location" cols="40"><?php echo $form_entry_location; ?></textarea></td>
        </tr>
        <tr>
            <td>
                <a class="tipp" style="z-index: 7;"><label for="lat">Geographische Breite (Latitude)</label>
                    <span><b>Hinweis: </b>Mit einem Klick auf die Karte setzen.</span></a>
            </td>
            <td><input type="text" maxlength="128" name="lat" id="entry_lat" value="<?php echo $form_entry_lat; ?>"/></td>
        </tr>
        <tr>
            <td>
                <a class="tipp" style="z-index: 6;"><label for="lon">Geographische Höhe (Longitude)</label>
                    <span><b>Hinweis: </b>Mit einem Klick auf die Karte setzen.</span></a>
            </td>
            <td><input type="text" maxlength="128" name="lon" id="entry_lon" value="<?php echo $form_entry_lon; ?>" /></td>
        </tr>
    </table>
  </fieldset>
</form>

<!-- Preview -->

<div id="preview" class="preview">

    <!-- close button -->
    <div style="position: absolute; top: 0px;">
        <input type="submit" value="Vorschau schließen" class="button regular" onclick="return closePreview()" />
    </div>
    
    <!-- chicken -->
    <div style="overflow: hidden; position: fixed; left: 20%; top: 20%; width: 304px; height: 125px;" id="chicken">
    
        <div style="overflow: hidden; position: absolute; top: 0px; left: 0px; height: 100%; width: 100%;" id="chicken_GroupDiv">
        
            <!-- Content -->
            <div style="overflow: auto; width: 256px; height: 66px; position: absolute; z-index: 1; left: 8px; top: 40px;" id="chicken_contentDiv">
                <div id="inhalt" style="position: absolute;"></div>
            </div>
            
            <!-- close button -->
            <a href="#" onclick="return closePreview();">
                <div style="width: 17px; height: 17px; position: absolute; right: 13px; top: 45px; z-index: 1; background-image: url(wiki_images/close.gif)" id="chicken_close">
                </div>
            </a>
            
            <!-- Framedecoration -->
            <div style="overflow: hidden; position: absolute; width: 282px; height: 72px; left: 0px; bottom: 21px; right: 22px; top: 32px;" id="chicken_FrameDecorationDiv_0">
                <img src="wiki_images/cloud-popup-relative.png" style="width: 676px; height: 736px; position: absolute; left: 0px; top: 0px;" id="chicken_FrameDecorationImg_0">
            </div>
            
            <div style="overflow: hidden; position: absolute; width: 22px; height: 72px; bottom: 21px; right: 0px; top: 32px;" id="chicken_FrameDecorationDiv_1">
                <img src="wiki_images/cloud-popup-relative.png" style="width: 676px; height: 736px; position: absolute; left: -638px; top: 0px;" id="chicken_FrameDecorationImg_1">
            </div>
            
            <div style="overflow: hidden; position: absolute; width: 282px; height: 21px; left: 0px; bottom: 0px; right: 22px;" id="chicken_FrameDecorationDiv_2">
                <img src="wiki_images/cloud-popup-relative.png" style="width: 676px; height: 736px; position: absolute; left: 0px; top: -629px;" id="chicken_FrameDecorationImg_2">
            </div>
            
            <div style="overflow: hidden; position: absolute; width: 22px; height: 21px; bottom: 0px; right: 0px;" id="chicken_FrameDecorationDiv_3">
                <img src="wiki_images/cloud-popup-relative.png" style="width: 676px; height: 736px; position: absolute; left: -638px; top: -629px;" id="chicken_FrameDecorationImg_3">
            </div>
            <!-- "Zipfel" -->
            <div style="overflow: hidden; position: absolute; width: 81px; height: 33px; right: 0px; top: 0px;" id="chicken_FrameDecorationDiv_4">
                <img src="wiki_images/cloud-popup-relative.png" style="width: 676px; height: 736px; position: absolute; left: -101px; top: -674px;" id="chicken_FrameDecorationImg_4">
            </div>
            
        </div>
        
    </div>
    
</div>

<!-- End of Preview-->

