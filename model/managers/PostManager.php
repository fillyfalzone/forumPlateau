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

    }

?>