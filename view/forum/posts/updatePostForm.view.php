<?php 
    $post = $result['data']['post'];
?>

<h3 style="text-align: center;">Modifier votre post</h3>

<form action="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>" method="post" style="background-color: #f4f4f4; border: 1px solid #ccc; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); max-width: 400px; margin: 0 auto;">
    <label for="message" style="font-weight: bold;">Modifier le message</label> <br>
    <textarea name="message" id="message" cols="40" rows="10" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><?= $post->getMessage() ?></textarea> <br>

    <input type="submit" value="Modifier" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
</form>