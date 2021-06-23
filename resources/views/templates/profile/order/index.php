<div class="list">
    <h2>Alle Bestellungen</h2>

    <div class="list-table table center">
        <div class="row table-headline">
                <div class="col">Bestellungsnummer:</div>
                <div class="col">Anzahl/Produkte</div>
                <div class="col">TOTAL:</div>
                <div class="col">Status:</div>
                <div class="col">Aktionen</div>
        </div>

        <?php foreach ($orders as $order): ?>
        <div class="row colored">
                <div class="col">#<?php echo $order->id; ?></div>
                <div class="col"><?php echo $order->amountOfProducts(); ?></div>
                <div class="col"><?php echo \Core\Helpers\Formatter::formatPrice($order->total()); ?></div>
                <div class="col"><?php echo $order->status; ?></div>
                <div class="col">
                    <a href="<?php echo BASE_URL . '/profile/order/' . $order->id . '/show'; ?>" class="btn" >anzeigen</a>
                </div>
        </div>
        <?php endforeach;?>

    </div>

</div>
