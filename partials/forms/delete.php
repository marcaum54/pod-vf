<form method="post" action="controller.php?action=delete">
    <h3 class="text-center">Você deseja excluir quais elementos?</h3>

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <ul class="list-group list-unstyled">
                <?php foreach($_SESSION['csv']['merged'] as $element): ?>
                <li class="list-group-item text-center">
                    <label style="display: block"><div class="pull-left"><input type="checkbox" name="elements[]" value="<?php echo $element; ?>"></div> <?php echo $element; ?> </label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-primary"><i class="fa fa-check-square-o"></i> Excluir elementos selecionados</button>
    </div>
</form>