<?php

namespace Jorpo\Tree\Builder;

use Jorpo\Tree\Node\Node;

class Builder
{
    /**
     * @var Node[]
     */
    private $stack;

    /**
     * @param Node $node
     */
    public function __construct($node = null)
    {
        $this->stack = [];

        $this->setRootNode($node ?: $this->nodeInstanceByValue());
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
        return $this->stack[count($this->stack) - 1];
    }

    /**
     * Add a leaf node
     */
    public function leaf($value = null)
    {
        $this->getCurrentNode()->addChild(
            $this->nodeInstanceByValue($value)
        );

        return $this;
    }

    /**
     * Add multiple leaf nodes
     */
    public function leaves($value1 /*,  $value2, ... */)
    {
        foreach (func_get_args() as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    /**
     * Add a branch down to another level
     */
    public function branch($value = null)
    {
        $this->getCurrentNode()->addChild($node = $this->nodeInstanceByValue($value));
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
    public function nodeInstanceByValue($value = null)
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
        $this->stack = [];
        return $this;
    }

    private function pushNode(Node $node)
    {
        array_push($this->stack, $node);
        return $this;
    }

    private function popNode()
    {
        return array_pop($this->stack);
    }
}
