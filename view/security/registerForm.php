<link rel="stylesheet" href=".<?= PUBLIC_DIR ?>/css/registerForm.css">

<h2>Inscription au Forum</h2>

    <form action="index.php?ctrl=security&action=register" method="POST" enctype="multipart/form-data">
       
    <label for="pseudo">Pseudo :</label>

        <input type="text" id="pseudo" name="pseudo" required >

        <label for="email" >Email :</label>

        <input type="email" id="email" name="email" required >

        <label for="passWord" >Mot de passe :</label>

        <input type="password" id="passWord" name="passWord" required >

        <label for="confirmPassWord" >Confirmer le mot de passe :</label>

        <input type="password" id="confirmPassWord" name="confirmPassWord" required >

        <label for="avatar" >Avatar :</label>

        <input type="file" id="avatar" name="avatar" accept="image/*" >

        <input type="checkbox" name="conditions" id="conditions" value="1" required> 
        <label for="conditions">: Veuillez confirmer que vous avez pris connaissance des <a href="">conditions générales du forum</a> et que vous consentez à les respecter.</label> <br> <br>

        <input type="submit" value="S'inscrire" >

    </form>