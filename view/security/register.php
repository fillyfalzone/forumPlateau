<h1 style="font-family: Arial, sans-serif; color: #333; text-align: center;">Inscription au Forum</h1>

    <form action="index.php?ctrl=security&action=register" method="post" enctype="multipart/form-data" style="max-width: 400px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
        <label for="pseudo" style="display: block; margin-bottom: 10px; font-weight: bold;">Pseudo :</label>

        <input type="text" id="pseudo" name="pseudo" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="email" style="display: block; margin-bottom: 10px; font-weight: bold;">Email :</label>

        <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="passWord" style="display: block; margin-bottom: 10px; font-weight: bold;">Mot de passe :</label>

        <input type="password" id="passWord" name="passWord" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="confirmPassWord" style="display: block; margin-bottom: 10px; font-weight: bold;">Confirmer le mot de passe :</label>

        <input type="password" id="confirmPassWord" name="confirmPassWord" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="avatar" style="display: block; margin-bottom: 10px; font-weight: bold;">Avatar :</label>

        <input type="file" id="avatar" name="avatar" accept="image/*" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <input type="checkbox" name="conditions" id="conditions" value="0" required> 
        <label for="conditions">: Veuillez confirmer que vous avez pris connaissance des <a href="">conditions générales du forum</a> et que vous consentez à les respecter.</label> <br> <br>

        <input type="submit" value="S'inscrire" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">

    </form>