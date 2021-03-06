<div class="product-list">
    <a href="<?php echo BASE_URL; ?>/admin/product/new" class="btn">anlegen</a>
    <div class="product table">
        <div class="row table-headline">
            <div class="item">Produktnummer:</div>
            <div class="item">Name:</div>
            <div class="item">Aktionen</div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="item"><?php echo $product->id; ?></div>
            <div class="item"><?php echo $product->name; ?></div>
            <div class="item">
                <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/edit'; ?>" class="btn">Bearbeiten</a>
                <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/delete'; ?>" class="btn danger">Löschen</a>
            </div>
        <?php endforeach;?>
    </div>
</div>
