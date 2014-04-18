<?php 
// show all entries in index.php
$file = basename($_SERVER['PHP_SELF']);
if($file == "index.php"){

    $entries = get_all_active_entries();
    ?>
    <h1>Liste aller Einträge</h1>
    <a href="index.php?show=alle&map=<?php echo $mapstatus; ?>"><?php echo $buttontext; ?></a><br />
    <?php echo "$map\n";?>
    <table class="data sortable">
    <thead>
        <tr>
        <?php if(!$mapstatus) {
            echo "<th class=\"sorttable_nosort\"></th>";
        } ?>
        <th class="sorttable_nosort">Icon</th>
        <th>Kategorie</th>
        <th>Name</th>
        <th>Standort</th>
        <th>Kurzbeschreibung</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($entries as $entry_list) { ?>
        <tr>
            <?php if(!$mapstatus) {
                echo "<td><input type=\"image\" src=\"wiki_images/eyes.png\" title=\"Eintrag zentrieren\" onclick=\"setCenter4326(new OpenLayers.LonLat({$entry_list['lon']},{$entry_list['lat']}))\"/></td>";
            } ?>
            <td><img src="<?php echo $entry_list['cat_icon']; ?>" alt="Icon" title="Icon" width="15px" /></td>
            <td><a href="index.php?show=cat&c=<?php echo $entry_list['category_id']; ?>" class="int"><?php echo $entry_list['cat_name']; ?></a></td>
            <td><a href="index.php?show=ent&e=<?php echo $entry_list['id']; ?>" class="int"><?php echo $entry_list['title'] ?></a></td>
            <td><?php echo parse_wikistyle($entry_list['location_text'], false); ?></td>
            <td><?php echo parse_wikistyle(cut_summary($entry_list['description']), false); ?></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
<?php
}
?>
