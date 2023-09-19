

<h1 style="font-family: Arial, sans-serif; color: #333; text-align: center;">Connexion</h1>


<form action="../../index.php?ctrl=security&action=login" method="POST" style="max-width: 400px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
       
    <label for="pseudo" style="display: block; margin-bottom: 10px; font-weight: bold;">Pseudo :</label>

    <input type="text" id="pseudo" name="pseudo" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
   
    <label for="passWord" style="display: block; margin-bottom: 10px; font-weight: bold;">Mot de passe :</label>
   
    <input type="password" id="passWord" name="passWord" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
   
   <input type="submit" value="Se connecter" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">

</form>