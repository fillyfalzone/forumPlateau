
<?php

$topics = $result["data"]['topics'];
    
?>

<h1>liste des topics de la categorie</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p><a href="index.php?ctrl=forum&action=showPostsByTopicId&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a></p>
    <?php
}
