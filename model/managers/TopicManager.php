<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use PDO;

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
        // Update category in bdd
        public function updateTopicInBdd($idTopic, $title, $status, $categoryId){

            $sql = "UPDATE topic
            SET title = :title, category_id = :category_id
            WHERE id-topic_id = :id";

            $param = [
                'id' => $idTopic,
                'title' => $title,
                'isLocked' => $status,
                'category_id' => $categoryId
            ];

            DAO::update($sql, $param);
        }


        //delete topic in Bdd 
        public function deleteTopicById(int $id){
            //delete Post of this topic before
            $sql = "DELETE 
            FROM post p 
            WHERE p.topic_id = :id";

            $param = ['id' => $id];

            DAO::delete($sql, $param);
        }


        

    }