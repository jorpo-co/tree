<?php

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node\Node;

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
        $nodes = [];

        $this->traverse($node, function (Node $node) use (&$nodes) {
            $nodes[] = $node;
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
        $stack = [];

        while (!empty($stack) || null !== $node) {
            if (null !== $node) {
                array_push($stack, $node);
                $children = $node->getChildren();
                $node = array_shift($children);
            } else {
                $node = array_pop($stack);
                $callback($node);
                $children = $node->getChildren();
                array_shift($children);
                $node = array_shift($children);
            }
        }
    }
}
