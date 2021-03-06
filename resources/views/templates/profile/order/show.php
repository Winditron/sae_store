<div class="summery-list">

<h2>Bestellung #<?php echo $order->id; ?></h2>
<div class="summery-status center">
    <div class="row">
        <div class="col"><strong>Status:</strong></div>
        <div class="col"><?php echo $order->status; ?></div>
    </div>

    <?php if ($order->status != 'Storno beantragt' && $order->status != "storniert"): ?>
    <div class="row">
        <div class="col-2 fill">
            <form action="<?php echo BASE_URL . "/profile/order/{$order->id}/storno"; ?>" method="post">
                    <input type="hidden" name="status" value="Storno beantragt">
                    <Button type="submit" class="danger fill">Stornierung beantragen</Button>
            </form>
        </div>
    </div>
    <?php endif;?>

</div>


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
            <div class="col"><?php echo Core\Helpers\Formatter::formatPrice($order->total()); ?></div>
        </div>
    </div>

</div>
