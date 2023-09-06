<br> <br>
<form action="index.php?ctrl=forum&action=addCategory" method="post" style="max-width: 400px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">

    <label for="categoryName" style="display: block; margin-bottom: 10px; font-weight: bold;">Nom de la catégorie :</label>
    <input type="text" name="categoryName" id="categoryName" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 3px;">
    
    <label for="description" style="display: block; margin-bottom: 10px; font-weight: bold;">Description de la catégorie :</label>
    <textarea name="description" id="description" cols="30" rows="5" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 3px;"></textarea>
    
    <input type="submit" value="Valider" style="background-color: #007BFF; color: white; border: none; padding: 10px 20px; border-radius: 3px; cursor: pointer;">
</form>
