<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Service\FunctionPerso;

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

             
 
            if( $pseudo && $email && $passWord && $confirmPassWord) {

             
                $userManager = new UserManager();
                $userPseudoBdd = $userManager->findOneByPseudo($pseudo);
                $userEmailBdd = $userManager->findOneByEmail($email);

                // on doit d'abord rechercher si le userEmail existe en BDD

                if(!$userPseudoBdd && !$userEmailBdd) {

              
                    // si c'est false on poursuit

                    // if($_FILES['avatar'] !== null){

                    //     // Utilisation de la fonction  uploadImage:
                    //     $directory = 'public/imgs/';
                    //     $fileInput = $_FILES['avatar'];
                    

                    //     $fileName = $this->uploadImage($fileInput, $directory);

                    //     if ($fileName !== false) {

                    //         return $fileName; 
                    //     } else {
                    //         // Le téléchargement de l'image a échoué, affichez un message d'erreur ou prenez d'autres mesures nécessaires.
                    //         return "Le téléchargement de l'image a échoué. Veuillez réessayer."; 
                    //     }
                    
                    // } else {
                    //     $fileName = "avatar"; 
                    // }

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
                      
                        echo "<pre>";
                        var_dump($pseudo);
                        var_dump($email);
                        var_dump($passWordHash);
                        // var_dump($nameFile);
                        echo "</pre>";
                       
            
                       
                        $userManager->add(['pseudo' => $pseudo, 'email' => $email, 'passWord' => $passWordHash, 'role' => json_decode("ROLE_USER") ]);

                        // die('hello2');
                        
                        $this->redirectTo("security", "loginForm");

                    } else {

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

            session_start();

            session_destroy();

            return [ "view" => VIEW_DIR."home.php"];
 
        }


       
        public function uploadImage($fileInputName, $targetDirectory) {
            // Vérifier si un fichier a été téléchargé
            if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
                return false; // Aucun fichier téléchargé
            }

            // Vérifier si le fichier est une image
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                return false; // Le fichier n'est pas une image
            }

            // Vérifier la taille de l'image (par exemple, 5 Mo)
            $maxFileSize = 5 * 1024 * 1024; // 5 Mo en octets
            if ($_FILES[$fileInputName]['size'] > $maxFileSize) {
                return false; // Le fichier est trop volumineux
            }

            // Générer un nom de fichier unique
            $randomFileName = uniqid() . '.' . $fileExtension;

            // Chemin complet du fichier de destination
            $targetFilePath = $targetDirectory . $randomFileName;

            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFilePath)) {
                return $randomFileName; // Succès, retourner le nom du fichier pour enregistrement en BDD
            } else {
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