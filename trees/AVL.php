<?php

class AVLTree
{
    var $left;
    var $right;
    var $depth;
    var $data;

    function __construct()
    {
        $this->left  = NULL;
        $this->right = NULL;
        $this->depth = 0;
        $this->data  = NULL;
    }

    function balance()
    {
        $ldepth = $this->left !== NULL
            ? $this->left->depth
            : 0;

        $rdepth = $this->right !== NULL
            ? $this->right->depth
            : 0;


        if( $ldepth > $rdepth+1 )
        {
            $lldepth = $this->left->left !== NULL
                ? $this->left->left->depth
                : 0;

            $lrdepth = $this->left->right !== NULL
                ? $this->left->right->depth
                : 0;

            if( $lldepth < $lrdepth )
                $this->left->rotateRR();

            $this->rotateLL();
        }
        else if( $ldepth+1 < $rdepth )
        {
            $rrdepth = $this->right->right !== NULL
                ? $this->right->right->depth
                : 0;

            $rldepth = $this->right->left !== NULL
                ? $this->right->left->depth
                : 0;

            if( $rldepth > $rrdepth )
                $this->right->rotateLL();

            $this->rotateRR();
        }
    }

    function rotateLL()
    {
        $data_before =& $this->data;
        $right_before =& $this->right;

        $this->data  =& $this->left->data;
        $this->right =& $this->left;
        $this->left  =& $this->left->left;
        $this->right->left =& $this->right->right;
        $this->right->right =& $right_before;
        $this->right->data =& $data_before;
        $this->right->updateInNewLocation();

        $this->updateInNewLocation();
    }

    function rotateRR()
    {
        $data_before =& $this->data;
        $left_before =& $this->left;

        $this->data  =& $this->right->data;
        $this->left =& $this->right;
        $this->right  =& $this->right->right;
        $this->left->right =& $this->left->left;
        $this->left->left =& $left_before;
        $this->left->data =& $data_before;
        $this->left->updateInNewLocation();

        $this->updateInNewLocation();
    }

    function getDepthFromChildren()
    {
        $this->depth = $this->data !== NULL ? 1 : 0;

        if( $this->left !== NULL )
            $this->depth = $this->left->depth+1;

        if( $this->right !== NULL && $this->depth <= $this->right->depth )
            $this->depth = $this->right->depth+1;
    }

    function updateInNewLocation()
    {
        $this->getDepthFromChildren();
    }
}
