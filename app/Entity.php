<?php
    namespace App;

    abstract class Entity{

        protected function hydrate($data){
            
            foreach($data as $field => $value){
                //field = nom d'une colonne.
                //value = valeur d'une cellule.
                //data = c'est une ligne du table de la base de données. 

                // A partir des clés etrangeres on va recuperer des objets. 
                //field = marque_id
                //fieldarray = ['marque','id']

                //explode permet de transformer une chaine de caractère en un tableau de strings en decoupant au niveau du separateur (ici le underscore "_").
                
                // 3 cas possibles (pour l'entité "truc") :
                //  1-  PK : id_truc
                //      exemple :[id, truc]
                // 2 -  FK : truc_id
                //      exemple : [truc_id]
                // 3 - autre (données classiques, qui ne sont pas des clés) : title, message, trucDate
                $fieldArray = explode("_", $field);

                // "le if des FK"
                // si fiejdArray a un 2eme élément ET que c'est "id" on est dans le cas de FK 'foriegn key'

                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                    // définition du nom du manager
                    $manName = ucfirst($fieldArray[0])."Manager"; //ucfirst() : 1ere lettre en Maj.
                    //FQC= nom complet du manager : "TrucManager"
                    $FQCName = "Model\Managers".DS.$manName; // FQC: full qualify class name Model\users\userManager 
                    
                    // instance du manager
                    $man = new $FQCName();

                    // appel à la methode findOneById du bon manager, en fournissant l'id de l'entité référencée (de l'enregistrement de la table "truc" qui a pour id $value))
                    //$value, qui contenait un id (car le champ était une FK), contien maintenant un objet (instance d'une entité (dans model/Entities/))
                    $value = $man->findOneById($value);
                }

                //fabrication du nom du setter à appeler (ex: setMarque)
                // 3 cas possibles (pour l'entité "Truc") :
                // 1- PK : "id" -> "setId"
                // 2- FK : "truc" -> "setTruc"
                // 3- autre : "title" -> "setTitle"
                $method = "set".ucfirst($fieldArray[0]);
                
                // si cette methde (ce stter) existe 
                if(method_exists($this, $method)){
                    // on l'appel en lui passant $value en argument
                    // 2 cas possibles
                    // 1- FK : un objet
                    // 2- PK ou autre : une valeur 
                    $this->$method($value);
                }

            }
        }

        public function getClass(){
            return get_class($this);
        }
    }