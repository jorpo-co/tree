<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Ds\Vector;
use Jorpo\Tree\Node;
use Jorpo\Tree\Traversal\TraversalAlgorithm;

class PostOrderTraversal implements TraversalAlgorithm
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
