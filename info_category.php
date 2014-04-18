<?php 
// show a category in index.php
$file = basename($_SERVER['PHP_SELF']);
if($file == "index.php"){

    $cat_id = $_GET['c'];
    $entries = get_active_entries_by_category($cat_id);
    $category = get_active_category($cat_id);
    
    if(!empty($category)) { ?>
        <h1 class="hovertitel">
            <img src="<?php echo $category[0]['icon']; ?>" alt="icon" width="<?php echo $category[0]['iconw']; ?>px" />
            <?php echo $category[0]['name']; ?>
            <a href="form.php?c=<?php echo $cat_id; ?>" class="hovertext">Bearbeiten</a>
        </h1>
        <?php echo parse_wikistyle($category[0]['description'], false); ?>

        <h2>Einträge zu dieser Kategorie</h2>
        <?php
        foreach($entries as $entry_list) { ?>
            <a href="index.php?show=ent&e=<?php echo $entry_list['id']; ?>" class="int"><?php echo $entry_list['title']; ?></a><br />
        <?php }
    } else { ?>
        <p>Keine Kategorie zu ID <?php echo $cat_id; ?> gefunden. Möglicherweise ist diese Kategorie deaktiviert.</p>
    <?php }
    
}
?>
