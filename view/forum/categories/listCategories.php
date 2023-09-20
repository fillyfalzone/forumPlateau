<link rel="stylesheet" href=".<?= PUBLIC_DIR ?>/css/listCategories.css">

<?php

$categories = $result["data"]['categories'];
$descriptionContent = $result['data']['descriptionContent'];
$pageTitle = $result['data']['pageTitle'];
    
?>

<h2>Liste des catégories</h2>

<table>
    <tr>
        <th>Catégories</th>
        <th >Modifier</th>
        <th>Supprimer</th>
    </tr>
    <!-- Boucle à travers le tableau de catégories pour afficher chaque catégorie avec les options de modification et de suppression -->
    <?php foreach($categories as $category ) : 
        $id = $category->getId();
    ?>
    <tr>
        <td >
            <a href="index.php?ctrl=forum&action=showTopicsByCategoryId&id=<?= $id ?>">
            <?=$category->getCategoryName()?></a>
        </td>
        <td >
            <a href="index.php?ctrl=forum&action=editCategoryForm&id=<?= $id ?>"><button>Modifier</button></a>
        </td>
        <td>
            <a href="index.php?ctrl=forum&action=deleteCategoryById&id=<?= $id ?>"><button>Supprimer</button></a>
        </td>
    </tr>
    
    <?php endforeach; ?>
    
</table>
<br>

<a href="index.php?ctrl=forum&action=addCategoryForm"><button>Ajouter une catégorie</button></a>


