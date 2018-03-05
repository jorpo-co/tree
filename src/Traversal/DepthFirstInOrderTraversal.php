<?php

namespace Jorpo\Tree\Traversal;

use Ds\Stack;
use Ds\Vector;
use Jorpo\Tree\Node;

class DepthFirstInOrderTraversal implements TraversalAlgorithm
{
    /**
     * Traverse over a node and it's descendant tree
     *
     * @param Node $node
     * @return mixed
     */
    public function sort(Node $node)
    {
        $nodes = new Vector;

        $this->traverse($node, function (Node $node) use (&$nodes) {
            $nodes->push($node);
        });

        return $nodes;
    }

    /**
     * Traverse over a node and it's descendant tree applying a callback
     *
     * @param Node $node
     * @param callable $callback
     */
    public function traverse(Node $node, callable $callback)
    {
        $stack = new Stack;

        while (!$stack->isEmpty() || null !== $node) {
            if (null !== $node) {
                $stack->push($node);
                $children = $node->getChildren();
                $node = !$children->isEmpty() ? $children->shift() : null;
            } else {
                $node = $stack->pop();
                $callback($node);
                $children = $node->getChildren();
                // $children->shift();
                $node = !$children->isEmpty() ? $children->shift() : null;
            }
        }
    }
}
