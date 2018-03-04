<?php

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node\Node;

interface TraversalAlgorithm
{
    /**
     * Traverse over a node and it's descendant tree
     *
     * @param Node $node
     * @return mixed
     */
    public function sort(Node $node);

    /**
     * Traverse over a node and it's descendant tree applying a callback
     *
     * @param Node $node
     * @param callable $callback
     * @return mixed
     */
    public function traverse(Node $node, callable $callback);
}
