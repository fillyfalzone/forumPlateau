<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }
         // get topics by category id from database
        public function getTopicsByCategoryId(int $id){
            $sql = "SELECT *
            FROM topic t
            WHERE t.category_id = :id;";
            
            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className);

        }

        //delete topic in Bdd 
        public function deleteTopicById($id){
            //Use delete method in manager parent class
            return $this->delete($id);
        }

        

    }