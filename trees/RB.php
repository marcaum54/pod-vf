<?php

class RBNode
{
    const COLOR_BLACK = 0;
    const COLOR_RED = 1;
    public $color = self::COLOR_BLACK;

    public $key = null;
    public $value = null;
    public $left = null;
    
    public $right = null;
    public $parent = null;
}

class RBTree
{
    protected $DEBUG = false;
    protected $root = null;
    protected $nil = null;

    
    public function __construct()
    {
        $this->nil = new RBNode();
        $this->nil->left = $this->nil->right = $this->nil->parent = $this->nil;
        $this->root = $this->nil;
    }
    
    public function isNil( RBTree $tree, RBNode $x )
    {
        return ( $tree->nil === $x );
    }
    
    public function setDebug( $debug )
    {
        if ( !is_bool( $debug ) )
            throw new InvalidArgumentException( __METHOD__.'() debug must be a boolean' );

        $this->DEBUG = $debug;
    }
    
    public function insert( RBTree $tree, RBNode $x )
    {

        $this->binaryTreeInsert( $tree, $x );

        $newNode = $x;
        $x->color = RBNode::COLOR_RED;
        while ( $x->parent->color === RBNode::COLOR_RED )
        {
            if ( $x->parent === $x->parent->parent->left )
            {
                $y = $x->parent->parent->right;
                if ( $y->color === RBNode::COLOR_RED )
                {
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $y->color = RBNode::COLOR_BLACK;
                    $x->parent->parent->color = RBNode::COLOR_RED;
                    $x = $x->parent->parent;
                }
                else
                {
                    if ( $x === $x->parent->right )
                    {
                        $x = $x->parent;
                        $this->leftRotate( $tree, $x );
                    }
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $x->parent->parent->color = RBNode::COLOR_RED;
                    $this->rightRotate( $tree, $x->parent->parent );
                }
            }
            else
            {
                $y = $x->parent->parent->left;
                if ( $y->color === RBNode::COLOR_RED )
                {
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $y->color = RBNode::COLOR_BLACK;
                    $x->parent->parent->color = RBNode::COLOR_RED;
                    $x = $x->parent->parent;
                }
                else
                {
                    if ( $x === $x->parent->left )
                    {
                        $x = $x->parent;
                        $this->rightRotate( $tree, $x );
                    }
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $x->parent->parent->color = RBNode::COLOR_RED;
                    $this->leftRotate( $tree, $x->parent->parent );
                }
            }
        }

        $tree->root->left->color = RBNode::COLOR_BLACK;

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
            assert( $tree->root->color === RBNode::COLOR_BLACK );
        }

