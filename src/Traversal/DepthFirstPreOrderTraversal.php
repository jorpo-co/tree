<?php

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node\Node;

class DepthFirstPreOrderTraversal implements TraversalAlgorithm
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
     * @return mixed
     */
    public function traverse(Node $node, callable $callback)
    {
        $stack = [$node];

        while (!empty($stack)) {
            $node = array_pop($stack);
            $callback($node);
            $stack = array_merge($stack, array_reverse($node->getChildren()));
        }
    }
}
