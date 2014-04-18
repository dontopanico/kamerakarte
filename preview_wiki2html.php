<?php
include_once("wikistyle.php");

echo "<h1><nobr>" . htmlspecialchars($_POST['preview_title']) . "</h1></nobr>";
echo parse_wikistyle(stripslashes($_POST['preview_description']), false, true);
echo "<br /><a href=\"index.php?show=ent&e={$_POST['entry_id']}\" class=\"infolink\" target=\"_blank\">Mehr Info</a>";
?>
