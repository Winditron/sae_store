
    <h2 class="form-title">Login</h2>

    <div class="form-group">
        <input type="text" name="email" id="email" placeholder="Email-Adresse" required>
    </div>

    <div class="form-group">
        <input type="password" name="password" id="password" placeholder="Passwort" required>
    </div>

    <div class="form-group checkbox">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Anmeldedaten merken?</label>
    </div>

    <button type="submit" class="fill">Anmelden</button>

    <a href="<?php echo BASE_URL; ?>/sign-up" class="register">Neues Konto anlegen...</a>
