<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

    }

        
?>