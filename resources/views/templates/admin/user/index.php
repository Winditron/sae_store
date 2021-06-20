<div class="user-list">

<div class="user table">
    <div class="row table-headline">
        <div class="item">Kontonummer:</div>
        <div class="item">Name:</div>
        <div class="item">Email:</div>
        <div class="item">Administrator:</div>
        <div class="item">Aktionen</div>
    </div>
</div>
<div class="row">
    <?php foreach ($users as $user): ?>
        <div class="item"><?php echo $user->id; ?></div>
        <div class="item"><?php echo (!empty($user->firstname) && !empty($user->secondname)) ? $user->firstname . ' ' . $user->secondname : '-'; ?></div>
        <div class="item"><?php echo $user->email; ?></div>
        <div class="item"><?php echo ((bool) $user->is_admin) ? 'true' : 'false'; ?></div>
        <div class="item">
            <a href="<?php echo BASE_URL . '/admin/user/' . $user->id . '/edit'; ?>" class="btn">Bearbeiten</a>

            <?php if (App\Models\User::getLoggedIn()->id !== $user->id): ?>
                <a href="<?php echo BASE_URL . '/admin/user/' . $user->id . '/delete/confirm'; ?>" class="btn danger">Löschen</a>
            <?php endif;?>

        </div>
    <?php endforeach;?>
</div>

</div>
