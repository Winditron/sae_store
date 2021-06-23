<div class="summery-list">

    <h2>Bestellübersicht</h2>
    <h3>Vielen Dank für Ihre Bestellung!</h3>

    <div class="summery-billing-address">
        <div class="row">
            <div class="col">
                <h3><?php echo (empty($order->alt_firstname)) ? 'Rechnungs- und Lieferadresse' : 'Rechnungsadresse' ?></h3>
                <p><?php echo "$order->firstname $order->secondname"; ?></p>
                <p><?php echo $order->phone; ?></p>
                <p><?php echo $order->address ?></p>
                <p><?php echo "$order->zip, $order->city"; ?></p>
            </div>
            <?php if (!empty($order->alt_firstname)): ?>
                <div class="col">
                    <h3>Lieferadresse</h3>
                    <p><?php echo "$order->alt_firstname $order->alt_secondname"; ?></p>
                    <p><?php echo $order->alt_phone; ?></p>
                    <p><?php echo $order->alt_address ?></p>
                    <p><?php echo "$order->alt_zip, $order->alt_city"; ?></p>
                </div>
            <?php endif;?>
        </div>
    </div>

    <div class="summery-product-list table">

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
                <div class="col"><?php echo Core\Helpers\Formatter::formatPrice($order_item->price); ?></div>
                <div class="col"><?php echo Core\Helpers\Formatter::formatPrice($order_item->price * $order_item->quantity); ?></div>
            </div>
        <?php endforeach;?>

        <div class="row total">
            <div class="col-3"></div>
            <div class="col right">TOTAL:</div>
            <div class="col"><?php echo Core\Helpers\Formatter::formatPrice($total); ?></div>
        </div>

        <div class="row ">
            <div class="col-3"></div>
            <div class="col-2 "><a class="btn fill big big-success" href="<?php echo BASE_URL . '/Shop'; ?>">Weiter stöbern?</a></div>
        </div>

    </div>
</div>
