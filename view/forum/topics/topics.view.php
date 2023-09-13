
<?php
use Model\Entities\Category;
$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
?>

<h1>liste des topics de la categorie : <?=$category->getCategoryName();?> </h1>

<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th style="background-color: #f2f2f2; text-align: left; padding: 10px;">Titre</th>
        <th style="background-color: #f2f2f2; text-align: left; padding: 10px;">Date de création</th>
        <th style="background-color: #f2f2f2; text-align: left; padding: 10px;">Créé par</th>
        <th style="background-color: #f2f2f2; text-align: left; padding: 10px;">Status</th>
        <th style="background-color: #f2f2f2; text-align: center; padding: 10px;">Modifier</th>
        <th style="background-color: #f2f2f2; text-align: center; padding: 10px;">Supprimer</th>
    </tr>
    <!-- looping in categories array to show each category and option to edit and delete -->
    <?php foreach($topics as $topic ) : 
        $id = $topic->getId();
        $status = ($topic->getIslocked() === 0) ? '<span style="color:green;">Open</span>' : '<span style="color:red;">Closed</span>';
    ?>
    
    ?>
    <tr>
        <td style="border: 1px solid #ddd; padding: 10px;">
            <a href="index.php?ctrl=forum&action=showPostsByTopicId&id=<?= $id ?>"> <?=$topic->getTitle()?> </a>
        </td>
        <td style="border: 1px solid #ddd; padding: 10px;"> <?=$topic->getCreationDate()?>
        </td>
        <td style="border: 1px solid #ddd; padding: 10px;"> <?=$topic->getUser()?></td>

        <td style="border: 1px solid #ddd; padding: 10px;"> <?= $status ?> </td>

        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
            <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $id ?>"><button style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Modifier</button></a>
        </td>
        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
            <a href="index.php?ctrl=forum&action=deleteTopicById&id=<?= $id ?>"><button style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;">Supprimer</button></a>
        </td>
    </tr>
    
    <?php endforeach; ?>
    
</table>

<br>


<a href="index.php?ctrl=forum&action=addTopicForm&id=<?= $id ?>" style="text-decoration: none;">
    <button style="background-color: #007BFF; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
        Créer un nouveau topic
    </button>
</a>

