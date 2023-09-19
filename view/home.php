<?php 
    $descriptionContent = $result['data']['descriptionContent'];
    $pageTitle = $result['data']['pageTitle'];
?>

        
<div id="home">
    <aside id="pseudo" class="left aside">
        <h2><a href="#">Pseudo</a></h2>
        <div id="main-avatar">
            <img src=".<?=PUBLIC_DIR ?>/images/avatar.svg" alt="avatar">
        </div>
        <ul>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Messagerie</a></li>
            <li><a href="#">Statistique</a></li>
        </ul>
    </aside>

    <section class="center">  
        <h2><a href="#">Aux dernières nouvelles </a></h2>
        <div class="carousel-container">
            <div class="carousel">
                <article>
                    <h3></h3>
                </article>
            </div>
        </div>
    </section>

    <aside class="right aside">
        <h2><a href="#">Top contributeurs</a></h2>
        <div id="top-user">
            <img src=".<?=PUBLIC_DIR ?>/images/avatar.svg" alt="avatar" width="50px" height="50px">
            <a href="#">Pseudo</a>
            <div class="msg-counter">
                <span>350</span>
            </div>
        </div>
        <div id="top-user">
            <img src=".<?=PUBLIC_DIR ?>/images/avatar.svg" alt="avatar" width="50px" height="50px">
            <a href="#">Pseudo</a>
            <div class="msg-counter">
                <span>350</span>
            </div>
        </div>
        <div id="top-user">
            <img src=".<?=PUBLIC_DIR ?>/images/avatar.svg" alt="avatar" width="50px" height="50px">
            <a href="#">Pseudo</a>
            <div class="msg-counter">
                <span>350</span>
            </div>
        </div>
        <div id="top-user">
            <img src=".<?=PUBLIC_DIR ?>/images/avatar.svg" alt="avatar" width="50px" height="50px">
            <a href="#">Pseudo</a>
            <div class="msg-counter">
                <span>350</span>
            </div>
        </div>
    </aside>

    <section id="top-categ-list">  
        <h2><a href="#">Catégories populaires</a></h2>

        <div class="top-categ">
            <h3 class="categ-name"><a href="#">CategName</a></h3>
            <span class="nb-topics">150</span>
        </div>
        <div class="top-categ">
            <h3 class="categ-name"><a href="#">CategName</a></h3>
            <span class="nb-topics">150</span>
        </div>
        <div class="top-categ">
            <h3 class="categ-name"><a href="#">CategName</a></h3>
            <span class="nb-topics">150</span>
        </div>

    </section>
</div>