        return $newNode;
    }
    
    public function treeSuccessor( RBTree $tree, RBNode $x )
    {
        $nil = $tree->nil;
        $root = $tree->root;
        if ( ( $y = $x->right ) !== $nil )
        {
            while ( $y->left !== $nil )
            {
                $y = $y->left;
            }
            return $y;
        }
        else
        {
            $y = $x->parent;
            while ( $x === $y->right )
            {
                $x = $y;
                $y = $y->parent;
            }
            if ( $y === $root )
                return $nil;

            return $y;
        }
    }
    
    public function treePredecessor( RBTree $tree, RBNode $x )
    {
        $nil = $tree->nil;
        $root = $tree->root;
        if ( ( $y = $x->left ) !== $nil )
        {
            while ( $y->right !== $nil )
            {
                $y = $y->right;
            }
            return $y;
        }
        else
        {
            $y = $x->parent;
            while ( $x === $y->left )
            {
                if ( $y === $root )
                    return $nil;

                $x = $y;
                $y = $y->parent;
            }
            return $y;
        }
    }
    
    public function inorderTreePrint( RBTree $tree, RBNode $x )
    {
        $nil = $tree->nil;
        $root = $tree->root;

        if ( $x !== $tree->nil )
        {
            $this->inorderTreePrint( $tree, $x->left );

            echo "info=  key=".var_export( $x->key, true );

            echo "  l->key=";
            if ( $x->left === $nil )
            {
                echo "NULL";
            }
            else
            {
                echo var_export( $x->left->key, true );
            }

            echo "  r->key=";
            if ( $x->right === $nil )
            {
                echo "NULL";
            }
            else
            {
                echo var_export( $x->right->key, true );
            }

            echo "  p->key=";
            if ( $x->parent === $root )
            {
                echo "NULL";
            }
            else
            {
                echo var_export( $x->parent->key, true );
            }

            echo "  red=";
            if ( $x->color === RBNode::COLOR_RED )
            {
                echo "1";
            }
            else
            {
                echo "0";
            }

            echo "\n";
            $this->inorderTreePrint( $tree, $x->right );
        }
    }
    
    public function printTree( RBTree $tree )
    {
        $this->inorderTreePrint( $tree, $tree->root->left );
    }
    
    public function findKey( RBTree $tree, $q )
    {
        $x = $tree->root->left;
        $nil = $tree->nil;

        if ( $x === $nil )
            return false;

        $isEqual = $this->compare( $x->key, $q );

        while ( $isEqual !== 0 )
        {
            if ( $isEqual === 1 )
            {
                $x = $x->left;
            }
            else
            {
                $x = $x->right;
            }

            if ( $x === $nil )
                return false;

            $isEqual = $this->compare( $x->key, $q );
        }

        return $x;
    }
    
    public function delete( RBTree $tree, RBNode $z )
    {
        $nil = $tree->nil;
        $root = $tree->root;

        if ( ( $z->left === $nil ) || ( $z->right === $nil ) )
        {
            $y = $z;
        }
        else
        {
            $y = $this->treeSuccessor( $tree, $z );
        }

        if ( $y->left === $nil )
        {
            $x = $y->right;
        }
        else
        {
            $x = $y->left;
        }

        if ( $root === ( $x->parent = $y->parent ) )
        {
            $root->left = $x;
        }
        else
        {
            if ( $y === $y->parent->left )
            {
                $y->parent->left = $x;
            }
            else
            {
                $y->parent->right = $x;
            }
        }

        if ( $y !== $z )
        {

            if ( $this->DEBUG )
            {
                assert( $y !== $tree->nil );
            }

            if ( $y->color === RBNode::COLOR_BLACK )
                $this->deleteFixUp( $tree, $x );

            $y->left = $z->left;
            $y->right = $z->right;
            $y->parent = $z->parent;
            $y->color = $z->color;
            $z->left->parent = $z->right->parent = $y;

            if ( $z === $z->parent->left )
            {
                $z->parent->left = $y;
            }
            else
            {
                $z->parent->right = $y;
            }
            $z = null;
            unset( $z );
        }
        else
        {
            if ( $y->color === RBNode::COLOR_BLACK )
                $this->deleteFixUp( $tree, $x );

            $y = null;
            unset( $y );
        }

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
        }
    }
    
    public function enumerate( RBTree $tree, $low, $high )
    {
        $return = array();
        $nil = $tree->nil;
        $x = $tree->root->left;
        $lastBest = $nil;
        while ( $x !== $nil )
        {
            if ( $this->compare( $x->key, $high ) === 1 )
            {
                $x = $x->left;
            }
            else
            {
                $lastBest = $x;
                $x = $x->right;
            }
        }

        while ( ( $lastBest !== $nil ) && ( $this->compare( $low, $lastBest->key ) !== 1 ) )
        {
            $return[] = $lastBest;
            $lastBest = $this->treePredecessor( $tree, $lastBest );
        }

        $return = array_reverse( $return );
        return $return;
    }
    
    protected function leftRotate( RBTree $tree, RBNode $x )
    {

        $nil = $tree->nil;

        $y = $x->right;
        $x->right = $y->left;

        if ( $y->left !== $nil )
        {
            $y->left->parent = $x;
        }

        $y->parent = $x->parent;

        if ( $x === $x->parent->left )
        {
            $x->parent->left = $y;
        }
        else
        {
            $x->parent->right = $y;
        }

        $y->left = $x;
        $x->parent = $y;

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
        }
    }
    
    protected function rightRotate( RBTree $tree, RBNode $y )
    {
        $nil = $tree->nil;

        $x = $y->left;
        $y->left = $x->right;

        if ( $x->right !== $nil )
        {
            $x->right->parent = $y;
        }

        $x->parent = $y->parent;

        if ( $y === $y->parent->left )
        {
            $y->parent->left = $x;
        }
        else
        {
            $y->parent->right = $x;
        }

        $x->right = $y;
        $y->parent = $x;

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
        }
    }
    
    protected function binaryTreeInsert( RBTree $tree, RBNode $z )
    {
        $nil = $tree->nil;
        
        $z->left = $z->right = $nil;

        $y = $tree->root;
        $x = $tree->root->left;

        while ( $x !== $nil )
        {
            $y = $x;
            if ( $this->compare( $x->key, $z->key ) === 1 )
            {
                $x = $x->left;
            }
            else
            {
                $x = $x->right;
            }
        }

        $z->parent = $y;

        if ( ( $y === $tree->root ) || ( $this->compare( $y->key, $z->key ) === 1 ) )
        {
            $y->left = $z;
        }
        else
        {
            $y->right = $z;
        }

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
        }
    }
    
    protected function deleteFixUp( RBTree $tree, RBNode $x )
    {
        $root = $tree->root->left;

        while ( ( $x->color === RBNode::COLOR_BLACK ) && ( $root !== $x ) )
        {
            if ( $x === $x->parent->left )
            {
                $w = $x->parent->right;
                if ( $w->color === RBNode::COLOR_RED )
                {
                    $w->color = RBNode::COLOR_BLACK;
                    $x->parent->color = RBNode::COLOR_RED;
                    $this->leftRotate( $tree, $x->parent );
                    $w = $x->parent->right;
                }

                if ( ( $w->right->color === RBNode::COLOR_BLACK ) &&
                    ( $w->left->color === RBNode::COLOR_BLACK ) )
                {
                    $w->color = RBNode::COLOR_RED;
                    $x = $x->parent;
                }
                else
                {
                    if ( $w->right->color === RBNode::COLOR_BLACK )
                    {
                        $w->left->color = RBNode::COLOR_BLACK;
                        $w->color = RBNode::COLOR_RED;
                        $this->rightRotate( $tree, $w );
                        $w = $x->parent->right;
                    }
                    $w->color = $x->parent->color;
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $w->right->color = RBNode::COLOR_BLACK;
                    $this->leftRotate( $tree, $x->parent );
                    $x = $root;
                }
            }
            else
            {
                $w = $x->parent->left;
                if ( $w->color === RBNode::COLOR_RED )
                {
                    $w->color = RBNode::COLOR_BLACK;
                    $x->parent->color = RBNode::COLOR_RED;
                    $this->rightRotate( $tree, $x->parent );
                    $w = $x->parent->left;
                }

                if ( ( $w->right->color === RBNode::COLOR_BLACK ) &&
                    ( $w->left->color === RBNode::COLOR_BLACK ) )
                {
                    $w->color = RBNode::COLOR_RED;
                    $x = $x->parent;
                }
                else
                {
                    if ( $w->left->color === RBNode::COLOR_BLACK )
                    {
                        $w->right->color = RBNode::COLOR_BLACK;
                        $w->color = RBNode::COLOR_RED;
                        $this->leftRotate( $tree, $w );
                        $w = $x->parent->left;
                    }
                    $w->color = $x->parent->color;
                    $x->parent->color = RBNode::COLOR_BLACK;
                    $w->left->color = RBNode::COLOR_BLACK;
                    $this->rightRotate( $tree, $x->parent );
                    $x = $root;
                }
            }
        }
        $x->color = RBNode::COLOR_BLACK;

        if ( $this->DEBUG )
        {
            assert( $tree->nil->color === RBNode::COLOR_BLACK );
        }
    }
    
    protected function compare( $key1, $key2 )
    {
        if ( !is_scalar( $key1 ) || is_bool( $key1 ) || !is_scalar( $key2 ) || is_bool( $key2 ) )
            throw new InvalidArgumentException( __METHOD__.'() keys must be a string or numeric' );

        $returnValue = null;

        switch ( true )
        {
            case ( is_numeric( $key1 ) && is_numeric( $key2 ) ):
                if ( $key1 > $key2 )
                {
                    $returnValue = 1;
                }
                else
                {
                    $returnValue = ( $key1 === $key2 ) ? 0 : -1;
                }
                return $returnValue;


        }

        $returnValue = strcmp( "$key1", "$key2" );

        if ( $returnValue > 0 )
            return 1;

        if ( $returnValue < 0 )
            return -1;

        return 0;
    }
}