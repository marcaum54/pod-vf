<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>FA7 - POD - VF 2016.02</title>

        <!-- CSS -->
        <link rel="stylesheet" href="assets/bootstrap/css/min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/theme.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/min.css">

        <link rel="stylesheet" href="assets/my-project/css/main.css">
    </head>
    <body>

        <header class="page-header">
            <h1 class="text-center">POD - VF <small>2016.02</small></h1>
        </header>

        <div class="container">

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
        </div>

        <!-- JS -->
        <script src="assets/jquery/js/min.js"></script>
        <script src="assets/bootstrap/js/min.js"></script>

        <script src="assets/my-project/js/main.js"></script>
    </body>
</html>