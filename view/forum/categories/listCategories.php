<link rel="stylesheet" href=".<?= PUBLIC_DIR ?>/css/listCategories.css">

<?php

$categories = $result["data"]['categories'];

$descriptionContent = $result['data']['descriptionContent'];
$pageTitle = $result['data']['pageTitle'];
    
?>
   
    <section id="categ-list">  
            <h2>Liste des Catégories</h2>

 <!-- Boucle à travers le tableau de catégories pour afficher chaque catégorie avec les options de modification et de suppression -->
 <?php foreach($categories as $category ) : 
        $id = $category->getId();
 ?>

            <div class="categ">
                <div class="categ-left">
                    <div class="icon-categ"></div>
                    <div>
                        <h3 class="categ-name"><a href="index.php?ctrl=forum&action=showTopicsByCategoryId&id=<?= $id ?>"> <?=$category->getCategoryName()?></a></h3>
                        <p class="descriptions"> <span> description : </span>  <?=$category->getDescriptions()?></p>
                    </div>
                </div>
                <div class="categ-right">
                    <span class="nbTopics">150</span>
                    <?php if (App\Session::isAdmin()) { ?>
                    <a href="index.php?ctrl=forum&action=editCategoryForm&id=<?= $id ?>" class="edit"></a>
                    <a href="index.php?ctrl=forum&action=deleteCategoryById&id=<?= $id ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');"></a>
                    <?php } ?> 
                </div>
            </div>
<?php endforeach; ?>

<?php if (App\Session::isAdmin()) { ?>

         <a href="index.php?ctrl=forum&action=addCategoryForm" class="add-categ"><button>Ajouter une catégorie</button></a>
         
<?php } ?>

    </section>



