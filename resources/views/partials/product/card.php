<div class="product-card">

    <div class="product-title">
        <a href="<?php echo BASE_URL . "/Shop/" . $product->slug; ?>"><?php echo $product->name; ?></a>
    </div>

    <div class="product-picture">
        <a href="<?php echo BASE_URL . "/Shop/" . $product->slug; ?>"></a>
    </div>

    <div class="row">
        <div class="price col">
            <span>Preis:</span>
        </div>
        <div class="actuall-price col">
            <span>&euro; <?php echo $product->formatPrice(); ?></span>
        </div>
    </div>

    <div class="product-actions">
    <button class="add-to-basket" data-href="<?php echo BASE_URL . '/api/basket/add/' . $product->id; ?>">In den Warenkorb <i class="ri-shopping-cart-fill"></i></button>
    </div>
</div>
