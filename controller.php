<?php
    include_once 'config.php';
    include_once 'functions.php';

    if( isset( $_REQUEST['action'] ) )
    {
        //UPLOAD
        if( $_REQUEST['action'] === 'upload' )
        {
            $csv = decode_csv_file();

            csv_is_valid( $csv );
            
        }
    }
