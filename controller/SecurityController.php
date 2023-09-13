<?php

    namespace Controller;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Exception;
    use Model\Entities\User;
    use Model\Managers\UserManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Service\FunctionPerso;
    
    class SecurityControleur extends AbstractController implements ControllerInterface{

        public function index(){

            $user = Session::getUser()();

            return [
                "view" => VIEW_DIR. "home.php",
                "data" => ["user" => $user]
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
                "view" => VIEW_DIR."security/register.php",
                "success" => Session::getFlash('success'),
                "error" => Session::getFlash('error')
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

 
            if($conditions && $pseudo && $email && $passWord && $confirmPassWord) {

                $userManager = new UserManager();

                // on doit d'abord rechercher si le userEmail existe en BDD

                if(!$userManager->findOneByEmail($email) && !$userManager->findOneByPseudo($pseudo)) {
                    // si c'est false on poursuit

                    // si le password correspond au confirmPassword et que la longueur de la chaîne de caractère du password est supérieur ou égale à 12
                    if(($passWord == $confirmPassWord) && (strlen($passWord) >= 12 )) {

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

                       
                        $userManager->add(['pseudo' => $pseudo, 'email' => $email, 'passWord' => $passWordHash, "role" => json_encode(['ROLE_USER'])]);

                    } else {

                        Session::addFlash('error', 'Les mots de passe ne sont pas identiques ou pas assez long');

                    }

                } elseif ($userManager->findOneByEmail($email)) {

                    Session::addFlash('error', 'Email déjà utilisé !');

                } elseif ($userManager->findOneByPseudo($pseudo)) {

                    Session::addFlash('error', 'Pseudo déjà utilisé !');
                }

            }

            $this->redirectTo("forum", "index");

        }





         
        
        public function login() {

            // je filtre les données envoyer dans le formulaire
            

            //on va verifier sil le filtrage s'est bien passé
            // if(donnée du form){}


        }





        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
