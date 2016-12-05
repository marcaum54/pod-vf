<?php
    include_once 'config.php';
    include_once 'functions.php';

    if( isset( $_REQUEST['action'] ) )
    {
        if( $_REQUEST['action'] === 'upload' )
        {
            $csv = decode_csv_file();

            extract( $csv );

            csv_is_valid( $csv );

            $tree = treeFactory( $type );

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
    }
