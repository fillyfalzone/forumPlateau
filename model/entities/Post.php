<?php
    namespace Model\Entities;

    use App\Entity;

    final class Post extends Entity {

        private $id;
        private $message;
        private $postDate;
        private $topic;
        private $user;
        
        public function __construct($data){
            $this->hydrate($data);
        }

        public function getId(){return $this->id;}
        public function getMessage(){return $this->message;}
        public function getPostDate(){return $this->postDate;}
        public function getTopic(){return $this->topic;}
        public function getUser(){return $this->user;}

        public function setId($id){ $this->id = $id;}
        public function setMessage($message){ $this->message = $message;}
        public function setPostDate($postDate){ $this->postDate = $postDate;}
        public function setTopic($topic){ $this->topic = $topic;}
        public function setUser($user){ $this->user = $user;}

        public function __toString(){
            return "The post message is : " . $this->message;
        }
    }


?>