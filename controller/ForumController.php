<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    
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

        //CATEGORIES SECTION -----------------------------------------------------------------------------------


        // function to show list categories 
        public function listCategories(){
            
            $categoryManager = new CategoryManager;

            $categories = $categoryManager->findAll();

            return [
                "view" => VIEW_DIR."forum/categories/listCategories.php",
                "data" => ["categories" => $categories]
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
            $descriptions = filter_var($_POST['descriptions'], FILTER_SANITIZE_SPECIAL_CHARS);
            // put information in data assiotiative array
            $data = [
                'categoryName' => $categoryName,
                'descriptions' => $descriptions,
            ];
            // instencied a new category manager to send data to categoryManager 
            $categoryManager = new CategoryManager;
            $categoryManager->addCategoryInDb($data); 
        }


        // function to return form view addCategory
        public function editCategoryForm($id){
            // instantiate a new category manager
            $categoryManager = new CategoryManager;
            $category = $categoryManager->getCategoryById($id);

            // require VIEW_DIR."forum/categories/editCategory.view.php"; (another way to redirect to the page)
            return [
                "view" => VIEW_DIR."forum/categories/editCategory.view.php",
                "data" => [
                    'category' =>$category
                ]
                ];
       }
        // edit the category
        public function validateUpdateCategory() {

            try {
                // check if keys exist in post before using it 
                if (isset($_POST['categoryName']) && isset($_POST['descriptions'])) {

                    $categoryName = filter_var($_POST['categoryName'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $descriptions = filter_var($_POST['descriptions'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            
                    // put information in associative array
                    $data = [
                        'categoryName' => $categoryName,
                        'descriptions' => $descriptions,
                        'id' => $id
                    ];
            
                    // instencied a new category manager to send data to categoryManager 
                    $categoryManager = new CategoryManager;
                    $categoryManager->updateCategoryInDb($data);
                } else {
                    throw new \Exception("La catégorie n'existe pas");
                }
            } catch (\Exception $e) {
                echo "Exception catch : " . $e->getMessage();
            }
        } 
        //delete category by id 
        public function deleteCategoryById(){
            // check if id is send by url
            if(isset($_GET['id'])){
                // filter id to prevent script injection
                $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
                //instance a new category manager and send the task; 
                $categoryManager = new CategoryManager;
                $categoryManager->deleteCategoryById($id);

            }
        }

        

        // TOPIC SECTION -------------------------------------------------------------------------------- 

         // show topics by category id from TopicManager
         public function showTopicsByCategoryId($id){
            //instance a new Topic manager and send the task; 
            $categoryManager = new TopicManager;
            $topics = $categoryManager->getTopicsByCategoryId($id);
            // redirect to topic view page with data 
            return [
                "view" => VIEW_DIR."forum/topics/topics.view.php",
                "data" => ["topics" => $topics]
            ];
        }

        // redirect to add topic form
        public function addTopicForm($id){
            // instance a new User and require all informations in bd
            $userManager = new UserManager;
            $users = $userManager->findAll(); 
            // instance a new category and get it by id
            $categoryManager = new CategoryManager;
            $category = $categoryManager->getCategoryById($id);

            // echo "<pre>";
            // print_r($category);
            // echo "</pre>";

            //return view form with category and user data
            return [
                "view" => VIEW_DIR."forum/topics/addTopic.view.php",
                "data" => [
                    "category" => $category,
                    "users" => $users
                ]
            ]; 
        }


        // detele topic by id 
        public function deteleTopicById(){
              // check if id is send by url
              if(isset($_GET['id'])){
                // filter id to prevent script injection
                $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
                //instance a new category manager and send the task; 
                $categoryManager = new TopicManager;
                $categoryManager->deleteTopicById($id);
            }

        }

        // POSTS SECTION ---------------------------------------------------------------------------------

        
        // show poste by topic ID
        public function showPostsByTopicId($id = null) {
            // creat a new instance of Post manager
            $postManager = new PostManager;
            $posts = $postManager->getPostsByTopicId($id);
            // redirect to posts view page with data 
            return [
                "view" => VIEW_DIR."forum/posts/posts.view.php",
                "data" => ["posts" => $posts]
            ];
        }



    }
