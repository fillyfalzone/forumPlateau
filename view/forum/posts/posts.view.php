
<?php

$posts = $result['data']['posts'];
$topic = $result['data']['topic']; 

?>

<h1 style="text-align: center; font-family: Arial, sans-serif; font-size: 24px;">Liste des Posts du topic : <?= $topic->getTitle()  ?></h1>

<table style="margin: 0 auto; border-collapse: collapse; width: 80%;">
    <tr>
        <th style="border: 1px solid #ddd; padding: 10px; background-color: #f2f2f2; text-align: center;">Message</th>
        <th style="border: 1px solid #ddd; padding: 10px; background-color: #f2f2f2; text-align: center;">Date de publication</th>
        <th style="border: 1px solid #ddd; padding: 10px; background-color: #f2f2f2; text-align: center;">Auteur</th>
        <th style="border: 1px solid #ddd; padding: 10px; background-color: #f2f2f2; text-align: center;">Modifier</th>
        <th style="border: 1px solid #ddd; padding: 10px; background-color: #f2f2f2; text-align: center;">Supprimer</th>
        
    </tr>
    <?php foreach($posts as $post) : 
    
    ?>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?= $post->getMessage() ?></td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?= $post->getPostDate() ?></td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?= $post->getUser()->getPseudo() ?></td>

            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                <a href="index.php?ctrl=forum&action=updatePostForm&id=<?= $post->getId() ?>">
                <button style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Modifier</button>
                </a>
            </td>

            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                <a href="index.php?ctrl=forum&action=deletePostById&id=<?= $post->getId() ?>">
                <button style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;">Supprimer</button>
                </a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<form action="index.php?ctrl=forum&action=addPostByTopicId&id=<?= $topic->getId(); ?>" method="post" style=" padding: 10px; text-align: center;">
    <textarea name="message" id="message" cols="30" rows="10" required style="display:block; width:50%; margin:20px auto;"></textarea> 

    <input type="submit" value="Ajouter un message" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">

    <!-- envoyer en post l'id du user qui add le nouveau "post : message" -->
    <input type="hidden" name="user" value="<?= $post->getUser()->getId()?>">
</form> 
       


