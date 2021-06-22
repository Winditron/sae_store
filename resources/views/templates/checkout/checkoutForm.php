<div class="checkout">
    <form action="<?php echo BASE_URL; ?>/checkout/check" method="post">
        <h2 class="signup form-title"><i class="ri-user-fill"></i>Lieferdaten</h2>

        <div class="row">

            <div class="col">
                <h3 class="js_checkout-headline">Rechnungs- und Lieferadresse</h3>

                <div class="row">
                    <div class="form-group col">
                        <label for="firstname">Vorname:</label>
                        <input type="text" id="firstname" name="firstname"  value="<?php echo (!empty($user->firstname)) ? $user->firstname : ''; ?>">
                    </div>

                    <div class="form-group col">
                        <label for="secondname">Nachname:</label>
                        <input type="text" id="secondname" name="secondname" value="<?php echo (!empty($user->secondname)) ? $user->secondname : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email-Adresse:</label>
                    <input type="email" id="email" name="email" value="<?php echo (!empty($user->email)) ? $user->email : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Telefonnummer:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo (!empty($user->phone)) ? $user->phone : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="address">Adresse:</label>
                    <input type="text" id="address" name="address" value="<?php echo (!empty($user->address)) ? $user->address : ''; ?>">
                </div>

                <div class="row" >
                    <div class="form-group col">
                        <label for="city">ORT:</label>
                        <input type="text" id="city" name="city" value="<?php echo (!empty($user->city)) ? $user->city : ''; ?>">
                    </div>

                    <div class="form-group col">
                        <label for="zip">PLZ:</label>
                        <input type="text" id="zip" name="zip" value="<?php echo (!empty($user->zip)) ? $user->zip : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alt_delivery">Lieferadresse weicht von der Rechnungsadresse ab: </label>
                    <input type="checkbox" class="js_alt_delivery" id="alt_delivery" name="alt_delivery">
                </div>

            </div>


            <div class="col ">

                <div class="alt_delivery js_alt_delivery">
                    <h3>Lieferadresse</h3>

                    <div class="row">
                        <div class="form-group col">
                            <label for="alt_firstname">Vorname:</label>
                            <input type="text" id="alt_firstname" name="alt_firstname">
                        </div>

                        <div class="form-group col">
                            <label for="alt_secondname">Nachname:</label>
                            <input type="text" id="alt_secondname" name="alt_secondname">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alt_address">Adresse:</label>
                        <input type="text" id="alt_address" name="alt_address">
                    </div>

                    <div class="row" >
                        <div class="form-group col">
                            <label for="alt_city">ORT:</label>
                            <input type="text" id="alt_city" name="alt_city">
                        </div>

                        <div class="form-group col">
                            <label for="alt_zip">PLZ:</label>
                            <input type="text" id="alt_zip" name="alt_zip">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alt_phone">Telefonnummer:</label>
                        <input type="text" id="alt_phone" name="alt_phone">
                    </div>

                </div>

            </div>
        </div>
        </div>




        <button type="submit">zur Bestellübersicht</button>
    </form>
</div>
