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
     

        // select post by topic id
        public function getPostsByTopicId($newId){
            // make request sql
            $sql = "SELECT *
            FROM post p 
            WHERE p.topic_id = :id";
            // link param
            $param = ['id' => $newId];

            // return DAO::select($sql, $param);
            return $this->getMultipleResults(
                DAO::select($sql, $param), 
                $this->className
            );
        }

        public function getPostById($idPost){
            //return post object where id is given
            return $this->findOneById($idPost);

        }

        public function updatePostInBdd($data){

            $sql = "UPDATE post 
            SET message = :message 
            WHERE id_post = :id_post";
           
           return DAO::update($sql, $data);
        }
    }

?>