<?php

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node\Node;

class DepthFirstPostOrderTraversal implements TraversalAlgorithm
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
        foreach ($node->getChildren() as $child) {
            if ($child->isBranch()) {
                $this->traverse($child, $callback);
            }

            $callback($child);
        }

        if ($node->isRoot()) {
            $callback($node);
        }
    }
}
