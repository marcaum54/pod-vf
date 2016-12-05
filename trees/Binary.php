<?php

class BinaryNode
{
    public $value;
    public $left;
    public $right;

    public function __construct($item)
    {
        $this->value = $item;

        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    protected $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function isEmpty()
    {
        return $this->root === null;
    }

    public function insert($item)
    {
        $node = new BinaryNode($item);

        if ($this->isEmpty())
            $this->root = $node;
        else
            $this->insertNode($node, $this->root);
    }

    protected function insertNode($node, &$subtree)
    {
        if ($subtree === null)
            $subtree = $node;

        if ($node->value > $subtree->value)
        {
            $this->insertNode($node, $subtree->right);
        }
        else if ($node->value < $subtree->value)
        {
            $this->insertNode($node, $subtree->left);
        }
    }
}
