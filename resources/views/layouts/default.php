<?php require_once __DIR__ . '/../partials/html/head.php';?>

<body>

<main>
    <!--
    In der View-Klasse definieren wir, welches Template geladen werden soll. Der eigentliche Vorgang des Ladens passiert
     hier.
     -->
    <?php require_once $renderTemplate;?>
</main>

<?php require_once __DIR__ . '/../partials/html/footer.php';?>
