<div class="row">
    <div class="col checkout-login">
        <form action="<?php echo BASE_URL . '/checkout/1/login'; ?>" method="POST">
            <?php require __DIR__ . "/../../partials/authentication/loginform.php";?>
        </form>
    </div>
    <div class="col checkout-guest">
        <h2>Weiter als Gast?</h2>
        <a href="<?php echo BASE_URL . '/checkout/2'; ?>" class="btn">Als Gast weiter</a>
    </div>
</div>