
<?php 
    $users = $result['data']['users'];
    $category = $result['data']['category'];
   

?>

<h1 style="text-align: center;">Créer un nouveau topic</h1>
<form action="index.php?ctrl=forum&action=createTopic" method="post" style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

    <label for="title" style="font-weight: bold; display: block; margin-bottom: 10px;">Titre :</label>
    <input type="text" name="title" id="title" placeholder="Entrez le titre" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;" required>

    <label for="message" style="font-weight: bold; display: block; margin-bottom: 10px;">Décrivez votre topic :</label>
    <textarea name="message" id="message" cols="30" rows="10" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;" required></textarea>

    <label for="user" style="font-weight: bold; display: block; margin-bottom: 10px;">Choisissez un utilisateur :</label>
    <select name="user_id" id="user" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px; margin-bottom: 20px;" required>
        <option value="">Sélectionnez</option>
        <?php foreach ($users as $user) : ?>
            <option value="<?= $user->getId() ?>"><?= $user->getPseudo() ?></option>
        <?php endforeach; ?>
    </select>

    <input type="hidden" name="category_id" value="<?= $category->getId() ?>">
    <input type="submit" value="Créer" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 3px; font-size: 18px; cursor: pointer;">
</form>

