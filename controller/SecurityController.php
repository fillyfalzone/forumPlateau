<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;


class SecurityController extends AbstractController implements ControllerInterface{
    


        public function index(){

            $user = Session::getUser();

            return [
                "view" => VIEW_DIR . "404.php",
            ];  
        }

          /**

         *  La méthode Session::getUser() est utilisée pour obtenir les informations de l'utilisateur connecté.

         * La variable $user contiendra les données de l'utilisateur si un utilisateur est connecté, sinon elle sera null.

         * Les méthodes Session::getFlash('success') et Session::getFlash('error') sont utilisées pour récupérer ces messages depuis la session.

         * La fonction retourne un tableau associatif contenant deux éléments :

                * "view" : Il s'agit du chemin vers le fichier de vue qui sera affiché pour le formulaire d'inscription. Ce chemin est généralement utilisé pour inclure la vue dans la page web.

                * "data" : Il s'agit d'un tableau associatif qui contient des données à transmettre à la vue. Dans ce cas, il contient les données de l'utilisateur, le message de succès et le message d'erreur.

        * Cette fonction prépare les données nécessaires à l'affichage du formulaire d'inscription en récupérant l'utilisateur connecté, les messages flash de succès et d'erreur, puis les renvoie sous forme de tableau pour être utilisés lors de l'affichage de la vue.

         **/

