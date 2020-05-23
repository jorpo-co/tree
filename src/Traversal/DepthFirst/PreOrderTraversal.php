<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Ds\Stack;
use Ds\Vector;
use Jorpo\Tree\Node;
use Jorpo\Tree\Traversal\TraversalAlgorithm;

class PreOrderTraversal implements TraversalAlgorithm
{
    public function sort(Node $node): array
    {
        $nodes = new Vector;

        $this->traverse($node, function (Node $node) use (&$nodes) {
            $nodes->push($node);
        });

        return $nodes->toArray();
    }

    public function traverse(Node $node, callable $callback): void
    {
        $stack = new Stack([$node]);

        while (!$stack->isEmpty()) {
            $node = $stack->pop();
            $callback($node);
            $stack->push(...$node->getChildren()->reversed());
        }
    }
}
