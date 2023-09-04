<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;
use PDO;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

        // add a new category in the database
        public function addCategoryInDb($data){
            //use method from manager.php 
            return $this->add($data); 
        }

        public function editCategoryInDb($data, $id){

            $sql = "UPDATE category c
            SET c.categoryName = ':categoryName',
                 c.description = ':description',
            WHERE c.id_category = :id";

            $sql->bindValue(":id",$id, PDO::PARAM_INT);
            $sql->bindValue(":categoryName",$data['categoryName'], PDO::PARAM_STR);
            $sql->bindValue(":description",$data['description'], PDO::PARAM_STR);

        
        }

    }

?>