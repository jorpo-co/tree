<?php

namespace Jorpo\Tree\Traversal;

use Ds\Vector;
use Jorpo\Tree\Node;

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
