<div class="list">
    <h2>Alle Bestellungen</h2>
    <div class="list-table table">
        <div class="row table-headline">
            <div class="col">Bestellungsnummer:</div>
            <div class="col">Name:</div>
            <div class="col">User:</div>
            <div class="col">Status:</div>
            <div class="col">Aktionen</div>
        </div>

        <?php foreach ($orders as $order): ?>
        <div class="row">
                <div class="col">#<?php echo $order->id; ?></div>
                <div class="col"><?php echo $order->firstname . ' ' . $order->secondname; ?></div>
                <div class="col"><?php echo (empty($order->user_id)) ? 'Guest' : '#' . $order->user_id; ?></div>
                <div class="col"><?php echo $order->status; ?></div>
                <div class="col">
                    <a href="<?php echo BASE_URL . '/admin/order/' . $order->id . '/edit'; ?>" class="btn">Bearbeiten</a>
                </div>
        </div>
        <?php endforeach;?>

    </div>
</div>
