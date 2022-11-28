<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Jorpo\Tree\Node;
use Jorpo\Tree\Traversal\AlgorithmTestCase;

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
class PreOrderTraversalTest extends AlgorithmTestCase
{
    public function testThatAlgorithmSortsNodeTree()
    {
        $traversal = new PreOrderTraversal;

        list($a, $b, $c, $d, $e, $f, $g, $h) = $this->buildNodeTree();

        $this->assertSame([$a, $b, $d, $e, $f, $h, $g, $c], ($traversal->sort($a))->toArray());
    }

    public function testThatAlgorithmTraversesNodeTree()
    {
        $traversal = new PreOrderTraversal;

        list($a) = $this->buildNodeTree();
        $traversed = "";

        $traversal->traverse($a, function (Node $node) use (&$traversed) {
            $traversed .= $node->getValue();
        });

        $this->assertSame('ABDEFHGC', $traversed);
    }
}
