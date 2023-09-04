

<form action="index.php?ctrl=forum&action=$id=<?=$category->getId()?>" method="post">
    <label for="categoryName">Nom de la catégorie : </label>
    <input type="text" name="categoryName" id="categoryName" value="<?=$category->getCategoryName()?>"> <br>
    <label for="description">Description de la catégorie : </label> <br>
    <textarea name="description" id="description" cols="30" rows="5"> <?=$category->getCategoryName()?> </textarea><br>
    <input type="submit" value="Valider">
</form>