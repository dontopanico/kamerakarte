<?php
include('wikistyle.php');

if(isset($_GET['c']) && is_numeric($_GET['c'])){
    $form_category_array = get_category($_GET['c']);
}
if(isset($form_category_array)) {
    $form_category_id = $form_category_array[0]['id'];
    $form_category_active = $form_category_array[0]['active'];
    $form_category_name = stripslashes($form_category_array[0]['name']);
    $form_category_description = stripslashes($form_category_array[0]['description']);
    $form_category_icon = $form_category_array[0]['icon'];
    $form_category_iconw = $form_category_array[0]['iconw'];
    $form_category_iconh = $form_category_array[0]['iconh'];
    $form_category_iconx = $form_category_array[0]['iconx'];
    $form_category_icony = $form_category_array[0]['icony'];
    $form_category_multi_icon = $form_category_array[0]['multi_icon'];
    $form_category_multi_iconw = $form_category_array[0]['multi_iconw'];
    $form_category_multi_iconh = $form_category_array[0]['multi_iconh'];
    $form_category_multi_iconx = $form_category_array[0]['multi_iconx'];
    $form_category_multi_icony = $form_category_array[0]['multi_icony'];
    $form_category_display_order = $form_category_array[0]['display_order'];
} else {
    $form_category_id = "";
    $form_category_active = "";
    $form_category_name = "";
    $form_category_description = "";
    $form_category_icon = "";
    $form_category_iconw = "";
    $form_category_iconh = "";
    $form_category_iconx = "";
    $form_category_icony = "";
    $form_category_multi_icon = "";
    $form_category_multi_iconw = "";
    $form_category_multi_iconh = "";
    $form_category_multi_iconx = "";
    $form_category_multi_icony = "";
    $form_category_display_order = "";
}
    $icon_dirs = array('icons');
    $icon_files = get_icon_files($icon_dirs);
?>

