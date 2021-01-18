<?php declare(strict_types=1);

namespace Jorpo\Tree;

use Ds\Vector;

class Node
{
    /**
     * @var mixed|null
     */
    private $value;

    private Vector $children;

    private Node $parent;

    /**
     * @param mixed|null $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
        $this->children = new Vector;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param Node $child
     */
    public function addChild(Node $child)
    {
        $this->children->push($child);
        $child->setParent($this);
    }

    public function setChildren(Node ...$children)
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

    public function removeChildren()
    {
        $this->children->clear();
    }

    public function getChildren(): Vector
    {
        return $this->children;
    }

    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): Node
    {
        return $this->parent;
    }

    public function isLeaf(): bool
    {
        return $this->children->isEmpty();
    }

    public function isBranch(): bool
    {
        return !$this->children->isEmpty();
    }

    public function isChild(): bool
    {
        return !empty($this->parent);
    }

    public function isRoot(): bool
    {
        return empty($this->parent);
    }

    public function getRoot(): Node
    {
        $node = $this;

        while ($node->isChild() && $parent = $node->getParent()) {
            $node = $parent;
        }

        return $node;
    }

    public function getAncestors(): Vector
    {
        $ancestors = new Vector;
        $node = $this;

        while ($node->isChild() && $parent = $node->getParent()) {
            $ancestors->push($parent);
            $node = $parent;
        }

        return $ancestors;
    }

    public function getAncestorsAndSelf(): Vector
    {
        $ancestors = $this->getAncestors();
        $ancestors->unshift($this);

        return $ancestors;
    }

    public function getSiblings(): Vector
    {
        $siblings = $this->getParent()->getChildren();
        $current = $this;

        return $siblings->filter(function ($sibling) use ($current) {
            return $sibling != $current;
        });
    }

    public function getSiblingsAndSelf(): Vector
    {
        return $this->getParent()->getChildren();
    }

    public function getSize(): int
    {
        $size = 1;

        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    public function getDepth(): int
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    public function getHeight(): int
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
