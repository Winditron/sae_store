<div class="signup">
    <form action="<?php echo BASE_URL; ?>/sign-up/finish" method="post">
        <h2 class="signup form-title"><i class="ri-user-fill"></i>Neues Konto anlegen</h2>

        <?php require_once __DIR__ . '/../../partials/ErrorAndSuccessMessages.php';?>

        <p class="form-note">&lowast; -> benötigte Felder</p>

        <div class="row">
            <div class="form-group col">
                <label for="firstname">Vorname:</label>
                <input type="text" id="firstname" name="firstname">
            </div>

            <div class="form-group col">
                <label for="secondname">Nachname:</label>
                <input type="text" id="secondname" name="secondname">
            </div>
        </div>

        <div class="form-group">
            <label for="email">&lowast;Email-Adresse:</label>
            <input type="email" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">&lowast;Passwort:</label>
            <input type="password" id="password" name="password" >
        </div>

        <div class="form-group">
            <label for="password-repeat">&lowast;Passwort wiederholen:</label>
            <input type="password" id="password-repeat" name="password-repeat" >
        </div>

        <div class="form-group">
            <label for="phone">Telefonnummer:</label>
            <input type="text" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address">
        </div>

        <div class="row" >
            <div class="form-group col">
                <label for="country">ORT:</label>
                <input type="text" id="country" name="country">
            </div>

            <div class="form-group col">
                <label for="zip">PLZ:</label>
                <input type="text" id="zip" name="zip">
            </div>
        </div>

        <button type="submit">registrieren</button>
    </form>
</div>
