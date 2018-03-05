<?php

namespace Jorpo\Tree;

use Ds\Stack;
use Jorpo\Tree\Node;

class TreeBuilder
{
    /**
     * @var Stack
     */
    private $stack;

    /**
     * @param Node $node
     */
    public function __construct($node = null)
    {
        $this->stack = new Stack;

        $this->setRootNode($node ?? $this->nodeFromValue());
    }

    /**
     * Set the initial node for the tree
     *
     * @param Node $node
     */
    public function setRootNode(Node $node)
    {
        $this->emptyStack()->pushNode($node);

        return $this;
    }

    /**
     * Get the last node from the stack
     */
    public function getCurrentNode()
    {
        return $this->stack->peek();
    }

    /**
     * Add a leaf node
     */
    public function leaf($value = null)
    {
        $this->getCurrentNode()->addChild(
            $this->nodeFromValue($value)
        );

        return $this;
    }

    /**
     * Add multiple leaf nodes
     */
    public function leaves(...$values)
    {
        foreach ($values as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    /**
     * Add a branch down to another level
     */
    public function branch($value = null)
    {
        $this->getCurrentNode()->addChild($node = $this->nodeFromValue($value));
        $this->pushNode($node);

        return $this;
    }

    /**
     * End a current branch
     */
    public function end()
    {
        $this->popNode();

        return $this;
    }

    /**
     * Create a node instance from a value
     */
    public function nodeFromValue($value = null)
    {
        return new Node($value);
    }

    /**
     * Set the value of the root node
     */
    public function value($value)
    {
        $this->getCurrentNode()->setValue($value);

        return $this;
    }

    private function emptyStack()
    {
        $this->stack->clear();

        return $this;
    }

    private function pushNode(Node $node)
    {
        $this->stack->push($node);

        return $this;
    }

    private function popNode()
    {
        return $this->stack->pop();
    }
}
