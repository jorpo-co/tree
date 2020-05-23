<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal;

use Jorpo\Tree\Node;

interface TraversalAlgorithm
{
    public function sort(Node $node): array;
    public function traverse(Node $node, callable $callback): void;
}
