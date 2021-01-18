<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal;

use Ds\Vector;
use Ds\Queue;
use Jorpo\Tree\Node;

class BreadthFirstTraversal implements TraversalAlgorithm
{
    public function sort(Node $node): Vector
    {
        $nodes = new Vector;

        $this->traverse($node, function (Node $node) use (&$nodes) {
            $nodes->push($node);
        });

        return $nodes;
    }

    public function traverse(Node $node, callable $callback): void
    {
        $queue = new Queue([$node]);

        while (!$queue->isEmpty()) {
            $node = $queue->pop();
            $callback($node);
            $queue->push(...$node->getChildren()->toArray());
        }
    }
}
