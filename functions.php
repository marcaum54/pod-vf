<?php

    function decode_csv_file()
    {
        $str = trim(file_get_contents($_FILES['arquivo']['tmp_name']));
        $array = str_getcsv($str);

        $type = $array[0];
        $qty = $array[1];
        $elements = array_slice($array, 2, $qty);

        return compact('type', 'qty', 'elements');
    }

    function csv_is_valid($csv)
    {
        $typeAllowed = [
            'rubro-negro',
            'rubro negro',
            'rubro-negra',
            'rubro negra',
            'binaria',
            'binario',
            'avl'
        ];

        if( ! in_array( strtolower($csv['type']), $typeAllowed ) )
            throw new \Exception('O tipo informado não é aceito, segue lista: <b>'. implode(', ', $typeAllowed) .'</b>.');
    }

    set_exception_handler(function($e)
    {
        include_once 'error.php';
    });