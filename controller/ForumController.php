<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        // redirection function to list topics if a page is unknown.  
        public function index(){
        
           $topicManager = new TopicManager();
            
            return [
                "view" => VIEW_DIR."forum/topics/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        
        }
        // function to show list categories 
        public function listCategories(){
            
            $categoryManager = new CategoryManager;

            $categories = $categoryManager->findAll();

            return [
                "view" => VIEW_DIR."forum/categories/listCategories.php",
                "data" => ["categories" => $categories]
            ];
        }

        // show topics by category id from TopicManager
        public function showTopicsByCategoryId($id){

            $categoryManager = new TopicManager;
            $topics = $categoryManager->getTopicsByCategoryId($id);

            return [
                "view" => VIEW_DIR."forum/topics/topics.view.php",
                "data" => ["topics" => $topics]
            ];
        }
        // show poste by topic ID
        public function showPostsByTopicId($id = null) {

            $postManager = new PostManager;
            $posts = $postManager->getPostsByTopicId($id);

            return [
                "view" => VIEW_DIR."forum/posts/posts.view.php",
                "data" => ["posts" => $posts]
            ];
        }

        // function to return form view addCategory
       public function addCategoryForm(){
        return [
            "view" => VIEW_DIR."forum/categories/addCategory.view.php",
        ]; 
       }
        // add a new category
        public function addCategory(){
            // get and filter informations send by fomr 
            $categoryName = filter_var($_POST['categoryName'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            // put information in data assiotiative array
            $data = [
                'categoryName' => $categoryName,
                'description' => $description,
            ];
            // instencied a new category manager to send data to categoryManager 
            $categoryManager = new CategoryManager;
            $categoryManager->addCategoryInDb($data); 
        }

          // function to return form view addCategory
       public function editCategoryForm(){
        return [
            "view" => VIEW_DIR."forum/categories/editCategory.view.php",
        ]; 
       }
        // edit the category
        public function editCategoryById($id) {

            try {
                // check if keys exist in post before using it 
                if (isset($_POST['categoryName']) && isset($_POST['description'])) {
                    $categoryName = filter_var($_POST['categoryName'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            
                    // put information in associative array
                    $data = [
                        'categoryName' => $categoryName,
                        'description' => $description,
                    ];
            
                    // instencied a new category manager to send data to categoryManager 
                    $categoryManager = new CategoryManager;
                    $categoryManager->editCategoryInDb($data, $id);
                } else {
                    throw new \Exception("La catégorie n'existe pas");
                }
            } catch (\Exception $e) {
                echo "Exception catch : " . $e->getMessage();
            }
        }  
    }
