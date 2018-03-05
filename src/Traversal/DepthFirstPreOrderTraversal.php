<?php

namespace Jorpo\Tree\Traversal;

use Ds\Stack;
use Ds\Vector;
use Jorpo\Tree\Node;

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
 *    A, B, D, E, F, H, G, C
 */
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
     * @return mixed
     */
    public function traverse(Node $node, callable $callback)
    {
        $stack = new Stack([$node]);

        while (!$stack->isEmpty()) {
            $node = $stack->pop();
            $callback($node);
            $stack->push(...$node->getChildren()->reversed());
        }
    }
}
