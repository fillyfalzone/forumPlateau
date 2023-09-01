<?php
    namespace Model\Managers;

    use App\DAO;
    use App\Manager;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

    }

?>