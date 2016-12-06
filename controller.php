<?php
    include_once 'config.php';

    if( isset( $_REQUEST['action'] ) )
    {
        if( $_REQUEST['action'] === 'upload' )
        {
            $csv = decode_csv_file();

            csv_is_valid( $csv );

            extract( $csv );

            $tree = treeFactory( $type );

            insertFactory($tree, $elements);

            $_SESSION['csv']['tree'] = $tree;
            sort($elements);
            $_SESSION['csv']['elements'] = $elements;

            return redirect('insert.php');
        }

        if( $_REQUEST['action'] === 'insert' )
        {
            $tree = $_SESSION['csv']['tree'];
            $csv = decode_csv_insert_file();
            extract( $csv );

            insertFactory($tree, $elements);

            $_SESSION['csv']['tree'] = $tree;
            sort($elements);
            $_SESSION['csv']['inserted'] = $elements;
            $merged = array_merge( $_SESSION['csv']['elements'], $_SESSION['csv']['inserted'] );
            sort($merged);
            $_SESSION['csv']['merged'] = $merged;

            return redirect('delete.php');
        }

        if( $_REQUEST['action'] === 'delete' )
        {

        }

        if( $_REQUEST['action'] === 'download' )
        {

        }

        if( $_REQUEST['action'] === 'reset' )
        {
            session_destroy();
            return redirect('index.php');
        }
    }
