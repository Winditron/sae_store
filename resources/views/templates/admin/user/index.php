<div class="user-list">

<div class="user table">
    <div class="row table-headline">
        <div class="col">Kontonummer:</div>
        <div class="col">Name:</div>
        <div class="col">Email:</div>
        <div class="col">Administrator:</div>
        <div class="col">Aktionen</div>
    </div>
</div>
<?php foreach ($users as $user): ?>
<div class="row">
        <div class="col"><?php echo $user->id; ?></div>
        <div class="col"><?php echo (!empty($user->firstname) && !empty($user->secondname)) ? $user->firstname . ' ' . $user->secondname : '-'; ?></div>
        <div class="col"><?php echo $user->email; ?></div>
        <div class="col"><?php echo ((bool) $user->is_admin) ? 'true' : 'false'; ?></div>
        <div class="col">
            <a href="<?php echo BASE_URL . '/admin/user/' . $user->id . '/edit'; ?>" class="btn">Bearbeiten</a>

            <?php if (App\Models\User::getLoggedIn()->id !== $user->id): ?>
                <a href="<?php echo BASE_URL . '/admin/user/' . $user->id . '/delete/confirm'; ?>" class="btn danger">Löschen</a>
            <?php endif;?>

        </div>
</div>
<?php endforeach;?>

</div>
