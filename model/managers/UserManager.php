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

        public function getUserByPostId($idPost){
            $sql = "SELECT *
            FROM user u 
            INNER JOIN post p ON p.user_id = u.id_user
            WHERE p.id_post = :id";
            //link parameters array
            $param = ["id" => $idPost];

            return DAO::select($sql, $param);

        }
        // find user by pseudo in bdd
        public function findUserByPseudo($pseudo){
            // query request to check if pseudo user is in bdd
            $sql = "SELECT u.pseudo 
                    FROM user u  
                    WHERE u.pseudo = :pseudo:";

            // link parameters
            $param = ["pseudo" => $pseudo];
            // use select method from DAO class
            return DAO::select($sql, $param);
        }

        // find user by email address in bdd

        public function findOneByEmail($email) {

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.email = :email;";
            $param = ['email' => $email];
            $row = DAO::select($sql, $param, false);

            return $this->getOneOrNullResult( $row,$this->className);

       }

       public function findOneByPseudo($pseudo) {

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.pseudo = :pseudo";

            $param = ['pseudo' => $pseudo];
            $row = DAO::select($sql, $param, false);

            return $this->getOneOrNullResult( $row,$this->className);

        }

    }
       
?>