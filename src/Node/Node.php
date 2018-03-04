<?php

namespace Jorpo\Tree\Node;

use Ds\Vector;

class Node
{
    /**
     * @var mixed|null
     */
    private $value;

    /**
     * @var Vector
     */
    private $children;

    /**
     * @var Node
     */
    private $parent;

    /**
     * @param mixed|null $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
        $this->children = new Vector;
    }

    /**
     * Set a value
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of the node
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add a child node
     *
     * @param Node $child
     */
    public function addChild(Node $child)
    {
        $this->children->push($child);
        $child->setParent($this);
    }

    /**
     * Set the children to an array of nodes
     *
     * @param array $children
     */
    public function setChildren(array $children)
    {
        $this->children->clear();

        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    public function removeChild(Node $child)
    {
        foreach ($this->children as $index => $myChild) {
            if ($child == $myChild) {
                $this->children->remove($index);
            }
        }
    }

    /**
     * Remove all child nodes
     */
    public function removeChildren()
    {
        $this->children->clear();
    }

    /**
     * Get all child nodes
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set a parent node
     *
     * @param Node $parent
     */
    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent node
     *
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Whether this node is a leaf
     *
     * @return boolean
     */
    public function isLeaf()
    {
        return $this->children->isEmpty();
    }

    /**
     * Whether this node is a branch
     *
     * @return boolean
     */
    public function isBranch()
    {
        return !$this->children->isEmpty();
    }

    /**
     * Whether this node is a child
     *
     * @return boolean
     */
    public function isChild()
    {
        return null !== $this->parent;
    }

    /**
     * Whether this node is a root
     *
     * @return boolean
     */
    public function isRoot()
    {
        return null === $this->parent;
    }

    /**
     * Get the root node
     *
     * @return Node
     */
    public function getRoot()
    {
        $node = $this;

        while ($parent = $node->getParent()) {
            $node = $parent;
        }

        return $node;
    }

    /**
     * Get any ancestor nodes in order of closest to furthest away
     *
     * @return array
     */
    public function getAncestors()
    {
        $ancestors = new Vector;
        $node = $this;

        while ($parent = $node->getParent()) {
            $ancestors->push($parent);
            $node = $parent;
        }

        return $ancestors;
    }

    /**
     * Get any ancestor nodes (including self) in order of closest to furthest away
     *
     * @return array
     */
    public function getAncestorsAndSelf()
    {
        $ancestors = $this->getAncestors();
        $ancestors->unshift($this);

        return $ancestors;
    }

    /**
     * Get any sibling nodes on the same branch
     *
     * @return array
     */
    public function getSiblings()
    {
        $siblings = $this->getParent()->getChildren();
        $current = $this;

        return $siblings->filter(function ($sibling) use ($current) {
            return $sibling != $current;
        });
    }

    /**
     * Get any sibling nodes (including self) on the same branch
     *
     * @return array
     */
    public function getSiblingsAndSelf()
    {
        return $this->getParent()->getChildren();
    }

    /**
     * Get the size of the tree from this node forwards
     *
     * @return int
     */
    public function getSize()
    {
        $size = 1;

        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    /**
     * Get the depth of the tree from this node backwards
     *
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    /**
     * Get the height of the tree from this node forwards
     *
     * @return int
     */
    public function getHeight()
    {
        if ($this->isLeaf()) {
            return 0;
        }

        $heights = [];

        foreach ($this->getChildren() as $child) {
            $heights[] = $child->getHeight();
        }

        return max($heights) + 1;
    }
}
