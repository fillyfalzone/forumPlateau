<?php

    $user = $result['data']['user'];
    $topic = $result['data']['topic'];
    $category = $result['data']['category'];
    $categories = $result['data']['categories'];    
?>

<h1 style="text-align: center;">Modifier le topic : <?= $topic->getTitle() ?></h1>

<form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post" style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

    <label for="title" style="font-weight: bold; display: block; margin-bottom: 10px;">Titre :</label>
    <input type="text" name="title" id="title" value="<?= $topic->getTitle() ?>" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;" required >

    <label for="status" style="font-weight: bold; display: block; margin-bottom: 10px;">Changer le status</label> 

    <label for="">Open :</label>
    <input type="radio" name="status" id="status" value="0" checked >
    <label for="">Closed :</label>
    <input type="radio" name="status" id="status" value="1"> <br><br>

    <label for="user" style="font-weight: bold; display: block; margin-bottom: 10px;">Modifier la catégorie :</label>

    <select name="adminChangeCategory" id="category" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px; margin-bottom: 20px;">
        <option value="">Sélectionnez</option>
        <?php foreach ($categories as $adminChangeCategory) : ?>
            <option value="<?= $adminChangeCategory->getId() ?>"> <?= $adminChangeCategory->getCategoryName() ?> </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Modifier" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 3px; font-size: 18px; cursor: pointer;">

    <!-- send in post different id by input:hidden -->
    <input type="hidden" name="categogy_id" value="<?= $category->getId() ?>">
    <input type="hidden" name="user_id" value="<?= $user->getId() ?>"> 
    <input type="hidden" name="id_topic" value="<?= $topic->getTitle() ?>"> 
</form>

