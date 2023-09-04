<?php

$categories = $result["data"]['categories'];
    
?>

<h1>liste categories</h1>

<table>
    <tr>
        <th>Categories</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
    <!-- looping in categories array to show each category and option to edit and delete -->
    <?php foreach($categories as $category ) : ?>
    <tr>
        <td>
            <a href="index.php?ctrl=forum&action=showTopicsByCategoryId&id=<?=$category->getId()?>">
            <?=$category->getCategoryName()?></a>
        </td>
        <td>
            <a href="index.php?ctrl=forum&action=editCategoryById&id=<?=$category->getId()?>"><button>Modifier</button></a>
        </td>
        <td>
            <a href="index.php?ctrl=forum&action=deleteCategoryById&id=<?=$category->getId()?>"><button>Supprimer</button></a>
        </td>
    </tr>
    
    <?php endforeach; ?>
    
</table>
<br>

<a href="index.php?ctrl=forum&action=addCategoryForm"><button>Ajouter une categorie</button></a> 

