<?php include_once 'partials/layout/header.php' ?>

    <div class="well">
        <div class="container">
            <p>O arquivo deve seguir o seguinte modelo:</p>
            <ul>
                <li>ARVORE(domínio: Binaria, AVL e Rubro Negra),</li>
                <li>Nº valores,</li>
                <li>Valor 1,</li>
                <li>Valor 2,</li>
            </ul>
        </div>
    </div>

    <form action="controller.php?action=upload" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="arquivo" id="arquivo">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>

<?php include_once 'partials/layout/footer.php' ?>
