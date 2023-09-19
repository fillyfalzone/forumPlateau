<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){
            
            $descriptionContent = "Bienvenue sur la page d'accueil du Forum Chelsea FC FanBase"; 
            $pageTitle = "Accueil"; 

            $data = [
                'descriptionContent' => $descriptionContent,
                'pageTitle' => $pageTitle
            ];

            return [
                "view" => VIEW_DIR."home.php",
                "data" => $data
            ];
        }
            
        public function listUsers() {

            $manager = new UserManager; 

            $users = $manager->findAll();



            return [
                "view" => VIEW_DIR."security/listUsers.php",
                "data" => ["users" => $users]
            ];
        }


        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
