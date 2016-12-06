<?php

    function redirect($url)
    {
        return header('Location: '. $url);
    }

    function decode_csv_file()
    {
        $str = trim(file_get_contents($_FILES['arquivo']['tmp_name']));
        $array = str_getcsv($str);

        $type = $array[0];
        $qty = $array[1];
        $elements = array_slice($array, 2, $qty);

        return compact('type', 'qty', 'elements');
    }

    function decode_csv_insert_file()
    {
        $str = trim(file_get_contents($_FILES['arquivo']['tmp_name']));
        $elements = str_getcsv($str);

        return compact('elements');
    }

    function csv_is_valid($csv)
    {
        $typeAllowed = [
            'rubro-negro',
            'rubro negro',
            'rubro-negra',
            'rubro negra',
            'rb',
            'binaria',
            'binario',
            'binary',
            'avl'
        ];

        if( ! in_array( strtolower($csv['type']), $typeAllowed ) )
            throw new \Exception('O tipo informado não é aceito, segue lista: <b>'. implode(', ', $typeAllowed) .'</b>.');
    }

    function treeFactory($type)
    {
        switch( strtolower( $type ) )
        {
            case 'rubro-negro':
            case 'rubro negro':
            case 'rubro-negra':
            case 'rubro negra':
            case 'rb':
                $class = 'RBTree';
                break;
            case 'binary':
            case 'binario':
            case 'binaria':
                $class = 'BinaryTree';
                break;
            case 'avl':
                $class = 'BinaryTree';
                break;
        }

        return new $class();
    }

    function insertFactory(&$tree, $elements)
    {
        if( $tree instanceof BinaryTree)
        {
            foreach( $elements as $element )
                $tree->insert( $element );
        }

        if( $tree instanceof AVLTree )
        {

        }

        if( $tree instanceof RBTree )
        {

        }
    }

