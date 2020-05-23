<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Ds\Stack;
use Ds\Vector;
use Jorpo\Tree\Node;
use Jorpo\Tree\Traversal\TraversalAlgorithm;

class InOrderTraversal implements TraversalAlgorithm
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
        $stack = new Stack;

        while (!$stack->isEmpty() || null !== $node) {
            if (null !== $node) {
                $stack->push($node);
            } else {
                $node = $stack->pop();
                $callback($node);
            }

            $children = $node->getChildren();
            $node = !$children->isEmpty() ? $children->shift() : null;
        }
    }
}
