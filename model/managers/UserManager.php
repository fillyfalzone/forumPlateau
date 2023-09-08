<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;
    use PDO;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        // get user by id topic
        public function getUserByTopicId($id){
          
            // make query
            $sql = "SELECT *
            FROM user u
            INNER JOIN topic t ON t.user_id = u.id_user
            WHERE t.id_topic = :id ";
            //Parameter of query
            $param = ['id' => $id];
            //Use DAO select method to get results
            return DAO::select($sql, $param, true);
        }

    }

        
?>