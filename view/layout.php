

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="Chelsea fc, sport, premiere league, football ">
    <meta name="description" content="<?= $descriptionContent ?>">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>./css/forum.css">
    <title><?= $pageTitle ?></title>
</head>
<body>
    <header>
        <nav id="nav-bar">
            <div id="nav-left">
                <a href="index.php" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 3px; text-align: center; display: inline-block;">Accueil</a>

                <?php
                if(App\Session::isAdmin()){
                    ?>
                    <a href="index.php?ctrl=home&action=users" rel="nofollow" >Voir la liste des gens</a>
                    
                    <?php
                }
                ?>
            </div>
            <div id="nav-right">
            <?php
                
                if(App\Session::getUser()){
                    ?>
                    <a href="/security/viewProfile.html"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a>
                    <a href="index.php?ctrl=security&action=logout">Déconnexion</a>
                    <?php
                }
                else{
                    ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="index.php?ctrl=security&action=loginForm" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 3px; text-align: center; display: inline-block;">Connexion</a>

                        <a href="index.php?ctrl=security&action=registerForm" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #4CAF50; color: white; border-radius: 3px; text-align: center; display: inline-block;">Inscription</a>

                        <a href="index.php?ctrl=security&action=logout" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #f44336; color: white; border-radius: 3px; text-align: center; display: inline-block;">Deconnexion</a>

                        <a href="index.php?ctrl=forum&action=listTopics" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #0f4336; color: white; border-radius: 3px; text-align: center; display: inline-block;">La liste des topics</a>

                        <a href="index.php?ctrl=home&action=listUsers" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #ff9800; color: white; border-radius: 3px; text-align: center; display: inline-block;">La liste des utilisateurs</a>

                        <a href="index.php?ctrl=forum&action=listCategories" style="text-decoration: none; margin: 10px; padding: 10px 20px; background-color: #9c27b0; color: white; border-radius: 3px; text-align: center; display: inline-block;">La liste des catégories</a>
                    </div>

                <?php
                }
            
                
            ?>
            </div>
        </nav>
    </header>

    <div id="wrapper"> 
       
        <div id="mainpage">
            <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
            <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
            <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>

            <main id="forum">
                <?= $page ?>
            </main>
        </div>
    </div>

        <footer>
            <p>&copy; 2020 - Forum CDA - <a href="/home/forumRules.html">Règlement du forum</a> - <a href="">Mentions légales</a> - <a href="">sitemap</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
        </footer>
   

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    <script>

        $(document).ready(function(){
            $(".message").each(function(){
                if($(this).text().length > 0){
                    $(this).slideDown(500, function(){
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function(){
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })

        

        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
</body>
</html>