<h1>Kategorien -> <?php echo is_numeric($_GET['c']) ? "Bearbeiten" : "Eintragen"; ?></h1>
<form action="form.php?map=<?php echo $_GET['map']; ?>" method="post" name="form_category">
  <fieldset>
    <table>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: #eef; text-align: left;">
                    <input type="hidden" name="form_category_edit" value="<?php echo is_numeric($form_category_id) ? 1 : 0; ?>" />
                    <input type="hidden" name="category_id" value="<?php echo $form_category_id; ?>" />
                    <input class="button positive" name="form_category_ok" type="submit" value="OK">
                    <input class="button negative" type="submit" name="form_back" value="Zurück">
                </td>
            </tr>
        </tfoot>
        <tr>
            <td><label for="active">Aktiv</label></td>
            <td><input name="active" type="checkbox" value="1" <?php echo $form_category_active == 't' ? "checked=\"checked\"" : ""; ?> /></td>
        </tr>
        <tr>
            <td><label for="name">Name</label></td>
            <td><input type="text" maxlength="128" name="name" value="<?php echo $form_category_name; ?>" /></td>
        </tr>
        <tr>
            <td><label for="description">Beschreibung</label></td>
            <td>
                <textarea name="description" rows="10" cols="40"><?php echo $form_category_description; ?></textarea><br />
                <a href="#" onclick="return showWikihelp('wikihelp', 'show_wikihelp');"><span id="show_wikihelp">+</span> Syntax-Hilfe</a>
		        <div id="wikihelp" style="text-align: left; display:none;"><?php echo wikihelp_short(); ?></div>
            </td>
        </tr>
        <tr>
            <td><label for="icon">Icon</label></td>
            <td>
                <select name="icon" />
                    <option>--- Bitte wählen ---</option>
                <?php
                    foreach($icon_files as $icon){
                		echo "<option value=\"$icon\" ";
                		echo "$icon" == "$form_category_icon" ? 'selected="selected"' : '';
                		echo ">$icon</option>\n";
        		    }
                ?>
                </select>
                <!-- <input type="text" name="icon" value="<?php echo $form_category_icon; ?>" /> -->
            </td>
        </tr>
        <tr>
            <td><a class="tipp" style="z-index: 9;">Icon - Außmaße<span><b>Hinweis: </b>
                Bei Nichtangabe (!) sucht sich dieses schlaue Programm seine eigenen Werte.</span></b></a></td>
            <td></td>
        </tr>
            
            <td><label for="iconw">Breite</label></td>
            <td><input type="text" name="iconw" value="<?php echo $form_category_iconw; ?>" />
        </tr>
             <td><label for="iconh">Höhe</label></td>
             <td><input type="text" name="iconh" value="<?php echo $form_category_iconh; ?>" /></td>
        </tr>
        <tr>
            <td><a class="tipp" style="z-index: 6;">Icon - Offset<span><b>Hinweis: </b>
                    Gibt die Verschiebung zum eingetragenen Punkt in Richtung X (horizontal) und Y (vertikal) an. 
                    Somit lässt sich der Zeigepunkt des Icons einstellen.<br /><br />
                    z.B. ein Icon hat die Maße 20x30 Pixel<br />
                    - Zeigerspitze des Icons: links-oben: X: 0 / Y: 0<br />
                    - Zeigerspitze des Icons: rechts-oben: X: -20 / Y: 0<br />
                    - Zeigerspitze des Icons: links-mitte: X: 0 / Y: -15</span></a></td>
            <td></td>
        </tr>
        <tr>
            <td><label for="iconx">X-Position</label></td>
            <td><input type="text" name="iconx" value="<?php echo $form_category_iconx; ?>" /></td>
        </tr>
        <tr>
            <td><label for="icony">Y-Position</label></td>
            <td><input type="text" name="icony" value="<?php echo $form_category_icony; ?>" /></td>
        </tr>
	<tr>
	    <td><a class="tipp" style="z-index: 6;">Einstellungen für MultiIcon<span><b>Hinweis: </b>
		    Wenn mehrere Punkte auf einem Haufen vorkommen, gruppiert (clustert) dieses schlaue Programm. Damit dies erkannt wird, sollte ein anderes Symbol angezeigt werden.
	    </span></a></td>
	</tr>
        <tr>
            <td><label for="multiicon">Icon (MultiIcon)</label><td>
                <select name="multi_icon" />
                    <option>--- Bitte wählen ---</option>
                <?php
                    foreach($icon_files as $icon){
                		echo "<option value=\"$icon\" ";
                		echo "$icon" == "$form_category_multi_icon" ? 'selected="selected"' : '';
                		echo ">$icon</option>\n";
        		    }
                ?>
                </select>
	    </td>
        </tr>
        <tr>
            <td><label for="multi_iconw">Breite (MultiIcon)</label></td>
            <td><input type="text" name="multi_iconw" value="<?php echo $form_category_multi_iconw; ?>" /></td>
        </tr>
        <tr>
            <td><label for="multi_iconh">Höhe (MultiIcon)</label></td>
            <td><input type="text" name="multi_iconh" value="<?php echo $form_category_multi_iconh; ?>" /></td>
        </tr>
        <tr>
            <td><a class="tipp" style="z-index: 6;">Icon - Offset<span><b>Hinweis: </b>
                    Gibt die Verschiebung zum eingetragenen Punkt in Richtung X (horizontal) und Y (vertikal) an. 
                    Somit lässt sich der Zeigepunkt des Icons einstellen.<br /><br />
                    z.B. ein Icon hat die Maße 20x30 Pixel<br />
                    - Zeigerspitze des Icons: links-oben: X: 0 / Y: 0<br />
                    - Zeigerspitze des Icons: rechts-oben: X: -20 / Y: 0<br />
                    - Zeigerspitze des Icons: links-mitte: X: 0 / Y: -15</span></a></td>
            <td></td>
        </tr>
        <tr>
            <td><label for="multi_iconx">X-Position (MultiIcon)</label></td>
            <td><input type="text" name="multi_iconx" value="<?php echo $form_category_multi_iconx; ?>" /></td>
        </tr>
        <tr>
            <td><label for="multi_icony">Y-Position (MultiIcon)</label></td>
            <td><input type="text" name="multi_icony" value="<?php echo $form_category_multi_icony; ?>" /></td>
        </tr>
        <tr>
            <td><a class="tipp" style="z-index: 2;"><label for="display_order">Display-Order</label>
                    <span><b>Hinweis: </b>
                    Gibt die Reihenfolge an, in der die Icons auf der Karte übereinander gelegt werden.</span></a></td>
            <td>
                <select name="display_order">
                    <option>-- Bitte wählen ---</option>
<?php 
for($i=1; $i<=10; $i++){
    echo "<option value=\"$i\" ";
    echo $form_category_display_order == $i ? "selected=\"selected\" " : "";
    echo ">$i</option>\n";
}
?>
                </select>
            </td>
        </tr>
    </table>
  </fieldset>
</form>
