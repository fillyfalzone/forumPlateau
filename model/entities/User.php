<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity {

        private $id;
        private $email;
        private $pseudo;
        private $passWord;
        private $signUpDate;
        private $role;
        private $avatar;
        private $isBanned;
        
        public function __construct($data){
            $this->hydrate($data);
        }

        public function getId(){return $this->id;}
        public function getEmail(){return $this->email;}
        public function getPseudo(){return $this->pseudo;}
        public function getPassWord(){return $this->passWord;}
        public function getSignUpDate(){return $this->signUpDate;}

        /*

        * Get the value of role

        */

       public function getRole(){
            // On utilise Json decode parceque
            return json_decode($this->role);
       }

        public function getAvatar(){return $this->avatar;}
        public function getIsbanned(){return $this->isBanned;}


        public function setId($id){ $this->id = $id;}
        public function setEmail($email){ $this->email = $email;}
        public function setPseudo($pseudo){ $this->pseudo = $pseudo;}
        public function setPassWord($passWord){ $this->passWord = $passWord;}
        public function setSignUpDate($signUpDate){ $this->signUpDate = $signUpDate;}

        /**
    
         * Set the value of role
        
         * @return  self
         */
    




        public function setRole($role){
            $this->role = $role;
        }


        public function setAvatar($avatar){$this->avatar = $avatar;}

        public function setIsbanned($isBanned){ $this->isBanned = $isBanned;}

        
        public function __toString(){
            return  $this->pseudo;
        }

        public function hasRole($role) {
                // si dans le tableau json on trouve un role qui correspond
                // au rôle envoyé en paramètre, alors cela nous return true
                $result = $this->getRole() == json_encode($role);

                return $result;

        }
    }  
?>