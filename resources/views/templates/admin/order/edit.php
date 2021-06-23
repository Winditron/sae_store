<div class="summery-list">
    <h2>Bearbeitung der Bestellung #<?php echo $order->id; ?></h2>
    <form action="<?php echo BASE_URL . "/admin/order/{$order->id}/edit/update"; ?>" method="post">

        <div class="summery-status center">
            <div class="row">
                <div class="col"><strong>Status:</strong></div>
                <div class="col">
                    <select name="status" id="status">
                        <option hidden>Bitte auswählen!</option>

                        <?php foreach ($order->statusValues() as $value): ?>
                        <option value="<?php echo $value; ?>" <?php echo ($order->status === $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach;?>

                    </select>
                </div>
            </div>
        </div>

        <div class="row summery-form-billing-address">

            <div class="col">
                <h3 class="js_checkout-headline"><?php echo (empty($order->alt_firstname)) ? 'Rechnungs- und Lieferadresse' : 'Rechnungsadresse' ?></h3>
                <div class="form-row">
                    <div class="form-group wrap">
                        <label for="firstname">Vorname:</label>
                        <input type="text" id="firstname" name="firstname"  value="<?php echo $order->firstname; ?>">
                    </div>

                    <div class="form-group wrap">
                        <label for="secondname">Nachname:</label>
                        <input type="text" id="secondname" name="secondname" value="<?php echo $order->secondname; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email-Adresse:</label>
                    <input type="email" id="email" name="email" value="<?php echo $order->email; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Telefonnummer:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $order->phone; ?>">
                </div>

                <div class="form-group">
                    <label for="address">Adresse:</label>
                    <input type="text" id="address" name="address" value="<?php echo $order->address; ?>">
                </div>

                <div class="form-row" >
                    <div class="form-group wrap">
                        <label for="city">ORT:</label>
                        <input type="text" id="city" name="city" value="<?php echo $order->city; ?>">
                    </div>

                    <div class="form-group wrap">
                        <label for="zip">PLZ:</label>
                        <input type="text" id="zip" name="zip" value="<?php echo $order->zip; ?>">
                    </div>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" class="js_alt_delivery" id="alt_delivery" name="alt_delivery" <?php echo (!empty($order->alt_firstname)) ? 'checked' : ''; ?>>
                    <label for="alt_delivery">Lieferadresse weicht von der Rechnungsadresse ab: </label>
                </div>
            </div>
            <div class="col">
                <div class="alt_delivery js_alt_delivery" <?php echo (!empty($order->alt_firstname)) ? 'style="display:block;"' : ''; ?>>
                    <h3>Lieferadresse</h3>

                    <div class="form-row">
                        <div class="form-group wrap">
                            <label for="alt_firstname">Vorname:</label>
                            <input type="text" id="alt_firstname" name="alt_firstname" value="<?php echo (!empty($order->alt_firstname)) ? $order->alt_firstname : ''; ?>">
                        </div>

                        <div class="form-group wrap">
                            <label for="alt_secondname">Nachname:</label>
                            <input type="text" id="alt_secondname" name="alt_secondname" value="<?php echo (!empty($order->alt_secondname)) ? $order->alt_secondname : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alt_address">Adresse:</label>
                        <input type="text" id="alt_address" name="alt_address" value="<?php echo (!empty($order->alt_address)) ? $order->alt_address : ''; ?>">
                    </div>

                    <div class="form-row" >
                        <div class="form-group wrap">
                            <label for="alt_city">ORT:</label>
                            <input type="text" id="alt_city" name="alt_city" value="<?php echo (!empty($order->alt_city)) ? $order->alt_city : ''; ?>">
                        </div>

                        <div class="form-group wrap">
                            <label for="alt_zip">PLZ:</label>
                            <input type="text" id="alt_zip" name="alt_zip" value="<?php echo (!empty($order->alt_zip)) ? $order->alt_zip : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alt_phone">Telefonnummer:</label>
                        <input type="text" id="alt_phone" name="alt_phone" value="<?php echo (!empty($order->alt_phone)) ? $order->alt_phone : ''; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="summery-product-list table center">
            <div class="row table-headline">
                <div class="col">Artikelnummer:</div>
                <div class="col">Artikel:</div>
                <div class="col">Menge:</div>
                <div class="col">Preis/Stück:</div>
                <div class="col">Preis:</div>
            </div>



            <?php foreach ($order_items as $order_item): ?>
                <div class="row colored">
                    <div class="col">#<?php echo $order_item->id; ?></div>
                    <div class="col"><?php echo $order_item->name; ?></div>
                    <div class="col"><?php echo $order_item->quantity; ?></div>
                    <div class="col "><?php echo Core\Helpers\Formatter::formatPrice($order_item->price); ?></div>
                    <div class="col "><?php echo Core\Helpers\Formatter::formatPrice($order_item->price * $order_item->quantity); ?></div>
                </div>
            <?php endforeach;?>

            <div class="row total">
                <div class="col-3"></div>
                <div class="col">TOTAL:</div>
                <div class="col "><?php echo Core\Helpers\Formatter::formatPrice($total); ?></div>
            </div>

            <div class="row ">
                <div class="col-4"></div>
                <div class="col "><button type="submit" class="fill">Speichern</button></div>
            </div>

        </div>
    </form>
</div>
