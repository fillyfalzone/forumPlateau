<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Exception;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        // redirection function to list topics if a page is unknown.  
        public function index(){
        
           $topicManager = new TopicManager();

           $descriptionContent = "Bienvenue sur la page d'accueil du Forum Chelsea FC FanBase"; 
           $pageTitle = "Accueil"; 

           $data = [
               'descriptionContent' => $descriptionContent,
               'pageTitle' => $pageTitle,
               "topics" => $topicManager->findAll(["creationdate", "DESC"])
           ];

            
            return [
                "view" => VIEW_DIR."forum/topics/listTopics.php",
                "data" => $data
            ];
        
        }

        //CATEGORIES SECTION -----------------------------------------------------------------------------------


        // function to show list categories 
        public function listCategories(){
             /*Les deux variables pour permettent de mettre à jour le titre de la page et la description*/
             $descriptionContent = "Vous avez ici la liste des categories du forum"; 
             $pageTitle = "Liste des catégories"; 
            
             //
            $categoryManager = new CategoryManager;

            $categories = $categoryManager->findAll();
           
 
            $data = [
                'descriptionContent' => $descriptionContent,
                'pageTitle' => $pageTitle,
                'categories' => $categories
            ];

            return [
                "view" => VIEW_DIR."forum/categories/listCategories.php",
                "data" => $data
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
            $categoryManager = new CategoryManager;
            $category = $categoryManager->getCategoryById($id);
            //instance a new Topic manager and send the task; 
            $topicManager = new TopicManager;
            $topics = $topicManager->getTopicsByCategoryId($id);
            // redirect to topic view page with data 
            return [
                "view" => VIEW_DIR."forum/topics/topics.view.php",
                "data" => [
                    "topics" => $topics,
                    "category" => $category
                ]
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

           

            //return view form with category and user data
            return [
                "view" => VIEW_DIR."forum/topics/addTopic.view.php",
                "data" => [
                    "category" => $category,
                    "users" => $users
                ]
            ]; 
        }

        public function createTopic(){
            // On utilise un fichier 
            try {
                // check if post info form are define
                if (isset($_POST['title']) && isset($_POST['message']) && isset($_POST['user_id']) && isset($_POST['category_id'])){
                    //clean inputs information
                    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $message = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $user_id = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
                    $category_id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);

                    //put these infomations in $data array
                    $dataTopic = [
                        "title" => $title,
                        "user_id" => $user_id,
                        "category_id" => $category_id
                    ];

                    //call topic manager
                    $topicManager = new TopicManager;
                    //add new topic in bdd by add method of parent class manager 
                    $idTopic = $topicManager->add($dataTopic);

                    $dataPost = [
                        "message" => $message,
                        "user_id" => $user_id,
                        "topic_id" => $idTopic,
                    ];
                    //Create in the same time first post
                    $postManager = new PostManager;
                    $postManager->add($dataPost);
                }else{
                    throw new Exception("form undefine");
                }
            } catch (Exception $e) {

                echo $e->getMessage();
            }
        }
        // 
        public function updateTopicForm(){
            
            $newId = filter_var($_GET['id'], FILTER_VALIDATE_INT);

            //get topic by id
            $topicManager = new TopicManager;
            $topic = $topicManager->findOneById($newId);
           

            // instance a new User and require all informations in bd
            $userManager = new UserManager;
            $user = $userManager->getUserByTopicId($newId); 

           

             // instance a new category and get it by id
             $categoryManager = new CategoryManager;

             $categories= $categoryManager->findAll();
             $category = $categoryManager->getCategoryByTopicId($newId);

            return [
                "view" => VIEW_DIR."forum/topics/updateTopic.view.php",
                "data" => ["topic" => $topic]
            ];
        }

        // Update topic informations

        public function updateTopic($id){
            
            try{
                //check if recieved informations are defined
            if(isset($_POST['title']) && isset($_POST['category-id']) && isset($_POST['adminChangeCategory'])){
                // filter recieved informations
                $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
                $idTopic = filter_var($_POST['id_topic'], FILTER_VALIDATE_INT);
                $status = filter_var($_POST['status'], FILTER_VALIDATE_INT);
                // check if admin change category
                $categoryId = ($_POST['adminChangeCategory']) ? filter_var($_POST['adminChangeCategory'], FILTER_VALIDATE_INT) : filter_var($_POST['category-id'], FILTER_VALIDATE_INT);

                $topicManager = new TopicManager;
                $topicManager->updateTopicInBdd($idTopic,$title, $status, $categoryId);

                $this-> redirectTo("forum", "showTopicsByCategoryId", $categoryId);
            }
            }catch(Exception $e){
                echo "Update failed: " . $e->getMessage();
            }  
        }
           
        


        // detele topic by id 
        public function deleteTopicById(){
            // check if id is sent by url
            if(isset($_GET['id'])){
                // filter id to prevent script injection
                $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
                // instance a new topic manager and send the task
                $topicManager = new TopicManager;
                $topicManager->deleteTopicById($id);
            }
        }
        
        // POSTS SECTION ---------------------------------------------------------------------------------

        
        // show poste by topic ID
        public function showPostsByTopicId($id) {
            // creat a new instance of Post manager
            $postManager = new PostManager;
            $posts = $postManager->getPostsByTopicId($id);

            $topicManager = new TopicManager;
            $topic = $topicManager->findOneById($id);
          
            // redirect to posts view page with data 
            return [
                "view" => VIEW_DIR."forum/posts/posts.view.php",
                "data" => [
                    "posts" => $posts,
                    "topic" => $topic
                ],
                "success" => Session::getFlash('success'),
                "error" => Session::getFlash('error')
            ];
        }

        // add post in topic 
        public function addPostByTopicId($id){
            // check if form infos post are defined
            if(isset($_POST['message']) && isset($_POST['user']) && $_POST['message'] !== null){
                // filter data received from form 
                $newMessage = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);
                $user = filter_var($_POST['user'], FILTER_VALIDATE_INT);
                $topic = filter_var($id, FILTER_VALIDATE_INT);
                // $postDate = "";
                // put in data array
                $data = [
                    'message' => $newMessage,
                    // 'postDate' => $postDate,
                    'topic_id' => $topic,
                    'user_id' => $user
                ];
                // initialize new Post Manager
                $postManager = new PostManager;

                $postManager->add($data); // add new post in bdd. 

                Session::addFlash('success', 'Votre messages à bien été ajouté');
                return [
                    "view" => VIEW_DIR."forum/posts/posts.view.php"   
                ];
            }

        }
        //delete post 
        public function deletePostById($id){
            $newId = filter_var($id, FILTER_VALIDATE_INT);
            // initialize new Post Manager
            $postManager = new PostManager;
            //delete post une bdd
            $postManager->delete($newId);

            return [
                "view" => VIEW_DIR."forum/posts/posts.view.php",
            ];

        }

        public function updatePostForm($id){

            $idPost = filter_var($id, FILTER_VALIDATE_INT); 
            $postManager = new PostManager;
            $post = $postManager->getPostById($idPost);

            return [
                "view" => VIEW_DIR . "/forum/posts/updatePostForm.view.php",
                "data" => ["post" => $post]
            ];
        }

        public function updatePost($id){
            $message = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);
            $idPost = filter_var($id, FILTER_VALIDATE_INT);
            $postManager = new PostManager;
            $post = $postManager->findOneById($idPost);

            // check if message is not null 
            if (!empty($message)){
                // put data into $data array
                $data = [
                    'id_post' => $idPost,
                    'message' => $message
                ];
                //instance new Post manager
                $postManager = new PostManager;

                $postManager->updatePostInBdd($data);
            }

            $this-> redirectTo("forum", "showPostsByTopicId", $post->getTopic()->getId());
        }


         //  echo "<pre>";
            //  print_r($user);
            //  echo "</pre>";
            //  die();

    }
