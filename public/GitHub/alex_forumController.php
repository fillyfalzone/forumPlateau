<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\AimerManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{

    /**
     * The index function returns a view and data for a 404 error page in a forum, including the user
     * information from the session.
     * 
     * @return array An array is being returned. The array has two elements: "view" and "data". The value of
     * "view" is the directory path to the file "404.php" in the "forum" directory of the view
     * directory. The value of "data" is an array with one element: "user", which is assigned the value
     * of the  variable.
     */
    public function index()
    {

        return [
            "view" => VIEW_DIR . "404.php"
        ];
    }

    /**
     * The function "home" returns an array with the view path and data needed for rendering the home page,
     * including categories, topics, messages, success and error messages, and the current user.
     * 
     * @return array An array is being returned. The array has two keys: "view" and "data". The value of the
     * "view" key is the path to a PHP file. The value of the "data" key is an array containing various
     * data, including the categories, topics, messages, success message, error message, and user.
     */
    public function home()
    {

        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $messageManager = new MessageManager();

        return [
            "view" => VIEW_DIR . "home.php",
            "data" => [
                "categories" => $categoryManager->findAll(),
                "topics" => $topicManager,
                "messages" => $messageManager
            ]
        ];
    }

    /**
     * The function "listTopics" retrieves a list of topics belonging to a specific category in a
     * forum and returns the data needed to display them in a view.
     * 
     * @param string $categoryId The categoryId parameter is the ID of the category for which you want to
     * list the topics.
     * 
     * @return array an array is being returned with two keys: "view" and "data". The value of "view" is
     * the path to a PHP file that will be used to display the topics. The value of "data" is an
     * array containing the topics, the category name, the user manager, and the message manager.
     */
    public function listTopics($categoryId)
    {

        $aimerManager = new AimerManager();
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        $messageManager = new MessageManager();

        $category = $categoryManager->findOneById($categoryId);
        $topics = $topicManager->getTopicByCategoryId($categoryId);

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "aimerManager" => $aimerManager,
                "topics" => $topics,
                "category" => $category,
                "userManager" => $userManager,
                "message" => $messageManager
            ]
        ];
    }

    /**
     * The function `likeTopic` adds a like to a topic and redirects the user to the forum home page.
     * 
     * @param string $id The id parameter represents the unique identifier of the topic that the user wants to
     * like.
     */
    public function likeTopic($id)
    {

        $topicManager = new TopicManager();

        $topic = $topicManager->findOneById($id);
        $catid = $_GET['catid'];

        $topicManager->addLike($topic, Session::getUser());

        $this->redirectTo('forum', 'listTopics', $catid);
    }

    /**
     * The function unlikeTopic removes a like from a topic and redirects the user to the forum home page.
     * 
     * @param string $id The id parameter represents the unique identifier of the topic that the user wants to
     * unlike.
     */
    public function unlikeTopic($id)
    {

        $topicManager = new TopicManager();

        $topic = $topicManager->findOneById($id);
        $catid = $_GET['catid'];

        $topicManager->removeLike($topic, Session::getUser());

        $this->redirectTo('forum', 'listTopics', $catid);
    }

    /**
     * The function "showTopic" retrieves a topic and its associated messages from the database and
     * returns them along with the necessary view and data for rendering the topic page.
     * 
     * @param string $topicId The topicId parameter is the unique identifier of the topic that you want to
     * display. It is used to retrieve the topic and its associated messages from the database.
     * 
     * @return array an array is being returned. The array has two elements: "view" and "data". The value
     * of "view" is the path to a PHP file that will be used to render the view. The value of
     * "data" is an array containing the topic, userManager, and messages.
     */
    public function showTopic($topicId)
    {

        $topicManager = new TopicManager();
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        $messages = $messageManager->getTopicByIdAscendant($topicId);
        $topic = $topicManager->findOneById($topicId);


        return [
            "view" => VIEW_DIR . "forum/topic.php",
            "data" => [
                "topic" => $topic,
                "userManager" => $userManager,
                "messages" => $messages
            ]
        ];
    }

    /**
     * The lockTopic function locks a topic, adds a success flash message, and redirects to the forum's
     * showTopic page.
     * 
     * @param string $id The parameter "id" is the identifier of the topic that needs to be locked.
     */
    public function lockTopic($id)
    {

        $topicManager = new TopicManager();
        $topicManager->lockTopic($id);
        Session::addFlash('success', 'Ce topic a bien été lock');
        $this->redirectTo('forum', 'showTopic', $id);
    }

    /**
     * The function unlocks a topic, adds a success flash message, and redirects to the forum page
     * showing the unlocked topic.
     * 
     * @param string $id The parameter "id" is the identifier of the topic that needs to be unlocked.
     */
    public function unlockTopic($id)
    {

        $topicManager = new TopicManager();
        $topicManager->unlockTopic($id);
        Session::addFlash('success', 'Ce topic a bien été unlock');
        $this->redirectTo('forum', 'showTopic', $id);
    }

    /**
     * The function returns a view and data for adding a category in a forum, including success and
     * error messages and the current user.
     * 
     * @return array An array is being returned. The array contains two elements: "view" and "data". The
     * "view" element contains the path to the view file "forum/addCategory.php". The "data" element
     * contains an associative array with three key-value pairs: "successMessage" and "errorMessage"
     * which are retrieved from the session flash messages, and "user" which is the current user object
     * retrieved
     */
    public function addCategoryForm()
    {

        return [
            "view" => VIEW_DIR . "forum/addCategory.php"
        ];
    }

    /**
     * The function adds a category to the database and redirects to the home page if successful,
     * otherwise it displays the add category form again.
     * 
     * @return mixed The result of calling the `index()` method on a `HomeController` object if the
     * `` is a string. Otherwise, it is returning the result of calling the
     * `addCategoryForm()` method on the current object.
     */
    public function addCategory()
    {

        $categoryName = filter_input(INPUT_POST, 'categoryNameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($categoryName) {

            $categoryManager = new CategoryManager();
            $data = ["categoryName" => $categoryName];
            $categoryManager->add($data);

            Session::addFlash('success', 'La catégorie a bien été ajouté !');
            $this->redirectTo('forum', 'home');
        } else {

            return $this->addCategoryForm();
        }
    }

    /**
     * The function returns a view and data for adding a topic in a forum, including a list of
     * categories.
     * 
     * @return array An array is being returned with two elements: "view" and "data".
     */
    public function addTopicForm()
    {

        $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR . "forum/addTopic.php",
            "data" => [
                "categories" => $categoryManager->findAll()
            ]
        ];
    }

    /**
     * The function adds a new topic to a forum with the provided topic name, message text, and
     * category ID.
     * 
     * @return void If the variables $topicName, $messageText and $categoryId are all set and valid,
     * the function will add a new topic and message to the database and then redirect the user to
     * the forum home page. If any of the variables are not set or not valid, the function will
     * return the addTopicForm.
     */
    public function addTopic()
    {

        $topicName = filter_input(INPUT_POST, 'categoryNameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $messageText = filter_input(INPUT_POST, 'messageInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoryId = filter_input(INPUT_POST, 'categoryInput', FILTER_VALIDATE_INT);

        if ($topicName && $messageText && $categoryId) {

            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            $topicData = ['title' => $topicName, 'user_id' => 2, 'category_id' => $categoryId];
            $topicId = $topicManager->add($topicData);

            $messageData = ['messageText' => $messageText, 'user_id' => 2, 'topic_id' => $topicId];
            $messageManager->add($messageData);

            Session::addFlash('success', 'Le topic a bien été ajouté ! Félicitation !');
            $this->redirectTo('forum', 'home');
        } else {

            return $this->addTopicForm();
        }
    }

    /**
     * The function `addMessage()` adds a message to a topic in a forum if the topic ID and message
     * content are valid, otherwise it shows the topic page.
     * 
     * @return void the `$topicId` and `$messageContent` are both valid, the function will call the
     * `add()` method of the `$messageMananger` object and pass in the `$messageData` array.
     */
    public function addMessage()
    {

        $id = Session::getUser()->getId();

        $topicId = filter_input(INPUT_POST, 'topicId', FILTER_VALIDATE_INT);
        $messageContent = filter_input(INPUT_POST, 'messageContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($topicId && $messageContent) {

            $messageManager = new MessageManager();

            $messageData = ['messageText' => $messageContent, 'user_id' => $id, 'topic_id' => $topicId];
            $messageManager->add($messageData);
            $this->redirectTo('forum', 'home');
        } else {

            return $this->showTopic($topicId);
        }
    }

    /**
     * The function modifies a form based on the type of data being modified (category, topic, or
     * message) and returns the corresponding view and data.
     * 
     * @param string $id The `id` parameter is the identifier of the item that needs to be modified. It is used
     * to retrieve the specific item from the database.
     * 
     * @return array An array with two keys: "view" and "data". The value of "view" is the path to a view
     * file, and the value of "data" is an array containing the specific data related to the form being
     * modified. The specific data being returned depends on the value of the "type" parameter.
     */
    public function modifyForm($id)
    {

        $type = $_GET['type'];
        switch ($type) {
            case 'category':

                $categoryManager = new CategoryManager();
                return [
                    "view" => VIEW_DIR . "forum/modify.php",
                    "data" => [
                        "category" => $categoryManager->findOneById($id),
                        "formtype" => "category"
                    ]
                ];
                break;
            case 'topic':

                $topicManager = new TopicManager();
                return [
                    "view" => VIEW_DIR . "forum/modify.php",
                    "data" => [
                        "topics" => $topicManager->findOneById($id),
                        "formtype" => "topic"
                    ]
                ];
                break;
            case 'message':

                $messageManager = new MessageManager();
                return [
                    "view" => VIEW_DIR . "forum/modify.php",
                    "data" => [
                        "message" => $messageManager->findOneById($id),
                        "formtype" => "message"
                    ]
                ];
                break;
        }
    }

    /**
     * The function modifies a category, topic, or message based on the type parameter passed in the
     * URL.
     * 
     * @param string $id The parameter "id" is used to identify the specific item that needs to be modified. It
     * is passed to the function as an argument and is used to update the corresponding record in the
     * database.
     * 
     * @return void The result of the `modifyForm()` method if the corresponding input value
     * (``, ``, or ``) is empty.
     */
    public function modify($id)
    {

        $type = $_GET['type'];
        switch ($type) {
            case 'category':

                $categoryName = filter_input(INPUT_POST, 'categoryNameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($categoryName) {

                    $categoryManager = new CategoryManager();
                    $data = ["id_category" => $id, "categoryName" => $categoryName];
                    $categoryManager->updateCategory($data);

                    Session::addFlash('success', 'La catégorie a bien été modifié ! Félicitation !');
                    $this->redirectTo('forum', 'home');
                } else {

                    return $this->modifyForm($id);
                }
                break;

            case 'topic':

                $topicName = filter_input(INPUT_POST, 'topicNameInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($topicName) {

                    $topicManager = new TopicManager();
                    $data = ["id_topic" => $id, "title" => $topicName];
                    $topicManager->updateTopic($data);

                    Session::addFlash('success', 'Le topic a bien été modifié ! Félicitation !');
                    $this->redirectTo('forum', 'home');
                } else {

                    return $this->modifyForm($id);
                }
                break;

            case 'message':

                $messageContent = filter_input(INPUT_POST, 'messageTextInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($messageContent) {

                    $messageManager = new MessageManager();
                    $data = ["id_message" => $id, "messageText" => $messageContent];
                    $messageManager->updateMessage($data);

                    Session::addFlash('success', 'Le message a bien été modifié ! Félicitation !');
                    $this->redirectTo('forum', 'home');
                } else {

                    return $this->modifyForm($id);
                }
                break;
        }
    }

    /**
     * The function `deleteForm` returns a view and data based on the type of form being deleted.
     * 
     * @param string $id The "id" parameter is used to specify the ID of the item that needs to be deleted. It
     * is an optional parameter, meaning it can be null if not provided.
     * 
     * @return array An array with two keys: "view" and "data". The value of "view" is the path to a view
     * file, and the value of "data" is an array containing additional data for the view. The specific
     * values of "view" and "data" depend on the value of the "type" variable.
     */
    public function deleteForm($id = null)
    {
        $type = $_GET['type'];
        switch ($type) {
            case 'category':

                $categoryManager = new CategoryManager();
                return [
                    "view" => VIEW_DIR . "forum/delete.php",
                    "data" => [
                        "category" => $categoryManager->findAll(),
                        "formtype" => "category"
                    ]
                ];
                break;
            case 'topic':

                $topicManager = new TopicManager();
                return [
                    "view" => VIEW_DIR . "forum/delete.php",
                    "data" => [
                        "topics" => $topicManager->findAll(),
                        "formtype" => "topic"
                    ]
                ];
                break;
            case 'message':

                $messageManager = new MessageManager();
                return [
                    "view" => VIEW_DIR . "forum/delete.php",
                    "data" => [
                        "message" => $messageManager->findOneById($id),
                        "formtype" => "message"
                    ]
                ];
                break;
        }
    }

    /**
     * The delete function handles the deletion of categories, topics, and messages based on the type
     * specified in the GET request.
     * 
     * @return void The result of the `deleteForm()` method if the condition in each case statement is not
     * met.
     */
    public function delete()
    {

        $type = $_GET['type'];
        switch ($type) {
            case 'category':

                $categoryId = filter_input(INPUT_POST, 'categoryInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($categoryId) {

                    $categoryManager = new CategoryManager();
                    $categoryManager->delete($categoryId);

                    Session::addFlash('success', 'La catégorie a bien été supprimé ! Félicitation !');
                    $this->redirectTo('forum', 'home');
                } else {

                    return $this->deleteForm();
                }
                break;

            case 'topic':

                $topicId = filter_input(INPUT_POST, 'topicInput', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($topicId) {

                    $topicManager = new TopicManager();
                    $messageManager = new MessageManager();
                    $result = $messageManager->findAll();
                    foreach ($result as $value) {
                        if ($value->getTopic()->getId() == $topicId) {
                            $message = $value;
                        }
                    }
                    $messageManager->delete($message->getId());
                    $topicManager->delete($topicId);

                    Session::addFlash('success', 'Le topic a bien été modifié ! Félicitation !');
                    $this->redirectTo('forum', 'home');
                } else {

                    return $this->deleteForm();
                }
                break;
        }
    }

    /**
     * The deleteMessage function deletes a message with the given ID and redirects the user to the
     * forum home page.
     * 
     * @param string $id The id parameter represents the unique identifier of the message that needs to be
     * deleted.
     */
    public function deleteMessage($id)
    {

        $messageManager = new MessageManager();
        $messageManager->delete($id);

        Session::addFlash('success', 'Le message a bien été modifié ! Félicitation !');
        $this->redirectTo('forum', 'home');
    }
}