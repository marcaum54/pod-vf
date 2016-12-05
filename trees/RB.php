<?php

class RBTree
{
    public $root;
    public $nullLeaf;
    const BLACK = 0;
    const RED = 1;

    public function __construct()
    {
        $this->nullLeaf = new stdClass();
        $this->nullLeaf->size = 0;
        $this->root =& $this->nullLeaf;
    }

    private function leftRotate($node)
    {
        $y =& $node->right;
        $node->right =& $y->left;

        if ($y->left !== $this->nullLeaf){

            $y->left->p =& $node;
        }
        $y->p =& $node->p;
        if ($node->p === $this->nullLeaf){

            $this->root =& $y;
        } else if ($node === $node->p->left){

            $node->p->left =& $y;
        } else {

            $node->p->right =& $y;
        }
        $y->left =& $node;
        $node->p =& $y;
        $y->size = $node->size;
        $node->size = $node->left->size + $node->right->size + 1;
    }

    private function rightRotate($node)
    {
        $y =& $node->left;
        $node->left =& $y->right;

        if ($y->right !== $this->nullLeaf){

            $y->right->p =& $node;
        }
        $y->p =& $node->p;

        if ($node->p === $this->nullLeaf){

            $this->root =& $y;
        } else if ($node === $node->p->right){

            $node->p->right =& $y;
        } else {

            $node->p->left =& $y;
        }
        $y->right =& $node;
        $node->p =& $y;
    }

    private function newTreeNode($key)
    {
        $node = new stdClass();
        $node->key = $key;
        $node->color = self::RED;
        $node->p =& $this->nullLeaf;
        $node->left =& $this->nullLeaf;
        $node->right =& $this->nullLeaf;
        $node->size = 1;
        return $node;
    }

    public function inOrderWalk($node)
    {
        if ($node !== $this->nullLeaf) {

            $this->inOrderWalk($node->left);
            echo $node->key;
            $this->inOrderWalk($node->right);
        }
    }

    public function searchRecursive($node, $key)
    {
        if ($node === $this->nullLeaf || $node->key == $key) return $node;

        if ($key < $node->key) {

            return $this->searchRecursive($node->left, $key);
        } else {

            return $this->searchRecursive($node->right, $key);
        }
    }

    public function searchIterative ($node, $key)
    {
        while (!is_null($node) && $node->key != $key) {

            $node = ($key < $node->key) ?
                $node->left :
                $node->right;
        }
        return $node;
    }

    public function minimum($node)
    {
        while ($node->left !== $this->nullLeaf) {

            $node =& $node->left;
        }
        return $node;
    }

    public function maximum($node)
    {
        while ($node->right !== $this->nullLeaf) {

            $node =& $node->right;
        }
        return $node;
    }

    public function insert($key)
    {
        $y = null;
        $x =& $this->root;
        $node = $this->newTreeNode($key);

        while ($x !== $this->nullLeaf) {

            $x->size++;
            $y =& $x;
            if ($node->key < $x->key) {

                $x =& $x->left;
            } else $x =& $x->right;
        }

        $node->p =& $y;

        if (is_null($y)) {

            $this->root =& $node;
            $this->root->p =& $this->nullLeaf;

        } elseif ($node->key < $y->key) {

            $y->left =& $node;
        } else {

            $y->right =& $node;
        }
        $node->left =& $this->nullLeaf;
        $node->right =& $this->nullLeaf;
        $node->color = self::RED;
        $this->insertFixup($node);
    }

    private function insertFixup ($node)
    {
        while ($node->p !== $this->nullLeaf && $node->p->color === self::RED){

            if ($node->p === $node->p->p->left){

                $y =& $node->p->p->right;
                if ($y->color === self::RED){

                    $node->p->color = self::BLACK;
                    $y->color = self::BLACK;
                    $node->p->p->color = self::RED;
                    $node =& $node->p->p;
                } else {
                    if ($node === $node->p->right){
                        $node =& $node->p;
                        $this->leftRotate($node);
                    }
                    $node->p->color = self::BLACK;
                    $node->p->p->color = self::RED;
                    $this->rightRotate($node->p->p);
                }
            } else {

                $y =& $node->p->p->left;
                if ($y !== $this->nullLeaf && $y->color === self::RED){

                    $node->p->color = self::BLACK;
                    $y->color = self::BLACK;
                    $node->p->p->color = self::RED;
                    $node =& $node->p->p;
                } else {

                    if ($node === $node->p->left){

                        $node =& $node->p;
                        $this->rightRotate($node);
                    }
                    $node->p->color = self::BLACK;
                    $node->p->p->color = self::RED;
                    $this->leftRotate($node->p->p);
                }
            }
        }
        $this->root->color = self::BLACK;
    }

