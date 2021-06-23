<div class="list">
    <h2>Alle Produkte</h2>
    <div class="list-table table center">
        <div class="row table-headline">
            <div class="col">Produktnummer:</div>
            <div class="col">Name:</div>
            <div class="col">Aktionen</div>
        </div>

        <?php foreach ($products as $product): ?>
        <div class="row colored">
            <div class="col">#<?php echo $product->id; ?></div>
            <div class="col"><?php echo $product->name; ?></div>
            <div class="col">
                <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/edit'; ?>" class="btn">Bearbeiten</a>
                <a href="<?php echo BASE_URL . '/admin/product/' . $product->id . '/delete/confirm'; ?>" class="btn danger">Löschen</a>
            </div>
        </div>
        <?php endforeach;?>

    </div>
</div>
