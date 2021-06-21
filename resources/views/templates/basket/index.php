<div class="basket-list">

<h2>Warenkorb</h2>

<div class="basket-product-list table">
    <div class="row table-headline">
        <div class="col">Artikelnummer:</div>
        <div class="col">Artikel:</div>
        <div class="col">Menge:</div>
        <div class="col">Aktionen:</div>
        <div class="col">Preis/Stück:</div>
        <div class="col">Preis:</div>
    </div>

    <?php foreach ($basket->items as $basket_item): ?>
        <div class="row">
            <div class="col">#<?php echo $basket_item->id; ?></div>
            <div class="col"><?php echo $basket_item->name; ?></div>
            <div class="col"><input type="number" class="basket-change-quatity" value="<?php echo $basket_item->quantity; ?>" data-href="<?php echo BASE_URL . '/api/basket/set/' . $basket_item->id; ?>/"></div>
            <div class="col"><button class="danger delete" data-href="<?php echo BASE_URL . '/api/basket/set/' . $basket_item->id; ?>/0">Entfernen</button></div>
            <div class="col js_price"><?php echo Core\Helpers\Formatter::formatPrice($basket_item->price); ?></div>
            <div class="col js_price-quantity"><?php echo Core\Helpers\Formatter::formatPrice($basket_item->price * $basket_item->quantity); ?></div>
        </div>
    <?php endforeach;?>

    <div class="row total">
        <div class="col-2">TOTAL:</div>
        <div class="col"><?php echo Core\Helpers\Formatter::formatPrice($basket->total()); ?></div>
    </div>
</div>

</div>
