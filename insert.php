<?php include_once 'config.php'; ?>

<?php include_once 'partials/layout/header.php' ?>

<h3>Elementos atuais da árvore: <span class="text-primary"><?php echo implode(', ', $_SESSION['csv']['elements']); ?></span>.</h3>
<br/>

<?php include_once 'partials/forms/insert.php'; ?>

<?php include_once 'partials/layout/footer.php' ?>
