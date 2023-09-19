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

        //  public function setRole($role)

        //  {
 
        //          // on récupère du JSON
 
        //         $this->role == json_encode($role);
 
        //          // s'il n'y a pas de rôles attitrés, on va lui attribuer un rôle
 
        //          return $this;
 
        //  }

        public function setRole($role){
            $this->role = $role;
            // // Vérifiez d'abord si $role est un tableau
            // if (is_array($role)) {
            //     // Encodez le tableau en JSON et attribuez-le à la propriété $role
            //     $this->role = json_encode($role);
            // }
            // // S'il n'est pas un tableau, vous pouvez gérer cette situation en conséquence
            // // (par exemple, attribuer un rôle par défaut ou générer une erreur).
            // return $this;
        }


        public function setAvatar($avatar){$this->avatar = $avatar;}

        public function setIsbanned($isBanned){ $this->isBanned = $isBanned;}

        
        public function __toString(){
            return  $this->pseudo;
        }

        public function hasRole($role)

        {
                // si dans le tableau json on trouve un role qui correspond
                // au rôle envoyé en paramètre, alors cela nous return true
                $result = $this->getRole() == json_encode($role);

                return $result;

        }

        public function afficherRole() {

            if(in_array("ROLE_ADMIN", $this->getRole())) {

            return "admin";

            } else {
                return "user";

            }

        }
    }

?>