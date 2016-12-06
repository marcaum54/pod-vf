<form action="controller.php?action=insert" method="post" enctype="multipart/form-data">
    <h3>Elementos atuais da árvore: <span class="text-primary"><?php echo implode(', ', $_SESSION['csv']['elements']); ?></span>.</h3>
    <br/>
    <h4>Selecione um arquivo com os elementos a serem inseridos:</h4>
    <div class="form-group">
        <input type="file" name="arquivo" id="arquivo">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Enviar</button>
    </div>
</form>
