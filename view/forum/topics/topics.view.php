<link rel="stylesheet" href=".<?= PUBLIC_DIR ?>/css/listTopics.css">

<?php
use Model\Entities\Category;
$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
?>


<section id="topic-list">  
    <h2> <?=$category->getCategoryName();?> </h2>

    <a href="index.php?ctrl=forum&action=addTopicForm&id=<?= $id ?>" class="add-topic"><button>Créer un topic</button></a>

    <?php foreach($topics as $topic ) : 
        
        $status = ($topic->getIslocked() === 0) ? '<span style="color:green;">Open</span>' : '<span style="color:red;">Closed</span>';
        $className = ($status) ? "closed" : "open"
    ?>

    <div class="topic">
        <div class="topic-left">
            <div class="icon-topic"><img src="./public/uploads/<?=$topic->getUser()->getAvatar()?>" alt="avatar" width="60px" height="60px"> </div>
            <div>
                <h3 class="topic-title"><a href="index.php?ctrl=forum&action=showPostsByTopicId&id=<?= $id ?>"> <?=$topic->getTitle()?>  </a></h3>
                <p class="postedBy"> <span>Posted by :</span> <a href="#"> <?=$topic->getUser()?></a> - <?=$topic->getCreationDate()?> </p>
            </div>
        </div>
        <div class="topic-right">
            <span class="nbPosts">150</span>

            <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>" class="edit"></a>
            <a href="index.php?ctrl=forum&action=deleteTopicById&id=<?= $topic->getId() ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');"></a>
           
            <a href="index.php?ctrl=forum&action=toggleTopicStatusById&id=<?= $topic->getId() ?>" class="<?= $className ?>"></a>
            
        </div>
    </div>
    <?php endforeach; ?>




    <a href="index.php?ctrl=forum&action=addTopicForm&id=<?= $id ?>" class="add-topic"><button>Créer un topic</button></a>
    


</section>

<script>
    /*
    fonction pour modifier le status d'un topic
    */


    //  stock l'element ciblé dans une variable
    const padlock = document.querySelector('.open'); 

    // on crée la fonction qui fera l'échange de classe au click
    function toggleClass(element, className) {
        element.addEventListener('click', () => {
        element.classList.toggle(className);
        });
    }
  

    toggleClass(padlock, '.closed');
</script>

