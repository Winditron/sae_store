<div class="product-form">
    <form action="<?php echo BASE_URL; ?>/profile/edit/update" method="post">
        <h2 class="signup form-title">Kontoeinstellungen</h2>

            <div class="row">
            <div class="form-group col">
                <label for="firstname">Vorname:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $user->firstname; ?>">
            </div>

            <div class="form-group col">
                <label for="secondname">Nachname:</label>
                <input type="text" id="secondname" name="secondname" value="<?php echo $user->secondname; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email-Adresse:</label>
            <input type="email" id="email" name="email" value="<?php echo $user->email; ?>">
        </div>

        <div class="form-group">
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" >
        </div>

        <div class="form-group">
            <label for="password-repeat">Passwort wiederholen:</label>
            <input type="password" id="password-repeat" name="password-repeat" >
        </div>

        <div class="form-group">
            <label for="phone">Telefonnummer:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user->phone; ?>">
        </div>

        <div class="form-group">
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" value="<?php echo $user->address; ?>">
        </div>

        <div class="row" >
            <div class="form-group col">
                <label for="city">ORT:</label>
                <input type="text" id="city" name="city" value="<?php echo $user->city; ?>">
            </div>

            <div class="form-group col">
                <label for="zip">PLZ:</label>
                <input type="text" id="zip" name="zip" value="<?php echo $user->zip; ?>">
            </div>
        </div>

        <button type="submit">Speichern</button>
    </form>
</div>
