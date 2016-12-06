<?php include_once 'config.php'; ?>

<?php include_once 'partials/layout/header.php' ?>

<div class="text-center">
    <h3>Elementos restantes: <span class="text-primary"><?php echo implode(', ', $_SESSION['csv']['deleted']); ?></span></h3>
    <a target="_blank" href="controller.php?action=download" class="btn btn-primary"><i class="fa fa-download"></i> Fazer download .CSV</a>
</div>

<?php include_once 'partials/layout/footer.php' ?>
