<?php

    function decode_csv_file()
    {
        $str = trim(file_get_contents($_FILES['arquivo']['tmp_name']));
        $array = str_getcsv($str);

        $tipo = $array[0];
        $quantidade = $array[1];
        $elementos = array_slice($array, 2, $quantidade);

        return compact('tipo', 'quantidade', 'elementos');
    }

    function csv_is_valid($csv)
    {
        $tipos_aceitos = [
            'rubro-negro',
            'rubro negro',
            'rubro-negra',
            'rubro negra',
            'binaria',
            'binario',
            'avl'
        ];

        if( ! in_array( strtolower($csv['tipo']), $tipos_aceitos ) )
            throw new \Exception('O tipo informado não é aceito, segue lista: <b>'. implode(', ', $tipos_aceitos) .'</b>.');
    }

    set_exception_handler(function($e)
    {
        include_once 'error.php';
    });