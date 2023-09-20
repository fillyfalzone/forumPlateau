<link rel="stylesheet" href=".<?= PUBLIC_DIR ?>/css/loginForm.css">

<h2>Connexion</h2>


<form action="././index.php?ctrl=security&action=login" method="POST" >
       
    <label for="pseudo">Pseudo :</label>

    <input type="text" id="pseudo" name="pseudo" required >
   
    <label for="passWord">Mot de passe :</label>
   
    <input type="password" id="passWord" name="passWord" required>
   
   <input type="submit" value="Se connecter">

</form>