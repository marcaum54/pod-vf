<?php

class BinaryTree
{
    private $_root;

    public function __construct()
    {
        $this->_root = new BinaryNode(null);
    }

    public function getRoot() {
        return $this->hasNode() ? $this->_root->right : null;
    }

    public function insert(BinaryNode $node) {
        $this->_root->insert($node);
        return $this;
    }

    public function detect(BinaryNode $node) {
        return $this->hasNode() ? $this->_root->detect($node) : false;
    }

    public function delete(BinaryNode $node) {
        return $this->hasNode() ? $this->_root->delete($node, $this->_root, 'right') : false;
    }

    public function hasNode() {
        return (bool)$this->_root->right;
    }

    public function printTree()
    {
        if ($this->hasNode())
        {
            $current_level[] = $this->_root->right;
            $next_level = array();

            while (!empty($current_level))
            {
                $node = array_shift($current_level);

                if ($node)
                {
                    array_push($next_level, $node->left, $node->right);
                    echo $node->val . ' ';
                }

                if (empty($current_level) && !empty($next_level))
                {
                    echo "\n";
                    list($current_level, $next_level) = array($next_level, $current_level);
                }
            }
        }
    }
}

class BinaryNode
{
    public $val;
    public $left = null;
    public $right = null;

    public function __construct($val)
    {
        $this->val = $val;
    }

    public function delete(BinaryNode $node, BinaryNode $parent=null, $left_right='')
    {
        if ($node->val > $this->val)
        {
            return $this->right && $this->right->delete($node, $this, 'right');
        }
        elseif ($node->val < $this->val)
        {
            return $this->left && $this->left->delete($node, $this, 'left');
        }
        else
        {
            if ($this->left)
            {
                $parent->$left_right = $this->left;
                $this->right && $this->left->insert($this->right);
            }
            elseif ($this->right)
            {
                $parent->$left_right = $this->right;
                $this->left && $this->right->insert($this->left);
            }
            else
            {
                $parent->$left_right = null;
            }

            return true;
        }
    }

    public function detect(BinaryNode $node)
    {
        if ($node->val > $this->val)
        {
            return $this->right && $this->right->detect($node);
        }
        elseif ($node->val < $this->val)
        {
            return $this->left && $this->left->detect($node);
        }
        else
        {
            return true;
        }
    }

    public function insert(BinaryNode $node)
    {
        if ($node->val > $this->val)
        {
            $this->right ? $this->right->insert($node) : ($this->right = $node);
        }
        elseif ($node->val < $this->val)
        {
            $this->left ? $this->left->insert($node) : ($this->left = $node);
        }
        else
        {
            return false;
        }
    }
}
