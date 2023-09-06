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
            // get connection 
            DAO::connect();
            $dao = DAO::getBdd();
            // to make queru
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
            // prepare and execute the query
            $stmt = $dao->prepare($sql);
            $stmt->execute($param);
        
        }
        
        // delet category in Bdd
        public function deleteCategoryById($id){
            //Use delete method in manager parent class
            return $this->delete($id);
        }
        
        
        
        
    }

?>