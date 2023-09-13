<?php
    namespace Service;
    
    class FunctionPerso {
        // this function is used to manage the images that will be uploaded to our site, it takes in parameters the image file and the direction directory 
        public function addPoster($file, $dir){
            if(!isset($file['name']) || empty($file['name'])) // check if an image is sent in the form
                throw new Exception("Vous devez indiquer une image");
        
            if(!file_exists($dir)) mkdir($dir,0777); // check whether direction directory exists check if the direction directory exists, otherwise it will create it
        
            $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION)); //get file extension
            $random = rand(0,99999); //generate a random number to add to the file name to have a unique file
            $target_file = $dir.$random."_".$file['name'];
            
            //check the name, the extension, if the file already exists and limit the size of the file,
            if(!getimagesize($file["tmp_name"]))
                throw new Exception("Le fichier n'est pas une image");
            if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
                throw new Exception("L'extension du fichier n'est pas reconnu");
            if(file_exists($target_file))
                throw new Exception("Le fichier existe déjà");
            if($file['size'] > 500000)
                throw new Exception("Le fichier est trop gros");
            if(!move_uploaded_file($file['tmp_name'], $target_file))
                throw new Exception("l'ajout de l'image n'a pas fonctionné");
            else return ($random."_".$file['name']);
        }

         // To convert int to hours format ex: "2h30min"
        public function intToHour($min) {
            $hours = floor($min / 60);
            $remindMin = $min % 60;
            if( $remindMin === 0){
                return $hours . "h ";
            } else{
                return $hours . "h " . $remindMin . "min";
            }
            
        }

    }
 
?>


<!-- <!DOCTYPE html>
<html>
<head>
<style>
    .fenetre-flottante {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
</head>
<body>

<a href="#" onmouseover="ouvrirFenetreFlottante()" onmouseout="fermerFenetreFlottante()">Survolez ce lien</a>

<div id="fenetreFlottante" class="fenetre-flottante">
    Contenu de la fenêtre flottante
</div>

<script>
    function ouvrirFenetreFlottante() {
        document.getElementById("fenetreFlottante").style.display = "block";
    }

    function fermerFenetreFlottante() {
        document.getElementById("fenetreFlottante").style.display = "none";
    }
</script>

</body>
</html> -->