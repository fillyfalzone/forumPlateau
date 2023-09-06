<?php
namespace Model\Entities;

use App\Entity;

final class Category extends Entity {

    private $id;
    private $categoryName;
    private $descriptions;

    public function __construct($data){
        $this->hydrate($data);
    }
    
    // Getters
    public function getId(){ return $this->id; }
    public function getCategoryName(){ return $this->categoryName; }
    public function getDescriptions(){ return $this->descriptions; }
    
    // Setters
    public function setId($id){ $this->id = $id; }
    public function setCategoryName($categoryName){ $this->categoryName = $categoryName; }
    public function setDescriptions($descriptions){ $this->descriptions = $descriptions; }

    public function __toString(){
        return $this->categoryName;
    }
}
?>