        public function registerForm(){

            return [
                "view" => VIEW_DIR."/security/registerForm.php",
                "data" => [
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error')]
            ];
        }


        public function register(){
            // filtrer ce qui arrive en POST
         
            $conditions = filter_input(INPUT_POST, "conditions", FILTER_SANITIZE_NUMBER_INT);

            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);

            $passWord = filter_input(INPUT_POST, "passWord", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $confirmPassWord = filter_input(INPUT_POST, "confirmPassWord", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        
            // password_hash = creates a new password hash using a strong one-way hashing algorithm.

            /**

             * PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. For that reason, the length of the result from using this identifier can change over time. Therefore, it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).

             */
           
            if( $pseudo && $email && $passWord && $confirmPassWord && $conditions) {

                // instancie un UserManager
                $userManager = new UserManager();

                 // on doit d'abord rechercher si le Mail et le pseudo  existe en BDD
                $userPseudoBdd = $userManager->findOneByPseudo($pseudo);
                $userEmailBdd = $userManager->findOneByEmail($email);

               
                if(!$userPseudoBdd && !$userEmailBdd) {

                    // si c'est false on poursuit

                    // on verifie si l'utilisateur à charger une image à l'inscription

                    $fileInput = $_FILES['avatar'];  
                    
                    if ($fileInput === true){

                        //on definie le dossier de direction des fichiers images
                        $targetDirectory = "././public/uploads/";

                        /* 
                            * Grace à la fonction de traitement de fichier définie plus bas, 
                                - verifie, l'extension,
                                - crée un nom unique,
                                - vérifie le poids de l'image,
                                - et l'enreigistre dans le repertoire defini.
                        */
                        $avatar = $this->uploadImage($_FILES['avatar'], $targetDirectory);    
                    } else {
                        // si le user de charge pas une image, on met l'image par defaut 
                        $avatar = "avatar.png";
                    }

                    // si le password correspond au confirmPassword et que la longueur de la chaîne de caractère du password est supérieur ou égale à 12
                    if(($passWord == $confirmPassWord) && (strlen($passWord) >= 6 )) {
                    
                        // On va hasher le password et enregistrer le user en BDD

                        // un password est hashé en BDD. Le hashage est un mécanisme unidirectionnel et irréversible. ON NE DEHASHE JAMAIS UN PASSWORD!!!

                        // la fonction password_hash va nous demander l'algorithme de hash choisi. Les algos a priviligié sont BCRYPT et ARGON2i.

                        // Ne pas utiliser sha ou md5

                        // BCRYPT et ARGON2i font parti des algos de hash fort

                        // sha ou md5 font parti des algos de hash faible

                        $passWordHash = password_hash($passWord, PASSWORD_DEFAULT);

                        // password_default utilise par défault l'algo BCRYPT

                        // BCRYPT est un algo fort comme ARGON2i

                        // il va créé une empreinte numérique en BDD composé de l'algo utilisé, d'un cost, d'un salt et du password hashé

                        // le salt est une chaîne de caractère aléatoire hashée qui sera concaténé à notre password hashé.

                        // si un pirate récupère notre password hashé il aura plus de difficulté à découvrir notre MDP d'origine

                        // $password_hash2 = md5($password);

                       // Ici on regroupe tout les données d'inputs reçues
                        $data = [
                            'pseudo' => $pseudo,
                            'email' => $email,
                            'passWord' => $passWordHash,
                            'avatar' => $avatar,
                            'role' => json_encode(["ROLE_USER"]) // Utilisez json_encode pour convertir un tableau PHP en chaîne JSON valide
                        ];

                        // On ajoute un nouveau utilisateur dans la bdd

                        $userManager->add($data);
                        
                        // On redirige l'e User vers la page d'inscription.
                        $this->redirectTo("security", "loginForm");

                    } else {
                        
                        // On redirige l'e User vers la page d'inscription.
                        $this->redirectTo("security", "registerForm");

                        // Si les mots de pass ne sont pas identiques on renvoi un flash
                        Session::addFlash('error', 'Les mots de passe ne sont pas identiques ou pas assez long');

                    }

                } elseif ($userManager->findOneByEmail($email)) {

                    Session::addFlash('error', 'Email déjà utilisé !');

                } elseif ($userManager->findOneByPseudo($pseudo)) {

                    Session::addFlash('error', 'Pseudo déjà utilisé !');
                }

            }

            $this->redirectTo("security", "registerForm");

        }  

         // LOGIN FORM

        public function loginForm() {

            return [
                "view" => VIEW_DIR. "security/loginForm.php",
                "data" => [
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error')
                ]
             ];
 
        }
 
 
        //LOGIN
 
        public function login() {

            // On filtre les données envoyées dans le formulaire
 
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
            $passWord = filter_input(INPUT_POST, "passWord", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
            // on va d'abord vérifié si le filtrage s'est bien passé

            if($pseudo && $passWord) {

                // on va instancier le UserManager pour vérifier que j'ai bien un user à ce nom là

                $userManager = new UserManager();

                $userInBdd= $userManager->findOneByPseudo($pseudo);

                if($userInBdd) {

                    $passWordInBdd = $userInBdd->getPassWord();

                    // si un user existe avec ce pseudo on continue

                    // on va vérfier que le password donné dans le formulaire de login correspond au password de l'utilisateur qui pseudo

                    if(password_verify($passWord, $passWordInBdd)) {

                        // PASSWORD_VERIRFY VA COMPARER DEUX CHAINES DE CARACTERES HASHE!

                        if($userInBdd->getIsBanned() == 0) {

                            // si ça fonctionne on met le user en session

                            Session::setUser($userInBdd);

                           return [ "view" => VIEW_DIR."home.php"];

                        } else {

                            return [ "view" => VIEW_DIR."home.php"];

                            Session::addFlash('error','Vous êtes banni du forum !!!');

                        }
                    }
                }
            }
        }


         //  LOG OUT
 
        public function logout() {

            // session_start();

            session_destroy();

            return [ "view" => VIEW_DIR."home.php"];
 
        }


       
        public function uploadImage($fileInputName, $targetDirectory) {
            
            // Vérifier si le fichier est une image
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileMimeType = mime_content_type($fileInputName['tmp_name']);
            if (!in_array($fileMimeType, $allowedMimeTypes)) {

                Session::addFlash('success', 'Le fichier n\'est pas une image ou  n\'est pas géré'); 
                return false; 
            }
        
            // Vérifier la taille de l'image (5 Mo)
            $maxFileSize = 5 * 1024 * 1024; // 5 Mo en octets
            if ($fileInputName['size'] > $maxFileSize) {

                Session::addFlash('success', 'Le poids du fichier doit est inferieur à 5 Mo'); 

                return false; // Le fichier est trop volumineux
            }
        
            // Générer un nom de fichier unique basé sur l'horodatage et une partie aléatoire
            $randomFileName = md5(uniqid(rand(), true)) . '.' . pathinfo($fileInputName['name'], PATHINFO_EXTENSION);
        
            // Chemin complet du fichier de destination
            $targetFilePath = $targetDirectory . $randomFileName;
        
            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($fileInputName['tmp_name'], $targetFilePath)) {
                return $randomFileName; // Succès, retourner le nom du fichier pour enregistrement en BDD
            } else {
                Session::addFlash('success', 'Échec du déplacement du fichier '); 
                return false; // Échec du déplacement du fichier
            }
        }
        

   
    
        
        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }

?>