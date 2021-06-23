<div class="product-showcase">
    <div class="row">
        <div class="col gallery">
            <div class="picture-gallery js_photo-gallary">
                <figure class="gallery-image">
                    <?php echo (!empty($product->pictures())) ? $product->pictures()[0]?->getImgTag() : ''; ?>
                </figure>
                <div class="gallery-menu js_photo-gallary-menu">
                    <?php foreach ($product->pictures() as $picture) {
                        if($product->pictures()[0]->id !== $picture->id){
                            echo $picture->getImgTag();
                        }
                    }?>
                </div>
            </div>
        </div>
        <div class="col product-data">
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
                    <span><?php echo $product->stock;  ?> Stk</span>
                </div>
            </div>

            <div class="row">
                <div class="price col">
                    <span>Preis:</span>
                </div>
                <div class="actuall-price col">
                    <span><?php echo Core\Helpers\Formatter::formatPrice($product->price); ?></span>
                </div>
            </div>

            <div class="product-actions row">

                    <button class="add-to-basket js_add-to-basket" data-href="<?php echo BASE_URL . '/api/basket/add/' . $product->id; ?>/1">In den Warenkorb <i class="ri-shopping-cart-fill"></i></button>

            </div>
        </div>
    </div>

    <div class="product-description">
        <p><?php echo $product->description; ?></p>
    </div>

</div>