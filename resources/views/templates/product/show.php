<div class="row">
    <div class="col">
        <div class="gallery">
            <figure>
                <?php echo (!empty($product->pictures())) ? $product->pictures()[0]?->getImgTag() : ''; ?>
            </figure>
            <div class="gallery-menue">
                <?php foreach ($product->pictures() as $picture) {
                    echo $picture->getImgTag();
                }?>
            </div>
        </div>
    </div>
    <div class="col">
        <h2 class="product-name">
            <?php echo $product->name; ?>
        </h2>

        <div class="row">
            <div class="col">
                <span>Wasserbedarf:</span>
            </div>
            <div class="col">
                <span><?php echo $product->watering; ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <span>Standort:</span>
            </div>
            <div class="col">
                <span><?php echo $product->sun_location; ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <span>max Größe:</span>
            </div>
            <div class="col">
                <span><?php echo $product->size; ?> cm</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <span>Verfügbarkeit:</span>
            </div>
            <div class="col">
                <span><?php echo $product->stock; ?></span>
            </div>
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
</div>

<div class="product-description">
    <?php echo $product->description; ?>
</div>