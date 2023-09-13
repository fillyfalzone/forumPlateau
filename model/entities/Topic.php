<?php
    namespace Model\Entities;  //ranger le fichier dans l'etargère  Model\Entities (chemin virtuel)

    use App\Entity; //Utilise le fichier ranger à cette etagère dans App\Entity (chemin virtuel)

    final class Topic extends Entity{ // class final (une class stérile) ne peut pas avoir d'enfant mais peut avoir des parent ici Entity
        // liste des propriétés de la class topic selon le principe d'encapsulation, (encapsulation: c'est visibilité des propriété d"une classe)
        private $id; 
        private $title;
        private $user;  //objet
        private $creationDate;
        private $isLocked;
        private $category; //objet

        public function __construct($data){         
            $this->hydrate($data); // permet de prendre les donner de la bd et hydrater notre objet       
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        public function getCreationDate(){
            $formattedDate = $this->creationDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setCreationDate($date){
            $this->creationDate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of closed
         */ 
        public function getIsLocked()
        {
                return $this->isLocked;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setIsLocked($closed)
        {
                $this->isLocked = $closed;

                return $this;
        }

        // methode __toString
        public function __toString(){
                
                return $this->title;
        }
                
        

        /**
         * Get the value of category
         */ 
        public function getCategory()
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @return  self
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }
    }
