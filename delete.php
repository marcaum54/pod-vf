<?php include_once 'config.php'; ?>

<?php include_once 'partials/layout/header.php' ?>

<h3>Você deseja excluir quais elementos?</h3>

<form action="">
    <ul class="list-group">
        <?php foreach($_SESSION['csv']['merged'] as $element): ?>
            <li class="list-group-item">
                <label style="display: block;"><?php echo $element; ?> <input type="checkbox" name="elements[]" value="<?php echo $element; ?>"></label>
            </li>
        <?php endforeach; ?>
    </ul>
</form>


<?php include_once 'partials/layout/footer.php' ?>