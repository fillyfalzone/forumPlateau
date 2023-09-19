<?php

$categories = $result["data"]['categories'];
$descriptionContent = $result['data']['descriptionContent'];
$pageTitle = $result['data']['pageTitle'];
    
?>

<h1>Liste des catégories</h1>

<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th style="background-color: #f2f2f2; text-align: left; padding: 10px;">Catégories</th>
        <th style="background-color: #f2f2f2; text-align: center; padding: 10px;">Modifier</th>
        <th style="background-color: #f2f2f2; text-align: center; padding: 10px;">Supprimer</th>
    </tr>
    <!-- Boucle à travers le tableau de catégories pour afficher chaque catégorie avec les options de modification et de suppression -->
    <?php foreach($categories as $category ) : 
        $id = $category->getId();
    ?>
    <tr>
        <td style="border: 1px solid #ddd; padding: 10px;">
            <a href="index.php?ctrl=forum&action=showTopicsByCategoryId&id=<?= $id ?>">
            <?=$category->getCategoryName()?></a>
        </td>
        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
            <a href="index.php?ctrl=forum&action=editCategoryForm&id=<?= $id ?>"><button style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Modifier</button></a>
        </td>
        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
            <a href="index.php?ctrl=forum&action=deleteCategoryById&id=<?= $id ?>"><button style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;">Supprimer</button></a>
        </td>
    </tr>
    
    <?php endforeach; ?>
    
</table>
<br>

<a href="index.php?ctrl=forum&action=addCategoryForm"><button style="background-color: #007BFF; color: white; border: none; padding: 10px 20px; cursor: pointer;">Ajouter une catégorie</button></a>


