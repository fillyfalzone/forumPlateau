<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }
        // get posts by topic id  in database
        public function getPostsByTopicId($id){

            $sql = "SELECT * 
            FROM post p
            WHERE p.topic_id = :id ;";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]), 
                $this->className);
        }


    }

?>