    public function successor ($node)
    {
        if ($node->right !== $this->nullLeaf) {

            return $this->minimum($node->right);
        }
        $y =& $node->p;

        while ($y !== $this->nullLeaf && $node === $y->right) {

            $node =& $y;
            $y =& $y->p;
        }
        return $y;
    }

    public function predecessor ($node)
    {
        if ($node->left != $this->nullLeaf) {

            return $this->maximum($node->left);
        }
        $y =& $node->p;

        while ($y !== $this->nullLeaf && $node === $y->left) {

            $node =& $y;
            $y =& $y->p;
        }
        return $y;
    }

    private function transPlant ($node, $y)
    {
        if ($node->p === $this->nullLeaf) {

            $this->root =& $y;
        } else if ($node === $node->p->left) {

            $node->p->left =& $y;
        } else {

            $node->p->right =& $y;
        }
        $y->p =& $node->p;
    }

    public function delete ($node)
    {
        $y = $node;
        $y_original_color = $y->color;

        if ($node->left === $this->nullLeaf) {

            $x =& $node->right;
            $this->transPlant($node, $node->right);

        } else if ($node->right === $this->nullLeaf) {

            $x =& $node->left;
            $this->transPlant($node, $node->left);
        } else {

            $y =& $this->minimum($node->right);

            $y_original_color = $y->color;
            $x = $y->right;

            if ($y->p === $node) {

                $x->p =& $y;
            } else {

                $this->transPlant($y, $y->right);
                $y->right =& $node->right;
                $y->right->p =& $y;
            }
            $this->transPlant($node, $y);
            $y->left =& $node->left;
            $y->left->p =& $y;
            $y->color = $node->color;
        }
        if ($y_original_color == self::BLACK) {

            $this->deleteFixup($x);
        }
    }

    private function deleteFixup($node)
    {
        while ($node !== $this->root && $node->color === self::BLACK)
        {
            if ($node === $node->p->left)
            {
                $w =& $node->p->right;

                if ($w->color === self::RED)
                {

                    $w->color = self::BLACK;
                    $node->p->color = self::RED;
                    $this->leftRotate($node->p);
                    $w =& $node->p->right;
                }

                if ($w->left->color === self::BLACK && $w->right->color === self::BLACK)
                {
                    $w->color = self::RED;
                    $node =& $node->p;
                }
                else
                {
                    if ($w->right->color === self::BLACK)
                    {
                        $w->left->color === self::BLACK;
                        $w->color = self::RED;
                        $this->rightRotate($w);
                        $w =& $node->p->right;
                    }

                    $w->color = $node->p->color;
                    $node->p->color = self::BLACK;
                    $w->right->color = self::BLACK;
                    $this->leftRotate($node->p);

                    $node =& $this->root;
                }
            }
            else
            {
                $w =& $node->p->left;

                if ($w->color === self::RED)
                {

                    $w->color = self::BLACK;
                    $node->p->color = self::RED;
                    $this->rightRotate($node->p);
                    $w =& $node->p->left;
                }

                if ($w->right->color === self::BLACK && $w->left->color === self::BLACK)
                {

                    $w->color = self::RED;
                    $node =& $node->p;
                }
                else
                {

                    if ($w->left->color === self::BLACK)
                    {
                        $w->right->color === self::BLACK;
                        $w->color = self::RED;
                        $this->leftRotate($w);
                        $w =& $node->p->left;
                    }

                    $w->color = $node->p->color;
                    $node->p->color = self::BLACK;
                    $w->left->color = self::BLACK;
                    $this->rightRotate($node->p);
                    $node =& $this->root;
                }
            }

            $node->color = self::BLACK;
        }
    }

    public function orderStatisticSelect($node, $iStat)
    {
        $rank = $node->left->size +1;

        if ($iStat === $rank)
            return $node;
        else if ($iStat < $rank)
            return $this->orderStatisticSelect($node->left, $iStat);

        return $this->orderStatisticSelect($node->right, $iStat - $rank);
    }

    public function orderStatisticRank($node)
    {
        $rank = $node->left->size +1;
        $tmpNode = $node;

        while( $tmpNode !== $this->root )
        {
            if( $tmpNode === $tmpNode->p->right)
                $rank = $rank + $tmpNode->p->left->size+1;

            $tmpNode = $tmpNode->p;
        }

        return $rank;
    }
}
