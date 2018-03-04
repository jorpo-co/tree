<?php

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node\Node;

/**
 *               A
 *              / \
 *             B   C
 *            / \
 *           D   E
 *              / \
 *             F   G
 *            /
 *           H
 *
 *    A, B, C, D, E, F, G, H
 */
class BreadthFirstTraversal implements TraversalAlgorithm
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
        $queue = [$node];

        while (!empty($queue)) {
            $node = array_shift($queue);
            $callback($node);
            $queue = array_merge($queue, $node->getChildren());
        }
    }
}
