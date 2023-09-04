
<?php

$posts = $result["data"]['posts'];
    
?>

<h1>liste des Posts du topic</h1>

<?php
    foreach($posts as $post ){
        if ($post !== null) { 
?>
            <p><?=$post->getMessage()?></p>
<?php   } 
        else {
            echo "<p> ce topic ne contient pas encore de messages</p>";
        }
    }
?>
