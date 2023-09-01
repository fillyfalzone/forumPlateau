<?php
namespace Model\Entities;

use App\Entity;

final class Category extends Entity {

    private $id;
    private $categoryName;

    public function __construct($data){
        $this->hydrate($data);
    }
    
    // Getters
    public function getId(){ return $this->id; }
    public function getCategoryName(){ return $this->categoryName; }
    
    // Setters
    public function setId($id){ $this->id = $id; }
    public function setCategoryName($categoryName){ $this->categoryName = $categoryName; }

    public function __toString(){
        return $this->categoryName;
    }
}
?>
