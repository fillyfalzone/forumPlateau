<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;
    use Model\Entities\Category;
    use PDO;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

        // add a new category in the database
        public function addCategoryInDb($data){
            //use add method from manager.php 
            return $this->add($data); 
        }

        public function getCategoryById($id){
            //use findOneById method from manager.php
            return $this->findOneById($id);
        }

        public function updateCategoryInDb($data) {
            // make query
            $sql = "UPDATE category
                    SET categoryName = :categoryName,
                        descriptions = :descriptions
                    WHERE id_category = :id";
            // join parameters
            $param = [
                ':id' => $data['id'],
                ':descriptions' => $data['descriptions'],
                'categoryName' => $data['categoryName']
            ];
           
            DAO::update($sql, $param);
        
        }
        
        // delet category in Bdd
        public function deleteCategoryById($id){
            //Use delete method in manager parent class
            return $this->delete($id);
        }
        
        // get categoty by topic id

        public function getCategoryByTopicId($id){
            // make query
            $sql = "SELECT *
            FROM category c
            INNER JOIN topic t ON t.category_id = c.id_category
            WHERE t.id_topic = :id";
            $param = ['id' => $id];

            return DAO::select($sql, $param, true);

        }
        
    }

?>