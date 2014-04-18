<?php 
// show a single entry in index.php
$file = basename($_SERVER['PHP_SELF']);
if($file == "index.php"){

    $entry_id = $_GET['e'];
    $entry = get_active_entry($entry_id);
    if(!empty($entry)) { ?>
        <h1 class="hovertitel"><?php echo $entry[0]['title']; ?><a href="form.php?show=ent&e=<?php echo $entry_id; ?>" class="hovertext">Bearbeiten</a></h1>
        <table class="data">
            <caption>Angaben zur Position</caption>
            <thead></thead>
            <tbody>
                <tr><th>Standortbeschreibung:</th><td style="background-color: white;"><?php echo parse_wikistyle($entry[0]['location_text'], false); ?></td></tr>
                <tr><th>Longitude:</th><td style="background-color: white;"><?php echo $entry[0]['lon']; ?></td></tr>
                <tr><th>Latitude:</th><td style="background-color: white;"><?php echo $entry[0]['lat']; ?></td></tr>
            </tbody>
        </table>
        <a href="index.php?show=ent&e=<?php echo $entry_id; ?>&map=<?php echo $mapstatus; ?>"><?php echo $buttontext; ?></a><br />
        <?php echo "$map\n"; ?>
        <hr />
        <?php // Wiki-Text
        echo parse_wikistyle($entry[0]['description'], false);
        // Link zur Kategorie ?>
        <hr />
        <a href="index.php?show=cat&c=<?php echo $entry[0]['category_id']; ?>" class="int">Kategorie: <?php echo $entry[0]['cat_name']; ?></a>
    <?php } else { ?>
        <p>Kein Eintrag mit der ID <?php echo $entry_id; ?> vorhanden. Möglicherweise ist dieser Eintrag derzeit inaktiv.</p>
    <?php }
}
?>
