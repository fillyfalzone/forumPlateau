<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\MessageManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;


class SecurityController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        return [
            "view" => VIEW_DIR . "404.php",
        ];
    }

    /**
     * The loginForm function returns the view and data needed to render a login form, including
     * success and error messages and the current user.
     * 
     * @return array An array is being returned with two elements: "view" and "data".
     */
    public function loginForm()
    {

        return [
            "view" => VIEW_DIR . "/security/login.php"
        ];
    }


    /**
     * The login function checks if the honeyPot input is empty, sanitizes the username and password
     * inputs, retrieves the user from the database based on the username, checks if the user is
     * banned, verifies the password, and sets the user in the session if successful.
     */
    public function login()
    {
        $honeyPot = filter_input(INPUT_POST, 'honeyPotInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'usernameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'passwordInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //Check if honeyPot is empty, just in case where a bot write something
        if (empty($honeyPot)) {

            //If the sanitize passed
            if ($username && $password) {

                $userManager = new UserManager();

                //Get the user by the username given in the form
                $user = $userManager->getUserByUsername($username);

                //If we get the user, pass, else they go back to the form
                if ($user) {

                    if ($user->getIsBanned() == 0) {

                        //We check if the password given in the form is
                        //Equal to the password stored in the DB
                        if (password_verify($password, $user->getPassword())) {

                            Session::setUser($user);
                            Session::addFlash('success', 'Vous êtes bien connecté !');
                            $this->redirectTo('forum', 'home');
                        } else {

                            Session::addFlash('error', 'Mauvais mot de passe !');
                            $this->redirectTo('forum', 'loginForm');
                        }
                    } else {

                        Session::addFlash('error', 'Vous êtes actuellement banni !');
                        $this->redirectTo('forum', 'loginForm');
                    }
                } else {

                    Session::addFlash('error', 'Mauvais pseudonyme !');
                    $this->redirectTo('forum', 'loginForm');
                }
            } else {

                Session::addFlash('error', 'Veuillez recommencer !');
                $this->redirectTo('forum', 'loginForm');
            }
        } else {

            Session::addFlash('error', 'Un bot ? Sérieusement ?');
            $this->redirectTo('forum', 'loginForm');
        }
    }

    /**
     * The disconnect function in PHP unsets the user session, adds a success flash message, and
     * redirects the user to the home page of the forum.
     */
    public function disconnect()
    {

        unset($_SESSION['user']);
        Session::addFlash('success', 'Vous êtes bien déconnecté !');
        $this->redirectTo('forum', 'home');
    }

    /**
     * The function returns the view and data needed for a registration form, including success and
     * error messages and the current user.
     * 
     * @return array An array is being returned. The array has two elements: "view" and "data". The "view"
     * element contains the path to the register.php view file. The "data" element is an associative
     * array that contains the following keys: "successMessage", "errorMessage", and "user". The values
     * for these keys are retrieved from the Session class using the getFlash method and the getUser
     * method
     */
    public function registerForm()
    {

        return [
            "view" => VIEW_DIR . "/security/register.php",
        ];
    }

    /**
     * This function registers a user by filtering and validating input, hashing the password,
     * creating a new user object, and adding the user to the database.
     * 
     * @return mixed Either the result of the `index()` method of the `HomeController` class if the
     * registration is successful, or the result of the `registerForm()` method if the registration
     * fails or if any of the input values are invalid.
     */
    public function register()
    {
        
        $honeyPot = filter_input(INPUT_POST, 'honeyPotInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'usernameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'emailInput', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'passwordInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordValidator = filter_input(INPUT_POST, 'passwordVerificatorInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($honeyPot)) {

            if ($username && $email && $password && $passwordValidator) {

                if ($_FILES['avatarInput']) {

                    $tmpName = $_FILES['avatarInput']['tmp_name'];
                    $mimetype = mime_content_type($tmpName);

                    if (in_array($mimetype, array('image/jpeg', 'image/png'))) {

                        $userManager = new UserManager();

                        if (!$userManager->getUserByUsername($username)) {

                            if ($password == $passwordValidator && preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/", $password)) {

                                $uniqueName = uniqid('', true);
                                $nameFile = $uniqueName . "." . $_FILES['avatarInput']['name'];
                                move_uploaded_file($tmpName, '././public/uploads/' . $nameFile);

                                
                                /* The above code is generating a password hash using the password_hash function in PHP. The
                                password_hash function takes two parameters - the password to be hashed and the algorithm to be used
                                for hashing. In this case, the PASSWORD_DEFAULT algorithm is used, which is currently bcrypt. The
                                resulting password hash can be stored in a database or used for password verification. */

                                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                                $data = ['username' => $username, 'email' => $email, 'password' => $passwordHash, 'role' => json_encode('ROLE_USER'), 'profilePicture' => $nameFile];

                                $userManager->add($data);

                                Session::addFlash('success', 'Vous êtes désormais inscrit ! Félicitation !');
                                $this->redirectTo('forum', 'home');
                            } else {

                                Session::addFlash('error', 'Vos mots de passe ne se ressemblent pas ou n\'est pas assez long !');
                                $this->redirectTo('security', 'registerForm');
                            }
                        } else {

                            Session::addFlash('error', 'Ce pseudonyme est déjà enregistré !');
                            $this->redirectTo('security', 'registerForm');
                        }
                    } else {

                        Session::addFlash('error', 'Veuillez insérer une image de type : PNG ou JPG !');
                        $this->redirectTo('security', 'registerForm');
                    }
                }
            } else {

                Session::addFlash('error', 'Impossible de vous eenregistrer, veuillez réessayer !');
                $this->redirectTo('security', 'registerForm');
            }
        } else {

            Session::addFlash('error', 'Un bot ? Sérieusement ?');
            $this->redirectTo('security', 'registerForm');
        }
    }

    /**
     * The profile function retrieves user information, topic and message counts, and a list of all
     * users for the profile page.
     * 
     * @return array An array is being returned with two keys: "view" and "data". The value of the "view" key
     * is the path to a PHP file that will be used to render the profile view. The value of the "data"
     * key is an array containing various data that will be passed to the view, including a success
     * message, an error message, the current user, the count of topics
     */
    public function profile()
    {
        $topicManager = new TopicManager();
        $messageManager = new MessageManager();

        $userManager = new UserManager();

        $users = $userManager->findAll();

        $topicCount = $topicManager->countAllByUserId(Session::getUser()->getId());
        $messageCount = $messageManager->countAllByUserId(Session::getUser()->getId());


        return [
            "view" => VIEW_DIR . "/profile/profile.php",
            "data" => [
                "topicCount" => $topicCount,
                "messageCount" => $messageCount,
                "users" => $users
            ]
        ];
    }

    // public function changeProfilePicture($id){
    //     $userManager = new UserManager();
    //     $user = $userManager->findOneById($id);

    //     $oldProfilePicture = $user->getProfilePicture();

    // }

    /**
     * The function "showProfile" retrieves user information, topic count, and message count for a given
     * user ID and returns it along with success and error messages.
     * 
     * @param string $id The parameter "id" is the identifier of the user whose profile is being requested to be
     * shown.
     * 
     * @return array An array is being returned. The array has two keys: "view" and "data". The value of the
     * "view" key is the directory path to the file "showProfile.php". The value of the "data" key is an
     * array containing various data such as success and error messages, user information, topic count,
     * message count, and profile viewer information.
     */
    public function showProfile($id)
    {

        $topicManager = new TopicManager();
        $messageManager = new MessageManager();


        $userManager = new UserManager();

        $profileViewer = $userManager->findOneById($id);

        $topicCount = $topicManager->countAllByUserId($id);
        $messageCount = $messageManager->countAllByUserId($id);

        return [
            "view" => VIEW_DIR . "/profile/showProfile.php",
            "data" => [
                "topicCount" => $topicCount,
                "messageCount" => $messageCount,
                "profileViewer" => $profileViewer
            ]
        ];
    }

    /**
     * The function changes the role of a user from "ROLE_ADMIN" to "ROLE_USER" or vice versa and
     * redirects to the user's profile page.
     * 
     * @param string $id The parameter "id" is the unique identifier of the user whose role needs to be
     * changed.
     */
    public function changeRole($id)
    {

        $userManager = new UserManager();

        $profileViewer = $userManager->findOneById($id);

        $oldRole = $profileViewer->getRole();
        if ($oldRole == '"ROLE_ADMIN"') {
            $newRole = "ROLE_USER";
        } else {
            $newRole = "ROLE_ADMIN";
        }

        $userManager->changeRole($newRole, $id);
        Session::addFlash('success', 'Le role a bien été modifié !');
        $this->redirectTo('security', 'showProfile', $id);
    }

    /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
}