<h2>Liste des users</h2>

<?php

$users = $result["data"]['users'];
    
?>

<?php
foreach($users as $user ){

    ?>
    <p><?=$user->getPseudo()?></p>
    <?php
}


  
