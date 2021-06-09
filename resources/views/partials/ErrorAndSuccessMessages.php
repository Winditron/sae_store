<?php foreach (Core\Session::getAndForget('success', []) as $success): ?>
    <div class="form-success"><?php echo $success; ?></div>
<?php endforeach;?>

<?php foreach (Core\Session::getAndForget('errors', []) as $error): ?>
    <div class="form-error"><?php echo $error; ?></div>
<?php endforeach;?>