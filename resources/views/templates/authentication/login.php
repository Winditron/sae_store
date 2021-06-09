<div class="login-window">
    <form action="<?php echo BASE_URL; ?>/login/finish" method="post">

        <h2 class="form-title"><?php echo Core\Config::get('app.appname'); ?></h2>

        <?php require_once __DIR__ . '/../../partials/ErrorAndSuccessMessages.php';?>

        <div class="form-group">
            <input type="text" name="email" id="email" placeholder="Email-Adresse" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" id="password" placeholder="Passwort" required>
        </div>

        <div class="form-group">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Anmeldedaten merken?</label>
        </div>

        <button type="submit">Anmelden</button>

        <a href="<?php echo BASE_URL; ?>/sign-up" class="register">Neues Konto anlegen...</a>
    </form>
</div>