<?php

namespace Jorpo\Tree\Traversal;

use Ds\Vector;
use Ds\Queue;
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
        $queue = new Queue([$node]);

        while (!$queue->isEmpty()) {
            $node = $queue->pop();
            $callback($node);
            $queue->push(...$node->getChildren()->toArray());
        }
    }
}
