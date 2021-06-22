<div class="product-list">

<div class="product table">
    <div class="row table-headline">
        <div class="col">Produktnummer:</div>
        <div class="col">Name:</div>
        <div class="col">Aktionen</div>
    </div>
</div>
<?php foreach ($products as $product): ?>
<div class="row">
        <div class="col">#<?php echo $product->id; ?></div>
        <div class="col"><?php echo $product->name; ?></div>
        <div class="col">
            <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/edit'; ?>" class="btn">Bearbeiten</a>
            <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/delete/confirm'; ?>" class="btn danger">Löschen</a>
        </div>
</div>
<?php endforeach;?>

</div>
